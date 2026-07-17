<?php

namespace App\Http\Controllers;

use App\Models\ApplicationStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusLogController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin sees all logs
            $logs = ApplicationStatusLog::with(['application.applicant.user', 'jobPosting', 'changer'])
                ->latest()
                ->paginate(50);
        } elseif ($user->role === 'hr') {
            // HR sees logs for their own job postings and associated applications
            $logs = ApplicationStatusLog::with(['application.applicant.user', 'jobPosting', 'changer'])
                ->whereHas('jobPosting', function ($query) use ($user) {
                    $query->where('created_by', $user->id);
                })
                ->orWhereHas('application.jobPosting', function ($query) use ($user) {
                    $query->where('created_by', $user->id);
                })
                ->latest()
                ->paginate(50);
        } else {
            abort(403);
        }

        return view('logs.index', [
            'title' => 'Riwayat Status',
            'logs' => $logs
        ]);
    }
}
