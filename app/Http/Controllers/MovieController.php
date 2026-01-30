<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index(Request $request)
{
    $movies = [];
    $search = $request->input('search');
    $page = $request->input('page', 1); // รับค่าหน้า ถ้าไม่มีให้เริ่มที่ 1
    $totalPages = 0;

    if ($search) {
        $apiKey = env('OMDB_API_KEY');
        
        // ส่งพารามิเตอร์ &page= เข้าไปด้วย
        $response = Http::get("http://www.omdbapi.com/?apikey={$apiKey}&s={$search}&page={$page}");
        
        if ($response->successful()) {
            $data = $response->json();
            $movies = $data['Search'] ?? [];
            
            // OMDb ส่ง totalResults มาเป็นจำนวนหนังทั้งหมด (เช่น 150 เรื่อง)
            $totalResults = $data['totalResults'] ?? 0;
            // OMDb ให้หน้าละ 10 เรื่องเสมอ เลยต้องหาร 10 เพื่อหาจำนวนหน้าทั้งหมด
            $totalPages = ceil($totalResults / 10);
        }
    }

    // ส่งตัวแปรที่จำเป็นไปที่หน้า View
    return view('movies', compact('movies', 'search', 'page', 'totalPages'));
}

    public function show($id)
    {
        $apiKey = env('OMDB_API_KEY');
        
        // ใช้ i=... แทน s=... เพื่อระบุ ID หนัง (เช่น tt0372784)
        $response = Http::get("http://www.omdbapi.com/?apikey={$apiKey}&i={$id}");
        
        $movie = $response->json();

        return view('show', compact('movie'));
    }
}
