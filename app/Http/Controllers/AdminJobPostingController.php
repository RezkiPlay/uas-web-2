<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;

class AdminJobPostingController extends Controller
{
    /**
     * Display a listing of all job postings.
     */
    public function index()
    {
        // Admin can see all jobs
        $jobs = JobPosting::with(['department', 'creator'])->latest()->get();
        return view('admin.jobs.index', [
            'title' => 'Review Lowongan',
            'jobs' => $jobs
        ]);
    }

    /**
     * Show details of a specific job posting.
     */
    public function show(JobPosting $job)
    {
        return view('admin.jobs.show', [
            'title' => 'Detail Lowongan',
            'job' => $job
        ]);
    }

    /**
     * Approve a job posting.
     */
    public function approve(JobPosting $job)
    {
        if ($job->status !== 'pending') {
            return back()->withError('Hanya lowongan berstatus pending yang dapat diapprove.');
        }

        $job->update([
            'status' => 'approved',
            'rejection_reason' => null
        ]);

        \App\Models\ApplicationStatusLog::create([
            'job_posting_id' => $job->id,
            'previous_status' => 'pending',
            'new_status' => 'approved',
            'changed_by' => \Illuminate\Support\Facades\Auth::id(),
        ]);

        return back()->withSuccess('Lowongan berhasil diapprove.');
    }

    /**
     * Reject a job posting with reason.
     */
    public function reject(Request $request, JobPosting $job)
    {
        if ($job->status !== 'pending') {
            return back()->withError('Hanya lowongan berstatus pending yang dapat direject.');
        }

        $request->validate([
            'rejection_reason' => 'required'
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi'
        ]);

        $job->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        \App\Models\ApplicationStatusLog::create([
            'job_posting_id' => $job->id,
            'previous_status' => 'pending',
            'new_status' => 'rejected',
            'changed_by' => \Illuminate\Support\Facades\Auth::id(),
        ]);

        return back()->withSuccess('Lowongan berhasil direject.');
    }
}
