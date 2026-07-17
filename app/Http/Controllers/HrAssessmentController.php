<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationStatusLog;
use App\Models\AssessmentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HrAssessmentController extends Controller
{
    /**
     * Store the assessment result for an application.
     */
    public function store(Request $request, Application $application)
    {
        // Check ownership
        if ($application->jobPosting->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Must be in interview or assessment status
        if (!in_array($application->status, ['interview', 'assessment'])) {
            return back()->withError('Penilaian hanya dapat dilakukan pada lamaran dengan status Interview atau Assessment.');
        }

        // Must not have been assessed before
        if ($application->assessmentResult) {
            return back()->withError('Penilaian untuk pelamar ini sudah dilakukan.');
        }

        $validate = $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'hr_notes' => 'nullable|string'
        ]);

        $validate['application_id'] = $application->id;

        // Save Assessment Result
        AssessmentResult::create($validate);

        // Determine new status based on score
        $previousStatus = $application->status;
        $newStatus = $validate['score'] >= 70 ? 'offered' : 'rejected';

        // Update application status
        $application->update(['status' => $newStatus]);

        // Log the status change
        ApplicationStatusLog::create([
            'application_id' => $application->id,
            'previous_status' => $previousStatus,
            'new_status' => $newStatus,
            'changed_by' => Auth::id(),
        ]);

        $message = $newStatus == 'offered' 
            ? 'Penilaian berhasil disimpan. Pelamar otomatis dinyatakan Lulus (Offered).' 
            : 'Penilaian berhasil disimpan. Pelamar otomatis dinyatakan Tidak Lulus (Rejected).';

        return back()->withSuccess($message);
    }
}
