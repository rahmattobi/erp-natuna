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
                                    <h6>Tanggal Invoice</h6>
                                    <input value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', now()->toDateString())->formatLocalized('%e %B %Y') }}" id="start_date"  name="" type="text" class= "form-control form-control-select @error('tanggal') is-invalid @enderror" disabled>
                                    <input value="{{ now()->toDateString() }}" name="tanggal" type="text" class= "form-control form-control-select @error('tanggal') is-invalid @enderror" hidden>
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
                                <div id="inputFieldsContainer">
                                </div>
                                <div id="form_inputs"></div>
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

    // const repeatCountSelect = document.getElementById('repeat_count');
    // const inputFieldsContainer = document.getElementById('inputFieldsContainer');

    // repeatCountSelect.addEventListener('change', function () {
    //     const repeatCount = parseInt(this.value);
    //     inputFieldsContainer.innerHTML = ''; // Clear previous input fields

    //     let currentDate = new Date();

    //     if (repeatCount === 1) {
    //             const label = document.createElement('label');
    //             label.innerText = 'Invoice Selanjutnya :' ;

    //             const inputField = document.createElement('input');
    //             inputField.setAttribute('type', 'text');
    //             inputField.setAttribute('name', 'nextDate');
    //             inputField.setAttribute('placeholder', 'Input');
    //             inputField.classList.add('form-control');
    //             inputField.setAttribute('disabled', 'disabled');

    //             currentDate.setMonth(currentDate.getMonth() + 1);
    //             // Convert currentDate to "Y-m-d" format
    //             const formattedDate = currentDate.toLocaleDateString('id', { day: 'numeric', month: 'long', year: 'numeric' });
    //             inputField.setAttribute('value', formattedDate);
    //             inputFieldsContainer.appendChild(label);
    //             inputFieldsContainer.appendChild(inputField);
    //             inputFieldsContainer.appendChild(document.createElement('br'));

    //     }else if (repeatCount === 3) {
    //             const label = document.createElement('label');
    //             label.innerText = 'Invoice Selanjutnya :' ;

    //             const inputField = document.createElement('input');
    //             inputField.setAttribute('type', 'text');
    //             inputField.setAttribute('name', 'nextDate');
    //             inputField.setAttribute('placeholder', 'Input');
    //             inputField.classList.add('form-control');
    //             inputField.setAttribute('disabled', 'disabled');

    //             currentDate.setMonth(currentDate.getMonth() + 3);
    //             // Convert currentDate to "Y-m-d" format
    //             const formattedDate = currentDate.toLocaleDateString('id', { day: 'numeric', month: 'long', year: 'numeric' });
    //             inputField.setAttribute('value', formattedDate);
    //             inputFieldsContainer.appendChild(label);
    //             inputFieldsContainer.appendChild(inputField);
    //             inputFieldsContainer.appendChild(document.createElement('br'));

    //     }if (repeatCount === 6) {
    //             const label = document.createElement('label');
    //             label.innerText = 'Invoice Selanjutnya :' ;

    //             const inputField = document.createElement('input');
    //             inputField.setAttribute('type', 'text');
    //             inputField.setAttribute('name', 'nextDate');
    //             inputField.setAttribute('placeholder', 'Input');
    //             inputField.classList.add('form-control');
    //             inputField.setAttribute('disabled', 'disabled');

    //             currentDate.setMonth(currentDate.getMonth() + 6);
    //             // Convert currentDate to "Y-m-d" format
    //             const formattedDate = currentDate.toLocaleDateString('id', { day: 'numeric', month: 'long', year: 'numeric' });
    //             inputField.setAttribute('value', formattedDate);
    //             inputFieldsContainer.appendChild(label);
    //             inputFieldsContainer.appendChild(inputField);
    //             inputFieldsContainer.appendChild(document.createElement('br'));

    //     }if (repeatCount === 12) {
    //             const label = document.createElement('label');
    //             label.innerText = 'Invoice Selanjutnya :' ;

    //             const inputField = document.createElement('input');
    //             inputField.setAttribute('type', 'text');
    //             inputField.setAttribute('name', 'nextDate');
    //             inputField.setAttribute('placeholder', 'Input');
    //             inputField.classList.add('form-control');
    //             inputField.setAttribute('disabled', 'disabled');

    //             currentDate.setMonth(currentDate.getMonth() + 12);
    //             // Convert currentDate to "Y-m-d" format
    //             const formattedDate = currentDate.toLocaleDateString('id', { day: 'numeric', month: 'long', year: 'numeric' });
    //             inputField.setAttribute('value', formattedDate);
    //             inputFieldsContainer.appendChild(label);
    //             inputFieldsContainer.appendChild(inputField);
    //             inputFieldsContainer.appendChild(document.createElement('br'));

    //     }
    // });

</script>

@endsection
