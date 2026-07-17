<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
                <div class="bg-primary text-white p-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-light text-primary px-3 py-2 rounded-pill fs-6">
                            {{ $job->department->name ?? 'Umum' }}
                        </span>
                        <small><i class='bx bx-calendar'></i> Diposting {{ $job->updated_at->diffForHumans() }}</small>
                    </div>
                    <h1 class="display-5 fw-bold mb-0">{{ $job->title }}</h1>
                </div>
                
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="fw-bold mb-3 border-bottom pb-2">Deskripsi Pekerjaan</h4>
                            <div class="mb-5 text-secondary fs-5" style="line-height: 1.8;">
                                {!! nl2br(e($job->description)) !!}
                            </div>

                            <h4 class="fw-bold mb-3 border-bottom pb-2">Persyaratan</h4>
                            <div class="mb-4 text-secondary fs-5" style="line-height: 1.8;">
                                {!! nl2br(e($job->requirements)) !!}
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded-4 sticky-top" style="top: 20px;">
                                <h5 class="fw-bold mb-4">Ringkasan</h5>
                                
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                                        <i class='bx bx-building fs-4'></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Departemen</small>
                                        <span class="fw-medium">{{ $job->department->name ?? '-' }}</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-3">
                                        <i class='bx bx-calendar-event fs-4'></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Terakhir Diperbarui</small>
                                        <span class="fw-medium">{{ $job->updated_at->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <hr>
                                
                                <!-- Apply Button Logic -->
                                @auth
                                    @if(Auth::user()->role === 'pelamar')
                                        @php
                                            $applicant = Auth::user()->applicant;
                                            $hasApplied = $applicant ? \App\Models\Application::where('job_posting_id', $job->id)->where('applicant_id', $applicant->id)->exists() : false;
                                        @endphp

                                        @if($hasApplied)
                                            <button class="btn btn-secondary btn-lg w-100 rounded-pill shadow-sm" disabled>
                                                <i class='bx bx-check-circle'></i> Sudah Dilamar
                                            </button>
                                        @else
                                            <form action="{{ route('jobs.apply', $job) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm" onclick="return confirm('Apakah Anda yakin ingin melamar posisi ini?')">
                                                    Lamar Pekerjaan Ini
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <div class="alert alert-info text-center mb-0">
                                            Hanya akun pelamar yang dapat melamar posisi ini.
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center">
                                        <p class="text-muted mb-2">Ingin melamar posisi ini?</p>
                                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm mb-2">Masuk untuk Melamar</a>
                                        <a href="{{ route('register') }}" class="text-decoration-none">Belum punya akun? Daftar</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                    <i class='bx bx-arrow-back'></i> Kembali ke Daftar Lowongan
                </a>
            </div>
        </div>
    </div>
</x-app>
