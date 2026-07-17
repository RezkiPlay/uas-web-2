<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HrApplicantController extends Controller
{
    /**
     * Display a listing of jobs with their applicants.
     */
    public function index()
    {
        $jobs = JobPosting::withCount('applications')
            ->where('created_by', Auth::id())
            ->whereIn('status', ['approved', 'closed'])
            ->latest()
            ->get();

        return view('hr.applicants.index', [
            'title' => 'Daftar Pelamar Masuk',
            'jobs' => $jobs
        ]);
    }

    /**
     * Display the specified resource (applicants for a job).
     */
    public function show(JobPosting $job)
    {
        // HR can only see applicants for their own jobs
        if ($job->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $applications = Application::with(['applicant.user', 'applicant.applicationDocuments', 'interviewSchedule', 'assessmentResult', 'offerLetter'])
            ->where('job_posting_id', $job->id)
            ->latest()
            ->get();

        return view('hr.applicants.show', [
            'title' => 'Detail Pelamar: ' . $job->title,
            'job' => $job,
            'applications' => $applications
        ]);
    }

    /**
     * Update the status of a specific application.
     */
    public function updateStatus(Request $request, Application $application)
    {
        // HR can only update status for their own jobs
        if ($application->jobPosting->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:applied,interview,assessment,offered,rejected'
        ]);

        $previousStatus = $application->status;

        $application->update([
            'status' => $request->status
        ]);

        if ($previousStatus !== $request->status) {
            \App\Models\ApplicationStatusLog::create([
                'application_id' => $application->id,
                'previous_status' => $previousStatus,
                'new_status' => $request->status,
                'changed_by' => Auth::id(),
            ]);
        }

        return back()->withSuccess('Status pelamar berhasil diperbarui.');
    }
}
