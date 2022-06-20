<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Chars</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="card my-3">
        <div class="card-header"><h3>Generate Chars</h3></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    @if (session()->has('error'))
                        <div class="alert alert-danger mw-50">
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            @if(is_array($errors = session('error')))
                                @foreach ($errors as $err)
                                    <p class="mb-1">*{{ $err }}</p>
                                @endforeach
                            @else
                                <p class="mb-1">*{{ $errors }}</p>  
                            @endif
                        </div>
                    @endif
                    <form method="post" action="" class="form-inline mb-3" id="formChars">
                        @csrf
                        <input type="text" class="form-control mr-2 mb-2 mb-sm-0" name="chars" placeholder="ABCDE" value="{{ old('chars') }}" minlength="5" maxlength="5" autocomplete="off" required>
                        <input type="number" class="form-control mr-2" name="count" placeholder="num" value="{{ old('count') ?? 15 }}" autocomplete="off" style="width:15%">
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </form>
                    @if (session()->has('all_chars'))
                        <div class="table-reponsive mr-lg-5">
                            <table class="table table-sm table-striped table-bordered table-hover text-center">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="width:20%">No</th>
                                        <th>Chars</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (session('all_chars') as $chars)
                                        <tr>
                                            <td><b>{{ $loop->iteration }}</b></td>
                                            <td>{{ $chars->chars }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
                <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Testing</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="mb-0">ABCDE -> {{ $full_chars = session('full_chars') }}</h5>
                        <small class="text-muted">A = {{ $full_chars[0] }}, B = {{ $full_chars[1] }}, dst. </small>
                        <hr>
                        <p><b>Pilih A, B, C, D atau E yang mewakilkan huruf/karakter yang tidak ada.</b></p> 
                        @foreach (session('all_chars') as $chars)
                        <form action="" method="post" data-choose-id="{{ $chars->choose_id }}" data-chars-id="{{ $chars->id }}" id="formAnswer" class="mb-2">
                            <b class="d-block w-100 ">{{ $loop->iteration }}. {{ $chars->chars }}</b>
                            @csrf
                            @foreach (str_split('ABCDE') as $chr)
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="{{ $fornameid = 'answer'.$chars->id.$chr }}" name="answer" value="{{ $chr }}" required>
                                    <label class="form-check-label font-weight-bold" for="{{ $fornameid }}">{{ $chr }}</label>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-sm btn-success ml-3">Check</button>
                        </form>
                        @endforeach
                        <button type="button" class="btn btn-success w-100 mt-2" id="checkAll">Check All</button>
                        <small class="text-muted">Note: Jawaban yang benar akan berubah warna hijau.</small>
                    </div>
                </div>
                </div>
                    @endif
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/sc.js') }}"></script>
</body>
</html>