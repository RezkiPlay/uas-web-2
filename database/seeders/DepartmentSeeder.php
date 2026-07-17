<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'IT (Information Technology)',
                'description' => 'Departemen yang bertanggung jawab untuk pengembangan perangkat lunak, infrastruktur jaringan, dan dukungan TI perusahaan.',
            ],
            [
                'name' => 'Finance & Accounting',
                'description' => 'Departemen yang mengelola arus kas, anggaran, pembukuan, laporan keuangan, dan kepatuhan perpajakan perusahaan.',
            ],
            [
                'name' => 'Marketing',
                'description' => 'Departemen yang bertanggung jawab atas branding, kampanye iklan, riset pasar, dan promosi produk.',
            ],
            [
                'name' => 'HR (Human Resources)',
                'description' => 'Departemen yang mengelola administrasi karyawan, proses rekrutmen, pelatihan, evaluasi kinerja, dan hubungan industrial.',
            ],
            [
                'name' => 'Operations',
                'description' => 'Departemen yang bertanggung jawab atas operasional bisnis harian dan efisiensi rantai pasok perusahaan.',
            ],
        ];

        foreach ($departments as $dept) {
            \App\Models\Department::updateOrCreate(
                ['name' => $dept['name']],
                ['description' => $dept['description']]
            );
        }
    }
}
