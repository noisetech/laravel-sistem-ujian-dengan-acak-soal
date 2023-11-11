<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function index()
    {
        return view('pages.siswa.index');
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::table('siswa')->orderBy('nama', 'ASC');

            return datatables()->of($data)
                ->addColumn('kelas', function ($data) {
                    $kelas = DB::table('siswa')
                        ->select('kelas.*')
                        ->join('kelas', 'kelas.id', '=', 'siswa.kelas_id')
                        ->where('siswa.id', $data->id)
                        ->orderBy('nama', 'ASC')
                        ->get();

                    foreach ($kelas as $k) {
                        return $k->kelas;
                    }
                })
                ->addColumn('aksi', function ($data) {
                    $button = "

                <div class='d-flex justify-content-start'>
                <a class='mx-2 btn btn-sm btn-warning
                ' title='Edit' href='" . route('guru.edit', $data->id) . "' ><i class='fas fa-sm fa-pencil-alt px-1'></i> Edit</a>";
                    $button  .= "<a class='btn btn-sm btn-danger hapus' href='javascript:void(0);'
                data-id='" . $data->id . "'><i class='fas fa-sm fa-trash-alt px-1'></i>Hapus</a>
           </div>
        ";
                    return $button;
                })
                ->rawColumns(['kelas', 'aksi'])
                ->make('true');
        }
    }

    public function tambah()
    {
        return view('pages.siswa.tambah');
    }

    public function simpan(Request $request)
    {
        $data = DB::table('siswa')->insert([
            'nama' => $request->nama,
            'kelas_id' => $request->kelas_id,
            'nisn' => $request->nisn
        ]);

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data simpan'
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


    public function edit($id)
    {
        $data = DB::table('siswa')->where('id', $id)->first();

        return view('pages.siswa.edit', [
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()->toArray()
            ]);
        }

        $data = DB::table('siswa')
            ->where('id', $request->id)
            ->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon
            ]);

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data diubah'
            ]);
        }
    }

    public function hapus(Request $request)
    {
        $data = DB::table('siswa')->where('id', $request->id)->delete();

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data dihapus'
            ]);
        }
    }
}
