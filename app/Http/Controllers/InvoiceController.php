<?php

namespace App\Http\Controllers;
// use Barryvdh\DomPDF\Facade\Pdf;
use PDF;
use App\Models\invoice;
use Illuminate\Http\Request;
use App\Models\invoice_detail;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoices = invoice::all();
        return view('invoice.index',compact('invoices'));
    }

    public function create()
    {
        return view('invoice.input');
    }

    public function inputDetail($id)
    {
        $invoice = invoice::where('id', $id)->first();
        return view('invoice.inputDetail',compact('invoice'));
    }

    public function actionDetail(Request $request, string $id)
    {
        $request->validate([
            'kuantitas' => 'required',
            'harga' => 'required',
            'keterangan' => 'required',
        ]);

        invoice_detail::create([
            'invoice_id' => $id,
            'keterangan' => $request->input('keterangan'),
            'kuantitas' => $request->input('kuantitas'),
            'harga' => $request->input('harga'),
        ]);

        return redirect()->route('invoice.view',$id)->with('success', 'Invoices updated successfully');
    }

    public function store(Request $request)
    {

         $kuantitas = $request->input('kuantitas');
         $harga = $request->input('harga');
         $keterangan = $request->input('keterangan');

        if ($kuantitas == "") {
        $invoiceModel = invoice::create($request->all());
        return redirect()->route('invoice.index')->with('success', 'Invoices updated successfully');

        } else {

        $request->validate([
            'kuantitas.*' => 'required',
            'harga.*' => 'required',
            'keterangan.*' => 'required',
        ]);


        $invoiceModel = invoice::create($request->all());

        // Save the data into the database
        foreach ($kuantitas as $key => $quantity) {
            invoice_detail::create([
                'invoice_id' => $invoiceModel->id,
                'kuantitas' => $quantity,
                'harga' => $harga[$key],
                'keterangan' => $keterangan[$key],
            ]);
        }
        $invoices = invoice::all();
        return view('invoice.index',compact('invoices'));
        }
    }

    public function show($id)
    {
        $invoice = invoice::where('id', $id)->first();
        $invoice_detail = DB::table('invoices')
        ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
        ->select('invoice_details.id','invoice_details.kuantitas', 'invoice_details.harga', 'invoice_details.keterangan')
        ->where('invoice_details.invoice_id', '=', $id)
        ->get();

        return view('invoice.show',compact('invoice','invoice_detail'));
    }

    public function viewInvoice($id){
        $invoice = invoice::where('id', $id)->first();
        $invoice_detail = DB::table('invoices')
        ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
        ->select('invoice_details.kuantitas', 'invoice_details.harga', 'invoice_details.keterangan')
        ->get();

        return view('invoice.print',compact('invoice','invoice_detail'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = invoice::where('id', $id)->first();
        return view('invoice.edit',compact('invoice'));
    }

    public function editDetail(string $id)
    {
        $invoice = invoice_detail::where('id', $id)->first();
        return view('invoice.editDetail',compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_client' => 'required',
            'nama_perusahaan' => 'required',
            'tanggal' => 'required',
            'no_inv' => 'required',
            'tempo' => 'required',
        ]);
        $invoice = invoice::findOrFail($id);
        $invoice->update($request->all());
        return redirect()->route('invoice.index')->with('success', 'Invoices updated successfully');

    }

    public function updateDetail(Request $request, string $id)
    {
        $request->validate([
            'keterangan' => 'required',
            'kuantitas' => 'required',
            'harga' => 'required',
        ]);
        $invoice = invoice_detail::findOrFail($id);
        $invoice->update($request->all());
        return redirect()->route('invoice.view',$invoice->invoice_id)->with('success', 'Invoices Detaild updated successfully');

    }

    public function deleteInvoiceDetail(string $id){
        $User = invoice_detail::find($id);
        $User->delete();
        return back()->with('success', 'Invoice Detail Deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $User = invoice::find($id);
        $User->delete();
        return back()->with('success', 'Invoice Deleted successfully');
    }


}
