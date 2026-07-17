<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px;">#</th>
                        <th scope="col">Posisi (Lowongan)</th>
                        <th scope="col">Departemen</th>
                        <th scope="col">Tanggal Melamar</th>
                        <th scope="col">Status Lamaran</th>
                        <th scope="col" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $app)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $app->jobPosting->title }}</td>
                            <td>{{ $app->jobPosting->department->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($app->applied_at)->format('d M Y, H:i') }}</td>
                            <td>
                                @if($app->status == 'applied')
                                    <span class="badge bg-secondary">Terkirim</span>
                                @elseif($app->status == 'interview')
                                    <span class="badge bg-primary">Interview</span>
                                @elseif($app->status == 'assessment')
                                    <span class="badge bg-info text-dark">Assessment</span>
                                @elseif($app->status == 'offered')
                                    <span class="badge bg-success">Offering</span>
                                @elseif($app->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif

                                @if($app->interviewSchedule)
                                    <div class="mt-2 p-2 border rounded bg-light small">
                                        <strong><i class='bx bx-calendar-event'></i> Jadwal:</strong><br>
                                        {{ \Carbon\Carbon::parse($app->interviewSchedule->schedule_time)->format('d M Y, H:i') }}<br>
                                        <strong>Lokasi/Link:</strong> {{ $app->interviewSchedule->location_or_link }}
                                        @if($app->interviewSchedule->notes)
                                            <br><strong>Catatan:</strong> {{ $app->interviewSchedule->notes }}
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('jobs.show', $app->jobPosting) }}" class="btn btn-info btn-sm" title="Lihat Lowongan">
                                        <i class='bx bx-show'></i> Detail
                                    </a>
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#timelineModal{{ $app->id }}">
                                        <i class='bx bx-history'></i> Riwayat
                                    </button>
                                </div>

                                <!-- Timeline Modal -->
                                <div class="modal fade" id="timelineModal{{ $app->id }}" tabindex="-1" aria-labelledby="timelineModalLabel{{ $app->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="timelineModalLabel{{ $app->id }}">Riwayat Status Lamaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="timeline">
                                                    @forelse($app->statusLogs as $log)
                                                        <div class="mb-3 border-start border-primary border-3 ps-3">
                                                            <div class="small text-muted">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }}</div>
                                                            <div class="fw-bold mt-1">
                                                                @if($log->previous_status)
                                                                    <span class="text-decoration-line-through text-muted fw-normal">{{ $log->previous_status }}</span>
                                                                    <i class='bx bx-right-arrow-alt mx-1'></i>
                                                                @endif
                                                                <span class="text-primary">{{ $log->new_status }}</span>
                                                            </div>
                                                            <div class="small text-muted mt-1">Diubah oleh: {{ $log->changer->name ?? 'Sistem' }}</div>
                                                        </div>
                                                    @empty
                                                        <p class="text-muted text-center">Belum ada riwayat.</p>
                                                    @endforelse
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
