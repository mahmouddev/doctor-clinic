<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class BackendRoleController extends Controller
{

    /**
     * @var \App\Repositories\RoleRepository
     */
    protected $repository;
    public function __construct(RoleRepository $repository)
    {
        $this->middleware('can:roles-create', ['only' => ['create', 'store']]);
        $this->middleware('can:roles-read', ['only' => ['show', 'index']]);
        $this->middleware('can:roles-update', ['only' => ['edit', 'update']]);
        $this->middleware('can:roles-delete', ['only' => ['delete']]);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $roles = $this->repository->where(function ($q) use ($request) {
            if ($request->id != null)
                $q->where('id', $request->id);
            if ($request->q != null)
                $q->where('name', 'LIKE', '%' . $request->q . '%')->orWhere('display_name', 'LIKE', '%' . $request->q . '%')->orWhere('description', 'LIKE', '%' . $request->q . '%');
        })->orderBy('id', 'DESC')->paginate();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CreateRoleRequest $request)
    {
        
        $role = $this->repository->create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);
        $role->syncPermissions($request->permissions);
    
        return redirect()->route('admin.roles.index')->withSuccess(__('Action done successfully'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(Request $request, Role $role)
    {
        $permissions = $role->permissions()->groupBy('table')->get();

        return view('admin.roles.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->repository->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ], $role->id);
        $role->syncPermissions($request->permissions);
        
        return redirect()->route('admin.roles.index')->withSuccess(__('Action done successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Role $role)
    {
        $this->repository->delete($role->id);

        return redirect()->route('admin.roles.index')->withSuccess(__('Action done successfully'));

    }
}