<?php

namespace App\Http\Controllers;

use App\Models\OfferLetter;
use App\Models\ApplicationStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicantOfferController extends Controller
{
    /**
     * Respond to an offer letter (accept or decline).
     */
    public function respond(Request $request, OfferLetter $offerLetter)
    {
        $application = $offerLetter->application;
        
        // Check ownership
        if ($application->applicant->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($offerLetter->status !== 'pending') {
            return back()->withError('Anda sudah memberikan respon terhadap offering letter ini.');
        }

        $request->validate([
            'response' => 'required|in:accept,decline'
        ]);

        $newStatus = $request->response === 'accept' ? 'accepted' : 'declined';
        
        // Update Offer Letter Status
        $offerLetter->update(['status' => $newStatus]);

        if ($newStatus === 'accepted') {
            // If accepted, close the job posting
            $jobPosting = $application->jobPosting;
            $oldJobStatus = $jobPosting->status;
            $jobPosting->update(['status' => 'closed']);

            // Optional: Log job posting status change as well, if needed.
            // But we mainly need to log the application status if we change it.
            // Let's keep application status as 'offered' since that's the final stage,
            // or we could add a new application status 'hired' if it existed in enum.
            // For now, the PRD just says to update offer_letter status and job_posting status.
        }

        // Log this action
        ApplicationStatusLog::create([
            'application_id' => $application->id,
            'previous_status' => $application->status, // remains 'offered' but we log the event
            'new_status' => $application->status,
            'changed_by' => Auth::id(),
        ]);

        $message = $newStatus === 'accepted' 
            ? 'Selamat! Anda telah menerima Offering Letter. Lowongan pekerjaan ini telah ditutup.'
            : 'Anda telah menolak Offering Letter. Terima kasih atas partisipasi Anda.';

        return back()->withSuccess($message);
    }
}
