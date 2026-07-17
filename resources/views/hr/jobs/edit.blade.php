<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        @if($job->status == 'rejected')
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Lowongan Ditolak!</h4>
                <p>Alasan penolakan: <strong>{{ $job->rejection_reason }}</strong></p>
                <hr>
                <p class="mb-0">Silakan perbaiki lowongan di bawah ini dan ajukan ulang.</p>
            </div>
        @endif

        <form action="{{ route('hr.jobs.update', $job) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="title" class="form-label required">Judul Posisi (Lowongan)</label>
                <input class="form-control @error('title') is-invalid @enderror" type="text" id="title"
                    name="title" required value="{{ old('title', $job->title) }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="department_id" class="form-label required">Departemen</label>
                <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id" required>
                    <option value="">-- Pilih Departemen --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $job->department_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label required">Deskripsi Lowongan</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" rows="4" required>{{ old('description', $job->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="requirements" class="form-label required">Persyaratan (Requirements)</label>
                <textarea class="form-control @error('requirements') is-invalid @enderror" id="requirements"
                    name="requirements" rows="4" required>{{ old('requirements', $job->requirements) }}</textarea>
                @error('requirements')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="text-end">
                <a href="{{ route('hr.jobs.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</x-app>
