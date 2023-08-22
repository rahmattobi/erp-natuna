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
                                @php
                                  use Carbon\Carbon;
                                @endphp
                                <div class="form-group">
                                    <h6>No.Invoice</h6>
                                    @if ($numbInv == '')
                                        <input name="no_inv" type="text" value="{{ str_pad(23, 3, '0', STR_PAD_LEFT) }}/NGE/INV/FIN/{{ $romanMonth }}/{{ Carbon::now()->year }}" class= "form-control form-control-select @error('no_inv') is-invalid @enderror" readonly>
                                    @else
                                    <input name="no_inv" type="text" value="{{ str_pad(($numbInv+1), 3, '0', STR_PAD_LEFT) }}/NGE/INV/FIN/{{ $romanMonth }}/{{ Carbon::now()->year }}" class= "form-control form-control-select @error('no_inv') is-invalid @enderror" readonly>
                                    @endif
                                    @error('no_inv')
                                        <span class="invalid-feedback"> {{ $message }}</span>
                                    @enderror
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
                                    <h6>Jatuh Tempo</h6>
                                    <input value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', now()->addDay(14)->toDateString())->formatLocalized('%e %B %Y') }}" id="start_date"  name="" type="text" class= "form-control form-control-select @error('tanggal') is-invalid @enderror" disabled>
                                    <input value="{{ now()->toDateString() }}" name="tanggal" type="text" class= "form-control form-control-select @error('tanggal') is-invalid @enderror" hidden>
                                        @error('tanggal')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                </div>
                                <input name="tempo" value="{{ now()->addDay(14)->toDateString() }}"  type="text" class= "form-control form-control-select @error('tempo') is-invalid @enderror" hidden>
                                <div id="inputFieldsContainer">
                                    <!-- Placeholder for input fields generated by JavaScript -->
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

    const repeatCountSelect = document.getElementById('repeat_count');
    const inputFieldsContainer = document.getElementById('inputFieldsContainer');

    repeatCountSelect.addEventListener('change', function () {
        const repeatCount = parseInt(this.value);
        inputFieldsContainer.innerHTML = ''; // Clear previous input fields

        let currentDate = new Date();

        if (repeatCount === 1) {
                const label = document.createElement('label');
                label.innerText = 'Jatuh Tempo :' ;

                const inputField = document.createElement('input');
                inputField.setAttribute('type', 'text');
                inputField.setAttribute('name', 'input');
                inputField.setAttribute('placeholder', 'Input');
                inputField.classList.add('form-control');
                inputField.setAttribute('disabled', 'disabled');

                currentDate.setMonth(currentDate.getMonth() + 1);
                currentDate.setDate(currentDate.getDate() - 1);
                // Convert currentDate to "Y-m-d" format
                const formattedDate = currentDate.toLocaleDateString('id', { day: 'numeric', month: 'long', year: 'numeric' });
                inputField.setAttribute('value', formattedDate);
                inputFieldsContainer.appendChild(label);
                inputFieldsContainer.appendChild(inputField);
                inputFieldsContainer.appendChild(document.createElement('br'));

        } else {
            for (let i = 1; i <= repeatCount; i++) {
                const label = document.createElement('label');
                label.innerText = 'Jatuh Tempo ' + i + ':';

                const inputField = document.createElement('input');
                inputField.setAttribute('type', 'text');
                inputField.setAttribute('name', 'input_' + i);
                inputField.setAttribute('placeholder', 'Input ' + i);
                inputField.classList.add('form-control');
                inputField.setAttribute('disabled', 'disabled');

                if (i === 1) {
                    // Calculate date by adding 4 months to the current date
                    currentDate.setMonth(currentDate.getMonth() + 4);
                    currentDate.setDate(currentDate.getDate() - 1);
                } else {
                    // Calculate date by adding 4 months to the previous calculated date
                    currentDate.setMonth(currentDate.getMonth() + 4);
                }

                // Subtract one day from currentDate


                // Convert currentDate to "Y-m-d" format
                const formattedDate = currentDate.toLocaleDateString('id', { day: 'numeric', month: 'long', year: 'numeric' });
                inputField.setAttribute('value', formattedDate);

                inputFieldsContainer.appendChild(label);
                inputFieldsContainer.appendChild(inputField);

                inputFieldsContainer.appendChild(document.createElement('br'));
            }
        }
    });

</script>

@endsection
