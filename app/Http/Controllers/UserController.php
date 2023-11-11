<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.user.index');
    }

    public function data(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::table('users')->orderBy('name', 'ASC');

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

    public function listSiswa(Request $request)
    {
        if ($request->has('q')) {
            $search = $request->q;

            $data = DB::table('guru')
                ->select('siswa.id as id', 'siswa.nama as nama')
                ->where('siswa.nama', 'LIKE', "%$search%")
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

            $data = DB::table('siswa')
                ->select('siswa.id as id', 'siswa.nama as nama')
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

    public function tambah_akun_guru()
    {
        return view('pages.user.tambah_akun_guru');
    }

    public function simpan_akun_guru(Request $request)
    {
        $guru = DB::table('guru')->where('id', $request->guru_id)->first();

        $tambah_akun_guru = DB::table('users')
            ->insertGetId([
                'name' => $guru->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guru'
            ]);

        $finish = DB::table('guru')->where('id', $request->guru_id)
            ->update([
                'users_id' => $tambah_akun_guru
            ]);

        if ($finish) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data disimpan'
            ]);
        }
    }

    public function tambah_akun_siswa()
    {
        return view('pages.user.tambah_akun_siswa');
    }

    public function simpan_akun_siswa(Request $request)
    {

        // dd($request->all());
        $siswa = DB::table('siswa')->where('id', $request->siswa_id)->first();

        $tambah_akun_siswa = DB::table('users')
            ->insertGetId([
                'name' => $siswa->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa'
            ]);

        $finish = DB::table('siswa')->where('id', $request->siswa_id)
            ->update([
                'users_id' => $tambah_akun_siswa
            ]);

        if ($finish) {
            return response()->json([
                'status' => 'success',
                'title' => 'Berhasil',
                'message' => 'Data disimpan'
            ]);
        }
    }
}
