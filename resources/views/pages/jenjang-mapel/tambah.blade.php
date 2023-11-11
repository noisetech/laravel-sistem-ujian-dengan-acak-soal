@extends('layouts.be')

@section('title', 'Tambah Jenjang Mapel')
@section('content')
    <div class="container-fluid">


        <a href="{{ route('jenjang_mapel') }}" class="btn btn-sm btn-primary my-3">
            <i class="fas fa-sm fa-arrow-left"></i> Kembali
        </a>

        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <span>
                        <i class="fas fa-sm fa-edit"></i> Form Tambah Jenjang Mapel
                    </span>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('jenjang_mapel.simpan') }}" id="form_simpan" method="POST" enctype="multipart/form-data">
                    @csrf



                    <div class="form-group">
                        <label for="">Mata Pelajaran:</label>
                        <select name="mapel_id" class="form-control mapel"></select>
                    </div>

                    <div class="form-group">
                        <label for="">Guru:</label>
                        <select name="guru_id" class="form-control guru"></select>
                    </div>

                    <div class="form-group">
                        <label for="">Kelas:</label>
                        <select name="kelas_id" class="form-control kelas"></select>
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
                                    '/dashboard/jenjang_mapel'; // Replace with your desired URL
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

@push('script')
    <script>
        $(document).ready(function() {
            $('.mapel').select2({
                width: '100%',
                placeholder: '--Pilih Mapel--',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: "{{ route('jenjang_mapel.listMapel') }}",
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
        });

        $(document).ready(function() {
            $('.guru').select2({
                width: '100%',
                placeholder: '--Pilih Guru--',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: "{{ route('jenjang_mapel.listGuru') }}",
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
        });

        $(document).ready(function() {
            $('.kelas').select2({
                width: '100%',
                placeholder: '--Pilih Kelas--',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: "{{ route('jenjang_mapel.listKelas') }}",
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
        });
    </script>
@endpush
