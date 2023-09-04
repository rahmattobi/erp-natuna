<!DOCTYPE html>
<html>
<head>
    <title>Preview PDF</title>
    <style>
        body{margin-top:20px;
        background-color: #f7f7ff;
        }
        #invoice {
            padding: 0px;
        }

        .invoice {
            position: relative;
            background-color: #FFF;
            min-height: 680px;
            padding: 15px
        }

        .invoice header {
            padding: 10px 0;
            margin-bottom: 10px;
            border-bottom: 1px solid #0d6efd
        }

        .invoice .company-details {
            text-align: right
        }

        .invoice .company-details .name {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .contacts {
            margin-bottom: 20px
        }

        .invoice .invoice-to {
            text-align: left
        }

        .invoice .invoice-to .to {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .invoice-details {
            text-align: right
        }

        .invoice .invoice-details .invoice-id {
            margin-top: 0;
            color: #0d6efd
        }

        .invoice main {
            padding-bottom: 50px
        }

        /* .invoice main .thanks {
            margin-top: -100px;
            font-size: 2em;
            margin-bottom: 50px
        }

        .invoice main .notices {
            padding-left: 6px;
            border-left: 6px solid #0d6efd;
            background: #e7f2ff;
            padding: 10px;
        } */

        /* .invoice main .notices .notice {
            font-size: 1.2em
        } */

        .invoice table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .invoice .isi td,
        .invoice .isi th {
            padding: 15px;
            border: 1.5px solid #ddd !important
        }

        .invoice .client td,
        .invoice .client th {
            padding-bottom: 10px;
        }

        .invoice table th {
            white-space: nowrap;
            font-weight: 400;
            font-size: 16px
        }

        .invoice table td h3 {
            margin: 0;
            font-weight: 400;
            color: #0d6efd;
            font-size: 1.2em
        }

        .invoice table .qty,
        .invoice table .total,
        .invoice table .unit {
            text-align: right;
            font-size: 1.2em
        }

        .invoice table .no {
            color: #fff;
            font-size: 1.6em;
            background: #0d6efd
        }

        .invoice table .unit {
            background: #ddd
        }

        .invoice table .total {
            background: #0d6efd;
            color: #fff
        }

        .invoice table tbody tr:last-child td {
            border: none
        }

        .invoice table tfoot td {
            background: 0 0;
            border-bottom: none;
            white-space: nowrap;
            text-align: right;
            padding: 10px 20px;
            font-size: 1.2em;
            border-top: 1px solid #aaa
        }

        .invoice table tfoot tr:first-child td {
            border-top: none
        }
        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0px solid rgba(0, 0, 0, 0);
            border-radius: .25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
        }

        .invoice table tfoot tr:last-child td {
            color: #0d6efd;
            font-size: 1.4em;
            border-top: 1px solid #0d6efd
        }

        .invoice table tfoot tr td:first-child {
            border: none
        }

        .invoice footer {
            width: 100%;
            text-align: center;
            color: #777;
            border-top: 1px solid #aaa;
            padding: 8px 0
        }

        @media print {
            .invoice {
                font-size: 11px !important;
                overflow: hidden !important
            }
            .invoice footer {
                position: absolute;
                bottom: 10px;
                page-break-after: always
            }
            .invoice>div:last-child {
                page-break-before: always
            }
        }

        .invoice main .notices {
            padding-left: 6px;
            border-left: 6px solid #0d6efd;
            background: #e7f2ff;
            padding: 10px;
        }

        .invoice-info {
            display: flex;
            align-items: center;
            margin-bottom: -40px;
        }

        .invoice-label {
            flex: 1;
            text-align: right;
        }

        .invoice-value {
            flex: 1;
            text-align: left;
            padding-left: 5px;
        }

    </style>
</head>
<body>
    @php
        $nomor = 1;

    @endphp
    @foreach ($invoice as $invoice_detail)
    @php
        $no = 1;
        $totalAmount = 0;
    @endphp
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div id="invoice">
                    <div class="invoice overflow-auto">
                        <div style="min-width: 600px">
                            <table >
                                <thead >
                                    <tr >
                                        <th class="no-border" style="text-align:left" width="50%" colspan="2" >
                                            <img width="200px" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('adminAssets/img/logo.jpg'))) }}" alt="My Image">
                                        </th>
                                        <th  width="50%" colspan="2" style="text-align:right" >
                                            <span style="font-size: 16px">PT. NATUNA GLOBAL EKAPERSADA</span> <br>
                                            <span>EduCenter Building Lt. 2A Unit 22592</span> <br>
                                            <span>Jl. Sekolah Foresta No. 8, BSD City</span> <br>
                                            <span>Banten 15331 - Indonesia</span> <br>
                                        </th>

                                    </tr>
                                </thead>
                                    <tbody>
                                        <td colspan="4" class="no-border"><hr></td>
                                    </tbody>
                            </table>
                            {{-- <main> --}}
                                <table class="client">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 24px;font-weight: bold" colspan="5">
                                                INVOICE <br><span style="font-size: 14px;font-weight: normal">(Preview Invoice-{{ $nomor++ }})</span>
                                            </th>
                                        </tr>
                                        <tr style="text-align: left">
                                            <th width="50%" colspan="2" >
                                                <span>Kepada Yth :</span> <br>
                                                <span></span> <br>
                                                <span>{{ $invoice_detail->nama_client }}</span> <br>
                                                <span>{{ $invoice_detail->nama_perusahaan }}</span> <br>
                                            </th>
                                            <th style="text-align: left;padding-left:50px" width="50%" colspan="2">
                                                <table>
                                                    <tr>
                                                      <th colspan="2" class="invoice-info">
                                                        <span class="invoice-label">Tanggal :</span>
                                                        <span class="invoice-value">{{ \Carbon\Carbon::parse($invoice_detail->tanggal)->format('d F Y', 'id') }}</span>
                                                      </th>
                                                    </tr>
                                                    <tr>
                                                      <th colspan="2" class="invoice-info">
                                                        <span class="invoice-label">No. Invoice :</span>
                                                        <span class="invoice-value">{{ $invoice_detail->no_inv }}</span>
                                                      </th>
                                                    </tr>
                                                    <tr>
                                                      <th colspan="2" class="invoice-info">
                                                        <span class="invoice-label">Jatuh Tempo :</span>
                                                        <span class="invoice-value">{{ \Carbon\Carbon::parse($invoice_detail->tempo)->format('d F Y', 'id') }}</span>
                                                      </th>
                                                    </tr>
                                                  </table>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="isi">
                                    <thead>
                                        <tr>
                                            <th>NO.</th>
                                            <th class="text-left">KETERANGAN</th>
                                            <th class="text-right">KUANTITAS</th>
                                            <th class="text-right">HARGA (Rp.)</th>
                                            <th class="text-right">TOTAL (Rp.)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center">{{ $no++ }}</td>
                                            <td class="text-left">{{ $invoice_detail->keterangan }}</td>
                                            <td class="unit">{{ $invoice_detail->kuantitas }}</td>
                                            <td class="qty"> {{ number_format($invoice_detail->harga, 0, ',', '.') }}</td>
                                            <td class="total">{{ 'Rp ' . number_format(( $invoice_detail->kuantitas*$invoice_detail->harga), 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        @php
                                            $totalAmount += $invoice_detail->kuantitas*$invoice_detail->harga;
                                        @endphp
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">SUBTOTAL</td>
                                            <td>{{ 'Rp ' . number_format($totalAmount, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">PPN 11%</td>
                                            <td>{{ 'Rp ' . number_format($totalAmount*0.11, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">GRAND TOTAL</td>
                                            <td>{{ 'Rp ' . number_format((($totalAmount*0.11)+$totalAmount), 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            {{-- </main> --}}
                            <p class="text-start">
                                Terbilang : {{ ucwords(Terbilang::make(($totalAmount*0.11)+$totalAmount)) }} Rupiah
                            </p>
                            <span> Pembayaran Ke :</span> <br>
                            <span>PT. NATUNA GLOBAL EKAPERSADA
                            BCA KCU BUMI SERPONG DAMAI, NO REK: 4977712121</span>
                            <p class="text-start">
                                Hormat Kami, <br>
                                PT. Natuna Global Ekapersada
                                <br> <br>
                                <img width="100px" src="{{ asset('adminAssets/img/QR Code.png') }}" alt="">
                            </p>
                            <footer>Corporate Office : Jl. Boulevard Eropa No. 10 Lippo Karawaci Panunggangan Barat,
                                Cibodas,Tangerang Banten 15138
                                INDONESIA
                                </footer>
                        </div>
                        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</body>
</html>
