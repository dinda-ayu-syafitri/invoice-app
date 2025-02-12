<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceController extends Controller
{
    public function get_all_invoices()
    {
        $invoices = Invoice::with('customer')->orderBy('id', 'DESC')->get();
        return response()->json([
            'invoices' => $invoices 
        ], 200);
    }

    public function search_invoice(Request $request)
    {
      $search = $request->get('s');
      if($search != null){
        $invoices = Invoice::with('customer')
        ->where('id', 'LIKE', "%$search%")
        ->get();

        return response()->json([
            'invoices' => $invoices 
        ], 200);
        } else {
        return $this->get_all_invoices();
        }
    }

    public function create_invoice(Request $request)
    {
       $counter = Counter::where('key', 'invoice')->first();
       $random = Counter::where('key', 'invoice')->first();

       $invoice = Invoice::orderBy('id', 'DESC')->first();
       if ($invoice) {
        $invoice = $invoice->id + 1;
        $counters = $counter->value + $invoice;
       } else {
        $counters = $counter->value ;
       }

       $formData = [
        'number' => $counter->prefix.$counters,
        'customer_id' => null,
        'customer' => null,
        'due_date' => date('Y-m-d'),
        'reference' => null,
        'discount' => 0,
        'terms_and_conditions' => "Default terms and conditions",
        'items' => [
            [
                'product_id' => null,
                'product' => null,
                'unit_price' => 0,
                'quantity' => 1,
            ]
        ]
       ];

       return response()->json($formData);
    }

    public function add_invoice(Request $request) {
        $invoiceItem = $request->input('invoice_item');

        $invoiceData['sub_total'] = $request->input('sub_total');
        $invoiceData['total'] = $request->input('total');
        $invoiceData['customer_id'] = $request->input('customer_id');
        $invoiceData['number'] = $request->input('number');
        $invoiceData['date'] = $request->input('date');
        $invoiceData['due_date'] = $request->input('due_date');
        $invoiceData['discount'] = $request->input('discount');
        $invoiceData['reference'] = $request->input('reference');
        $invoiceData['terms_and_conditions'] = $request->input('terms_and_conditions');
       
        $invoice = Invoice::create($invoiceData);

        foreach (json_decode($invoiceItem) as $item) {
           $itemData = [
            'invoice_id' => $invoice->id,
            'product_id' => $item->product_id,
            'unit_price' => $item->unit_price,
            'quantity' => $item->quantity,
           ]; 

           InvoiceItem::create($itemData);
        }
    }
    
    public function delete_invoice($id) {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
    
        return response()->json(['message' => 'Invoice deleted successfully']);
    }
    
}
