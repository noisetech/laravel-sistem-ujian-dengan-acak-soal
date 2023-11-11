<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlah_guru = DB::table('guru')
            ->select(DB::raw('count(*) as jumlah_guru'))
            ->first();

        $jumlah_siswa = DB::table('siswa')
            ->select(DB::raw('count(*) as jumlah_siswa'))
            ->first();

        $jumlah_mapel = DB::table('mapel')
            ->select(DB::raw('count(*) as jumlah_mapel'))
            ->first();

        return view('pages.dashboard', [
            'jumlah_guru' => $jumlah_guru,
            'jumlah_siswa' => $jumlah_siswa,
            'jumlah_mapel' => $jumlah_mapel,
        ]);
    }
}
