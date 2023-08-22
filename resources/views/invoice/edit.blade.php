@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Edit Invoice</h1>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-6 mb-4">
                <div class="card border-left-primary shadow">
                    <div class="card-body">
                        <form action="{{ route('invoice.update',$invoice->id) }}" method="POST" class="user">
                            @csrf
                            @method('PUT')
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <h6>Nama Client</h6>
                                        <input name="nama_client" value="{{ $invoice->nama_client }}"  type="text" class="form-control form-control-select @error('nama_client') is-invalid @enderror" id="exampleFirstName" placeholder="Nama Client">
                                        @error('nama_client')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <h6>Nama Perusahaan</h6>
                                        <input name="nama_perusahaan" value="{{ $invoice->nama_perusahaan }}"  type="text" class="form-control form-control-select @error('nama_perusahaan') is-invalid @enderror" id="exampleLastName" placeholder="Nama Perusahaan">
                                        @error('nama_perusahaan')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h6>No.Invoice</h6>
                                    <input name="no_inv" type="text" value="{{ $invoice->no_inv }}" class= "form-control form-control-select @error('no_inv') is-invalid @enderror">
                                    @error('no_inv')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
