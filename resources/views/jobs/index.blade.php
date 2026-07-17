<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold">Temukan Karir Impianmu</h2>
            <p class="text-muted">Jelajahi berbagai peluang karir yang tersedia di perusahaan kami.</p>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($jobs as $job)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 transition-hover">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-brand-100 text-brand-700 px-3 py-2 rounded-pill">
                                {{ $job->department->name ?? 'Umum' }}
                            </span>
                            <small class="text-muted">{{ $job->updated_at->diffForHumans() }}</small>
                        </div>
                        <h4 class="card-title fw-bold mb-3">{{ $job->title }}</h4>
                        <p class="card-text text-secondary mb-4 line-clamp-3">
                            {{ Str::limit($job->description, 120) }}
                        </p>
                        <a href="{{ route('jobs.show', $job) }}" class="btn btn-outline-primary w-100 stretched-link rounded-pill fw-medium">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted mb-3">
                    <i class='bx bx-search fs-1'></i>
                </div>
                <h4>Belum ada lowongan</h4>
                <p class="text-secondary">Saat ini belum ada lowongan pekerjaan yang tersedia. Silakan cek kembali nanti.</p>
            </div>
        @endforelse
    </div>
    
    <style>
        .transition-hover {
            transition: all 0.3s ease;
        }
        .transition-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
        .bg-brand-100 {
            background-color: #dbeafe !important;
        }
        .text-brand-700 {
            color: #1d4ed8 !important;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
</x-app>
