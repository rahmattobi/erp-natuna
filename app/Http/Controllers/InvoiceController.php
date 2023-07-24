<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\invoice_detail;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoice = invoice::all();
        // $invoice_detail = invoice_detail::all();
        return view('invoice.index',compact('invoice'));
    }

    public function create()
    {
        return view('invoice.input');
    }

    public function store(Request $request)
    {

        $invoiceModel = invoice::create($request->all());
        $request->validate([
            'kuantitas.*' => 'required',
            'harga.*' => 'required',
            'keterangan.*' => 'required',
        ]);

        // Access the dynamic input values as arrays
        $kuantitas = $request->input('kuantitas');
        $harga = $request->input('harga');
        $keterangan = $request->input('keterangan');

        // Save the data into the database
        foreach ($kuantitas as $key => $quantity) {
            invoice_detail::create([
                'invoice_id' => $invoiceModel->id,
                'kuantitas' => $quantity,
                'harga' => $harga[$key],
                'keterangan' => $keterangan[$key],
            ]);
        }
        return view('invoice.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = DB::table('invoice')
        ->join('invoice_detail', 'invoice.id', '=', 'invoice_detail.invoice_id')
        ->select('invoice.*', 'invoice_detail.kuantitas', 'invoice_detail.harga', 'invoice_detail.keterangan')
        ->get();
        // return view('invoice.show',compact('invoice'));
        return response()->json($invoice);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoice $invoice)
    {
        //
    }
}
