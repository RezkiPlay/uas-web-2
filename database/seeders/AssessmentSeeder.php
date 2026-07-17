<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\AssessmentResult;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        // For demonstration, let's artificially change one applicant's status to assessment 
        // (if none exists) and then simulate HR giving them an assessment.

        // First, let's grab an application that is in 'interview' status.
        $application = Application::where('status', 'interview')->first();
        
        if ($application) {
            // Give them a dummy assessment result of 85 (Offered)
            AssessmentResult::create([
                'application_id' => $application->id,
                'score' => 85,
                'hr_notes' => 'Kandidat sangat menguasai Laravel dan komunikasi sangat baik.',
            ]);

            // Automatically update status to 'offered'
            $application->update(['status' => 'offered']);
        }
    }
}
