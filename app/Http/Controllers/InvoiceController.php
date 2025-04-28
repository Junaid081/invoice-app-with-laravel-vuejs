<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function getInvoices(){

        $invoices = Invoice::with('customer')->orderBy('id', 'desc')->get();
        return response()->json([
            'invoices' => $invoices
        ], 200);

    }

    public function searchInvoice(Request $req){
        $value = $req->get('s');
        if($value != null){
            $invoices = Invoice::with('customer')->where('id','like', '%'.$value.'%')->get();
            return response()->json([
                'invoices' => $invoices
            ], 200);
        }else{
            return $this->getInvoices();
        }

        
    }
}
