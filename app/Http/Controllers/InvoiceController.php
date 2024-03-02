<?php

namespace App\Http\Controllers;
// use Barryvdh\DomPDF\Facade\Pdf;
use PDF;
use App\Models\pajak;
use App\Models\no_inv;
use App\Models\revisi;
use App\Models\invoice;
use App\Models\notification;
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
        $invoices = invoice::orderBy('created_at','desc')->get();
        $revisi = DB::table('invoices')
        ->join('revisis', 'invoices.id', '=', 'revisis.invoice_id')
        ->select('revisis.*')
        ->where('revisis.status', '=', 0)
        ->get();

        $pajaks = pajak::all();

        return view('invoice.index',compact('invoices','revisi','pajaks'));
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
        $nama_client = $request->input('nama_client');
        $nama_perusahaan = $request->input('nama_perusahaan');
        $tanggal = $request->input('tanggal');
        $langganan = $request->input('langganan');

        $keterangan = $request->input('keterangan');
        $kuantitas = $request->input('kuantitas');
        $harga = $request->input('harga');

        if ($kuantitas == "" && $keterangan == "" && $harga == "") {
            return back()->with('danger', 'Lengkapi data dengan benar');
        } else {

        $request->validate([
            'kuantitas.*' => 'required',
            'harga.*' => 'required',
            'keterangan.*' => 'required',
            'tempo.*' => 'required',
        ]);

        $currentDate = Carbon::now(); // Mendapatkan tanggal saat ini
        $newDate = $currentDate->copy()->addMonths($langganan); // Menambah 1 bulan ke tanggal saat ini

        $formattedNewDate = $newDate->format('Y-m-d');

        $invoiceModel = invoice::create([
            'nama_client' => $nama_client,
            'nama_perusahaan' => $nama_perusahaan,
            'tanggal' => $tanggal,
            'langganan' => $langganan,
            'nextDate' => $formattedNewDate,
        ]);

        if ($invoiceModel) {
            notification::create([
                'notify' => 'Invoice terbaru telah diinputkan',
                'user_id' => auth()->id(),
                'invoice_id' => $invoiceModel->id,
            ]);

            // Save the data into the database
            foreach ($kuantitas as $key => $quantity) {
                invoice_detail::create([
                    'invoice_id' => $invoiceModel->id,
                    'kuantitas' => $quantity,
                    'harga' => $harga[$key],
                    'keterangan' => $keterangan[$key],
                ]);
            }
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

            $invoice = invoice::find($id);
            $currentMonthNumber = Carbon::now()->month;
            $romanMonth = $this->getRomanMonth($currentMonthNumber);
            $lastInvoice = invoice::orderByDesc('id')->skip(1)->take(1)->get();
            $pattern = '/^(\d+)/';

            if ($invoice->no_inv == '') {
                $noinv = new no_inv();
                $no_inv = no_inv::latest()->first();
                if ($no_inv == '') {
                    $noinv->no_inv = '23/NGE/INV/FIN/'.$romanMonth.'/'.Carbon::now()->year;
                    $noinv->save();

                    $no_invo = no_inv::latest()->first();
                    $invoice->no_inv = $no_invo->no_inv;
                    $invoice->status = 2;
                    $invoice->save();
                    return back()->with('success', 'No.Invoice berhasil di terbitkan');
                } else {
                    if (preg_match($pattern, $no_inv->no_inv, $matches)) {
                            $numbInv = $matches[1]; // Angka yang cocok ditemukan di indeks ke-1 array $matches
                            $no_inv->no_inv = ($numbInv+1).'/NGE/INV/FIN/'.$romanMonth.'/'.Carbon::now()->year;
                            $no_inv->save();

                            $no_invo = no_inv::latest()->first();
                            $invoice->no_inv = $no_invo->no_inv;
                            $invoice->status = 2;
                            $invoice->save();
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
        ->select('invoice_details.*')
        ->where('invoices.id', '=', $id)
        ->get();

        $inv = invoice::find($id);
        // print_r($invoice);

        return view('invoice.print', compact('invoice','inv'));
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
            notification::create([
                'notify' => 'Invoice terbaru telah diinputkan',
                'user_id' => auth()->id(),
                'invoice_id' => $invoice->id,
            ]);
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
        $invoice = invoice::find($id);

        if ($invoice) {

            $invoice->status = 3;
            $invoice->save();
            return back()->with('success', 'Status updated successfully.');
        }
    }

    public function inputPajak(Request $request,$id){

        pajak::create([
            'id_invoice' => $id,
            'ntpn' => $request->input('ntpn')
        ]);

        $invoice = invoice::find($id);

        if ($invoice) {
            $invoice->status = 4;
            $invoice->save();
        return back()->with('success', 'Status updated successfully.');
        }
    }

    // GMFinance
    public function finance()
    {
        $invoices = invoice::orderBy('created_at','desc')->get();
        $revisi = DB::table('invoices')
        ->join('revisis', 'invoices.id', '=', 'revisis.invoice_id')
        ->select('revisis.*')
        ->where('revisis.status', '=', 0)
        ->get();
        $pajaks = pajak::all();

        return view('invoice.gmFinance.index',compact('invoices','revisi','pajaks'));

    }

    public function accInvoice($id)
    {
        $invoice = invoice::find($id);
        $acc = notification::where('invoice_id', $id)->get();


        if ($invoice && $acc->isNotEmpty()) {
            $invoice->status = 1;
            $invoice->save();

            foreach ($acc as $acc) {
                $acc->status = 1;
                $acc->notify = 'Invoice telah di acc';
                $acc->save();
            }
        }
        return back()->with('success', 'successfully.');
    }

    public function showFinance($id)
    {
        $invoice = invoice::where('id', $id)->first();
        $invoice_detail = DB::table('invoices')
        ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
        ->select('invoice_details.*')
        ->where('invoice_details.invoice_id', '=', $id)
        ->get();


        return view('invoice.gmFinance.show',compact('invoice','invoice_detail'));
    }
    public function inputRevisi(Request $request, string $id){

        $revisi = revisi::where('invoice_id', $id)->get();
        $notify = notification::where('invoice_id', $id)->get();

        // if ($notify->isNotEmpty()) {
        //     print_r($notify);
        // } else {
        //     print_r('tesst');
        // }

        if ($notify ->isNotEmpty()) {
            foreach ($notify as $key => $value) {
                if ($value != '') {
                    $value->notify = 'Revisi Pada Invoice';
                    $value->status = 2;
                    $value->save();
                }
            }
        }else {
            notification::create([
                'notify' => 'Revisi Pada Invoice',
                'status' => 2,
                'user_id' => auth()->id(),
                'invoice_id' => $id,
            ]);
        }


            $invoice = invoice::find($id);

            if ($invoice) {
                $invoice->status = 5;
                $invoice->save();
            }

            if ($revisi->isEmpty()) {
                revisi::create([
                    'invoice_id' => $id,
                    'revisi' => $request->input('revisi'),
                ]);
            } else {
            foreach ($revisi as $revisi) {
                if ($revisi->status == 0 | $revisi->status == 1) {
                    $revisi->revisi = $request->input('revisi');
                    $revisi->status = 0;
                    $revisi->save();
                } else {
                    revisi::create([
                        'invoice_id' => $id,
                        'revisi' => $request->input('revisi'),
                    ]);
                }
            }
        }

        return back()->with('success', 'Status updated successfully');
    }

    public function revision($id)
    {
        $invoice = invoice::find($id);
        $revisi = revisi::where('invoice_id', $id)->get();
        $acc = notification::where('invoice_id', $id)->get();

        $invoice->status = 0;
        $invoice->save();

        foreach ($revisi as $revisi) {
            $revisi->status = 1;
            $revisi->save();
        }

        foreach ($acc as $acc) {
            $acc->status = 0;
            $acc->user_id = auth()->id();
            $acc->notify = 'Invoice telah di Revisi';
            $acc->save();
        }
        return back()->with('success', 'Status updated successfully.');
    }

    public function preview($id){
        $invoice = DB::table('invoice_details')
        ->join('invoices', 'invoices.id', '=', 'invoice_details.invoice_id')
        ->select('invoice_details.*')
        ->where('invoices.id', '=', $id)
        ->get();

        $inv = invoice::find($id);
        // print_r($invoice);

        // $pdf = PDF::loadView('invoice.gmFinance.preview',compact('invoice','inv'));
        // $pdf->stream("dompdf_out.pdf", array("Attachment" => false));
        // exit(0);
        return view('invoice.gmFinance.preview', compact('invoice','inv'));
    }

    public function download(){
        $data = []; // Data yang ingin Anda tampilkan di tampilan HTML

        $pdf = PDF::loadView('invoice.gmFinance.preview', $data);
        return $pdf->download('invoice.gmFinance.preview');
    }

    public function createInv($id){
        $invoice = invoice::findOrFail($id);
        $inv = DB::table('invoices')
            ->join('invoice_details', 'invoices.id', '=', 'invoice_details.invoice_id')
            ->select('invoice_details.*')
            ->where('invoices.id', '=', $id)
            ->get();
       return view('invoice.gmFinance.createInv',compact('invoice','inv'));
    }

    public function newInv(Request $request){
        $nama_client = $request->input('nama_client');
        $nama_perusahaan = $request->input('nama_perusahaan');
        $tanggal = $request->input('tanggal');
        $langganan = $request->input('langganan');
        $invcount = $request->input('invcount');

        $keterangan = $request->input('keterangan');
        $kuantitas = $request->input('kuantitas');
        $harga = $request->input('harga');

        if ($langganan == "") {
            return back()->with('danger', 'Lengkapi data dengan benar');
        } else {

        $currentDate = Carbon::now(); // Mendapatkan tanggal saat ini
        $newDate = $currentDate->copy()->addMonths($langganan); // Menambah 1 bulan ke tanggal saat ini

        $formattedNewDate = $newDate->format('Y-m-d');

        $invoiceModel = invoice::create([
            'nama_client' => $nama_client,
            'nama_perusahaan' => $nama_perusahaan,
            'tanggal' => $tanggal,
            'langganan' => $langganan,
            'nextDate' => $formattedNewDate,
        ]);

        if ($invoiceModel) {
            notification::create([
                'notify' => 'Invoice terbaru telah diinputkan',
                'user_id' => auth()->id(),
                'invoice_id' => $invoiceModel->id,
            ]);

            foreach ($kuantitas as $key => $quantity) {
                invoice_detail::create([
                    'invoice_id' => $invoiceModel->id,
                    'kuantitas' => $quantity,
                    'harga' => $harga[$key],
                    'keterangan' => $keterangan[$key],
                ]);
            }

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
}
