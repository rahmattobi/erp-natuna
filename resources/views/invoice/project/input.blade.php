@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Input Invoice Project</h1>
        </div>
         {{-- alert --}}
         @if (Session::has('danger'))
         <div class="alert alert-danger" role="alert">
             {{ Session::get('danger') }}
         </div>
        @endif
        <div class="row">
            <div class="col-xl-12 col-md-6 mb-4">
                <div class="card border-left-primary shadow">
                    <div class="card-body">
                        <form action="{{ route('invoice.inputProject') }}" method="POST" class="user">
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
                                    <h6>Instalment Plan</h6>
                                    <select id="repeat_count" name="inst_plan" class="form-select form-control form-control-select" aria-label="Default select example" required>
                                        <option selected disabled>Instalment Plan</option>
                                            <option value="3">3x Pembayaran</option>
                                            <option value="6">6x Pembayaran</option>
                                            <option value="12">12x Pembayaran</option>
                                    </select>
                                </div>
                                {{-- <div class="form-group">
                                    <h6>Tanggal Invoice</h6>
                                    <input value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', now()->toDateString())->formatLocalized('%e %B %Y') }}" id="start_date"  name="tanggal" type="text" class= "form-control form-control-select @error('tanggal') is-invalid @enderror" readonly>
                                    <input value="{{ now()->toDateString() }}" name="tanggal" type="text" class= "form-control form-control-select @error('tanggal') is-invalid @enderror" hidden>
                                    @error('tanggal')
                                            <span class="invalid-feedback"> {{ $message }}</span>
                                        @enderror
                                </div> --}}
                                <div id="inputFieldsContainer">
                                    <!-- Placeholder for input fields generated by JavaScript -->
                                </div>
                                <div id="form_inputs"></div>
                                <div id="dynamic-inputs">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    const repeatCountSelect = document.getElementById('repeat_count');
    const inputFieldsContainer = document.getElementById('inputFieldsContainer');

    repeatCountSelect.addEventListener('change', function () {
        const repeatCount = parseInt(this.value);
        inputFieldsContainer.innerHTML = ''; // Clear previous input fields

        let currentDate = new Date();
        let fixDate = new Date();

        if (repeatCount === 3) {
            for (let i = 1; i <= repeatCount; i++) {
                const row = document.createElement('div');
                row.classList.add('row', 'mb-3'); // Add Bootstrap classes for row and margin bottom

                const tanggal = document.createElement('div');
                tanggal.classList.add('col-md-2');
                const labelTextarea1 = document.createElement('label');
                labelTextarea1.innerText = 'Tanggal Invoice '+ i+' :';
                tanggal.appendChild(labelTextarea1);
                const inputField = document.createElement('input');
                inputField.setAttribute('type', 'text');
                inputField.setAttribute('name', 'tanggal_' + i);
                inputField.setAttribute('placeholder', 'Input ' + i);
                inputField.classList.add('form-control');
                inputField.setAttribute('rows', '3'); // Set the number of rows
                inputField.setAttribute('readonly', 'readonly');

                const keterangan = document.createElement('div');
                keterangan.classList.add('col-md-6');
                const keter = document.createElement('label');
                keter.innerText = 'Keterangan '+ i+' :';
                keterangan.appendChild(keter);
                const ketInput = document.createElement('textarea');
                ketInput.setAttribute('type', 'text');
                ketInput.setAttribute('name', 'ket_' + i);
                ketInput.setAttribute('placeholder', 'Input Keterangan ' + i);
                ketInput.classList.add('form-control');
                keterangan.appendChild(ketInput);

                const kuantitas = document.createElement('div');
                kuantitas.classList.add('col-md-2');
                const kuan = document.createElement('label');
                kuan.innerText = 'Kuantitas '+ i+' :';
                kuantitas.appendChild(kuan);
                const kuanInput = document.createElement('input');
                kuanInput.setAttribute('type', 'number');
                kuanInput.setAttribute('name', 'kuantitas_' + i);
                kuanInput.setAttribute('placeholder', 'Input kuantitas ' + i);
                kuanInput.classList.add('form-control');
                kuantitas.appendChild(kuanInput);

                const harga = document.createElement('div');
                harga.classList.add('col-md-2');
                const labelHarga = document.createElement('label');
                labelHarga.innerText = 'Harga '+ i+' :';
                harga.appendChild(labelHarga);
                const inputHarga = document.createElement('input');
                inputHarga.setAttribute('type', 'number');
                inputHarga.setAttribute('name', 'harga_' + i);
                inputHarga.setAttribute('placeholder', 'Input ' + i + ' - Harga');
                inputHarga.setAttribute('title', 'Enter price');
                inputHarga.setAttribute('class', 'form-control'); // Add form-control class
                inputHarga.setAttribute('min', '0'); // Set minimum value
                inputHarga.setAttribute('step', '1000'); // Set step value
                harga.appendChild(inputHarga);

                if (i === 1) {
                    // Calculate date by adding 4 months to the current date
                    currentDate.setMonth(currentDate.getMonth());
                    fixDate.setMonth(fixDate.getMonth());
                    fixDate.setDate(fixDate.getDate()+14)
                } else {
                    // Calculate date by adding 4 months to the previous calculated date
                    currentDate.setMonth(currentDate.getMonth() + 4);
                    fixDate.setMonth(fixDate.getMonth() + 4);
                }
                // Convert currentDate to "Y-m-d" format
                const formattedDate = currentDate.toISOString().split('T')[0];
                inputField.setAttribute('value', formattedDate);
                tanggal.appendChild(inputField);

                row.appendChild(tanggal);
                row.appendChild(keterangan);
                row.appendChild(kuantitas);
                row.appendChild(harga);
                inputFieldsContainer.appendChild(row);
            }

        }  else if (repeatCount === 6) {
            for (let i = 1; i <= repeatCount; i++) {
                const row = document.createElement('div');
                row.classList.add('row', 'mb-3'); // Add Bootstrap classes for row and margin bottom

                const tanggal = document.createElement('div');
                tanggal.classList.add('col-md-2');
                const labelTextarea1 = document.createElement('label');
                labelTextarea1.innerText = 'Tanggal Invoice :';
                tanggal.appendChild(labelTextarea1);
                const inputField = document.createElement('input');
                inputField.setAttribute('type', 'text');
                inputField.setAttribute('name', 'tanggal_' + i);
                inputField.setAttribute('placeholder', 'Input ' + i);
                inputField.classList.add('form-control');
                inputField.setAttribute('readonly', 'readonly');
                tanggal.appendChild(inputField);

                const keterangan = document.createElement('div');
                keterangan.classList.add('col-md-6');
                const keter = document.createElement('label');
                keter.innerText = 'Keterangan:';
                keterangan.appendChild(keter);
                const ketInput = document.createElement('textarea');
                ketInput.setAttribute('type', 'text');
                ketInput.setAttribute('name', 'ket_' + i);
                ketInput.setAttribute('placeholder', 'Input Keterangan ' + i);
                ketInput.classList.add('form-control');
                keterangan.appendChild(ketInput);

                const kuantitas = document.createElement('div');
                kuantitas.classList.add('col-md-2');
                const kuan = document.createElement('label');
                kuan.innerText = 'Kuantitas:';
                kuantitas.appendChild(kuan);
                const kuanInput = document.createElement('input');
                kuanInput.setAttribute('type', 'number');
                kuanInput.setAttribute('name', 'kuantitas_' + i);
                kuanInput.setAttribute('placeholder', 'Input kuantitas ' + i);
                kuanInput.classList.add('form-control');
                kuantitas.appendChild(kuanInput);

                const harga = document.createElement('div');
                harga.classList.add('col-md-2');
                const labelHarga = document.createElement('label');
                labelHarga.innerText = 'Harga:';
                harga.appendChild(labelHarga);
                const inputHarga = document.createElement('input');
                inputHarga.setAttribute('type', 'number');
                inputHarga.setAttribute('name', 'harga_' + i);
                inputHarga.setAttribute('placeholder', 'Input ' + i + ' - Harga');
                inputHarga.setAttribute('title', 'Enter price');
                inputHarga.setAttribute('class', 'form-control'); // Add form-control class
                inputHarga.setAttribute('min', '0'); // Set minimum value
                inputHarga.setAttribute('step', '1000'); // Set step value
                harga.appendChild(inputHarga);

                if (i === 1) {
                    // Calculate date by adding 4 months to the current date
                    currentDate.setMonth(currentDate.getMonth());
                    fixDate.setDate(fixDate.getDate() + 14);
                } else {
                    // Calculate date by adding 4 months to the previous calculated date
                    currentDate.setMonth(currentDate.getMonth() + 2);
                    fixDate.setMonth(fixDate.getMonth() + 2);
                }
                // Convert currentDate to "Y-m-d" format
                const formattedDate = currentDate.toISOString().split('T')[0];
                inputField.setAttribute('value', formattedDate);


                row.appendChild(tanggal);
                row.appendChild(keterangan);
                row.appendChild(kuantitas);
                row.appendChild(harga);
                inputFieldsContainer.appendChild(row);
            }
        } else {
            for (let i = 1; i <= repeatCount; i++) {
                const row = document.createElement('div');
                row.classList.add('row', 'mb-3'); // Add Bootstrap classes for row and margin bottom

                const tanggal = document.createElement('div');
                tanggal.classList.add('col-md-2');
                const labelTextarea1 = document.createElement('label');
                labelTextarea1.innerText = 'Tanggal Invoice :';
                tanggal.appendChild(labelTextarea1);
                const inputField = document.createElement('input');
                inputField.setAttribute('type', 'text');
                inputField.setAttribute('name', 'tanggal_' + i);
                inputField.setAttribute('placeholder', 'Input ' + i);
                inputField.classList.add('form-control');
                inputField.setAttribute('readonly', 'readonly');
                tanggal.appendChild(inputField);

                const keterangan = document.createElement('div');
                keterangan.classList.add('col-md-6');
                const keter = document.createElement('label');
                keter.innerText = 'Keterangan:';
                keterangan.appendChild(keter);
                const ketInput = document.createElement('textarea');
                ketInput.setAttribute('type', 'text');
                ketInput.setAttribute('name', 'ket_' + i);
                ketInput.setAttribute('placeholder', 'Input Keterangan ' + i);
                ketInput.classList.add('form-control');
                keterangan.appendChild(ketInput);

                const kuantitas = document.createElement('div');
                kuantitas.classList.add('col-md-2');
                const kuan = document.createElement('label');
                kuan.innerText = 'Kuantitas:';
                kuantitas.appendChild(kuan);
                const kuanInput = document.createElement('input');
                kuanInput.setAttribute('type', 'number');
                kuanInput.setAttribute('name', 'kuantitas_' + i);
                kuanInput.setAttribute('placeholder', 'Input kuantitas ' + i);
                kuanInput.classList.add('form-control');
                kuantitas.appendChild(kuanInput);

                const harga = document.createElement('div');
                harga.classList.add('col-md-2');
                const labelHarga = document.createElement('label');
                labelHarga.innerText = 'Harga:';
                harga.appendChild(labelHarga);
                const inputHarga = document.createElement('input');
                inputHarga.setAttribute('type', 'number');
                inputHarga.setAttribute('name', 'harga_' + i);
                inputHarga.setAttribute('placeholder', 'Input ' + i + ' - Harga');
                inputHarga.setAttribute('title', 'Enter price');
                inputHarga.setAttribute('class', 'form-control'); // Add form-control class
                inputHarga.setAttribute('min', '0'); // Set minimum value
                inputHarga.setAttribute('step', '1000'); // Set step value
                harga.appendChild(inputHarga);

                if (i === 1) {
                    // Calculate date by adding 4 months to the current date
                    currentDate.setMonth(currentDate.getMonth() + 1);
                } else {
                    // Calculate date by adding 1 months to the previous calculated date
                    currentDate.setMonth(currentDate.getMonth() + 1);
                }
                // Convert currentDate to "Y-m-d" format
                const formattedDate = currentDate.toISOString().split('T')[0];
                inputField.setAttribute('value', formattedDate);

                row.appendChild(tanggal);
                row.appendChild(keterangan);
                row.appendChild(kuantitas);
                row.appendChild(harga);
                inputFieldsContainer.appendChild(row);
            }
        }
    });

</script>

@endsection
