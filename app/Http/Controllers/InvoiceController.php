<?php

namespace App\Http\Controllers;

use App\Jobs\InvoiceEmailJob;
use App\Models\Client;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceEmail;


class InvoiceController extends Controller
{


/**
     * Function Index
     * Display invoices
     */


    public function index(Request $request)
    {

         // Get latest invoices
        $invoices = Invoice::with('client')->where('user_id',Auth::id())->latest();

        if(!empty($request->client_id)){

            $invoices = $invoices->where('client_id',$request->client_id);
        }

        if(!empty($request->status)){

            $invoices = $invoices->where('status',$request->status);
        }

        if(!empty($request->emailsent)){

            $invoices = $invoices->where('email_sent',$request->emailsent);
        }

        $invoices = $invoices->paginate(10);

        return view('invoice.index')->with([
            'clients' => Client::where('user_id',Auth::user()->id)->get(),
            'invoices' => $invoices,
        ]);

        // $invoices = $invoices->paginate(10);
    }
    /**
     * Funcation Create
     * @param request
     * Method Get
     * Search query
     *
     */
    public function create( Request $request)
    {


        $tasks = false;
        // If client id and status is not empty
        if(!empty($request->client_id) && !empty($request->status)){

            $request->validate([
                'client_id' => ['required','not_in:none'],
                'status' => ['required','not_in:none'],
            ]);
            $tasks = $this->getTasksForPreview($request);
        }

        // Return
        return view('invoice.create')->with([
            'clients' => Client::where('user_id',Auth::user()->id)->get(),
            'tasks' => $tasks
        ]);
    }

    /**
     * Function Update
     * @param Request, Invoice
     * Update invoice status to paid
     */


    public function update(Request $request,Invoice $invoice)
    {

        $invoice->update([
            'status'    => $invoice->status == 'unpaid' ?  'paid' : 'unpaid'
        ]);
        return redirect()->route('invoice.index')->with('success', 'Invoice Payment marked as paid!');

    }

     /**
     * Function Destroy
     * Delete invoice info
     */


    public function destroy(Invoice $invoice)
    {
        Storage::delete('public/invoices/'.$invoice->download_url);
        $invoice->delete();
        return redirect()->route('invoice.index')->with('success','Invoice Deleted');
    }
    /**
     * Function Get Invoice Data
     * return tasks
     */
    public function getTasksForPreview(Request $request)
    {
        $tasks = Task::latest();

        if( !empty($request->client_id) ){
            $tasks = $tasks->where('client_id', '=', $request->client_id);
        }

        if( !empty($request->status) ){
            $tasks = $tasks->where('status', '=', $request->status);
        }

        if( !empty($request->fromDate) ){
            $tasks = $tasks->whereDate('created_at', '>=', $request->fromDate);
        }
        if( !empty($request->endDate) ){
            $tasks = $tasks->whereDate('created_at', '<=', $request->endDate);
        }

        return $tasks->get();
    }


    public function invoice(Request $request)
    {
        if( !empty($request->generate) && $request->generate == 'yes' ){
            $this->generate($request);
            return redirect()->route('invoice.index')->with('success', 'Invocie Created');
        }
        if( !empty($request->preview) && $request->preview == 'yes' ){

           if( !empty($request->discount) && !empty($request->discount_type) ){
               $discount = $request->discount;
               $discount_type = $request->discount_type;
           }else{
                $discount = 0;
                $discount_type = '';
           }

            $tasks = Task::whereIn('id',$request->invoice_ids)->get();

            return view('invoice.preview')->with([
                'invoice_no'  => 'INVO_'.rand(23435252,235235326532),
                'user'  => Auth::user(),
                'tasks' => $tasks,
                'discount' => $discount,
                'discount_type' => $discount_type,
            ]);
        }
    }




    /**
     * Function Generate
     * PDF generation
     * Invoice Insert
     *
     */
        public function generate(Request $request){



            if( !empty($request->discount) && !empty($request->discount_type) ){
                $discount = $request->discount;
                $discount_type = $request->discount_type;
            }else{
                 $discount = 0;
                 $discount_type = '';
            }

            $tasks = Task::whereIn('id',$request->invoice_ids)->get();


            $invo_no = 'INVO_'.rand(234252,1351535);
           $data = [
            'invoice_no'  => $invo_no ,
            'user'  => Auth::user(),
            'tasks' => $tasks,
            'discount' => $discount,
            'discount_type' => $discount_type,
           ];
         // Generation PDF
           $pdf = PDF::loadview('invoice.pdf', $data);

         // Store PDF in Storage
        Storage::put('public/invoices/'.$invo_no.'.pdf', $pdf->output());
        //    Storage::put('public/invoices/',$invo_no.'.pdf', $pdf->output());

         // Insert Invoice data
         Invoice::create([
            'invoice_id'    => $invo_no,
            'client_id'     => $tasks->first()->client->id,
            'user_id'       => Auth::user()->id,
            'status'        => 'unpaid',
            'amount'        => $tasks->sum('price'),
            'download_url'  => $invo_no.'.pdf'
        ]);

        }


        //invoice sent function
        public function sendEmail(Invoice $invoice)
    {

      //  $pdf = Storage::get('public/invoices/'.$invoice->download_url);


        $data = [
            'user'          => Auth::user(),
            'invoice_id'    => $invoice->invoice_id,
            'invoice'       =>$invoice,
            'pdf'           => public_path('storage/invoices/'.$invoice->download_url),
        ];


       // Email initialize with Mailable and Queue
      // Mail::to($invoice->client)->send(new InvoiceEmail($data));//mailable when adding queue
      //dispatch(new InvoiceEmailJob($data));
      InvoiceEmailJob::dispatch($data);

        $invoice->update([
            'email_sent' => 'yes'
        ]);

        return redirect()->route('invoice.index')->with('success','Email sent');
    }


}




