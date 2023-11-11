<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index()
    {
        return view('pages.kelas.index');
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::table('kelas')
                ->select('kelas.*')->orderBy('kelas', 'ASC');

            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="d-flex justify-content-start align-items-center">
            <a href="' . route('kelas.edit', $data->id) . '" class="btn btn-sm btn-outline-warning">
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
        return view('pages.kelas.create');
    }

    public function simpan(Request $request)
    {

        $data = DB::table('kelas')->insert([
            'kelas' => $request->kelas
        ]);

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data disimpan'
            ]);
        }
    }

    public function edit($id)
    {
        $data = DB::table('kelas')->where('id', $id)->first();
        return view('pages.kelas.edit', [
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {

        $data = DB::table('kelas')
            ->where('id', $request->id)
            ->update([
                'kelas' => $request->kelas
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
        $data = DB::table('kelas')->where('id', $request->id)->delete();

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data disimpan'
            ]);
        }
    }
}
