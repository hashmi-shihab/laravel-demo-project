@extends('admin.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Register</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                        <li class="breadcrumb-item active"><a href="{{route('users.index')}}">Users list</a></li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    {{--@php
        dd(session()->all());
    @endphp--}}
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid col-md-8 ml-0">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Create new user</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(session()->has('success'))
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aira-hidden="true">
                                &times;
                            </button>
                            {{session()->get('success')}}
                        </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aira-hidden="true">
                                &times;
                            </button>
                            {{session()->get('error')}}
                        </div>
                    @endif
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- Username -->
                                    <div class="form-group">
                                        <label for="user_name">Username<span style="color: red;"> *</span></label>
                                        <input type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror" placeholder="Enter username" value="{{ old('user_name') }}">
                                        @error('user_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- First Name -->
                                    <div class="form-group">
                                        <label for="user_first_name">First Name <span style="color: red;"> *</span></label>
                                        <input type="text" name="user_first_name" class="form-control @error('user_first_name') is-invalid @enderror" placeholder="Enter first name" value="{{ old('user_first_name') }}">
                                        @error('user_first_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- Last Name -->
                                    <div class="form-group">
                                        <label for="user_last_name">Last Name <span style="color: red;"> *</span></label>
                                        <input type="text" name="user_last_name" class="form-control @error('user_last_name') is-invalid @enderror" placeholder="Enter last name" value="{{ old('user_last_name') }}">
                                        @error('user_last_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- Email -->
                                    <div class="form-group">
                                        <label for="email">Email <span style="color: red;"> *</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ old('email') }}">
                                        @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- Mobile -->
                                    <div class="form-group">
                                        <label for="user_mobile">Mobile <span style="color: red;"> *</span></label>
                                        <input type="text" name="user_mobile" class="form-control @error('user_mobile') is-invalid @enderror" placeholder="Enter mobile number" value="{{ old('user_mobile') }}">
                                        @error('user_mobile')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- Password -->
                                    <div class="form-group">
                                        <label for="password">Password <span style="color: red;"> *</span></label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password" autocomplete="off">
                                        @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="roles">Roles <span style="color: red;"> *</span></label>
                                        <select name="roles[]" id="roles" class="form-control @error('roles') is-invalid @enderror" data-dropdown-css-class="select2-bg-info" style="width: 100%;" multiple>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info">Submit</button>
                        </form>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection

@push('scripts')
    <script src="{{asset('admin/plugins/select2/js/select2.full.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#roles').select2({
                placeholder: "Select roles",
                allowClear: true,
                color: "#17a2b8"
            });
        });
    </script>
@endpush
