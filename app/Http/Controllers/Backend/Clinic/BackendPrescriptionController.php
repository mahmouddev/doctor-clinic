<?php

namespace App\Http\Controllers\Backend\Clinic;

use App\Models\Prescription;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
use App\Repositories\PrescriptionRepository;
use App\Http\Requests\CreatePrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;

class BackendPrescriptionController extends Controller
{
    /**
     * @var PrescriptionRepository
     */
    protected $repository;

    /**
     * @var PatientRepository
     */
    protected $patientRepository;

    public function __construct(
        PrescriptionRepository $repository, 
        PatientRepository $patientRepository 
    ){
        $this->middleware('can:prescriptions-create', [ 'only' => [ 'create', 'store' ] ]);
        $this->middleware('can:prescriptions-read',   [ 'only' => [ 'show', 'index' ] ]);
        $this->middleware('can:prescriptions-update', [ 'only' => [ 'edit', 'update' ] ]);
        $this->middleware('can:prescriptions-delete', [ 'only' => [ 'delete' ] ]);

        $this->repository = $repository;
        $this->patientRepository = $patientRepository;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $prescriptions = $this->repository->where(function ($q) use ($request) {
            if ($request->id != null)
                $q->where('id', $request->id);
            if ($request->q != null)
                $q->where('name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('phone', 'LIKE', '%' . $request->q . '%')
                ->orWhere('email', 'LIKE', '%' . $request->q . '%');
        })->orderBy('id', 'DESC')->paginate();

        return view('admin.clinic.prescriptions.index', compact('prescriptions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View 
     */
    public function create()
    {
        return view('admin.clinic.prescriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePrescriptionRequest $request)
    {
        $data = $request->all();

        if(! $data['patient_id']){
            $patientData = $this->patientRepository->create($request->all());
            $data['patient_id'] = $patientData->id;

        }

        $this->repository->create($data);

        return redirect()->route('admin.clinic.prescriptions.index')
        ->withSuccess(__('Action done successfully'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Prescription $prescription)
    {
        return view('admin.clinic.prescriptions.edit', compact('prescription'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        $this->repository->update($request->all(), $prescription->id);

        return redirect()->route('admin.clinic.prescriptions.index')->withSuccess(__('Action done successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prescription $prescription)
    {
        $this->repository->delete($prescription->id);

        return redirect()->route('admin.clinic.prescriptions.index')
            ->withSuccess(__('Action done successfully'));
    }


    public function view($prescriptionId)
    {
        $prescription = $this->repository->find($prescriptionId);
        return view('admin.clinic.prescriptions.view' , compact('prescription'));
    }

}
