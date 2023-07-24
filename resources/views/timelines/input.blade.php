@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Input Timeline</h1>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-6 mb-4">
                <div class="card border-left-primary shadow">
                    <div class="card-body">
                        <h5>Input Timeline</h5> <br>
                        <form action="{{ route('timeline.action') }}" method="POST" class="user">
                            @csrf
                            <div class="form-group">
                                <h6>Title</h6>

                                <input name="title" type="text" class= "form-control form-control-select @error('title') is-invalid @enderror">
                                @error('title')
                                    <span class="invalid-feedback"> {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <h6>Start</h6>
                                <input name="start" type="date" class= "form-control form-control-select @error('start') is-invalid @enderror">
                                    @error('start')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <h6>End</h6>
                                <input name="end" type="date" class= "form-control form-control-select @error('end') is-invalid @enderror">
                                    @error('end')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <h6>Category</h6>
                                <select name="category" class="form-select form-control form-control-select" aria-label="Default select example" required>
                                    <option selected disabled>Category</option>
                                        <option value="0">On Progress</option>
                                        <option value="1">Done</option>
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
