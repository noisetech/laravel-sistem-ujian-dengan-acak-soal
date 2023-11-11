@extends('layouts.be')

@section('title', 'Jenjang Mapel')
@section('content')
    <div class="container-fluid">


        <div class="card shadow">
            <div class="card-header">
                <span>Soal Ujian</span>
            </div>
            <div class="card-body">
                <form action="{{ route('ujian.proses') }}" method="POST" id="form_simpan">
                    @csrf

                    <input type="hidden" name="jenjang_mapel_id" value="{{ $jenjang_mapel_id }}">

                    <ol start="1">
                        @foreach ($bank_soal as $item)
                            <li class="mb-4">
                                <span>{!! $item->soal !!}
                                </span>

                                @php
                                    $pilihan_ganda = DB::table('pilgan')
                                        ->select('pilgan.*', 'bank_soal.no_urut as no_urut_soal')
                                        ->join('bank_soal', 'bank_soal.id', '=', 'pilgan.bank_soal_id')
                                        ->where('pilgan.bank_soal_id', $item->id)
                                        ->get();
                                @endphp

                                <div class="row">
                                    @foreach ($pilihan_ganda as $pilihan_ganda)
                                        <div class="col-md-12">
                                            <div class="d-flex">
                                                <input type="checkbox" name="jawaban_user[]"
                                                    value="{{ 'Soal:' . $pilihan_ganda->no_urut_soal . ',' . 'Jawaban:' . $pilihan_ganda->huruf }}"
                                                    style="margin-top: -15px; !important; margin-right: 10px !important;"
                                                    data-no-urut-soal="{{ $pilihan_ganda->no_urut_soal }}"
                                                    id="pilgan_{{ $pilihan_ganda->id }}">
                                                {{ $pilihan_ganda->huruf }}&nbsp;&nbsp;&nbsp;&nbsp;{!! $pilihan_ganda->isi !!}



                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                        @endforeach
                    </ol>



                    <button class="btn btn-sm btn-primary" type="submit">
                        Proses
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
