<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Movie Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<div class="container mt-5">
    <a href="/" class="btn btn-outline-light mb-3">&larr; กลับไปหน้าค้นหา</a>

    <div class="card bg-secondary text-white border-0 shadow-lg">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x450' }}" 
                     class="img-fluid rounded-start w-100" alt="Poster">
            </div>
            
            <div class="col-md-8">
                <div class="card-body">
                    <h1 class="card-title text-warning">{{ $movie['Title'] }}</h1>
                    <p class="text-muted">
                        {{ $movie['Year'] }} • {{ $movie['Rated'] }} • {{ $movie['Runtime'] }}
                    </p>
                    
                    <span class="badge bg-primary mb-3">{{ $movie['Genre'] }}</span>

                    <h5 class="mt-3">เรื่องย่อ (Plot)</h5>
                    <p class="card-text">{{ $movie['Plot'] }}</p>

                    <h5 class="mt-3">นักแสดงนำ</h5>
                    <p class="text-info">{{ $movie['Actors'] }}</p>

                    <h5 class="mt-3">คะแนน IMDb ⭐</h5>
                    <h3 class="text-warning">{{ $movie['imdbRating'] }} / 10</h3>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>