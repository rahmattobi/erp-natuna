@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Input data Invoice No.
                <span style="color: red">{{ $invoice->no_inv }} ({{ $invoice->nama_perusahaan }})</h1></span>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-6 mb-4">
                <div class="card border-left-primary shadow">
                    <div class="card-body">
                        <form action="{{ route('invoice.actionDetail', $invoice->id) }}" method="POST" class="user">
                            @csrf
                                <div class="form-group">
                                    <h6>keterangan</h6>
                                    <textarea name="keterangan" id="" cols="30" rows="5"  class="form-control form-control-select @error('keterangan') is-invalid @enderror"></textarea>
                                    @error('keterangan')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h6>Kuantitas</h6>
                                    <input name="kuantitas"  type="number" class="form-control form-control-select @error('kuantitas') is-invalid @enderror" id="exampleLastName" placeholder="Kuantitas">
                                    @error('kuantitas')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h6>Harga</h6>
                                    <input name="harga" type="number" class= "form-control form-control-select @error('harga') is-invalid @enderror" placeholder="Harga">
                                        @error('harga')
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
