<?php

namespace App\Http\Controllers\Backend\Clinic;

use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackendPatientController extends Controller
{
    /**
     * @var \App\Repositories\UserRepository
     */
    protected $repository;

    public function __construct(PatientRepository $repository )
    {
        $this->middleware('can:patients-create', [ 'only' => [ 'create', 'store' ] ]);
        $this->middleware('can:patients-read',   [ 'only' => [ 'show', 'index' ] ]);
        $this->middleware('can:patients-update', [ 'only' => [ 'edit', 'update' ] ]);
        $this->middleware('can:patients-delete', [ 'only' => [ 'delete' ] ]);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $patients = $this->repository->where(function ($q) use ($request) {
            if ($request->id != null)
                $q->where('id', $request->id);
            if ($request->q != null)
                $q->where('name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('phone', 'LIKE', '%' . $request->q . '%')
                ->orWhere('email', 'LIKE', '%' . $request->q . '%');
        })->orderBy('id', 'DESC')->paginate();

        return view('admin.clinic.patients.index', compact('patients'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View 
     */
    public function create()
    {
        return view('admin.clinic.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePatientRequest $request)
    {

        $this->repository->create($request->all());

        return redirect()->route('admin.clinic.patients.index')->withSuccess(__('Action done successfully'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Patient $patient)
    {
        return view('admin.clinic.patients.edit', compact('patient'));
    }


    /* Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    */
   public function show(Patient $patient)
   {
       return view('admin.clinic.patients.view', compact('patient'));
   }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $this->repository->update($request->all(), $patient->id);

        return redirect()->route('admin.clinic.patients.index')->withSuccess(__('Action done successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $this->repository->delete($patient->id);

        return redirect()->route('admin.clinic.patients.index')
            ->withSuccess(__('Action done successfully'));
    }

    public function search(){

        $keyword = request('q');

        $patients = $this->repository->where(function ($q)use($keyword){
    
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('phone', 'LIKE', $keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $keyword . '%');
            })
            ->with('appointments')
            ->orderBy('id', 'DESC')
            ->get(['id' , 'name' , 'phone', 'dob', 'gendar']);

        return response()->json([
            "status"   => true,
            "patients" => $patients
        ]);
    }
}