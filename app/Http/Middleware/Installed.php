<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Http\Response;

class Installed
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            DB::connection()->getPdo();
            if (
                Setting::where('key', 'installed')->first()
                && Setting::where('key', 'installed')->first()->value == 0
            ) {

                return redirect()->route('install');

            } else if (
                Setting::where('key', 'installed')->first()
                && Setting::where('key', 'installed')->first()->value == 1
            ) {


            } else {

                abort(500);
            }
        } catch (Throwable $th) {

            if (file_exists(base_path('/app/Http/Controllers/InstallerController.php')) 
            && file_exists(base_path('/app/Repositories/InstallerRepository.php')) 
            && file_exists(base_path('/config/installer.php'))) {

                return redirect()->route('install');
                
            }else{ 

                abort(500);

            }
        }
        return $next($request);
    }
}