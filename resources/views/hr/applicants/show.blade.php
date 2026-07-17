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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada pelamar yang mendaftar untuk posisi ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app>
