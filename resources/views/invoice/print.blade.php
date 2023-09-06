<!DOCTYPE html>
<html>
<head>
    <title>Preview PDF</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap">
    <style>
        #invoice {
            padding: 0px;
            font-family: 'Poppins', sans-serif;
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
        }

        .invoice main {
            padding-bottom: 50px
        }

        .invoice table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .invoice .isi td,
        .invoice .isi th {
            padding-left: 15px;
            padding-right: 15px;
            border: 1.5px solid #ddd !important
        }

        .invoice .client td,
        .invoice .client th {
            padding-bottom: 10px;
        }

        .invoice table th {
            white-space: nowrap;
            font-weight: 400;
        }

        .invoice table td h3 {
            margin: 0;
            font-weight: 400;
        }

        .invoice table .qty,
        .invoice table .total,
        .invoice table .unit {
            text-align: right;
        }

        .invoice table .no {
            color: #fff;
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
            border-top: 1px solid #aaa
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

            .invoice>div:last-child {
                page-break-before: always
            }

            @page { margin: 0%; }

            .invoice table tfoot {
                display: table-row-group; /* Menampilkan tfoot hanya di halaman terakhir */
            }
            .invoice table tfoot td {
                border-bottom: none;
            }
            /* .invoice footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 1000;
            } */
            .invoice .isi tbody td {
                page-break-inside: avoid;
            }
/*
            .invoice .header {
                position: fixed;
                top: 10px;
            }

            .invoice .header th{
                padding-right: 40px;
            }

            .invoice .content {
                padding-top: 100px;
                padding-bottom: 50px;
            } */
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
            flex: 2;
            text-align: right;
            padding: 2px;
        }

        .invoice-value {
            flex: 2;
            text-align: left;
            padding-left: 5px;
        }

    </style>
    <script>window.print()</script>

</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div id="invoice">
                    <div class="invoice overflow-auto">
                        <div >
                            <table class="header">
                                <thead>
                                    <tr>
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
                                        <td colspan="4" class="no-border" ><hr></td>
                                    </tbody>
                            </table>
                            <div class="content">
                            {{-- <main> --}}
                                <table class="client">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 18px;font-weight: bold" colspan="5">
                                                INVOICE
                                            </th>
                                        </tr>
                                        <tr style="text-align: left">
                                            <th width="50%" colspan="2" >
                                                <span>Kepada Yth :</span> <br>
                                                <span></span> <br>
                                                <span>{{ $inv->nama_client }}</span> <br>
                                                <span>{{ $inv->nama_perusahaan }}</span> <br>
                                            </th>
                                            <th style="text-align: left;padding-left:50px" width="50%" colspan="2">
                                                <table>
                                                    <tr>
                                                      <th colspan="2" class="invoice-info">
                                                        <span class="invoice-label">Tanggal :</span>
                                                        <span class="invoice-value">{{ \Carbon\Carbon::parse($inv->tanggal)->format('d F Y', 'id') }}</span>
                                                      </th>
                                                    </tr>
                                                    <tr>
                                                      <th colspan="2" class="invoice-info">
                                                        <span class="invoice-label">No. Invoice :</span>
                                                        <span class="invoice-value">{{ $inv->no_inv }}</span>
                                                      </th>
                                                    </tr>
                                                    <tr>
                                                      <th colspan="2" class="invoice-info">
                                                        <span class="invoice-label">Jatuh Tempo :</span>
                                                        @php
                                                        $invoiceDate = \Carbon\Carbon::createFromFormat('Y-m-d', $inv->tanggal);
                                                        $newDate = $invoiceDate->addDays(14);

                                                        $formattedNewDate = $newDate->formatLocalized('%e %B %Y');
                                                    @endphp
                                                        <span class="invoice-value">{{ $formattedNewDate }}</span>
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
                                        @php
                                            $no = 1;
                                            $totalAmount = 0;
                                        @endphp
                                        @foreach ($invoice as $invoice_detail)
                                            <tr>
                                                <td style="text-align: center">{{ $no++ }}</td>
                                                <td class="text-left">{!! Parsedown::instance()->text($invoice_detail->keterangan) !!}</td>
                                                <td class="unit">{{ $invoice_detail->kuantitas }}</td>
                                                <td class="qty"> {{ number_format($invoice_detail->harga, 0, ',', '.') }}</td>
                                                <td class="total">{{ number_format(( $invoice_detail->kuantitas*$invoice_detail->harga), 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @php
                                            $totalAmount += $invoice_detail->kuantitas*$invoice_detail->harga;
                                        @endphp
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">SUBTOTAL</td>
                                            <td>{{ number_format($totalAmount, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">PPN 11%</td>
                                            <td>{{ number_format($totalAmount*0.11, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">GRAND TOTAL</td>
                                            <td>{{ number_format((($totalAmount*0.11)+$totalAmount), 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            <span class="subfoot">
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
                            </span>
                            {{-- </main> --}}
                            </div>
                            {{-- <footer>Corporate Office : Jl. Boulevard Eropa No. 10 Lippo Karawaci Panunggangan Barat, <br>
                                Cibodas,Tangerang Banten 15138
                                INDONESIA
                            </footer> --}}
                        </div>
                        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
