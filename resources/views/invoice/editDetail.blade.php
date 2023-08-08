@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Edit Invoice Detail</h1>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-6 mb-4">
                <div class="card border-left-primary shadow">
                    <div class="card-body">
                        <form action="{{ route('invoice.updateDetail',$invoice->id) }}" method="POST" class="user">
                            @csrf
                            @method('PUT')
                                <div class="form-group">
                                    <h6>keterangan</h6>
                                    <textarea name="keterangan" id="" cols="30" rows="5"  class="form-control form-control-select @error('keterangan') is-invalid @enderror">{{ $invoice->keterangan }}</textarea>
                                    @error('keterangan')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h6>Kuantitas</h6>
                                    <input name="kuantitas" value="{{ $invoice->kuantitas }}"  type="text" class="form-control form-control-select @error('kuantitas') is-invalid @enderror" id="exampleLastName" placeholder="Nama Perusahaan">
                                    @error('kuantitas')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h6>Harga</h6>
                                    <input name="harga" type="number" value="{{ $invoice->harga }}" class= "form-control form-control-select @error('harga') is-invalid @enderror">
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
