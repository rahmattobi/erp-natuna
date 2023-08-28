@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Invoice</h1>
            {{-- <a href="{{ route('invoice.input') }}" class="d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-primary-50"></i> Input Invoice</a> --}}
            <button class="d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm dropdown-toggle" type="button"
                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="fas fa-plus fa-sm text-primary-50"></i> Input Invoice</a>
            </button>
            <div class="dropdown-menu animated--fade-in"
                aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('invoice.input') }}">Perbulan</a>
                <a class="dropdown-item" href="{{ route('invoice.inv_project') }}">Project</a>
            </div>
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
                                <th>Nama Client</th>
                                <th>Nama Perusahaan</th>
                                <th>Instalment Plan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama Client</th>
                                <th>Nama Perusahaan</th>
                                <th>Instalment Plan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->nama_client }}</td>
                                    <td>{{ $invoice->nama_perusahaan }}</td>
                                    <td>
                                        @foreach ($result as $row)
                                            @if ($invoice->id == $row->invoice_id)
                                                @if ($row->total_status == $invoice->inst_plan)
                                                    <span class="badge badge-success">Lunas</span>
                                                @else
                                                    <span style="color: red">{{ $row->total_status }}</span>/{{ $invoice->inst_plan }} Dibayar
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($invoice->status == 0)
                                            <span class="badge badge-warning">Belum di Setujui</span>
                                        @elseif ($invoice->status == 1)
                                            <span class="badge badge-success">Di Setujui</span>
                                        @else
                                        <div class="btn-group" role="group" >
                                            <button class="badge badge-danger open-modal" data-toggle="modal" data-target="#invoiceModal{{ $invoice->id }}">
                                                Lihat Revisi
                                            </button>
                                            <form action="{{ route('invoice.revisi', $invoice->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                    <button class="badge badge-primary" type="submit">Submit Revisi</button>
                                            </form>
                                        </div>
                                        @endif
                                    </td>

                                    {{-- popup revisi --}}
                                    <div id="invoiceModal{{ $invoice->id }}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Detail Invoice</h4>
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
                                        <div class="btn-group" role="group" >
                                            <a href="{{ route('invoice.view', $invoice->id )}}">
                                                <button class="btn btn-info"><i class="fas fa-eye"></i></button>
                                            </a> &nbsp;
                                            <a href="{{ route('invoice.edit', $invoice->id )}}">
                                                <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                            </a>  &nbsp;
                                            <a href="{{ route('invoice.view', $invoice->id ) }}" data-toggle="modal" data-target="#deleteModal{{ $invoice->id  }}">
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                @php
                                                     $data = $invoice->id ;
                                                @endphp
                                            </a>
                                        </div>
                                        @elseif ($invoice->status == 3)
                                        <div class="btn-group" role="group" >
                                            <a href="{{ route('invoice.view', $invoice->id )}}">
                                                <button class="btn btn-info"><i class="fas fa-eye"></i></button>
                                            </a> &nbsp;
                                            <a href="{{ route('invoice.edit', $invoice->id )}}">
                                                <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                            </a>  &nbsp;
                                            <a href="{{ route('invoice.view', $invoice->id ) }}" data-toggle="modal" data-target="#deleteModal{{ $invoice->id  }}">
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                @php
                                                     $data = $invoice->id ;
                                                @endphp
                                            </a>
                                        </div>
                                        @else
                                        <a href="{{ route('invoice.view', $invoice->id )}}">
                                            <button class="btn btn-info"><i class="fas fa-eye"></i></button>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
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
<script>
    $(document).ready(function() {
        $('.open-modal').click(function() {
            var targetModal = $(this).data('target');
            $(targetModal).modal('show');
        });
    });
</script>
@endsection

