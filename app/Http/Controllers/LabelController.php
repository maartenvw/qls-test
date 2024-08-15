<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\PdfToImage\Pdf as PdfToImagePdf;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::withBasicAuth(env('QLS_API_USER'), env('QLS_API_USER_PASSWORD'))
            ->get('https://api.pakketdienstqls.nl/companies/'. env('QLS_COMPANY_ID').'/products');

        return Inertia::render('Dashboard', [
            'shipmentProducts' => $response->json()
        ]);
    }

    public function getShipmentProducts(Request $request)
    {
        $response = Http::withBasicAuth(env('QLS_API_USER'), env('QLS_API_USER_PASSWORD'))
            ->get('https://api.pakketdienstqls.nl/companies/'. env('QLS_COMPANY_ID').'/products');

        return $response->json();
    }

    /**
     * Generate a new shipment with the given request
     */
    public function generate(Request $request)
    {
        // Normaal gesproken zal deze uit de database gehaald worden
        $order = [
            'number' => '#958201',
            'billing_address' => [
               'companyname' => null,
               'name' => 'John Doe',
               'street' => 'Daltonstraat',
               'housenumber' => '65',
               'address_line_2' => '',
               'zipcode' => '3316GD',
               'city' => 'Dordrecht',
               'country' => 'NL',
               'email' => 'email@example.com',
               'phone' => '0101234567',
            ],
            'delivery_address' => [
               'companyname' => '',
               'name' => 'John Doe',
               'street' => 'Daltonstraat',
               'housenumber' => '65',
               'address_line_2' => '',
               'zipcode' => '3316GD',
               'city' => 'Dordrecht',
               'country' => 'NL',
            ],
            'order_lines' => [
               [
                  'amount_ordered' => 2,
                  'name' => 'Jeans - Black - 36',
                  'sku' => 69205,
                  'ean' =>  '8710552295268',
               ],
               [
                  'amount_ordered' => 1,
                  'name' => 'Sjaal - Rood Oranje',
                  'sku' => 25920,
                  'ean' =>  '3059943009097',
               ]
            ]
        ];

        // Hier gebruiken we de ingebouwd curl client van Laravel om in te loggen en de shipment aan te maken
        $response = Http::withBasicAuth(env('QLS_API_USER'), env('QLS_API_USER_PASSWORD'))
            ->post('https://api.pakketdienstqls.nl/company/'.env('QLS_COMPANY_ID').'/shipment/create',[
                'brand_id' => env('QLS_BRAND_ID'),
                'reference' => $order['number'],
                'weight' => 1000,
                'product_id' => isset($request->product['id']) ? $request->product['id'] : 2,
                'product_combination_id' => isset($request->productCombination['id']) ? $request->productCombination['id']: 3,
                'cod_amount' => 0,
                'piece_total' => 1,
                'receiver_contact' => [
                    'companyname' => $order['delivery_address']['companyname'],
                    'name' => $order['delivery_address']['name'],
                    'street' => $order['delivery_address']['street'],
                    'housenumber' => $order['delivery_address']['housenumber'],
                    'postalcode' => $order['delivery_address']['zipcode'],
                    'locality' => $order['delivery_address']['city'],
                    'country' => $order['delivery_address']['country'],
                    'email' => $order['billing_address']['email'],
                ]
            ])->throw()->json();
        if(isset($response['errors'])) {
            return $response['errors'];
        }

        // Hier wordt de pdf uitgelezen om deze lokaal op te slaan en te kunnen gebruiken
        $pdf = file_get_contents($response['data']['labels']['a6']);

        // Hier wordt met de Storage facade de pdf opgeslagen
        $pdfPath = '/package-slip-'. Str::replace('#', '', $order['number']) .'.pdf';
        Storage::disk('public')->put($pdfPath, $pdf);

        // Hier wordt de PDF gebruikt om er een afbeelding van te maken
        $image = new PdfToImagePdf(storage_path('/app/public'.$pdfPath));
        $imagePath = '/shipment-label-'. Str::replace('#', '', $order['number']) .'.jpg';
        $image->save(storage_path('/app/public/'.$imagePath));

        // Hier wordt via het snappy pakket een pdf gegenereerd op basis van de pdf/packing-slip.blade.php
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadView('pdf.packing-slip', [
            'order' => $order,
            'image' =>  asset('/storage/'.$imagePath)
        ]);

        // Hier wordt de PDF opgeslagen om in VUE opgehaald te kunnen worden en gedownload
        $pdfFileName = 'packing-slip-'. Str::replace('#', '', $order['number']) .'.pdf';
        Storage::disk('public')->put($pdfFileName, $pdf->download($pdfFileName));

        return [
            'file' => asset('/storage/'.$pdfFileName),
            'fileName' => $pdfFileName
        ];
    }

}
