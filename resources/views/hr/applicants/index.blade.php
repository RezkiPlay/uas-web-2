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
                        <th scope="col">Status Lowongan</th>
                        <th scope="col">Jumlah Pelamar</th>
                        <th scope="col" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jobs as $job)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->department->name ?? '-' }}</td>
                            <td>
                                @if($job->status == 'approved')
                                    <span class="badge bg-success">Active</span>
                                @elseif($job->status == 'closed')
                                    <span class="badge bg-dark">Closed</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary rounded-pill">{{ $job->applications_count }}</span>
                            </td>
                            <td>
                                <a href="{{ route('hr.applicants.show', $job) }}" class="btn btn-info btn-sm" title="Lihat Pelamar">
                                    <i class='bx bx-group'></i> Lihat Pelamar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Anda belum memiliki lowongan yang berstatus disetujui atau ditutup.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app>
