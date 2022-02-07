<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoice.index')->with([
            'invoices' => Invoice::with('client')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('invoice.create')->with([
            'clients' => Client::where('user_id',Auth::user()->id)->get(),
            'tasks' => false
        ]);
    }


    public function edit()
    {

    }
    public function update(Request $request,Invoice $invoice)
    {

    }
    public function store(Request $request)
    {

    }
    public function show(Invoice $invoice)
    {

    }
    public function destroy(Invoice $invoice)
    {

    }
}

