<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\OfferLetter;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OfferLetterSeeder extends Seeder
{
    public function run(): void
    {
        // Get applications that are in 'offered' status
        $applications = Application::with(['applicant.user', 'jobPosting.department'])
            ->where('status', 'offered')
            ->get();

        foreach ($applications as $index => $application) {
            $salary = 10000000 + ($index * 1500000);
            $joinDate = Carbon::now()->addDays(14)->format('Y-m-d');
            
            // Generate PDF for dummy
            $pdf = Pdf::loadView('pdf.offer_letter', [
                'application' => $application,
                'salary_offered' => $salary,
                'join_date' => $joinDate
            ]);

            $fileName = 'offer_letter_' . $application->id . '_' . time() . '.pdf';
            $filePath = 'offers/' . $fileName;
            Storage::disk('public')->put($filePath, $pdf->output());

            // Make the first one pending, and the second one accepted (if exists)
            $status = $index === 0 ? 'pending' : 'accepted';

            OfferLetter::create([
                'application_id' => $application->id,
                'salary_offered' => $salary,
                'join_date' => $joinDate,
                'status' => $status,
                'file_path' => $filePath
            ]);

            if ($status === 'accepted') {
                $application->jobPosting->update(['status' => 'closed']);
            }
        }
    }
}
