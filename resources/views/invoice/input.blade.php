@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Input Invoice</h1>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-6 mb-4">
                <div class="card border-left-primary shadow">
                    <div class="card-body">
                        <form action="{{ route('invoice.action') }}" method="POST" class="user">
                            @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <h6>Nama Client</h6>
                                        <input name="nama_client"  type="text" class="form-control form-control-select @error('nama_client') is-invalid @enderror" id="exampleFirstName" placeholder="Nama Client">
                                        @error('nama_client')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <h6>Nama Perusahaan</h6>
                                        <input name="nama_perusahaan"  type="text" class="form-control form-control-select @error('nama_perusahaan') is-invalid @enderror" id="exampleLastName" placeholder="Nama Perusahaan">
                                        @error('nama_perusahaan')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h6>Tanggal</h6>
                                    <input name="tanggal" type="date" class= "form-control form-control-select @error('tanggal') is-invalid @enderror">
                                        @error('tanggal')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="form-group">
                                    <h6>No.Invoice</h6>
                                    <input name="no_inv" type="text" class= "form-control form-control-select @error('no_inv') is-invalid @enderror">
                                    @error('no_inv')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <h6>Jatuh Tempo</h6>
                                    <input name="tempo" type="date" class= "form-control form-control-select @error('tempo') is-invalid @enderror">
                                        @error('tempo  ')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                </div>
                                <div id="dynamic-inputs">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <button type="button" class="btn btn-info btn-block" onclick="addInput()">Tambah Keterangan</button>
                                    </div>
                                    <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    function addInput() {
        var div = document.createElement('div');
        div.innerHTML = `
            <div class="form-group">
                <h6>Keterangan</h6>
                <Textarea name="keterangan[]" type="text" class= "form-control form-control-select @error('keterangan') is-invalid @enderror"></Textarea>
                    @error('keterangan  ')
                        <span class="invalid-feedback"> {{ $message }}</span>
                    @enderror
            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <h6>Kuantitas</h6>
                    <input name="kuantitas[]"  type="number" class="form-control" id="exampleFirstName" placeholder="Kuantitas">
                </div>
                <div class="col-sm-6">
                    <h6>Harga</h6>
                    <input name="harga[]"  type="number" class="form-control" id="exampleLastName" placeholder="Harga">
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-block" onclick="removeInput(this)">Hapus Keterangan</button><br>
        `;
        document.getElementById('dynamic-inputs').appendChild(div);
    }

    function removeInput(element) {
        element.parentNode.remove();
    }
</script>

@endsection
