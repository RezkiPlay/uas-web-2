<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="mb-3">
        <a href="{{ route('hr.applicants.index') }}" class="btn btn-outline-secondary">
            <i class='bx bx-arrow-back'></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-lg p-3 mb-4 border-0">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-1 fw-bold">{{ $job->title }}</h4>
                <p class="text-muted mb-0">
                    <i class='bx bx-building'></i> {{ $job->department->name ?? '-' }} | 
                    <i class='bx bx-group'></i> Total Pelamar: {{ $applications->count() }}
                </p>
            </div>
            <div>
                @if($job->status == 'approved')
                    <span class="badge bg-success py-2 px-3 fs-6">Active</span>
                @elseif($job->status == 'closed')
                    <span class="badge bg-dark py-2 px-3 fs-6">Closed</span>
                @endif
            </div>
        </div>
    </div>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 40px;">#</th>
                        <th scope="col">Nama Pelamar</th>
                        <th scope="col">Kontak & Ringkasan</th>
                        <th scope="col" style="width: 150px;">Dokumen</th>
                        <th scope="col" style="width: 130px;">Waktu Apply</th>
                        <th scope="col" style="width: 250px;">Status & Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $app->applicant->user->name }}</strong><br>
                                <small class="text-muted">{{ $app->applicant->user->email }}</small>
                            </td>
                            <td>
                                <div><i class='bx bx-phone'></i> {{ $app->applicant->phone }}</div>
                                <div class="mt-1 small text-muted text-truncate" style="max-width: 200px;" title="{{ $app->applicant->summary }}">
                                    {{ Str::limit($app->applicant->summary, 50) }}
                                </div>
                            </td>
                            <td>
                                @php
                                    $cv = $app->applicant->applicationDocuments->where('document_type', 'CV')->first();
                                @endphp
                                @if($cv)
                                    <a href="{{ Storage::url($cv->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class='bx bx-download'></i> Unduh CV
                                    </a>
                                @else
                                    <span class="text-muted small">Tidak ada dokumen</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($app->applied_at)->format('d M Y, H:i') }}</td>
                            <td>
                                <div class="d-flex flex-column gap-2">
                                    <form action="{{ route('hr.applications.status.update', $app) }}" method="POST" class="d-flex gap-2 align-items-center">
                                        @csrf
                                        @method('patch')
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="applied" {{ $app->status == 'applied' ? 'selected' : '' }}>Applied</option>
                                            <option value="interview" {{ $app->status == 'interview' ? 'selected' : '' }}>Interview</option>
                                            <option value="assessment" {{ $app->status == 'assessment' ? 'selected' : '' }}>Assessment</option>
                                            <option value="offered" {{ $app->status == 'offered' ? 'selected' : '' }}>Offered</option>
                                            <option value="rejected" {{ $app->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                        
                                        @if($app->status == 'applied')
                                            <span class="badge bg-secondary ms-1 w-50">Applied</span>
                                        @elseif($app->status == 'interview')
                                            <span class="badge bg-primary ms-1 w-50">Interview</span>
                                        @elseif($app->status == 'assessment')
                                            <span class="badge bg-info text-dark ms-1 w-50">Assessment</span>
                                        @elseif($app->status == 'offered')
                                            <span class="badge bg-success ms-1 w-50">Offered</span>
                                        @elseif($app->status == 'rejected')
                                            <span class="badge bg-danger ms-1 w-50">Rejected</span>
                                        @endif
                                    </form>

                                    @if($app->status === 'interview')
                                        <button type="button" class="btn btn-sm btn-outline-primary mt-1" data-bs-toggle="modal" data-bs-target="#interviewModal{{ $app->id }}">
                                            <i class='bx bx-calendar-event'></i> {{ $app->interviewSchedule ? 'Edit Jadwal' : 'Jadwalkan Interview' }}
                                        </button>

                                        <!-- Interview Modal -->
                                        <div class="modal fade" id="interviewModal{{ $app->id }}" tabindex="-1" aria-labelledby="interviewModalLabel{{ $app->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('hr.applications.interview.store', $app) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="interviewModalLabel{{ $app->id }}">Jadwal Interview - {{ $app->applicant->user->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label required">Tanggal & Waktu</label>
                                                                <input type="datetime-local" class="form-control" name="schedule_time" required value="{{ $app->interviewSchedule ? \Carbon\Carbon::parse($app->interviewSchedule->schedule_time)->format('Y-m-d\TH:i') : '' }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label required">Lokasi / Link Meeting</label>
                                                                <input type="text" class="form-control" name="location_or_link" required placeholder="Contoh: Google Meet / Ruang Rapat Lt 2" value="{{ $app->interviewSchedule->location_or_link ?? '' }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Catatan (Opsional)</label>
                                                                <textarea class="form-control" name="notes" rows="3" placeholder="Contoh: Harap membawa laptop">{{ $app->interviewSchedule->notes ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if(in_array($app->status, ['interview', 'assessment']) || $app->assessmentResult)
                                        <button type="button" class="btn btn-sm {{ $app->assessmentResult ? 'btn-success' : 'btn-outline-info' }} mt-1" data-bs-toggle="modal" data-bs-target="#assessmentModal{{ $app->id }}">
                                            <i class='bx bx-check-square'></i> {{ $app->assessmentResult ? 'Lihat Penilaian' : 'Input Penilaian' }}
                                        </button>

                                        <!-- Assessment Modal -->
                                        <div class="modal fade" id="assessmentModal{{ $app->id }}" tabindex="-1" aria-labelledby="assessmentModalLabel{{ $app->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    @if($app->assessmentResult)
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="assessmentModalLabel{{ $app->id }}">Hasil Penilaian - {{ $app->applicant->user->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Skor Penilaian</label>
                                                                <div class="fs-4 fw-bold {{ $app->assessmentResult->score >= 70 ? 'text-success' : 'text-danger' }}">
                                                                    {{ $app->assessmentResult->score }} / 100
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Catatan HR</label>
                                                                <div class="p-2 border rounded bg-light">
                                                                    {{ $app->assessmentResult->hr_notes ?? '-' }}
                                                                </div>
                                                            </div>
                                                            <div class="alert {{ $app->assessmentResult->score >= 70 ? 'alert-success' : 'alert-danger' }} mb-0">
                                                                Sistem otomatis mengarahkan pelamar ini ke status <strong>{{ $app->assessmentResult->score >= 70 ? 'Offered' : 'Rejected' }}</strong>.
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    @else
                                                        <form action="{{ route('hr.applications.assessment.store', $app) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="assessmentModalLabel{{ $app->id }}">Input Penilaian - {{ $app->applicant->user->name }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-start">
                                                                <div class="alert alert-warning small">
                                                                    <strong>Perhatian:</strong> Penilaian bersifat final dan tidak dapat diubah. <br>
                                                                    Skor >= 70 akan otomatis lulus (Offered). <br>
                                                                    Skor < 70 akan otomatis tidak lulus (Rejected).
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label required">Skor Penilaian (0-100)</label>
                                                                    <input type="number" class="form-control" name="score" required min="0" max="100" placeholder="Misal: 85">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Catatan HR (Opsional)</label>
                                                                    <textarea class="form-control" name="hr_notes" rows="3" placeholder="Contoh: Kandidat memiliki komunikasi yang baik"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($app->status === 'offered' || $app->offerLetter)
                                        <button type="button" class="btn btn-sm {{ $app->offerLetter ? 'btn-success' : 'btn-outline-warning' }} mt-1" data-bs-toggle="modal" data-bs-target="#offerModal{{ $app->id }}">
                                            <i class='bx bx-envelope'></i> {{ $app->offerLetter ? 'Detail Offering' : 'Terbitkan Offering' }}
                                        </button>

                                        <!-- Offer Modal -->
                                        <div class="modal fade" id="offerModal{{ $app->id }}" tabindex="-1" aria-labelledby="offerModalLabel{{ $app->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    @if($app->offerLetter)
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="offerModalLabel{{ $app->id }}">Detail Offering - {{ $app->applicant->user->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Gaji Ditawarkan</label>
                                                                <div class="fs-5 fw-bold">Rp {{ number_format($app->offerLetter->salary_offered, 0, ',', '.') }}</div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Tanggal Bergabung</label>
                                                                <div class="fs-6">{{ \Carbon\Carbon::parse($app->offerLetter->join_date)->translatedFormat('d F Y') }}</div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Status Respon Pelamar</label>
                                                                <div>
                                                                    @if($app->offerLetter->status == 'pending')
                                                                        <span class="badge bg-warning text-dark">Menunggu Respon</span>
                                                                    @elseif($app->offerLetter->status == 'accepted')
                                                                        <span class="badge bg-success">Diterima (Accepted)</span>
                                                                    @elseif($app->offerLetter->status == 'declined')
                                                                        <span class="badge bg-danger">Ditolak (Declined)</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if($app->offerLetter->file_path)
                                                                <div class="mt-4 text-center">
                                                                    <a href="{{ Storage::url($app->offerLetter->file_path) }}" target="_blank" class="btn btn-outline-primary">
                                                                        <i class='bx bx-download'></i> Unduh File Offering PDF
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    @else
                                                        <form action="{{ route('hr.applications.offer.store', $app) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="offerModalLabel{{ $app->id }}">Terbitkan Offering - {{ $app->applicant->user->name }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-start">
                                                                <div class="alert alert-info small">
                                                                    Sistem akan otomatis menghasilkan surat penawaran dalam bentuk PDF dan mengirimkannya ke dashboard pelamar.
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label required">Gaji yang Ditawarkan (Rp)</label>
                                                                    <input type="number" class="form-control" name="salary_offered" required min="0" placeholder="Contoh: 10000000">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label required">Tanggal Bergabung</label>
                                                                    <input type="date" class="form-control" name="join_date" required min="{{ date('Y-m-d') }}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Terbitkan Offering Letter</button>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
