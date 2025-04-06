<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LombaKuy - Katalog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">LombaKuy</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <h2 class="mb-4">Katalog Lomba</h2>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            @foreach ($competitions as $competition)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div style="height: 300px; overflow: hidden;">
                            <img 
                                src="{{ asset('storage/' . $competition->photo) }}" 
                                class="card-img-top img-thumbnail"
                                alt="{{ $competition->title }}"
                                style="cursor:pointer"
                                data-bs-toggle="modal"
                                data-bs-target="#previewModal"
                                data-img="{{ asset('storage/' . $competition->photo) }}">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $competition->title }}</h5>
                            <p class="card-text text-muted">{{ $competition->category }}</p>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($competition->description, 80) }}</p>
                        </div>
                        <div class="card-footer bg-white">
                            <small class="text-primary fw-bold">Hadiah: {{ $competition->prize }}</small><br>
                            <small class="text-danger">Deadline: {{ \Carbon\Carbon::parse($competition->deadline)->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <!-- Modal Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Full Poster" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS & Script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const previewModal = document.getElementById('previewModal');

            previewModal.addEventListener('show.bs.modal', function (event) {
                const trigger = event.relatedTarget;
                if (!trigger) return;

                const imageUrl = trigger.getAttribute('data-img');
                const modalImage = document.getElementById('modalImage');
                if (modalImage && imageUrl) {
                    modalImage.src = imageUrl;
                }
            });
        });
    </script>
</body>
</html>
