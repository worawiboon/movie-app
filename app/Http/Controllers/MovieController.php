<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // 👈 พระเอกของเรา! ต้อง Import ตัวนี้

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $movies = []; // เตรียมตัวแปรว่างไว้ก่อน

        // ถ้ามีการส่งค่า ?search=... มา
        if ($request->has('search')) {
            $apiKey = env('OMDB_API_KEY'); // ดึงกุญแจจาก .env
            $query = $request->search;

            // 🔥 บรรทัดนี้คือเวทมนตร์! ดึงข้อมูลจาก API ง่ายๆ
            $response = Http::get("http://www.omdbapi.com/?apikey={$apiKey}&s={$query}");
            
            // แปลง JSON เป็น Array พร้อมใช้งาน
            if ($response->successful()) {
                $movies = $response->json()['Search'] ?? [];
            }
        }

        // ส่งข้อมูล $movies ไปที่หน้าเว็บ (View)
        return view('movies', compact('movies'));
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