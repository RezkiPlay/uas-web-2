<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\InterviewSchedule;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InterviewSeeder extends Seeder
{
    public function run(): void
    {
        // Cari lamaran yang statusnya 'interview'
        $applications = Application::where('status', 'interview')->get();

        foreach ($applications as $app) {
            InterviewSchedule::create([
                'application_id' => $app->id,
                'schedule_time' => Carbon::now()->addDays(rand(1, 7))->setHour(rand(9, 15))->setMinute(0),
                'location_or_link' => 'https://meet.google.com/abc-defg-hij',
                'notes' => 'Harap siapkan presentasi portfolio.',
            ]);
        }
    }
}
