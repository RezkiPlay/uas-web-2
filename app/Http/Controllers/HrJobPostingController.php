<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HrJobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = JobPosting::where('created_by', Auth::id())->latest()->get();
        return view('hr.jobs.index', [
            'title' => 'Lowongan Saya',
            'jobs' => $jobs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hr.jobs.create', [
            'title' => 'Buat Lowongan',
            'departments' => Department::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'title' => 'required|max:255',
            'description' => 'required',
            'requirements' => 'required',
        ], [
            'department_id.required' => 'Departemen wajib dipilih',
            'department_id.exists' => 'Departemen tidak valid',
            'title.required' => 'Judul lowongan wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
            'requirements.required' => 'Persyaratan wajib diisi',
        ]);

        $validate['created_by'] = Auth::id();
        $validate['status'] = 'draft';

        DB::beginTransaction();
        try {
            $job = JobPosting::create($validate);
            
            \App\Models\ApplicationStatusLog::create([
                'job_posting_id' => $job->id,
                'previous_status' => null,
                'new_status' => 'draft',
                'changed_by' => Auth::id(),
            ]);

            DB::commit();
            return to_route('hr.jobs.index')->withSuccess('Lowongan berhasil disimpan sebagai draft.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal menyimpan lowongan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPosting $job)
    {
        // Check ownership
        if ($job->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow edit if draft or rejected
        if (!in_array($job->status, ['draft', 'rejected'])) {
            return to_route('hr.jobs.index')->withError('Lowongan tidak dapat diedit karena status saat ini adalah ' . $job->status);
        }

        return view('hr.jobs.edit', [
            'title' => 'Edit Lowongan',
            'job' => $job,
            'departments' => Department::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobPosting $job)
    {
        // Check ownership
        if ($job->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow update if draft or rejected
        if (!in_array($job->status, ['draft', 'rejected'])) {
            return to_route('hr.jobs.index')->withError('Lowongan tidak dapat diedit.');
        }

        $validate = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'title' => 'required|max:255',
            'description' => 'required',
            'requirements' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $job->update($validate);
            DB::commit();
            return to_route('hr.jobs.index')->withSuccess('Lowongan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withError('Gagal memperbarui lowongan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Submit for approval (change status to pending).
     */
    public function submit(JobPosting $job)
    {
        if ($job->created_by !== Auth::id()) {
            abort(403);
        }

        if (!in_array($job->status, ['draft', 'rejected'])) {
            return back()->withError('Lowongan tidak valid untuk diajukan.');
        }
        
        $previousStatus = $job->status;
        $job->update(['status' => 'pending']);
        
        \App\Models\ApplicationStatusLog::create([
            'job_posting_id' => $job->id,
            'previous_status' => $previousStatus,
            'new_status' => 'pending',
            'changed_by' => Auth::id(),
        ]);

        return back()->withSuccess('Lowongan berhasil diajukan untuk approval.');
    }

    /**
     * Close job posting.
     */
    public function close(JobPosting $job)
    {
        if ($job->created_by !== Auth::id()) {
            abort(403);
        }

        if ($job->status !== 'approved') {
            return back()->withError('Hanya lowongan yang approved yang dapat ditutup.');
        }

        $job->update(['status' => 'closed']);
        
        \App\Models\ApplicationStatusLog::create([
            'job_posting_id' => $job->id,
            'previous_status' => 'approved',
            'new_status' => 'closed',
            'changed_by' => Auth::id(),
        ]);

        return back()->withSuccess('Lowongan berhasil ditutup.');
    }
}
