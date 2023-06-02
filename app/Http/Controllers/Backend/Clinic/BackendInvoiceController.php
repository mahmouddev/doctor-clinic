<?php

namespace App\Http\Controllers\Backend\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Appointment;
use App\Repositories\InvoiceRepository;
use Exception;
use Illuminate\Http\Request;

class BackendInvoiceController extends Controller
{
    /**
     * @var \App\Repositories\InvoiceRepository
     */
    protected $repository;


    public function __construct(
        InvoiceRepository $repository
    ) {
        $this->middleware('can:invoices-create', [ 'only' => [ 'create', 'store' ] ]);
        $this->middleware('can:invoices-read',   [ 'only' => [ 'show', 'index' ] ]);
        $this->middleware('can:invoices-update', [ 'only' => [ 'edit', 'update' ] ]);
        $this->middleware('can:invoices-delete', [ 'only' => [ 'delete' ] ]);


        $this->repository = $repository;
    }

    /**
     * Display a listing of the invoice.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $invoices = $this->repository->where(function ($q) use ($request) {
            if ($request->id != null)
                $q->where('id', $request->id);
            if ($request->q != null)
                $q->where('name', 'LIKE', '%' . $request->q . '%');
        })->orderBy('id', 'DESC')
            ->paginate();
        return view('admin.clinic.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.clinic.invoices.create');
    }

    public function view($invoiceId)
    {
        $invoice = $this->repository->find($invoiceId);

        return view('admin.clinic.invoices.view' , compact('invoice'));
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateInvoiceRequest $request)
    {

        try {
            $this->repository->create([
                'appointment_id' => $request->appointment_id,
                'patient_id' => $request->patient_id,
                'total_price' => $request->total,
                'total_recieved' => $request->total_recieved,
                'change' => $request->change,
                'status' => 'paied',
            ]);
        } catch (Exception $e) {

            dd($e->getMessage());
            return response()->json([
                'status' => false,
                'redirect' => '',
            ]);
        }

        return response()->json([
            'status' => true,
            'redirect' => route('admin.clinic.invoices.index'),
        ]);
    }


    /**
     * Show the form for editing the specified invoice.
     *
     * @param  Request  $request
     * @param  int      $invoiceId
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Request $request, $invoiceId)
    {
        return view('admin.clinic.invoices.edit', compact('invoice'));
    }

    /**
     * Update the specified invoice in storage.
     *
     * @param  Request  $request
     * @param  int      $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateInvoiceRequest $request, $invoiceId)
    {

        try {
            $this->repository->update([
                'total_recieved' => $request->total_recieved,
                'change' => $request->change,
                'status' => 'paied',
            ], $invoiceId);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'redirect' => '',
            ]);
        }

        return response()->json([
            'status' => true,
            'redirect' => route('admin.clinic.invoices.index'),
        ]);
    }

    /**
     * Remove the specified invoice from storage.
     *
     * @param  int  $invoiceId
     * @return \Illuminate\Http\Response
     */
    public function destroy($invoiceId)
    {
        $this->repository->delete($invoiceId);

        return redirect()->route('admin.clinic.invoices.index')->withSuccess(__('Action done successfully'));
    }
}