<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px;">#</th>
                        <th scope="col">Posisi</th>
                        <th scope="col">Departemen</th>
                        <th scope="col">Dibuat Oleh</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal Diajukan</th>
                        <th scope="col" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->department->name ?? '-' }}</td>
                            <td>{{ $job->creator->name ?? '-' }}</td>
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
                            <td>{{ $job->updated_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.jobs.show', $job) }}" class="btn btn-info btn-sm" title="Detail">
                                    <i class='bx bx-show'></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
