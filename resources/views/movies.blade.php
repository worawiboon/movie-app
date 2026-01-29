<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieFlix - ดูหนังออนไลน์</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        /* --- NETFLIX THEME CSS --- */
        :root {
            --netflix-red: #E50914;
            --netflix-black: #141414;
            --netflix-dark-grey: #181818;
            --netflix-light-grey: #b3b3b3;
        }

        body {
            background-color: var(--netflix-black);
            color: white;
            font-family: 'Kanit', sans-serif;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(to bottom, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 100%);
            padding: 20px 0;
        }
        .brand-logo {
            color: var(--netflix-red) !important;
            font-weight: 900;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        /* Search Section */
        .hero-section {
            padding: 80px 0 40px;
            text-align: center;
        }
        .search-input {
            background-color: rgba(0,0,0,0.5);
            border: 1px solid white;
            color: white;
            padding: 12px 20px;
            border-radius: 0;
        }
        .search-input::placeholder { color: var(--netflix-light-grey); }
        .search-input:focus {
            background-color: rgba(0,0,0,0.7);
            color: white;
            box-shadow: none;
            border-color: var(--netflix-red);
        }
        .btn-netflix {
            background-color: var(--netflix-red);
            color: white;
            border-radius: 0;
            font-weight: bold;
            padding: 12px 30px;
        }
        .btn-netflix:hover {
            background-color: #f40612;
            color: white;
        }

        /* Movie Cards */
        .movie-card {
            background-color: var(--netflix-dark-grey);
            border: none;
            transition: transform 0.3s ease, z-index 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            border-radius: 4px;
        }
        .movie-card:hover {
            transform: scale(1.1); /* ซูมเมื่อเอาเมาส์ชี้ */
            z-index: 10;
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }
        .card-img-top {
            height: 400px;
            object-fit: cover;
            opacity: 0.9;
            transition: opacity 0.3s;
        }
        .movie-card:hover .card-img-top { opacity: 1; }
        
        .card-body {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 10%, rgba(0,0,0,0));
            padding: 20px 10px 10px;
            opacity: 0; /* ซ่อนรายละเอียดไว้ก่อน */
            transition: opacity 0.3s;
        }
        .movie-card:hover .card-body { opacity: 1; } /* โชว์รายละเอียดตอนโฮเวอร์ */

        .rating-badge {
            background-color: rgba(0,0,0,0.6);
            border: 1px solid white;
            padding: 2px 5px;
            font-size: 0.7rem;
        }

        /* Pagination Styles */
        .page-link {
            background-color: var(--netflix-black);
            border-color: #333;
            color: white;
        }
        .page-link:hover {
            background-color: #333;
            color: white;
            border-color: white;
        }
        .page-item.disabled .page-link {
            background-color: #000;
            color: #555;
            border-color: #333;
        }
    </style>
</head>
<body>

    <nav class="navbar fixed-top">
        <div class="container">
            <a class="navbar-brand brand-logo" href="/">MOVIEHOT</a>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        
        <div class="hero-section">
            <h2 class="mb-4 fw-light">ค้นหาภาพยนตร์ รายการทีวี และอีกมากมาย</h2>
            <form action="/" method="GET" class="d-flex justify-content-center w-75 mx-auto">
                <input type="text" name="search" class="form-control search-input" 
                       placeholder="ชื่อเรื่อง, คนแสดง, ประเภท..." 
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-netflix ms-2">ค้นหา</button>
            </form>
        </div>

        <div class="row g-4"> @if(isset($movies) && count($movies) > 0)
                @foreach($movies as $movie)
                    <div class="col-6 col-md-3 col-lg-2"> <a href="{{ route('movie.show', $movie['imdbID']) }}" class="text-decoration-none text-white">
                            <div class="card movie-card h-100">
                                <img src="{{ $movie['Poster'] != 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x450?text=No+Image' }}" 
                                     class="card-img-top" alt="Poster">
                                <div class="card-body">
                                    <h6 class="card-title text-truncate">{{ $movie['Title'] }}</h6>
                                    <div class="d-flex justify-content-between align-items-center small">
                                        <span class="text-success fw-bold">98% Match</span> <span class="rating-badge">{{ $movie['Year'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center text-muted py-5">
                    <h1>🍿</h1>
                    <h4>ยังไม่ได้ค้นหาหนัง หรือไม่พบข้อมูล</h4>
                </div>
            @endif
        </div>

        @if(isset($totalPages) && $totalPages > 1)
            <nav class="mt-5 mb-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item {{ $page <= 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ url('/?search='.$search.'&page='.($page-1)) }}">Previous</a>
                    </li>
                    <li class="page-item disabled">
                        <span class="page-link">Page {{ $page }} of {{ $totalPages }}</span>
                    </li>
                    <li class="page-item {{ $page >= $totalPages ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ url('/?search='.$search.'&page='.($page+1)) }}">Next</a>
                    </li>
                </ul>
            </nav>
        @endif

    </div>

</body>
</html>