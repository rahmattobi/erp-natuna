@extends('layouts.app')
@section('title', 'ERP - Natuna Global Ekapersada')

@section('contents')
<div class="row">
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">Invoice</h1>
            <a href="{{ route('invoice.input') }}" class="d-none d-sm-inline-block btn btn-sm btn-outline-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-primary-50"></i> Input Invoice</a>
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
                                <th>Tanggal</th>
                                <th>No. Invoice</th>
                                <th>Jatuh Tempo</th>
                                <th>Total Harga</th>
                                <th style="width: 100px">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama Client</th>
                                <th>Nama Perusahaan</th>
                                <th>Tanggal</th>
                                <th>No. Invoice</th>
                                <th>Jatuh Tempo</th>
                                <th>Total Harga</th>
                                <th style="width: 100px">Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($invoice as $invoice)
                                <tr>
                                    <td>{{ $invoice->nama_client }}</td>
                                    <td>{{ $invoice->nama_perusahaan }}</td>
                                    <td>{{ $invoice->tanggal }}</td>
                                    <td>{{ $invoice->no_inv }}</td>
                                    <td>{{ $invoice->tempo }}</td>
                                    <td>100</td>
                                    {{-- <td class="show-read-more">{{ $invoice->end }}</td> --}}
                                    {{-- <td>
                                        @if ($invoice->category == 0)
                                            <span class="badge badge-primary">On Progress</span>
                                        @else
                                            <span class="badge badge-success">Done</span>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <div class="btn-group" role="group" >
                                            <a href="{{ route('invoice.view', $invoice->id)}}">
                                                <button class="btn btn-info"><i class="fas fa-eye"></i></button>
                                            </a>
                                            <a href="{{ route('invoice.view', $invoice->id)}}">
                                                <button class="btn btn-warning"><i class="fas fa-edit"></i></button>
                                            </a>
                                            <a href="{{ route('invoice.view', $invoice->id) }}" data-toggle="modal" data-target="#deleteModal{{ $invoice->id }}">
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                @php
                                                     $data = $invoice->id;
                                                @endphp
                                            </a>
                                        </div>
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
                                        <form action="{{ route('timeline.delete', $invoice->id) }}" method="POST" id="deleteForm">
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

