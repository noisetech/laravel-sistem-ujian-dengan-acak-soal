<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UjianController extends Controller
{
    public function index($id)
    {
        $semuaNomorSoal = DB::table('bank_soal')->select('no_urut')->get();

        $shuffled = collect($semuaNomorSoal->pluck('no_urut'))->shuffle();

        $shuffled = $shuffled->all();


        $bank_soal = DB::table('bank_soal')
            ->whereIn('no_urut', $shuffled)
            ->where('bank_soal.jenjang_mapel_id', $id)
            ->orderByRaw(DB::raw('FIELD(no_urut, ' . implode(',', $shuffled) . ')'))
            ->get();

        // $jenjang_mapel = DB::table('jenjang_mapel')
        //     ->select('jenjang_mapel.*', 'mapel.nama as nama_mapel', 'guru.nama as nama_guru', 'kelas.kelas as kelas')
        //     ->join('mapel', 'mapel.id', '=', 'jenjang_mapel.mapel_id')
        //     ->join('guru', 'guru.id', '=', 'jenjang_mapel.guru_id')
        //     ->join('kelas', 'kelas.id', '=', 'jenjang_mapel.kelas_id')
        //     ->get();

        // dd($jenjang_mapel);


        return view('pages.ujian.index', [
            'bank_soal' => $bank_soal,
            'jenjang_mapel_id' => $id
        ]);
    }

    public function proses(Request $request)
    {

        $skor = 0; //skor awal
        foreach ($request->jawaban_user as $jawaban) {

            // bagian untuk nomor urut soal dan jawaban yang di isi siswa
            list($soal, $jawabanUser) = explode(",", $jawaban);

            // lalu ambil tiap soal dan jawabannya
            $soal = explode(":", $soal)[1]; // Ambil nomor soal
            $jawabanUser = explode(":", $jawabanUser)[1]; // Ambil jawaban user

            // Cari jawaban benar dan skor dari tabel bank soal berdasarkan nomor soal
            $dataSoal = DB::table('bank_soal')
                ->where('no_urut', $soal)
                ->select('jawaban_benar', 'score')
                ->first();

            if ($dataSoal) {
                $jawabanBenar = $dataSoal->jawaban_benar;
                $scoreSoal = $dataSoal->score;

                // Bandingkan jawaban user dengan jawaban benar
                if ($jawabanUser === $jawabanBenar) {
                    $skor += $scoreSoal; // Tambahkan skor berdasarkan score soal
                }
            }
        }


        $hasil_ujian = DB::table('hasil_ujian')->insert([
            'users_id' => Auth::user()->id,
            'jenjang_mapel_id' => $request->jenjang_mapel_id,
            'hasil' => $skor
        ]);

        if ($hasil_ujian) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data disimpan'
            ]);
        }
    }

    public function hasil_ujian()
    {

        return view('pages.ujian.hasil');
    }

    public function data_hasil_ujian(Request $request)
    {
        if (request()->ajax()) {

            $data = DB::table('hasil_ujian')
                ->select('hasil_ujian.*', 'users.name as nama', 'mapel.nama as nama_mapel', 'guru.nama as nama_guru', 'kelas.kelas as kelas', 'hasil_ujian.hasil')
                ->join('users', 'users.id', '=', 'hasil_ujian.users_id')
                ->join('jenjang_mapel', 'jenjang_mapel.id', '=', 'hasil_ujian.jenjang_mapel_id')
                ->join('mapel', 'mapel.id', '=', 'jenjang_mapel.mapel_id')
                ->join('guru', 'guru.id', '=', 'jenjang_mapel.guru_id')
                ->join('kelas', 'kelas.id', '=', 'jenjang_mapel.kelas_id')
                ->where('users.id', Auth::user()->id)
                ->get();

            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="d-flex justify-content-start align-items-center">
        <a href="' . route('mapel.edit', $data->id) . '" class="btn btn-sm btn-outline-warning">
        <i class="fas fa-sm fa-edit"></i> Edit
    </a>

            <a class="btn btn-sm btn-outline-danger  hapus mx-1" href="javascript:void(0)" data-id="' . $data->id . '">
            <i class="fas fa-sm fa-trash-alt"></i> Hapus
            </a>
        </div>';

                    return $button;
                })
                ->rawColumns(['aksi'])
                ->make('true');
        }
    }
}
