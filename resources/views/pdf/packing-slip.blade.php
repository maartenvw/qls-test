<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        {{-- <link rel="preconnect" href="https://fonts.bunny.net"> --}}
        {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
        {{-- <link href="{{ 'file://'.resource_path('css/tailwind.css') }}" rel="stylesheet" /> --}}
        {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
        <style>
            :host, html {
                line-height: 1.5;
                -webkit-text-size-adjust: 100%;
                -moz-tab-size: 4;
                tab-size: 4;
                font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-feature-settings: normal;
                font-variation-settings: normal;
                -webkit-tap-highlight-color: transparent;
            }
            *, ::after, ::before {
                box-sizing: border-box;
                border-width: 0;
                border-style: solid;
                border-color: #e5e7eb;
            }
            body {
                margin: 0;
                line-height: inherit;
            }
            ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            table {
                text-indent: 0;
                border-color: inherit;
                border-collapse: collapse;
            }
            thead {
                display: table-header-group;
                vertical-align: middle;
                unicode-bidi: isolate;
                border-color: inherit;
            }
            th {
                display: table-cell;
                vertical-align: inherit;
                font-weight: bold;
                text-align: -internal-center;
                unicode-bidi: isolate;
            }
            tbody {
                display: table-row-group;
                vertical-align: middle;
                unicode-bidi: isolate;
                border-color: inherit;
            }
            td {
                display: table-cell;
                vertical-align: inherit;
                unicode-bidi: isolate;
            }
            .flex {
                display: flex;
            }
            .p-4 {
                padding: 1rem;
            }
            .leading-7 {
                line-height: 1.75rem;
            }
            .font-bold {
                font-weight: 700;
            }
            .text-3xl {
                font-size: 1.875rem;
                line-height: 2.25rem;
            }
            .grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .grid {
                display: grid;
            }
            .justify-end {
                justify-content: flex-end;
            }
            .mt-4 {
                margin-top: 1rem;
            }
            .mb-4 {
                margin-bottom: 1rem;
            }
            .table-auto {
                table-layout: auto;
            }
            .border {
                border-width: 1px;
            }
            .float {
                float: none;
            }
        </style>
    </head>
    <body class="p-4">
        <div>
            <div>
                <h2 class="text-3xl font-bold leading-7">Pakbon</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <ul>
                            <li>{{ $order['billing_address']['name'] }}</li>
                            <li>{{ $order['billing_address']['street'] }} {{ $order['billing_address']['housenumber'] }}</li>
                            <li>{{ $order['billing_address']['zipcode'] }} {{ $order['billing_address']['city'] }}</li>
                            <li></li>
                            <li>{{ $order['billing_address']['email'] }}</li>
                            <li>{{ $order['billing_address']['phone'] }}</li>
                        </ul>
                    </div>
                    <div class="flex justify-end">
                        <ul>
                            <li class="font-bold">QLS</li>
                            <li>Kerkeplaats 11</li>
                            <li>3313LC Dordrecht</li>
                            <li></li>
                            <li>info@qls.nl</li>
                            <li>078-6475590</li>
                        </ul>
                    </div>
                    <div class="float"></div>
                </div>
                <ul class="mt-4">
                    <li>
                        Bestelnummer: {{ $order['number'] }}
                    </li>
                    <li>
                        Besteldatum: {{ now()->format('d-m-Y') }}
                    </li>
                </ul>
                <table class="mt-4 mb-4 table-auto" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="border">Aantal</th>
                            <th class="border">Omschrijving</th>
                            <th class="border">SKU</th>
                            <th class="border">EAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order['order_lines'] as $line)
                            <tr>
                                <td class="border">{{ $line['amount_ordered'] }}</td>
                                <td class="border">{{ $line['name'] }}</td>
                                <td class="border">{{ $line['sku'] }}</td>
                                <td class="border">{{ $line['ean'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <img src="{{ $image }}" alt="Package Label" width="400" height="500">
    </body>
</html>
