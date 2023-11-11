@extends('layouts.be')

@section('title', 'Tambah Guru')
@section('content')
    <div class="container-fluid">


        <a href="{{ route('guru') }}" class="btn btn-sm btn-primary my-3">
            <i class="fas fa-sm fa-arrow-left"></i> Kembali
        </a>

        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <span>
                        <i class="fas fa-sm fa-edit"></i> Form Tambah Guru
                    </span>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('guru.sinpan') }}" id="form_simpan" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="">Nama:</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukan nama">
                    </div>

                    <div class="form-group">
                        <label for="">NIDN:</label>
                        <input type="text" name="nidn" class="form-control" placeholder="Masukan NIDN">
                    </div>


                    <button class="btn btn-sm btn-primary" type="submit">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#form_simpan').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'), // Form action URL
                    type: $(this).attr('method'), // Form method (POST)
                    data: formData,
                    dataType: 'json', // Expected response type

                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            setTimeout(function() {
                                window.location.href =
                                    '/dashboard/guru'; // Replace with your desired URL
                            }, 1500);
                        } else {
                            $.each(response.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        }
                    },
                });

            });
        });
    </script>
@endpush
