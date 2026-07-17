<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\InterviewSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HrInterviewController extends Controller
{
    /**
     * Store or update the interview schedule for an application.
     */
    public function storeOrUpdate(Request $request, Application $application)
    {
        // Check ownership
        if ($application->jobPosting->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Must be in interview status
        if ($application->status !== 'interview') {
            return back()->withError('Hanya lamaran berstatus interview yang dapat dijadwalkan.');
        }

        $validate = $request->validate([
            'schedule_time' => 'required|date',
            'location_or_link' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        InterviewSchedule::updateOrCreate(
            ['application_id' => $application->id],
            $validate
        );

        return back()->withSuccess('Jadwal interview berhasil disimpan.');
    }
}
