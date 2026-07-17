<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('applicant.profile.update') }}" method="post" enctype="multipart/form-data" class="form">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input class="form-control" type="text" value="{{ Auth::user()->name }}" disabled>
                    <div class="form-text">Nama sesuai akun yang terdaftar.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" value="{{ Auth::user()->email }}" disabled>
                </div>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label required">Nomor HP / WhatsApp</label>
                <input class="form-control @error('phone') is-invalid @enderror" type="text" id="phone"
                    name="phone" required value="{{ old('phone', $applicant?->phone) }}">
                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label required">Alamat Lengkap</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                    name="address" rows="3" required>{{ old('address', $applicant?->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="summary" class="form-label">Ringkasan Profil (Opsional)</label>
                <textarea class="form-control @error('summary') is-invalid @enderror" id="summary"
                    name="summary" rows="3" placeholder="Ceritakan sedikit tentang keahlian dan pengalaman Anda">{{ old('summary', $applicant?->summary) }}</textarea>
                @error('summary')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <hr class="my-4">
            
            <h5 class="mb-3">Dokumen Pendukung</h5>

            <div class="mb-3">
                <label for="cv" class="form-label {{ !$applicant ? 'required' : '' }}">Upload CV Terbaru</label>
                <input class="form-control @error('cv') is-invalid @enderror" type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" {{ !$applicant ? 'required' : '' }}>
                <div class="form-text">Format yang didukung: PDF, DOC, DOCX. Maksimal ukuran: 2MB.</div>
                @error('cv')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                @if($cv)
                    <div class="mt-2">
                        <a href="{{ Storage::url($cv->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                            <i class='bx bx-file'></i> Lihat CV Tersimpan
                        </a>
                        <span class="text-muted small ms-2">Upload file baru untuk mengganti.</span>
                    </div>
                @endif
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-save'></i> Simpan Profil
                </button>
            </div>
        </form>
    </div>
</x-app>
