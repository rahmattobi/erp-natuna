@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Invoice Detail</h1>
            <div class="btn-group" role="group" aria-label="Button group example">
            {{-- <a href="{{ route('invoice.inputDetail', $invoice->id) }}" class="d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm" ><i
                class="fas fa-plus fa-sm text-primary-50"></i> Input Invoice </a>
            <a href="{{ route('invoice.viewInvoice', $invoice->id) }}" class="d-sm-inline-block btn btn-sm btn-outline-info shadow-sm"><i
                class="fas fa-print fa-sm text-primary-50"></i> Download Invoice</a> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mb-4">
                <div class="card border-left-primary shadow">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-sm-6">
                            @php $counter = 1; $grandTotal = 0; @endphp
                            @foreach ($invoice_detail as $data)
                                @php $grandTotal += ($data->harga*$data->kuantitas); @endphp
                            @endforeach
                                <h6><b>Nama Client: </b> {{ $invoice->nama_client }}</h6>
                                <h6><b>Nama Perusahan: </b> {{ $invoice->nama_perusahaan }}</h6>
                                <h6><b>Total Harga: </b> <span style="color: red">{{ 'Rp. '.number_format((float)$grandTotal, 2, '.', ',')}} </span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            <a class="btn btn-info" href="{{ route('invoice.index') }}"><i class="fas fa-list"></i> List Invoice</a>
            </div>
        </div>

         {{-- alert --}}
         @if (Session::has('success'))
         <div class="alert alert-success" role="alert">
             {{ Session::get('success') }}
         </div>
         @elseif (Session::has('danger'))
         <div class="alert alert-danger" role="alert">
             {{ Session::get('danger') }}
         </div>
        @endif
        {{-- data table --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Invoice Detail</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Keterangan</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Keterangan</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($invoice_detail as $invoice_detail)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $invoice_detail->keterangan }}</td>
                                    <td>{{ $invoice_detail->kuantitas }}</td>
                                    <td>{{ 'Rp. '.number_format((float)$invoice_detail->harga, 2, '.', ',') }}</td>
                                    <td>{{ 'Rp. '.number_format((float)($invoice_detail->harga*$invoice_detail->kuantitas), 2, '.', ',') }}</td>
                                    <td>
                                        @if ($invoice->status == 0)
                                        <div class="btn-group" role="group" >
                                            <a href="{{ route('invoice.editDetail', $invoice_detail->id)}}">
                                                <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                            </a>&nbsp;
                                            <a href="{{ route('invoice.deleteDetail', $invoice_detail->id) }}" data-toggle="modal" data-target="#deleteModal{{ $invoice->id }}">
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                @php
                                                     $data = $invoice_detail->id;
                                                @endphp
                                            </a>
                                        </div>
                                        @elseif ($invoice->status == 2)
                                        <div class="btn-group" role="group" >
                                            <a href="{{ route('invoice.editDetail', $invoice_detail->id)}}">
                                                <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                            </a> &nbsp;
                                            <a href="{{ route('invoice.deleteDetail', $invoice_detail->id) }}" data-toggle="modal" data-target="#deleteModal{{ $invoice->id }}">
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                @php
                                                     $data = $invoice_detail->id;
                                                @endphp
                                            </a>
                                        </div>
                                        @else
                                        <div class="btn-group" role="group" >
                                            <a href="{{ route('invoice.editDetail', $invoice_detail->id)}}">
                                                <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                            </a> &nbsp;
                                            <a href="{{ route('invoice.deleteDetail', $invoice_detail->id) }}" data-toggle="modal" data-target="#deleteModal{{ $invoice->id }}">
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                @php
                                                     $data = $invoice_detail->id;
                                                @endphp
                                            </a>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="deleteModal{{ $invoice->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel{{ $invoice->id }}">Are you sure ?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Do you really want to delete these record ? this process cannot be undone.</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('invoice.deleteDetail', $invoice->id) }}" method="POST" id="deleteForm">
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

