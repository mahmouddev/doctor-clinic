<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BackendUserController extends Controller
{

    /**
     * @var \App\Repositories\UserRepository
     */
    protected $repository;

      /**
     * @var \App\Repositories\RoleRepository
     */
    protected $roleRepository;

    public function __construct(UserRepository $repository , RoleRepository $roleRepository)
    {
        $this->middleware('can:users-create', [ 'only' => [ 'create', 'store' ] ]);
        $this->middleware('can:users-read',   [ 'only' => [ 'show', 'index' ] ]);
        $this->middleware('can:users-update', [ 'only' => [ 'edit', 'update' ] ]);
        $this->middleware('can:users-delete', [ 'only' => [ 'delete' ] ]);

        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request)
    {

        $users = $this->repository->where(function ($q) use ($request) {
            if ($request->id != null)
                $q->where('id', $request->id);
            if ($request->q != null)
                $q->where('name', 'LIKE', '%' . $request->q . '%')->orWhere('phone', 'LIKE', '%' . $request->q . '%')->orWhere('email', 'LIKE', '%' . $request->q . '%');
        })->orderBy('id', 'DESC')->paginate();

        return view('admin.users.index', compact('users'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        
        $user = $this->repository->create([
            "name"     => $request->name,
            "phone"    => $request->phone,
            "bio"      => $request->bio,
            "blocked"  => $request->blocked,
            "email"    => $request->email,
            "password" => Hash::make($request->password),
        ]);
        //if (auth()->user()->can('user-roles-update')) {
            $request->validate([
                'roles'   => "required|array",
                'roles.*' => "required|exists:roles,id",
            ]);
            $user->syncRoles($request->roles);
        //}

        if ($request->hasFile('avatar')) {
            $avatar = $user->addMedia($request->avatar)->toMediaCollection('avatar');
            $this->repository->update([ 'avatar' => $avatar->id . '/' . $avatar->file_name ], $user->id);
        }

        return redirect()->route('admin.users.index')->withSuccess(__('Action done successfully'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $roles = $this->roleRepository->all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {       
        $this->repository->update([
            "name"    => $request->name,
            "phone"   => $request->phone,
            "bio"     => $request->bio,
            "blocked" => $request->blocked,
            "email"   => $request->email,

        ], $user->id);
        //if (auth()->user()->can('user-roles-update')) {
            $request->validate([
                'roles'   => "required|array",
                'roles.*' => "required|exists:roles,id",
            ]);
            $user->syncRoles($request->roles);
        //}

        if ($request->password != null) {
            $this->repository->update([
                "password" => Hash::make($request->password)
            ], $user->id);
        }
        if ($request->hasFile('avatar')) {

            $avatar = $user->addMedia($request->avatar)->toMediaCollection('avatar');

            $this->repository->update([ 'avatar' => $avatar->id . '/' . $avatar->file_name ], $user->id);
        }

        return redirect()->route('admin.users.index')->withSuccess(__('Action done successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $roles = $this->roleRepository->all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->can('users-delete')) abort(403);

        $this->repository->delete($user->id);

        return redirect()->route('admin.users.index')->withSuccess(__('Action done successfully'));
    }
}
