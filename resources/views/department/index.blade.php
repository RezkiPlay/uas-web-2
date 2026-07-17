<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        @if(auth()->user()->role == 'admin')
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('department.create') }}" role="button">Tambah</a>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px;">#</th>
                        <th scope="col">Nama Departemen</th>
                        <th scope="col">Deskripsi</th>
                        @if(auth()->user()->role == 'admin')
                        <th scope="col" style="width: 150px;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->description ?? '-' }}</td>
                            @if(auth()->user()->role == 'admin')
                            <td>
                                <a href="{{ route('department.edit', $department) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('department.destroy', $department) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })
        </script>
    @endpush
</x-app>
