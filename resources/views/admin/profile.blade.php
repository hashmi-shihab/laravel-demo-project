@extends('admin.layouts.master')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                        <li class="breadcrumb-item"><a href="{{route('Dashboard')}}">Dashboard</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid col-md-8 ml-0">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Edit Profile</h3>
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
                    <form action="{{ route('Profile.Post') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Username -->
                                <div class="form-group">
                                    <label for="user_name">Username<span style="color: red;"> *</span></label>
                                    <input type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror" placeholder="Enter username" value="{{ old('user_name', $user->user_name) }}">
                                    @error('user_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- First Name -->
                                <div class="form-group">
                                    <label for="user_first_name">First Name <span style="color: red;"> *</span></label>
                                    <input type="text" name="user_first_name" class="form-control @error('user_first_name') is-invalid @enderror" placeholder="Enter first name" value="{{ old('user_first_name', $user->user_first_name) }}">
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
                                    <input type="text" name="user_last_name" class="form-control @error('user_last_name') is-invalid @enderror" placeholder="Enter last name" value="{{ old('user_last_name', $user->user_last_name) }}">
                                    @error('user_last_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email <span style="color: red;"> *</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ old('email', $user->email) }}">
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
                                    <input type="text" name="user_mobile" class="form-control @error('user_mobile') is-invalid @enderror" placeholder="Enter mobile number" value="{{ old('user_mobile', $user->user_mobile) }}">
                                    @error('user_mobile')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password" autocomplete="off">
                                    @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-info">Update</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection
