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
                                <th>No.Invoice</th>
                                <th>Tanggal Invoice</th>
                                <th>Tempo</th>
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
                                <th>No.Invoice</th>
                                <th>Tanggal Invoice</th>
                                <th>Tempo</th>
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
                                    <td>@if ($invoice_detail->no_inv == null)
                                        Invoice Belum Diterbitkan
                                    @else
                                        {{ $invoice_detail->no_inv }}
                                    @endif</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice_detail->tanggal)->formatLocalized('%e %B %Y') }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice_detail->tempo)->formatLocalized('%e %B %Y') }}</td>
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
                                            @if ($invoice_detail->status == 0)
                                                <a href="{{ route('invoice.terbitkanInvoice', $invoice_detail->id)}}">
                                                    <button class="btn btn-info"><i class="fas fa-print"> Terbitkan Invoice</i></button>
                                                </a>
                                            @elseif ($invoice_detail->status == 1)
                                            <a href="{{ route('invoice.printInvoice', $invoice_detail->id)}}" target="_blank">
                                                <button class="btn btn-info"><i class="fas fa-print"></i></button>
                                            </a> &nbsp;
                                            <form action="{{ route('invoice.bayar', $invoice_detail->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                    <button class="btn btn-primary" type="submit"><i class="fas fa-check">Bayar</i></button>
                                            </form>
                                            @elseif ($invoice_detail->status == 2)
                                            <a href="#">
                                                <button class="btn btn-secondary" data-toggle="modal" data-target="#inputModal{{ $invoice_detail->id  }}">Faktur Pajak</button> &nbsp;
                                                @php
                                                 $data = $invoice_detail->id;
                                                @endphp
                                            </a>
                                            @else
                                            <a href="#">
                                                <button class="d-sm-inline-block btn btn-m btn-outline-success shadow-m" data-toggle="modal" data-target="#viewModal{{ $invoice_detail->id  }}"><i class="fas fa-eye"></i> No.NTPN</button> &nbsp;
                                                @php
                                                 $data = $invoice_detail->id;
                                                @endphp
                                            </a>
                                            @endif
                                        </div>
                                        @endif
                                    </td>
                                    <div class="modal fade" id="inputModal{{ $invoice_detail->id }}" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="inputModalLabel">Input No.NTPN</h5>
                                              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                              <form action="{{ route('invoice.pajak', $invoice_detail->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                  <label for="inputField" class="form-label">Input No.NTPN</label>
                                                  <input name="ntpn" type="number" class="form-control" id="inputField" placeholder="No.NTPN" >
                                                  <input name="id" value="{{ $invoice_detail->id }}" type="number" class="form-control" id="inputField" placeholder="No.NTPN" hidden>
                                                </div>
                                                <!-- Add more form fields as needed -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </form>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                    <div class="modal fade" id="viewModal{{ $invoice_detail->id }}" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="inputModalLabel">No.NTPN </h5>
                                              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                               @foreach ($pajaks as $item)
                                                    @if ($item->id_invoice_detail == $invoice_detail->id)
                                                       No. NTPN : {{ $item->ntpn }}
                                                    @endif
                                               @endforeach
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                </tr>
                                <div class="modal fade" id="deleteModal{{ $invoice_detail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel{{ $invoice_detail->id }}">Are you sure ?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Do you really want to delete these record ? this process cannot be undone.</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('invoice.deleteDetail', $invoice_detail->id) }}" method="POST" id="deleteForm">
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

