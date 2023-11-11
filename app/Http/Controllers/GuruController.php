<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index()
    {
        return view('pages.guru.index');
    }


    public function data(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::table('guru')
                ->select('guru.*')->orderBy('nama', 'ASC');

            return datatables()->of($data)
                ->addColumn('aksi', function ($data) {
                    $button = '<div class="d-flex justify-content-start align-items-center">
            <a href="' . route('guru.edit', $data->id) . '" class="btn btn-sm btn-outline-warning">
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

    public function tambah(Request $request)
    {
        return view('pages.guru.tambah');
    }

    public function simpan(Request $request)
    {

        $tambah_guru =  DB::table('guru')
            ->insertGetId([
                'nama' => $request->nama,
                'nidn' => $request->nidn,
            ]);

        if ($tambah_guru) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data ditambah'
            ]);
        }
    }

    public function edit($id)
    {
        $data = DB::table('guru')
            ->select('guru.*')
            ->where('guru.id', $id)->first();

        return view('pages.guru.edit', [
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $guru = DB::table('guru')->where('id', $request->id)
            ->update([
                'nama' => $request->nama,
                'nidn' => $request->nidn
            ]);

        if ($guru) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data diubah'
            ]);
        }
    }

    public function hapus(Request $request)
    {
        $data = DB::table('guru')->where('id', $request->id)->delete();

        if ($data) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data dihapus'
            ]);
        }
    }
}
