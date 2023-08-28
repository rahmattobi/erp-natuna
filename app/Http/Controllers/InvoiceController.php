<?php

namespace App\Http\Controllers;
// use Barryvdh\DomPDF\Facade\Pdf;
use PDF;
use App\Models\pajak;
use App\Models\no_inv;
use App\Models\revisi;
use App\Models\invoice;
use Illuminate\Http\Request;
use App\Models\invoice_detail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoices = invoice::all();
        $result = DB::table('invoices as i')
        ->leftJoin('invoice_details as d', function ($join) {
            $join->on('i.id', '=', 'd.invoice_id')
                ->where('d.status', '>=', 2);
        })
        ->select('i.id as invoice_id', DB::raw('COALESCE(COUNT(d.status), 0) as total_status'))
        ->groupBy('i.id')
        ->get();

        $revisi = DB::table('invoices')
        ->join('revisis', 'invoices.id', '=', 'revisis.invoice_id')
        ->select('revisis.*')
        ->where('revisis.status', '=', 0)
        ->get();

        return view('invoice.index',compact('result','invoices','revisi'));
    }

    // convert number to romawi
    public function getRomanMonth($monthNumber) {
        $romans = [
            'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'
        ];

        return $romans[$monthNumber - 1];
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
         $tempo = $request->input('tempo');
         $tanggal = $request->input('tanggal');

        if ($kuantitas == "" && $keterangan == "" && $harga == "") {
            return back()->with('danger', 'Lengkapi data dengan benar');
        } else {

        $request->validate([
            'kuantitas.*' => 'required',
            'harga.*' => 'required',
            'keterangan.*' => 'required',
            'tempo.*' => 'required',
        ]);


        $invoiceModel = invoice::create($request->all());

        // Save the data into the database
        foreach ($kuantitas as $key => $quantity) {
            invoice_detail::create([
                'invoice_id' => $invoiceModel->id,
                'kuantitas' => $quantity,
                'harga' => $harga[$key],
                'keterangan' => $keterangan[$key],
                'tempo' => $tempo,
                'tanggal' => $tanggal,
            ]);
        }
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->level == 5) {
                    return redirect()->route('invoice.index')->with('success', 'Invoices updated successfully');

                } else {
                    return redirect()->route('finance.index')->with('success', 'Invoices updated successfully');
                }
            }
        }
    }

    public function show($id)
    {
        $invoice = invoice::where('id', $id)->first();
        $invoice_detail = DB::table('invoices')
        ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
        ->select('invoice_details.*')
        ->where('invoice_details.invoice_id', '=', $id)
        ->get();

        $pajaks = pajak::all();

        return view('invoice.show',compact('invoice','invoice_detail','pajaks'));
    }

    public function terbitkanInvoice($id){

            $invoice_detail = invoice_detail::find($id);
            $currentMonthNumber = Carbon::now()->month;
            $romanMonth = $this->getRomanMonth($currentMonthNumber);
            $lastInvoice = invoice_detail::orderByDesc('id')->skip(1)->take(1)->get();
            $pattern = '/^(\d+)/';

            if ($invoice_detail->no_inv == '') {
                $noinv = new no_inv();
                $no_inv = no_inv::latest()->first();
                if ($no_inv == '') {
                    $noinv->no_inv = '23/NGE/INV/FIN/'.$romanMonth.'/'.Carbon::now()->year;
                    $noinv->save();

                    $no_invo = no_inv::latest()->first();
                    $invoice_detail->no_inv = $no_invo->no_inv;
                    $invoice_detail->status = 1;
                    $invoice_detail->save();
                    return back()->with('success', 'No.Invoice berhasil di terbitkan');
                } else {
                    if (preg_match($pattern, $no_inv->no_inv, $matches)) {
                            $numbInv = $matches[1]; // Angka yang cocok ditemukan di indeks ke-1 array $matches
                            $no_inv->no_inv = ($numbInv+1).'/NGE/INV/FIN/'.$romanMonth.'/'.Carbon::now()->year;
                            $no_inv->save();

                            $no_invo = no_inv::latest()->first();
                            $invoice_detail->no_inv = $no_invo->no_inv;
                            $invoice_detail->status = 1;
                            $invoice_detail->save();
                            return back()->with('success', 'No.Invoice berhasil di terbitkan');
                    }
                }
            }

            // if ($invoice_detail->no_inv == '' && $lastInvo->no_inv == '') {
            //     $invoice_detail->no_inv = '23/NGE/INV/FIN/'.$romanMonth.'/'.Carbon::now()->year;
            //     $invoice_detail->status = 1;
            //     $invoice_detail->save();
            //     return back()->with('success', 'No.Invoice berhasil di terbitkan');
            // }else {
            //     if (preg_match($pattern, $lastInvo->no_inv, $matches)) {
            //         $numbInv = $matches[1]; // Angka yang cocok ditemukan di indeks ke-1 array $matches
            //         $invoice_detail->no_inv = ($numbInv+1).'/NGE/INV/FIN/'.$romanMonth.'/'.Carbon::now()->year;
            //         $invoice_detail->status = 1;
            //         $invoice_detail->save();
            //         return back()->with('success', 'No.Invoice berhasil di terbitkan');
            //     }
            //     // print_r($lastInvo->no_inv);
            //  }

    }

    public function printInvoice($id){
         $invoice = DB::table('invoice_details')
        ->join('invoices', 'invoices.id', '=', 'invoice_details.invoice_id')
        ->select('invoice_details.*','invoices.*')
        ->where('invoice_details.id', '=', $id)
        ->get();

        return view('invoice.print',compact('invoice'));
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
            'no_inv' => 'required',
        ]);
        $invoice = invoice::findOrFail($id);
        $invoice->update($request->all());
        return redirect()->route('invoice.finance')->with('success', 'Invoices updated successfully');

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

    // project

    public function inv_project(){
        return view('invoice.project.input');
    }

    public function inputProject(Request $request)
    {
        if (!$request->has('nama_client')||!$request->has('nama_perusahaan')) {
            return back()->with('danger', 'Lengkapi data dengan benar');
        } else{
            $invoice = invoice::create($request->all());
        }
            $insta_plan = $request->input('inst_plan');
            for ($i = 1; $i <= $insta_plan; $i++) {
                    $tanggal = $request->input('tanggal_' . $i);
                    $carbonDate = Carbon::createFromFormat('Y-m-d', $tanggal);
                    $kuantitas = $request->input('kuantitas_' . $i);
                    $keterangan = $request->input('ket_' . $i);
                    $harga = $request->input('harga_' . $i);

                    invoice_detail::create([
                        'invoice_id' => $invoice->id,
                        'kuantitas' => $kuantitas,
                        'harga' => $harga,
                        'keterangan' => $keterangan,
                        'tempo' => $carbonDate->addDays(14),
                        'tanggal' => $tanggal,
                    ]);
            }
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->level == 5) {
                return redirect()->route('invoice.index')->with('success', 'Invoices updated successfully');

            } else {
                return redirect()->route('finance.index')->with('success', 'Invoices updated successfully');
            }
        }
    }

    public function bayarInvoice($id)
    {
        $invoice = invoice_detail::find($id);

        if ($invoice) {

            $invoice->status = 2;
            $invoice->save();
            return back()->with('success', 'Status updated successfully.');
        }
    }

    public function inputPajak(Request $request){

        $id_invdetail = $request->input('id');
        pajak::create([
            'id_invoice_detail' => $id_invdetail,
            'ntpn' => $request->input('ntpn')
        ]);

        $invoiceDetail = invoice_detail::find($id_invdetail);

        if ($invoiceDetail) {
            $invoiceDetail->status = 3;
            $invoiceDetail->save();
        return back()->with('success', 'Status updated successfully.');
        }
    }

    // GMFinance
    public function finance()
    {
        $invoices = invoice::all();
        $result = DB::table('invoices as i')
        ->leftJoin('invoice_details as d', function ($join) {
            $join->on('i.id', '=', 'd.invoice_id')
                ->where('d.status', '>=', 2);
        })
        ->select('i.id as invoice_id', DB::raw('COALESCE(COUNT(d.status), 0) as total_status'))
        ->groupBy('i.id')
        ->get();

        $revisi = DB::table('invoices')
        ->join('revisis', 'invoices.id', '=', 'revisis.invoice_id')
        ->select('revisis.*')
        ->where('revisis.status', '=', 0)
        ->get();

        return view('invoice.gmFinance.index',compact('result','invoices','revisi'));

    }

    public function accInvoice($id)
    {
        $invoice = invoice::find($id);

        if ($invoice) {
            $invoice->status = 1;
            $invoice->save();
            return back()->with('success', 'successfully.');
        }
    }

    public function showFinance($id)
    {
        $invoice = invoice::where('id', $id)->first();
        $invoice_detail = DB::table('invoices')
        ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
        ->select('invoice_details.*')
        ->where('invoice_details.invoice_id', '=', $id)
        ->get();

        $pajaks = pajak::all();

        return view('invoice.gmFinance.show',compact('invoice','invoice_detail','pajaks'));
    }
    public function inputRevisi(Request $request, string $id){
        revisi::create([
            'invoice_id' => $id,
            'revisi' => $request->input('revisi'),
        ]);

        $invoice = invoice::find($id);

        if ($invoice) {
            $invoice->status = 2;
            $invoice->save();
        }

        return back()->with('success', 'Status updated successfully');
    }

    public function revision($id)
    {
        $invoice = invoice::find($id);
        $revisi = revisi::where('invoice_id', $id)->get();

        if ($invoice && $revisi->isNotEmpty()) {
            $invoice->status = 0;
            $invoice->save();

            foreach ($revisi as $revisi) {
                $revisi->status = 1;
                $revisi->save();
            }

        }

        return back()->with('success', 'Status updated successfully.');
    }
}
