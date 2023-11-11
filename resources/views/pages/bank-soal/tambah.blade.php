@extends('layouts.be')

@section('title', 'Tambah Soal')
@section('content')
    <div class="container-fluid">


        <a href="{{ route('bank_saol.simpan') }}" class="btn btn-sm btn-primary my-3">
            <i class="fas fa-sm fa-arrow-left"></i> Kembali
        </a>

        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <span>
                        <i class="fas fa-sm fa-edit"></i> Form Tambah Bank Soal
                    </span>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('bank_saol.simpan') }}" id="form_simpan" method="POST" enctype="multipart/form-data">
                    @csrf



                    <div class="form-group">
                        <label for="">Mata Pelajaran:</label>
                        <select name="mapel_id" class="form-control mapel"></select>
                    </div>

                    <div class="form-group">
                        <label for="">Kelas:</label>
                        <select name="kelas_id" class="form-control kelas" disabled></select>
                    </div>

                    <div class="form-group">
                        <label for="">Guru:</label>
                        <select name="guru_id" class="form-control guru" disabled></select>
                    </div>




                    <div class="form-group">
                        <label for="">No Urut</label>
                        <input type="text" name="no_urut" class="form-control" placeholder="Masukan  angka 1-20">
                    </div>


                    <div class="form-group">
                        <label for="">Soal:</label>
                        <textarea class="form-control content" name="soal" placeholder="Masukkan deskripsi" rows="10"></textarea>
                    </div>


                    <div class="form-group">
                        <label for="">Jawaban Pilihan Ganda:</label>
                        <select name="jawaban" class="form-control">
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Huruf Pilihan Ganda (A):</label>
                        <input type="text" name="huruf[]" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Jawaban Pilihan Ganda (A):</label>
                        <textarea class="form-control content" name="jawaban_huruf[]" placeholder="Masukkan deskripsi" rows="10"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Huruf Pilihan Ganda (B):</label>
                        <input type="text" name="huruf[]" class=" form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Jawaban Pilihan Ganda (B):</label>
                        <textarea class="form-control content" name="jawaban_huruf[]" placeholder="Masukkan deskripsi" rows="10"></textarea>
                    </div>


                    <div class="form-group">
                        <label for="">Huruf Pilihan Ganda (C):</label>
                        <input type="text" name="huruf[]" class=" form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Jawaban Pilihan Ganda (C):</label>
                        <textarea class="form-control content" name="jawaban_huruf[]" placeholder="Masukkan deskripsi" rows="10"></textarea>
                    </div>


                    <div class="form-group">
                        <label for="">Huruf Pilihan Ganda (D):</label>
                        <input type="text" name="huruf[]" class=" form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Jawaban Pilihan Ganda (D):</label>
                        <textarea class="form-control content" name="jawaban_huruf[]" placeholder="Masukkan deskripsi" rows="10"></textarea>
                    </div>


                    <div class="form-group">
                        <label for="">Score:</label>
                        <input type="number" class="form-control" name="score" placeholder="Masukan score">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
    <script>
        var editor_config = {
            selector: "textarea.content",
            plugins: [
                "advlist autolink lists link charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
            relative_urls: false,
        };

        tinymce.init(editor_config);
    </script>

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
                                    '/dashboard/bank_soal'; // Replace with your desired URL
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
                    url: "{{ route('bank_soal.listMapel') }}",
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

        $('.mapel').change(function() {
            let data_id_mapel = $('.mapel').val();

            $('.kelas').removeAttr('disabled');
            $('.kelas').select2({
                width: '100%',
                placeholder: '--Pilih Kelas--',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: "{{ url('dashboard/bank_soal/listKelas') }}/" + data_id_mapel,
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

        $('.kelas').change(function() {
            let data_id_mapel = $('.mapel').val();
            let kelas_id = $('.kelas').val();

            $('.guru').removeAttr('disabled');
            $('.guru').select2({
                width: '100%',
                placeholder: '--Pilih Guru--',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: "{{ url('dashboard/bank_soal/listGuru') }}/" + data_id_mapel + '/' + kelas_id,
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
