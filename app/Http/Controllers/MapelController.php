<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapelController extends Controller
{
    public function index()
    {
        return view('pages.mapel.index');
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::table('mapel')
                ->select('mapel.*')->orderBy('nama', 'ASC');

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



    public function tambah()
    {
        return view('pages.mapel.tambah');
    }


    public function hapus(Request $request)
    {
        $data = DB::table('mapel')->where('id', $request->id)->delete();

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data dihapus'
            ]);
        }
    }

    public function simpan(Request $request)
    {

        $data = DB::table('mapel')->insert([

            'nama' =>  $request->nama,
        ]);

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data ditambah'
            ]);
        }
    }

    public function edit($id)
    {

        $data = DB::table('mapel')->where('id', $id)->first();

        return view('pages.mapel.edit', [
            'data' => $data
        ]);
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


    public function detial($id)
    {
        $data = DB::table('mapel')->where('id', $id)->first();

        return view('pages.mapel.detail', [
            'data' => $data
        ]);
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

    public function update(Request $request)
    {

        // dd($request->all());
        $data = DB::table('mapel')
            ->where('id', $request->id)
            ->update([

                'nama' =>  $request->nama,

            ]);

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data diubah'
            ]);
        }
    }
}
