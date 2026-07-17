<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('hr.jobs.create') }}" role="button">Buat Lowongan</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px;">#</th>
                        <th scope="col">Posisi</th>
                        <th scope="col">Departemen</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal Dibuat</th>
                        <th scope="col" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->department->name ?? '-' }}</td>
                            <td>
                                @if($job->status == 'draft')
                                    <span class="badge bg-secondary">Draft</span>
                                @elseif($job->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($job->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($job->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @elseif($job->status == 'closed')
                                    <span class="badge bg-dark">Closed</span>
                                @endif
                            </td>
                            <td>{{ $job->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('hr.jobs.edit', $job) }}" class="btn btn-info btn-sm" title="Detail/Edit">
                                        <i class='bx bx-edit-alt'></i>
                                    </a>
                                    
                                    @if(in_array($job->status, ['draft', 'rejected']))
                                        <form action="{{ route('hr.jobs.submit', $job) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('patch')
                                            <button type="submit" class="btn btn-primary btn-sm" title="Ajukan Approval" onclick="return confirm('Apakah Anda yakin ingin mengajukan lowongan ini untuk approval?')">
                                                <i class='bx bx-send'></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if($job->status == 'approved')
                                        <form action="{{ route('hr.jobs.close', $job) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('patch')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Tutup Lowongan" onclick="return confirm('Apakah Anda yakin ingin menutup lowongan ini?')">
                                                <i class='bx bx-x-circle'></i>
                                            </button>
                                        </form>
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
