<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JenjangMapelController extends Controller
{
    public function index()
    {
        return view('pages.jenjang-mapel.index');
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::table('jenjang_mapel')
                ->select('jenjang_mapel.*', 'mapel.nama as mapel', 'kelas.kelas as kelas', 'guru.nama as guru')
                ->join('mapel', 'mapel.id', '=', 'jenjang_mapel.mapel_id')
                ->join('kelas', 'kelas.id', '=', 'jenjang_mapel.kelas_id')
                ->join('guru', 'guru.id', '=', 'jenjang_mapel.guru_id');


            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    if (Auth::user()->role === 'siswa') {
                        $button = '<div class="d-flex justify-content-start align-items-center">


                        <a class="btn btn-sm btn-outline-primary mx-1" href="'.route('ujian', $data->id).'">
                        <i class="fas fa-sm fa-eye"></i> Ujian
                         </a>
                       </div>';

                        return $button;
                    } else {
                        $button = '<div class="d-flex justify-content-start align-items-center">


                        <a class="btn btn-sm btn-outline-danger  hapus mx-1" href="javascript:void(0)" data-id="' . $data->id . '">
                        <i class="fas fa-sm fa-trash-alt"></i> Hapus
                         </a>
                       </div>';

                        return $button;
                    }
                })
                ->rawColumns(['aksi'])
                ->make('true');
        }
    }

    public function tambah()
    {
        return view('pages.jenjang-mapel.tambah');
    }

    public function simpan(Request $request)
    {
        $data = DB::table('jenjang_mapel')->insert([
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'guru_id' => $request->guru_id
        ]);

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data ditambah'
            ]);
        }
    }

    public function listKelas(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $data = DB::table('kelas')
                ->select('kelas.id as id', 'kelas.kelas as kelas')
                ->where('kelas.kelas', 'LIKE', "%$search%")
                ->get();

            $result = [];

            foreach ($data as $d) {
                $result[] = [
                    'id' => $d->id,
                    'text' => $d->kelas
                ];
            }

            return response()->json($result);
        } else {
            $data = DB::table('kelas')
                ->select('kelas.id as id', 'kelas.kelas as kelas')
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
    }

    public function listGuru(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $data = DB::table('guru')
                ->select('guru.id as id', 'guru.nama as nama')
                ->where('guru.nama', 'LIKE', "%$search%")
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
            $data = DB::table('guru')
                ->select('guru.id as id', 'guru.nama as nama')
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

    public function edit($id)
    {
    }

    public function update(Request $request)
    {
    }

    public function hapus(Request $request)
    {

        dd($request->all());

        $data = DB::table('jenjang_mapel')->where('id', $request->id)->delete();

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data dihapus'
            ]);
        }
    }
}
