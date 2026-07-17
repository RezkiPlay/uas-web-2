<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobPostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hr = User::where('role', 'hr')->first();
        $departments = Department::all();

        if (!$hr || $departments->isEmpty()) {
            return;
        }

        $jobs = [
            [
                'department_id' => $departments->where('name', 'IT (Information Technology)')->first()->id ?? $departments->first()->id,
                'created_by' => $hr->id,
                'title' => 'Backend Developer (Laravel)',
                'description' => 'Kami mencari Backend Developer berpengalaman untuk bergabung dengan tim kami mengembangkan sistem rekrutmen berskala enterprise.',
                'requirements' => "- Minimal 2 tahun pengalaman dengan PHP dan Laravel.\n- Memahami konsep MVC, RESTful API, dan ORM.\n- Pengalaman dengan MySQL/PostgreSQL.",
                'status' => 'approved',
                'rejection_reason' => null,
            ],
            [
                'department_id' => $departments->where('name', 'IT (Information Technology)')->first()->id ?? $departments->first()->id,
                'created_by' => $hr->id,
                'title' => 'Frontend Engineer (React)',
                'description' => 'Membangun antarmuka pengguna yang responsif dan interaktif untuk aplikasi internal perusahaan.',
                'requirements' => "- Menguasai HTML, CSS, JavaScript Modern (ES6+).\n- Pengalaman minimal 1 tahun dengan React.js atau Vue.js.\n- Memahami konsep UI/UX.",
                'status' => 'approved',
                'rejection_reason' => null,
            ],
            [
                'department_id' => $departments->where('name', 'Marketing')->first()->id ?? $departments->first()->id,
                'created_by' => $hr->id,
                'title' => 'Digital Marketing Specialist',
                'description' => 'Mengelola kampanye digital perusahaan melalui berbagai kanal social media dan paid ads.',
                'requirements' => "- Pengalaman 2 tahun di bidang digital marketing.\n- Mampu menganalisa data dari Google Analytics dan FB Ads Manager.\n- Kreatif dan inovatif.",
                'status' => 'pending',
                'rejection_reason' => null,
            ],
            [
                'department_id' => $departments->where('name', 'Finance & Accounting')->first()->id ?? $departments->first()->id,
                'created_by' => $hr->id,
                'title' => 'Tax Accountant',
                'description' => 'Menangani pelaporan pajak perusahaan bulanan dan tahunan sesuai regulasi terbaru.',
                'requirements' => "- S1 Akuntansi/Perpajakan.\n- Memiliki sertifikat Brevet A & B.\n- Teliti dan jujur.",
                'status' => 'rejected',
                'rejection_reason' => 'Persyaratan kurang spesifik, mohon tambahkan minimal IPK dan pengalaman software akuntansi.',
            ],
            [
                'department_id' => $departments->where('name', 'HR (Human Resources)')->first()->id ?? $departments->first()->id,
                'created_by' => $hr->id,
                'title' => 'Talent Acquisition Staff',
                'description' => 'Draft lowongan untuk staf rekrutmen internal.',
                'requirements' => "- S1 Psikologi atau Manajemen SDM.\n- Paham alat tes psikologi dasar.",
                'status' => 'draft',
                'rejection_reason' => null,
            ],
            [
                'department_id' => $departments->where('name', 'Operations')->first()->id ?? $departments->first()->id,
                'created_by' => $hr->id,
                'title' => 'Logistics Manager',
                'description' => 'Mengelola rantai pasok dan armada pengiriman perusahaan di seluruh cabang.',
                'requirements' => "- S1 Teknik Industri atau Manajemen.\n- Pengalaman 5 tahun di bidang logistik.\n- Jiwa kepemimpinan kuat.",
                'status' => 'closed',
                'rejection_reason' => null,
            ],
            [
                'department_id' => $departments->where('name', 'Marketing')->first()->id ?? $departments->first()->id,
                'created_by' => $hr->id,
                'title' => 'Content Writer',
                'description' => 'Draft lowongan untuk penulis blog dan artikel SEO.',
                'requirements' => "- Suka menulis.\n- Tahu dasar SEO.",
                'status' => 'draft',
                'rejection_reason' => null,
            ],
        ];

        foreach ($jobs as $job) {
            JobPosting::create($job);
        }
    }
}
