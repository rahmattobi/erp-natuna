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
                        <form action="{{ route('user.action') }}" method="POST" class="user">
                            @csrf
                            <div class="form-group">
                                <h6>Nama User</h6>
                                <input name="name" type="text" class= "form-control form-control-select @error('user') is-invalid @enderror">
                                @error('user')
                                    <span class="invalid-feedback"> {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <h6>Email</h6>
                                <input name="email" type="email" class= "form-control form-control-select @error('email') is-invalid @enderror">
                                    @error('email')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <h6>Password</h6>
                                <input name="password" type="password" class= "form-control form-control-select @error('password') is-invalid @enderror">
                                    @error('password')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                            </div>
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

        {{-- data table --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">User Table</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Posisi</th>
                                <th style="width: 100px">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Posisi</th>
                                <th style="width: 100px">Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                             @foreach ($user as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                        @if ( $user->level == 0)
                                           <td>Admin</td>
                                        @elseif ( $user->level == 1)
                                           <td>CEO</td>
                                        @elseif ( $user->level == 2)
                                           <td>General Manager</td>
                                        @elseif ( $user->level == 3)
                                           <td>Sales & Marketing</td>
                                        @elseif ( $user->level == 4)
                                           <td>GA & Operational</td>
                                        @elseif ( $user->level == 5)
                                           <td>Finance</td>
                                        @elseif ( $user->level == 6)
                                           <td>Developer</td>
                                        @endif
                                    <td>
                                        <div class="btn-group" role="group" >
                                            <a href="{{ route('user.edit', $user->id)}}">
                                                <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                            </a>
                                            <a href="{{ route('user.delete', $user->id) }}" data-toggle="modal" data-target="#deleteModal{{ $user->id }}">
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                @php
                                                     $data = $user->id;
                                                @endphp
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel{{ $user->id }}">Are you sure ?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Do you really want to delete these record ? this process cannot be undone.</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('user.delete', $user->id) }}" method="POST" id="deleteForm">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
