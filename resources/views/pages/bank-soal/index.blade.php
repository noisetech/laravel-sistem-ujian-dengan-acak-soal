@extends('layouts.be')

@section('title', 'Bank Soal')
@section('content')
    <div class="container-fluid">

        <style>
            table {
                font-size: 12px;
            }
        </style>

        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <span>Manajemen Bank Soal</span>

                    <a href="{{ route('bank_soal.tambah') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-sm fa-plus-circle"></i> Tambah
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th>Mapel</th>
                                <th>No Soal</th>
                                <th>Kelas</th>
                                <th>Guru</th>
                                <th>Soal</th>
                                <th>Kunci Jawaban</th>
                                <th>Score</th>
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
                    url: "{{ route('bank_soal.data') }}"
                },
                columns: [{
                        data: 'nama_mapel',
                        name: 'nama_mapel'
                    },
                    {
                        data: 'no_urut',
                        name: 'no_urut'
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
                        data: 'soal',
                        name: 'soal'
                    },
                    {
                        data: 'jawaban_benar',
                        name: 'jawaban_benar'
                    },
                    {
                        data: 'score',
                        name: 'score'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
                    },
                ]
            });
        });

        $(document).on('click', '.hapus', function(e) {
            let id = $(this).attr('data-id');
            Swal.fire({
                title: 'Hapus?',
                text: "Data telah dihapus tidak bisa di kembalikan!",
                icon: 'warning',
                confirmButton: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bank_soal.hapus') }}",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire({
                                    icon: data.status,
                                    text: data.message,
                                    title: data.title,
                                    // toast: true,
                                    // position: 'top-end',
                                    timer: 1500,
                                    showConfirmButton: false,
                                });
                                $('#datatable').DataTable().ajax.reload();
                            }
                        },
                    })
                }
            })
        });
    </script>
@endpush
