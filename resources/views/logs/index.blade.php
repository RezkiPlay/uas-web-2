<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px;">#</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Tipe Log</th>
                        <th scope="col">Konteks (Lowongan / Pelamar)</th>
                        <th scope="col">Perubahan Status</th>
                        <th scope="col">Diubah Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i:s') }}</td>
                            <td>
                                @if($log->job_posting_id)
                                    <span class="badge bg-secondary">Lowongan</span>
                                @elseif($log->application_id)
                                    <span class="badge bg-info text-dark">Lamaran</span>
                                @endif
                            </td>
                            <td>
                                @if($log->job_posting_id)
                                    <strong>{{ $log->jobPosting->title ?? 'N/A' }}</strong>
                                @elseif($log->application_id)
                                    Pelamar: <strong>{{ $log->application->applicant->user->name ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">Lowongan: {{ $log->application->jobPosting->title ?? 'N/A' }}</small>
                                @endif
                            </td>
                            <td>
                                @if($log->previous_status)
                                    <span class="text-muted text-decoration-line-through">{{ $log->previous_status }}</span>
                                    <i class='bx bx-right-arrow-alt mx-1'></i>
                                @else
                                    <span class="text-muted">(Baru)</span>
                                    <i class='bx bx-right-arrow-alt mx-1'></i>
                                @endif
                                <strong>{{ $log->new_status }}</strong>
                            </td>
                            <td>
                                {{ $log->changer->name ?? 'Sistem' }}
                                <br><small class="text-muted">({{ $log->changer->role ?? 'N/A' }})</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-app>
