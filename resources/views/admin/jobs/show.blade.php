<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-lg p-4">
                <div class="mb-4">
                    <h3 class="mb-1">{{ $job->title }}</h3>
                    <p class="text-muted mb-0">
                        <i class='bx bx-building'></i> {{ $job->department->name ?? '-' }} | 
                        <i class='bx bx-user'></i> Dibuat oleh {{ $job->creator->name ?? '-' }}
                    </p>
                </div>

                <div class="mb-4">
                    <h5>Deskripsi Pekerjaan</h5>
                    <div class="p-3 bg-light rounded border">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>

                <div class="mb-4">
                    <h5>Persyaratan</h5>
                    <div class="p-3 bg-light rounded border">
                        {!! nl2br(e($job->requirements)) !!}
                    </div>
                </div>
                
                @if($job->status == 'rejected')
                    <div class="alert alert-danger mt-3">
                        <strong>Alasan Penolakan Sebelumnya:</strong><br>
                        {{ $job->rejection_reason }}
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg p-4">
                <h5 class="mb-3">Status Lowongan</h5>
                <div class="mb-4">
                    @if($job->status == 'draft')
                        <span class="badge bg-secondary fs-6 w-100 py-2">Draft</span>
                    @elseif($job->status == 'pending')
                        <span class="badge bg-warning text-dark fs-6 w-100 py-2">Pending Review</span>
                    @elseif($job->status == 'approved')
                        <span class="badge bg-success fs-6 w-100 py-2">Approved</span>
                    @elseif($job->status == 'rejected')
                        <span class="badge bg-danger fs-6 w-100 py-2">Rejected</span>
                    @elseif($job->status == 'closed')
                        <span class="badge bg-dark fs-6 w-100 py-2">Closed</span>
                    @endif
                </div>

                @if($job->status == 'pending')
                    <hr>
                    <h6 class="mb-3">Tindakan Admin</h6>
                    
                    <form action="{{ route('admin.jobs.approve', $job) }}" method="POST" class="mb-2">
                        @csrf
                        @method('patch')
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Apakah Anda yakin ingin MENG-APPROVE lowongan ini?')">
                            <i class='bx bx-check-circle'></i> Approve Lowongan
                        </button>
                    </form>

                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class='bx bx-x-circle'></i> Reject Lowongan
                    </button>
                @endif
                
                <div class="mt-4">
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-secondary w-100">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>

    @if($job->status == 'pending')
        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin.jobs.reject', $job) }}" method="POST">
                    @csrf
                    @method('patch')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">Tolak Lowongan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="rejection_reason" class="form-label required">Alasan Penolakan</label>
                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required placeholder="Jelaskan alasan menolak lowongan ini..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Tolak Lowongan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
</x-app>
