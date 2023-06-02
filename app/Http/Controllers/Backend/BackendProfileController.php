<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class BackendProfileController extends Controller
{

    /**
     * @var \App\Repositories\UserRepository
     */
    protected $repository;

    public function __construct(UserRepository $repository )
    {
        $this->middleware('can:profile-read', [ 'only' => [ 'show', 'index' ] ]);
        $this->middleware('can:profile-update', [ 'only' => [ 'edit', 'update', 'update_password', 'update_email' ] ]);
        
        $this->repository = $repository;
    }


    public function index(Request $request): Factory|View|Application
    {
        return view('admin.profile.index');
    }

    public function edit(Request $request): Factory|View|Application
    {
        return view('admin.profile.edit');
    }

    public function base64ToFile($file): UploadedFile
    {

        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file));

        // save it to temporary dir first.
        $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
        file_put_contents($tmpFilePath, $fileData);

        // this just to help us get file info.
        $tmpFile = new File($tmpFilePath);

        $file = new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,
            true // Mark it as test, since the file isn't from real HTTP POST.
        );

        return $file;
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        if (Hash::check($request->old_password, auth()->user()->password)) {
            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->back()->withSuccess(__('Action done successfully'));
        } else {
            return redirect()->back()->withErrors(__('You enterd wrong password'));
        }
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $this->repository->where('id', auth()->id())->firstOrFail();
        if ($request->avatar != null) {
            $avatar = $user->addMediaFromBase64($request->avatar)->toMediaCollection('avatar');
            
            $this->repository->update([ 'avatar' => $avatar->id . '/' . $avatar->file_name ] , $user->id);
        }

        $this->repository->update([
            'name' => $request->name,
            'bio'  => $request->bio
        ], $user->id);

        return redirect()->back()->withSuccess(__('Action done successfully'));
    }

    public function updateEmail(UpdateEmailRequest $request): RedirectResponse
    {
        auth()->user()->update([
            'email' => $request->email
        ]);
        return redirect()->back()->withSuccess(__('Action done successfully'));;
    }


}
