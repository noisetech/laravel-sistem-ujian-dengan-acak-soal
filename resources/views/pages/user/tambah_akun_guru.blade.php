@extends('layouts.be')

@section('title', 'Tambah Akun Guru')
@section('content')
    <div class="container-fluid">


        <a href="{{ route('user') }}" class="btn btn-sm btn-primary my-3">
            <i class="fas fa-sm fa-arrow-left"></i> Kembali
        </a>

        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <span>
                        <i class="fas fa-sm fa-edit"></i> Form Tambah Akun Guru
                    </span>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('user.simpan_akun_guru') }}" id="form_simpan" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="">Guru:</label>
                        <select name="guru_id" class="form-control guru"></select>
                    </div>

                    <div class="form-group">
                        <label for="">Email:</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukan email">
                    </div>


                    <div class="form-group">
                        <label for="">Password:</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukan password">
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
            $('.guru').select2();
        })

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
                                    '/dashboard/user'; // Replace with your desired URL
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

        $(document).ready(function() {
            $('.guru').select2({
                width: '100%',
                placeholder: '--Pilih Guru--',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: "{{ route('user.listGuru') }}",
                    dataType: 'json',
                    delay: 500,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });
        })
    </script>
@endpush
