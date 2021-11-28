@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload file</div>
                
                @error('fileerror')
                    <span class="text-danger" >
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="card-body">
                    
                    <form method="POST" action="{{ route('submitFile') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="textfile" class="col-md-4 col-form-label text-md-right">File</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control @error('textfile') is-invalid @enderror" name="textfile" required accept=".txt">

                            </div>
                        </div>

                        

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Upload
                                </button>
                            </div>
                        </div>
                    </form>

                    @if($errors->any())
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first() }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
