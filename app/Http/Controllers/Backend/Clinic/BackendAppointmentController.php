<?php

namespace App\Http\Controllers\Backend\Clinic;

use App\Models\Appointment;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
use App\Repositories\AppointmentRepository;
use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;

class BackendAppointmentController extends Controller
{
    /**
     * @var AppointmentRepository
     */
    protected $repository;

    /**
     * @var PatientRepository
     */
    protected $patientRepository;

    public function __construct(
        AppointmentRepository $repository, 
        PatientRepository $patientRepository 
    ){
        $this->middleware('can:appointments-create', [ 'only' => [ 'create', 'store' ] ]);
        $this->middleware('can:appointments-read',   [ 'only' => [ 'show', 'index' ] ]);
        $this->middleware('can:appointments-update', [ 'only' => [ 'edit', 'update' ] ]);
        $this->middleware('can:appointments-delete', [ 'only' => [ 'delete' ] ]);

        $this->repository = $repository;
        $this->patientRepository = $patientRepository;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $appointments = $this->repository->where(function ($q) use ($request) {
            if ($request->id != null)
                $q->where('id', $request->id);
            if ($request->q != null)
                $q->where('name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('phone', 'LIKE', '%' . $request->q . '%')
                ->orWhere('email', 'LIKE', '%' . $request->q . '%');
        })->orderBy('id', 'DESC')->paginate();

        $todayAppointments = $this->repository->whereDate('dov', today())
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.clinic.appointments.index', compact('appointments' , 'todayAppointments'));

    }


    /**
     * Display a listing of the resource.
     *
     */
    public function todayAppointments(Request $request)
    {
        $todayAppointments = $this->repository->whereDate('dov', today())
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.clinic.appointments.today-appointments', compact('todayAppointments'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View 
     */
    public function create()
    {
        return view('admin.clinic.appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAppointmentRequest $request)
    {
        $data = $request->all();

        if(! $data['patient_id']){
            $patientData = $this->patientRepository->create($request->all());
            $data['patient_id'] = $patientData->id;

        }

        

        $this->repository->create($data);

        return redirect()->route('admin.clinic.appointments.index')
        ->withSuccess(__('Action done successfully'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Appointment $appointment)
    {
        return view('admin.clinic.appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $this->repository->update($request->all(), $appointment->id);

        return redirect()->route('admin.clinic.appointments.index')->withSuccess(__('Action done successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $this->repository->delete($appointment->id);

        $redirect = request('redirect') ?: route('admin.clinic.appointments.index');

        return redirect($redirect)->withSuccess(__('Action done successfully'));
    }
}
