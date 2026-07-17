<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\OfferLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class HrOfferController extends Controller
{
    /**
     * Generate and store an offer letter.
     */
    public function store(Request $request, Application $application)
    {
        // Check ownership
        if ($application->jobPosting->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Must be in offered status
        if ($application->status !== 'offered') {
            return back()->withError('Offering letter hanya dapat dibuat untuk pelamar dengan status Offered.');
        }

        // Must not have an existing offer letter
        if ($application->offerLetter) {
            return back()->withError('Offering letter untuk pelamar ini sudah diterbitkan.');
        }

        $validate = $request->validate([
            'salary_offered' => 'required|numeric|min:0',
            'join_date' => 'required|date|after:today'
        ]);

        $validate['application_id'] = $application->id;
        $validate['status'] = 'pending';

        // Load relations for PDF
        $application->load(['applicant.user', 'jobPosting.department']);

        // Generate PDF
        $pdf = Pdf::loadView('pdf.offer_letter', [
            'application' => $application,
            'salary_offered' => $validate['salary_offered'],
            'join_date' => $validate['join_date']
        ]);

        $fileName = 'offer_letter_' . $application->id . '_' . time() . '.pdf';
        $filePath = 'offers/' . $fileName;
        
        // Save PDF to storage disk public
        Storage::disk('public')->put($filePath, $pdf->output());

        $validate['file_path'] = $filePath;

        OfferLetter::create($validate);

        return back()->withSuccess('Offering Letter berhasil diterbitkan.');
    }
}
