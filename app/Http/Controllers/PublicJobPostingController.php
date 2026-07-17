<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use Illuminate\Http\Request;

class PublicJobPostingController extends Controller
{
    /**
     * Display a listing of approved jobs.
     */
    public function index()
    {
        $jobs = JobPosting::with('department')
            ->where('status', 'approved')
            ->latest()
            ->get();
            
        return view('jobs.index', [
            'title' => 'Lowongan Pekerjaan',
            'jobs' => $jobs
        ]);
    }

    /**
     * Display the specified job.
     */
    public function show(JobPosting $job)
    {
        if ($job->status !== 'approved') {
            abort(404, 'Lowongan tidak ditemukan atau sudah ditutup.');
        }

        return view('jobs.show', [
            'title' => $job->title,
            'job' => $job
        ]);
    }
}
