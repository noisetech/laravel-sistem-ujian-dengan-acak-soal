@extends('layouts.be')

@section('title', 'Hasil Ujian')
@section('content')
    <div class="container-fluid">


        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <span class="font-weight-bold">List Hasil Ujian</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Mapel</th>
                                <th>Kelas</th>
                                <th>Pengajar</th>
                                <th>Hasil</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,

                pageLength: 5,
                lengthMenu: [
                    [5, 10, 20, -1],
                    [5, 10, 20, "50"]
                ],
                order: [],
                ajax: {
                    url: "{{ route('hasil_ujian.data') }}"
                },
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nama_mapel',
                        name: 'nama_mapel'
                    },
                    {
                        data: 'kelas',
                        name: 'kelas'
                    },
                    {
                        data: 'nama_guru',
                        name: 'nama_guru'
                    },
                    {
                        data: 'hasil',
                        name: 'hasil'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
                    },
                ]
            });
        });
    </script>
@endpush
