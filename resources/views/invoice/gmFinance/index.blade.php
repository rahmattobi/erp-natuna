@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

             {{-- @foreach ($notifications as $notification)
                @php
                    print_r($notification);
                @endphp
            @endforeach --}}
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Invoice</h1>
            <a href="{{ route('invoice.input') }}" class="d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-primary-50"></i> Create Invoice</a>
            {{-- <button class="d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm dropdown-toggle" type="button"
                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fas fa-plus fa-sm text-primary-50"></i> Input Invoice</a>
            </button>
            <div class="dropdown-menu animated--fade-in"
                aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('invoice.input') }}">Perbulan</a>
                <a class="dropdown-item" href="{{ route('invoice.inv_project') }}">Project</a>
            </div> --}}
        </div>

          {{-- alert --}}
          @if (Session::has('success'))
          <div class="alert alert-success" role="alert">
              {{ Session::get('success') }}
          </div>
         @endif
        {{-- data table --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Invoice Table</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No.Invoice</th>
                                <th>Nama Client</th>
                                <th>Nama Perusahaan</th>
                                <th>Tanggal Invoice</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>No.Invoice</th>
                                <th>Nama Client</th>
                                <th>Nama Perusahaan</th>
                                <th>Tanggal Invoice</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>@if ($invoice->no_inv == null)
                                        Invoice Belum Diterbitkan
                                    @else
                                        {{ $invoice->no_inv }}
                                    @endif</td>
                                    <td>{{ $invoice->nama_client }}</td>
                                    <td>{{ $invoice->nama_perusahaan }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->tanggal)->formatLocalized('%e %B %Y') }}</td>
                                        @php
                                            $invoiceDate = \Carbon\Carbon::createFromFormat('Y-m-d', $invoice->tanggal);
                                            $newDate = $invoiceDate->addDays(14);

                                            $formattedNewDate = $newDate->formatLocalized('%e %B %Y');
                                        @endphp
                                    <td>{{ $formattedNewDate}}</td>
                                    <td>
                                        @if ($invoice->status == 0)
                                            <span class="badge badge-warning">Belum di Setujui</span>
                                        @elseif ($invoice->status == 1)
                                            <span class="badge badge-success">Di Setujui</span>
                                        @elseif ($invoice->status == 2)
                                            <span class="badge badge-info">No. Invoice diterbitkan</span>
                                        @elseif ($invoice->status == 3 )
                                            <span class="badge badge-primary">Lunas</span>
                                        @elseif ($invoice->status == 4 )
                                            <span class="badge badge-success">Done</span>
                                        @else
                                        <button class="badge badge-danger open-modal" data-toggle="modal" data-target="#invoiceModal{{ $invoice->id }}">
                                            Lihat Revisi
                                        </button>
                                        @endif
                                    </td>

                                    {{-- popup revisi --}}
                                    <div id="invoiceModal{{ $invoice->id }}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Detail Revisi</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                        @foreach ($revisi as $item)
                                                            @if ($item->invoice_id == $invoice->id)
                                                                {{ $item->revisi }}
                                                            @endif
                                                        @endforeach
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <td>
                                        @if ($invoice->status == 0)
                                        <div class="btn-group" role="group">
                                            <button class="d-sm-inline-block btn btn-warning shadow-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false"> Confirm</a>
                                            </button>
                                            <div class="dropdown-menu animated--fade-in"
                                                aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('finance.preview', $invoice->id )}}"><i class="fas fa-print"></i> Preview Invoice</a>
                                                <form id="myForm" action="{{ route('finance.acc', $invoice->id )}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('myForm').submit();"><i class="fas fa-check"></i> Setujui Invoice</a>
                                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#inputModal{{ $invoice->id  }}">
                                                    @php
                                                     $data = $invoice->id ;
                                                    @endphp
                                                <i class="fas fa-edit" ></i> Revisi Invoice</a>
                                                <a class="dropdown-item" href="{{ route('finance.showFinance', $invoice->id )}}"><i class="fas fa-eye"></i> Lihat Keterangan</a>
                                                <a class="dropdown-item" href="{{ route('invoice.edit', $invoice->id )}}"><i class="fas fa-edit"></i> Edit Invoice</a>
                                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#deleteModal{{ $invoice->id  }}"><i class="fas fa-trash"></i> Hapus Invoice
                                                    @php
                                                        $data = $invoice->id ;
                                                     @endphp
                                               </a>
                                            </div>
                                        </div>
                                        @elseif ($invoice->status == 1)
                                            <button class="d-sm-inline-block btn btn-success shadow-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">Action</a>
                                            </button>
                                            <div class="dropdown-menu animated--fade-in"
                                                aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('finance.preview', $invoice->id )}}"><i class="fas fa-print"></i> Preview Invoice</a>
                                                <a href="{{ route('invoice.terbitkanInvoice', $invoice->id)}}" class="dropdown-item">
                                                    <i class="fas fa-check"></i> Terbitkan Invoice
                                                </a>
                                                <a href="{{ route('finance.showFinance', $invoice->id )}}" class="dropdown-item">
                                                    <i class="fas fa-eye"></i> Lihat Keterangan
                                                </a>
                                                <a href="{{ route('invoice.edit', $invoice->id )}}" class="dropdown-item">
                                                    <i class="fas fa-edit"></i> Edit Invoice
                                                </a>
                                                <a href="{{ route('finance.showFinance', $invoice->id ) }}" data-toggle="modal" data-target="#deleteModal{{ $invoice->id  }}" class="dropdown-item">
                                                    <i class="fas fa-trash"></i> Hapus Invoice
                                                    @php
                                                        $data = $invoice->id ;
                                                    @endphp
                                                </a>
                                            </div>
                                        @elseif ($invoice->status == 2)
                                        <button class="d-sm-inline-block btn btn-info shadow-sm dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">Action</a>
                                        </button>
                                            <div class="dropdown-menu animated--fade-in"
                                                aria-labelledby="dropdownMenuButton">
                                                <a href="{{ route('finance.showFinance', $invoice->id )}}" class="dropdown-item">
                                                    <i class="fas fa-print"></i> Download Invoice
                                                </a>
                                                 <form id="bayar" action="{{ route('invoice.bayar', $invoice->id )}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('bayar').submit();"><i class="fas fa-check"></i> Konfirmasi Bayar</a>

                                                <a href="{{ route('finance.showFinance', $invoice->id )}}" class="dropdown-item">
                                                    <i class="fas fa-eye"></i> Lihat Keterangan
                                                </a>
                                                <a href="{{ route('invoice.edit', $invoice->id )}}" class="dropdown-item">
                                                    <i class="fas fa-edit"></i> Edit Invoice
                                                </a>
                                                <a href="{{ route('finance.showFinance', $invoice->id ) }}" data-toggle="modal" data-target="#deleteModal{{ $invoice->id  }}" class="dropdown-item">
                                                    <i class="fas fa-trash"></i> Hapus Invoice
                                                    @php
                                                        $data = $invoice->id ;
                                                    @endphp
                                                </a>
                                            </div>
                                        @elseif ($invoice->status == 3)
                                            <a href="#">
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#inputPajak{{ $invoice->id }}">Input Faktur Pajak</button> &nbsp;
                                                @php
                                                 $data = $invoice->id;
                                                @endphp
                                            </a>
                                        @elseif ($invoice->status == 4)
                                            <a href="#">
                                                <button class="d-sm-inline-block btn btn-m btn-outline-success shadow-m" data-toggle="modal" data-target="#viewModal{{ $invoice->id  }}"><i class="fas fa-eye"></i> No.NTPN</button> &nbsp;
                                                @php
                                                 $data = $invoice->id;
                                                @endphp
                                            </a>
                                        @else
                                        <div class="btn-group" role="group" >
                                            <button class="d-sm-inline-block btn btn-danger shadow-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">Action</a>
                                            </button>
                                            <div class="dropdown-menu animated--fade-in"
                                                aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('finance.preview', $invoice->id )}}"><i class="fas fa-print"></i> Preview Invoice</a>
                                                <form id="myForm" action="{{ route('finance.acc', $invoice->id )}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('myForm').submit();"><i class="fas fa-check"></i> Setujui Invoice</a>
                                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#inputModal{{ $invoice->id  }}">
                                                    @php
                                                     $data = $invoice->id ;
                                                    @endphp
                                                <i class="fas fa-edit" ></i> Revisi Invoice</a>
                                                <a class="dropdown-item" href="{{ route('finance.showFinance', $invoice->id )}}"><i class="fas fa-eye"></i> Lihat Keterangan</a>
                                                <a class="dropdown-item" href="{{ route('invoice.edit', $invoice->id )}}"><i class="fas fa-edit"></i> Edit Invoice</a>
                                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#deleteModal{{ $invoice->id  }}"><i class="fas fa-trash"></i> Hapus Invoice
                                                    @php
                                                        $data = $invoice->id ;
                                                     @endphp
                                               </a>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                <div class="modal fade" id="viewModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
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
                                                @if ($item->id_invoice == $invoice->id)
                                                   No. NTPN : {{ $item->ntpn }}
                                                @endif
                                           @endforeach
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <div class="modal fade" id="inputPajak{{ $invoice->id }}" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="inputModalLabel">Input No.NTPN</h5>
                                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                          <form action="{{ route('invoice.pajak', $invoice->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                              <label for="inputField" class="form-label">Input No.NTPN</label>
                                              <input name="ntpn" type="number" class="form-control" id="inputField" placeholder="No.NTPN" >
                                              <input name="idInv" value="{{ $invoice->id }}" type="number" class="form-control" id="inputField" placeholder="No.NTPN" hidden>
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
                                <div class="modal fade" id="inputModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="inputModalLabel">Input Revisi</h5>
                                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                          <form action="{{ route('finance.revisi', $invoice->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                              <label for="inputField" class="form-label">Input Revisi</label>
                                              <textarea name="revisi" class="form-control" id="inputField" placeholder="Input Revisi" id="" cols="30" rows="5"></textarea>
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
                            <div class="modal fade" id="deleteModal{{ $invoice->id  }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                        <form action="{{ route('invoice.delete', $invoice->id ) }}" method="POST" id="deleteForm">
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


