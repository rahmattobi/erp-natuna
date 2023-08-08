@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Input User</h1>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-6 mb-4">
                <div class="card border-left-primary shadow">
                    <div class="card-body">
                        <h5>Input User</h5> <br>
                         {{-- alert --}}
                            @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <form action="{{ route('user.update',$user->id) }}" method="POST" class="user">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <h6>Nama User</h6>
                                <input name="name" value="{{ $user->name }}" type="text" class= "form-control form-control-select @error('user') is-invalid @enderror">
                                @error('user')
                                    <span class="invalid-feedback"> {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <h6>Email</h6>
                                <input name="email" value="{{ $user->email }}" type="email" class= "form-control form-control-select @error('email') is-invalid @enderror">
                                    @error('email')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                            </div>
                            {{-- <div class="form-group">
                                <h6>Password</h6>
                                <input name="password" type="password" value="{{ $user->password }}"  class= "form-control form-control-select @error('password') is-invalid @enderror">
                                    @error('password')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                            </div> --}}
                            <div class="form-group">
                                <h6>Posisi</h6>
                                <select name="level" class="form-select form-control form-control-select" aria-label="Default select example" required>
                                    <option disabled>Posisi</option>
                                        <option value="1">CEO</option>
                                        <option value="2">General Manager</option>
                                        <option value="3">Sales & Marketing</option>
                                        <option value="4">GA & Operational</option>
                                        <option value="5">Finance</option>
                                        <option value="6">Developer</option>
                                    </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
