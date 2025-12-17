<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Wajib import ini untuk hitungan manual

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. DATA CHART GENDER (PIE CHART) ---
        // Hitung jumlah laki-laki dan perempuan
        $totalMale = Pegawai::where('gender', 'male')->count();
        $totalFemale = Pegawai::where('gender', 'female')->count();

        // --- 2. DATA CHART PEKERJAAN (BAR CHART) ---
        // Ambil 5 pekerjaan dengan jumlah pegawai terbanyak
        $topPekerjaan = Pekerjaan::withCount('pegawai') // Hitung relasi
            ->orderBy('pegawai_count', 'desc') // Urutkan dari yang terbanyak
            ->take(5) // Ambil 5 saja
            ->get();

        // Pisahkan nama pekerjaan dan jumlahnya ke array terpisah untuk ChartJS
        $labelPekerjaan = $topPekerjaan->pluck('nama');
        $jumlahPegawai = $topPekerjaan->pluck('pegawai_count');

        // Kirim semua variabel ke View
        return view('index', compact('totalMale', 'totalFemale', 'labelPekerjaan', 'jumlahPegawai'));
    }
}