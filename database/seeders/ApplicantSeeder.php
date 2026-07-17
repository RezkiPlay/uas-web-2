<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\ApplicationDocument;
use App\Models\Application;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Existing dummy pelamar from UserSeeder
        $pelamar1 = User::where('role', 'pelamar')->where('email', 'pelamar@rekrutmudah.test')->first();

        // Let's create 2 more dummy pelamar
        $pelamar2 = User::firstOrCreate(
            ['email' => 'budipelamar@rekrutmudah.test'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'pelamar',
            ]
        );

        $pelamar3 = User::firstOrCreate(
            ['email' => 'sitipelamar@rekrutmudah.test'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('password'),
                'role' => 'pelamar',
            ]
        );

        // Dummy CV path (we won't actually create the physical file here to keep it simple, just the DB record)
        // Ensure storage directory exists
        Storage::disk('public')->makeDirectory('documents');
        $dummyCvPath = 'documents/dummy_cv.pdf';
        if (!Storage::disk('public')->exists($dummyCvPath)) {
            Storage::disk('public')->put($dummyCvPath, 'This is a dummy CV for testing purposes.');
        }

        // 2. Create Applicants
        $applicantsData = [
            $pelamar1->id => [
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 123, Jakarta Selatan',
                'summary' => 'Lulusan S1 Teknik Informatika dengan ketertarikan di bidang Web Development.',
            ],
            $pelamar2->id => [
                'phone' => '081987654321',
                'address' => 'Jl. Pahlawan No. 45, Bandung',
                'summary' => 'Berpengalaman 2 tahun sebagai Frontend Engineer.',
            ],
            $pelamar3->id => [
                'phone' => '085612349876',
                'address' => 'Jl. Sudirman No. 1, Surabaya',
                'summary' => 'Fresh graduate dari Universitas Ternama, cepat belajar dan adaptif.',
            ]
        ];

        $applicants = [];
        foreach ($applicantsData as $userId => $data) {
            $applicant = Applicant::updateOrCreate(['user_id' => $userId], $data);
            $applicants[] = $applicant;

            // Add dummy CV
            ApplicationDocument::firstOrCreate([
                'applicant_id' => $applicant->id,
                'document_type' => 'CV',
            ], [
                'file_path' => $dummyCvPath,
            ]);
        }

        // 3. Create Applications
        $approvedJobs = JobPosting::where('status', 'approved')->get();

        if ($approvedJobs->count() >= 2) {
            $job1 = $approvedJobs[0];
            $job2 = $approvedJobs[1];

            // Pelamar 1 applies to Job 1 (Applied status)
            Application::firstOrCreate([
                'job_posting_id' => $job1->id,
                'applicant_id' => $applicants[0]->id,
            ], [
                'status' => 'applied'
            ]);

            // Pelamar 2 applies to Job 1 (Interview status)
            Application::firstOrCreate([
                'job_posting_id' => $job1->id,
                'applicant_id' => $applicants[1]->id,
            ], [
                'status' => 'interview'
            ]);

            // Pelamar 3 applies to Job 2 (Assessment status)
            Application::firstOrCreate([
                'job_posting_id' => $job2->id,
                'applicant_id' => $applicants[2]->id,
            ], [
                'status' => 'assessment'
            ]);
        }
    }
}
