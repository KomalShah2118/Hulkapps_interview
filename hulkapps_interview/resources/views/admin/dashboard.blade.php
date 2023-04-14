@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Student Details') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-md-12 bg-light text-right">
                        <!-- <a href="{{ route('import')}}"></a><button type="button" class="btn btn-primary">Import</button> -->
                        <a href="{{ route('export')}}"><button type="button" class="btn btn-success">Export</button></a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Studnetname</th>
                            <th>Email</th>
                            <th>DOB</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ucfirst($user['name'])}}</td>
                                <td>{{$user['email']}}</td>
                                <td>{{$user['date_of_birth']}}</td>
                                <td>{{$user['address']}}</td>
                                <td>
                                    <div class="text-center">
                                        <a href="{{ route('edit-student',$user['id']) }}" title="Edit Student"><i class="bi-pencil pd5"></i></a>
                                        @if($user['is_verified'] == 0)
                                            <a href="{{ route('verify-student',$user['id']) }}" title="Verify Student"><i class="bi-check-circle"></i></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
