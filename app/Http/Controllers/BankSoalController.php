<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankSoalController extends Controller
{
    public function index()
    {
        return view('pages.bank-soal.index');
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {

            $data = DB::table('bank_soal')
                ->select('bank_soal.*', 'mapel.nama as nama_mapel', 'guru.nama as nama_guru', 'kelas.kelas as kelas')
                ->join('jenjang_mapel', 'jenjang_mapel.id', '=', 'bank_soal.jenjang_mapel_id')
                ->join('mapel', 'mapel.id', '=', 'jenjang_mapel.mapel_id')
                ->join('guru', 'guru.id', '=', 'jenjang_mapel.guru_id')
                ->join('kelas', 'kelas.id', '=', 'jenjang_mapel.kelas_id');

            return datatables()->of($data)
                ->editColumn('soal', function ($data) {
                    return '<div class="tinymce-content">' . $data->soal . '</div>';
                })
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="d-flex justify-content-start align-items-center">


             <a class="btn btn-sm btn-outline-danger  hapus mx-1" href="javascript:void(0)" data-id="' . $data->id . '">
             <i class="fas fa-sm fa-trash-alt"></i> Hapus
              </a>
            </div>';

                    return $button;
                })
                ->rawColumns(['aksi', 'soal', 'keterangan_jawaban'])
                ->make('true');
        }
    }

    public function tambah()
    {
        return view('pages.bank-soal.tambah');
    }

    public function simpan(Request $request)
    {
        // dd($request->all());

        $db_jenjang_mapel = DB::table('jenjang_mapel')
            ->select('jenjang_mapel.*')
            ->where('mapel_id', $request->mapel_id)
            ->where('guru_id', $request->guru_id)
            ->where('kelas_id', $request->kelas_id)
            ->first();


        $banksoal = DB::table('bank_soal')->insertGetId([
            'no_urut' => $request->no_urut,
            'soal' => $request->soal,
            'jawaban_benar' => strtoupper($request->jawaban),
            'jenjang_mapel_id' => $db_jenjang_mapel->id,
            'score' => $request->score
        ]);

        foreach ($request->huruf as $key => $value) {

            DB::table('pilgan')
            ->insert([
                'bank_soal_id' => $banksoal,
                'huruf' => strtoupper($value),
                'isi' => $request->jawaban_huruf[$key]
            ]);
        }

        return response()->json([
            'status' => 'success',
            'title' => 'Berhasil',
            'message' => 'Data disimpan'
        ]);
    }

    public function listMapel(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $data = DB::table('mapel')
                ->select('mapel.id as id', 'mapel.nama as nama')
                ->where('mapel.nama', 'LIKE', "%$search%")
                ->get();

            $result = [];

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->nama
                ];
            }

            return response()->json($result);
        } else {

            $data = DB::table('mapel')
                ->select('mapel.id as id', 'mapel.nama as nama')
                ->get();

            $result = [];

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->nama
                ];
            }

            return response()->json($result);
        }
    }


    public function listKelas($id)
    {
        $data = DB::table('kelas')
            ->select('kelas.*')
            ->where('kelas.kelas', 'LIKE', '%' . request('q') . '%')
            ->get();

        $result = [];

        foreach ($data as $d) {
            $result[] = [
                'id' => $d->id,
                'text' => $d->kelas
            ];
        }

        return response()->json($result);
    }

    public function listGuru($id_mapel, $id_kelas)
    {
        $data = DB::table('jenjang_mapel')
            ->select('guru.*')
            ->join('guru', 'guru.id', '=', 'jenjang_mapel.guru_id')
            ->where('guru.nama', 'LIKE', '%' . request('q') . '%')
            ->where('jenjang_mapel.mapel_id', $id_mapel)
            ->where('jenjang_mapel.kelas_id', $id_kelas)
            ->get();

        foreach ($data as $d) {
            $result[] = [
                'id' => $d->id,
                'text' => $d->nama
            ];
        }

        return response()->json($result);
    }

    public function hapus(Request $request)
    {
        $data = DB::table('kunci_jawaban')->where('id', $request->id)->delete();

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data dihapus'
            ]);
        }
    }
}
