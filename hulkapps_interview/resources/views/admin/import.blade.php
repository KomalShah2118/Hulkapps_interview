@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Import Data') }}</div>

                <div class="card-body">
                @if ($failures)
                    <div class="alert alert-danger" role="alert">
                        <strong>Errors:</strong>
                        <ul>
                            @foreach ($failures as $failure)
                                @foreach ($failure->errors() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <form method="POST" action="{{ route('import-data') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="file" class="col-md-4 col-form-label text-md-end">{{ __('Import') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="form-control @error('photo') is-invalid @enderror" name="file" autofocus>

                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Import') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
