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
                    @forelse ($applications as $app)
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
                            </td>
                            <td>
                                <a href="{{ route('jobs.show', $app->jobPosting) }}" class="btn btn-info btn-sm" title="Lihat Lowongan">
                                    <i class='bx bx-show'></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada riwayat lamaran. <br>
                                <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-sm mt-2">Cari Lowongan</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app>
