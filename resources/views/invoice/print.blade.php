<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Invoice untuk {{ $invoice->nama_client }}</title>
    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            /* border: 1px solid #ddd; */
            padding: 8px;
            font-size: 14px;
        }

        .isi th, .isi td {
            border: 1.5px solid #ddd !important
        }


        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
            border: none;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
            border: none;

        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }

        @media print {
            @page { margin: 0; }
            body { margin: 1.6cm; }
        }
    </style>
    <script>window.print()</script>
</head>
<body>
        <table>
            <thead>
                <tr >
                    <th class="no-border" width="50%" colspan="2" >
                        {{-- <h2 class="text-start">Natuna Global</h2> --}}
                        <img width="200px" src="{{ asset('adminAssets/img/logo.jpg') }}" alt="" srcset="">
                        {{-- <img width="200px" src="{{ public_path("logo.jpg") }}"> --}}

                    </th>
                    <th  width="50%" colspan="2" class="text-end company-data no-border" >
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

        <table>
            <thead>
                <tr>
                    <br>
                    <th class="no-border heading text-center" colspan="5">
                        INVOICE
                    </th>
                </tr>
                <tr>
                    <th class="text-start company-data no-border" width="50%" colspan="2" >
                        <span>Kepada Yth :</span> <br>
                        <span></span> <br>
                        <span>{{ $invoice->nama_client }}</span> <br>
                        <span>{{ $invoice->nama_perusahaan }}</span> <br>
                    </th>
                    <th  width="50%" colspan="2" class="text-start company-data no-border">
                        <span>Tanggal: {{ \Carbon\Carbon::parse($invoice->tanggal)->format('d F Y', 'id') }}</span> <br>
                        <span>No. Invoice: {{ $invoice->no_inv }}</span> <br>
                        <span>Jatuh Tempo: {{ \Carbon\Carbon::parse($invoice->tempo)->format('d F Y', 'id') }}</span>
                    </th>
                </tr>
            </thead>
        </table>

        <table class="isi" style="margin-top: 50px;">
            <thead>
                <tr class="bg-blue">
                    <th>No.</th>
                    <th>Keterangan</th>
                    <th>Kuantitas</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @php
                $nomor = 1;
                $totalAmount = 0;
            @endphp
            @foreach($invoice_detail as $invoice_detail)
                <tr>
                    <td width="5%">{{ $nomor++ }}</td>
                    <td width="40%">
                        {{ $invoice_detail->keterangan }}
                    </td>
                    <td width="5%">{{ $invoice_detail->kuantitas }}</td>
                    <td> {{ 'Rp ' . number_format($invoice_detail->harga, 0, ',', '.') }}</td>
                    <td class="fw-bold">{{ 'Rp ' . number_format(( $invoice_detail->kuantitas*$invoice_detail->harga), 0, ',', '.') }}</td>
                </tr>
                <tr>
                    @php
                        $totalAmount += $invoice_detail->kuantitas*$invoice_detail->harga;
                    @endphp
                @endforeach
                    <td colspan="4" class="text-end"> Sub Total</td>
                    <td colspan="1">{{ 'Rp ' . number_format($totalAmount, 0, ',', '.') }}</td>
                </tr>
                <tr ><td colspan="4"></td><td colspan="1"></td></tr>
                <tr>
                    <td colspan="4" class="text-end"> PPN 11%</td>
                    <td colspan="1">{{ 'Rp ' . number_format($totalAmount*0.11, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end"> <b>Grand Total</b></td>
                    <td colspan="1"><b>{{ 'Rp ' . number_format((($totalAmount*0.11)+$totalAmount), 0, ',', '.') }}</b></td>
                </tr>
            </tbody>
        </table>

        <br>
        <p class="text-start">
            Terbilang : {{ ucwords(Terbilang::make(($totalAmount*0.11)+$totalAmount)) }}
        </p>
        <table>
            <thead>
                <tr>
                    <th class=" no-border" style="width: 25%">
                      <span> Pembayaran Ke :</span>
                    </th>
                    <th class="text-start company-data no-border" style="width: 75%">
                        <span>PT. NATUNA GLOBAL EKAPERSADA</span> <br>
                        <span>BANK CENTRAL ASIA KCU BUMI SERPONG DAMAI</span> <br>
                        <span>NO REK: 4977712121</span>
                    </th>
                </tr>
            </thead>
        </table>
        <p class="text-start">
            Hormat Kami, <br>
            PT. Natuna Global Ekapersada
            <br> <br>
            <img width="100px" src="{{ asset('adminAssets/img/QR Code.png') }}" alt="">
        </p>
</body>
</html>
