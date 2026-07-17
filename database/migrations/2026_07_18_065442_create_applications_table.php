<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_posting_id')->constrained('job_postings')->onDelete('cascade');
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->enum('status', ['applied', 'interview', 'assessment', 'offered', 'rejected'])->default('applied');
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamps();

            // Prevent duplicate applications for the same job by the same applicant
            $table->unique(['job_posting_id', 'applicant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
