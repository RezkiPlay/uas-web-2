<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicantProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $applicant = $user->applicant;
        $cv = $applicant ? $applicant->applicationDocuments()->where('document_type', 'CV')->first() : null;

        return view('applicant.profile.edit', [
            'title' => 'Profil Saya',
            'applicant' => $applicant,
            'cv' => $cv
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validate = $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'summary' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ], [
            'phone.required' => 'Nomor HP wajib diisi',
            'address.required' => 'Alamat lengkap wajib diisi',
            'cv.mimes' => 'CV harus berupa file PDF, DOC, atau DOCX',
            'cv.max' => 'Ukuran file CV maksimal 2MB',
        ]);

        // Require CV for first-time profile completion
        if (!$user->applicant && !$request->hasFile('cv')) {
            return back()->withErrors(['cv' => 'CV wajib diunggah saat pertama kali melengkapi profil.'])->withInput();
        }

        $applicant = Applicant::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $validate['phone'],
                'address' => $validate['address'],
                'summary' => $validate['summary'],
            ]
        );

        if ($request->hasFile('cv')) {
            // Delete old CV if exists
            $oldCv = $applicant->applicationDocuments()->where('document_type', 'CV')->first();
            if ($oldCv) {
                Storage::disk('public')->delete($oldCv->file_path);
                $oldCv->delete();
            }

            $path = $request->file('cv')->store('documents', 'public');
            $applicant->applicationDocuments()->create([
                'document_type' => 'CV',
                'file_path' => $path
            ]);
        }

        return redirect()->route('applicant.profile.edit')->withSuccess('Profil dan dokumen berhasil diperbarui.');
    }
}
