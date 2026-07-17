<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Display a listing of user's applications.
     */
    public function index()
    {
        $applicant = Auth::user()->applicant;
        
        $applications = [];
        if ($applicant) {
            $applications = Application::with(['jobPosting.department', 'statusLogs.changer'])
                ->where('applicant_id', $applicant->id)
                ->latest()
                ->get();
        }

        return view('applicant.applications.index', [
            'title' => 'Lamaran Saya',
            'applications' => $applications
        ]);
    }

    /**
     * Store a newly created application in storage.
     */
    public function store(JobPosting $job)
    {
        $applicant = Auth::user()->applicant;

        // Validation 1: Job must be approved
        if ($job->status !== 'approved') {
            return back()->withError('Lowongan ini tidak tersedia untuk dilamar.');
        }

        // Validation 2: Ensure not already applied
        $existing = Application::where('job_posting_id', $job->id)
            ->where('applicant_id', $applicant->id)
            ->first();

        if ($existing) {
            return back()->withError('Anda sudah melamar posisi ini sebelumnya.');
        }

        // Create application
        $application = Application::create([
            'job_posting_id' => $job->id,
            'applicant_id' => $applicant->id,
            'status' => 'applied'
        ]);

        \App\Models\ApplicationStatusLog::create([
            'application_id' => $application->id,
            'previous_status' => null,
            'new_status' => 'applied',
            'changed_by' => Auth::id(),
        ]);

        return redirect()->route('applicant.applications.index')->withSuccess('Berhasil melamar pekerjaan! Semoga beruntung.');
    }
}
