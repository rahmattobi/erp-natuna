@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Input Invoice</h1>
        </div>
        @if (Session::has('danger'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('danger') }}
        </div>
       @endif
        <div class="row">
            <div class="col-xl-12 col-md-6 mb-4">
                <div class="card border-left-primary shadow">
                    <div class="card-body">
                        <form action="{{ route('finance.newInv') }}" method="POST" class="user">
                            @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <h6>Nama Client</h6>
                                        <input name="nama_client"  type="text" value="{{ $invoice->nama_client }}" class="form-control form-control-select @error('nama_client') is-invalid @enderror" id="exampleFirstName" placeholder="Nama Client">
                                        @error('nama_client')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <h6>Nama Perusahaan</h6>
                                        <input name="nama_perusahaan"  type="text" value="{{ $invoice->nama_perusahaan }}" class="form-control form-control-select @error('nama_perusahaan') is-invalid @enderror" id="exampleLastName" placeholder="Nama Perusahaan">
                                        @error('nama_perusahaan')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h6>Tanggal Invoice</h6>
                                    <input value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', now()->toDateString())->formatLocalized('%e %B %Y') }}" id="start_date"  name="" type="text" class= "form-control form-control-select @error('tanggal') is-invalid @enderror" disabled>
                                    <input value="{{ now()->toDateString() }}" name="tanggal" type="text"  class= "form-control form-control-select @error('tanggal') is-invalid @enderror" hidden>
                                        @error('tanggal')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <h6>Langganan</h6>
                                    <select id="repeat_count" name="langganan" class="form-select form-control form-control-select" aria-label="Default select example" required>
                                        <option selected disabled>Langganan</option>
                                            <option value="1">1 Bulan</option>
                                            <option value="3">3 Bulan</option>
                                            <option value="6">6 Bulan</option>
                                            <option value="12">12 Bulan</option>
                                    </select>
                                </div>
                                <input type="text" name="invcount" value="{{ $inv->count() }}" hidden>
                            @foreach ($inv as $inv)
                                <div class="form-group">
                                    <h6>keterangan</h6>
                                    <textarea name="keterangan[]" id="" cols="30" rows="5"  class="form-control form-control-select @error('keterangan') is-invalid @enderror">{{ $inv->keterangan }}</textarea>
                                    @error('keterangan')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h6>Kuantitas</h6>
                                    <input name="kuantitas[]"  type="number" value="{{ $inv->kuantitas }}" class="form-control form-control-select @error('kuantitas') is-invalid @enderror" id="exampleLastName" placeholder="Kuantitas">
                                    @error('kuantitas')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h6>Harga</h6>
                                    <input name="harga[]" type="number" value="{{ $inv->harga }}" class= "form-control form-control-select @error('harga') is-invalid @enderror" placeholder="Harga">
                                        @error('harga')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                </div>
                                @endforeach
                                <button type="submit" class="btn btn-primary btn-block">Submit</button> <br>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
