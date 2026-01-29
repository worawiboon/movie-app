<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Search Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

    <div class="container mt-5">
        <h1 class="text-center mb-4 text-warning">🎬 ค้นหาหนัง (OMDb API)</h1>

        <form action="/" method="GET" class="d-flex justify-content-center mb-5">
            <input type="text" name="search" class="form-control w-50 me-2" 
                   placeholder="พิมพ์ชื่อหนัง... (เช่น Batman, Avenger)" 
                   value="{{ request('search') }}"> <button type="submit" class="btn btn-warning">ค้นหา</button>
        </form>

        <div class="row">
            @if(count($movies) > 0)
                @foreach($movies as $movie)
                    <div class="col-md-3 mb-4">
                        <a href="{{ route('movie.show', $movie['imdbID']) }}" class="text-decoration-none">
    <div class="card h-100 bg-secondary text-white border-0 shadow start-card-hover">
        <img src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x450' }}" 
             class="card-img-top" alt="Poster" style="height: 400px; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title">{{ $movie['Title'] }}</h5>
            <p class="card-text text-warning">{{ $movie['Year'] }}</p>
        </div>
    </div>
</a>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center text-muted">
                    <h3>...เริ่มค้นหาหนังที่คุณชอบได้เลย...</h3>
                </div>
            @endif
        </div>
    </div>
    </div> @if($totalPages > 1)
    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            
            <li class="page-item {{ $page <= 1 ? 'disabled' : '' }}">
                <a class="page-link bg-secondary text-white border-0" 
                   href="{{ url('/?search='.$search.'&page='.($page-1)) }}">ก่อนหน้า</a>
            </li>

            <li class="page-item disabled">
                <span class="page-link bg-dark text-warning border-0">
                    หน้า {{ $page }} จาก {{ $totalPages }}
                </span>
            </li>

            <li class="page-item {{ $page >= $totalPages ? 'disabled' : '' }}">
                <a class="page-link bg-secondary text-white border-0" 
                   href="{{ url('/?search='.$search.'&page='.($page+1)) }}">ถัดไป</a>
            </li>

        </ul>
    </nav>
@endif

</body>
</html>