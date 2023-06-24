<?php

namespace App\Http\Controllers;

use App\Repositories\InstallerRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
class InstallerController extends Controller
{
    protected $installer;
    public function __construct(InstallerRepository $installer)
    {
        $this->installer = $installer;
    }

    public function index(Request $request)
    {
        $sub_directory = !($request->getSchemeAndHttpHost() . '/' . $request->route()->uri == $request->url());
        
        return view('vendor.installer.installer', [
            'sub_directory' => $sub_directory, 
            'timezones'     => json_encode(timezone_identifiers_list()), 
            'host'          => str_replace("install", "", $request->url())
        ]);
    }

    public function serverComponents()
    {
        $phpSupportInfo = $this->installer->checkPHPversion(
            config('installer.core.minPhpVersion')
        );
        $serverComponents = $this->installer->check(
            config('installer.server_components')
        );
        $html = view('vendor.installer.server-components', compact('serverComponents', 'phpSupportInfo'))->render();
        $status = false;
        if (!isset($requirements['errors']) && $phpSupportInfo['supported']) {
            $status = true;
        }
        return response()->json(['html' => $html, 'status' => $status]);
    }


    public function directoryPermissions()
    {
        $directoriesPermissions = $this->installer->checkPermission(
            config('installer.directories_permissions')
        );
        $html = view('vendor.installer.directories-permissions', compact('directoriesPermissions'))->render();
        $status = false;
        if (!isset($permissions['errors']))
            $status = true;
        return response()->json(['html' => $html, 'status' => $status]);
    }

    public function environment()
    {
        $envConfig = $this->installer->getEnvContent();

        return view('vendor.installer.environment', compact('envConfig'));
    }

    public function completeInstallation(Request $request)
    {
        $data = $request->all();
        $rules = config('installer.environment.form.rules');
        try {
            $request->validate($rules);
            $app_url = str_replace("environment/save", "", url('/'));
            $res = $this->installer->saveFileWizard($request->all(), $app_url);
            $data['customer_details']['host'] = $app_url;
            $same_directory = false;
            if ($request->getSchemeAndHttpHost() . '/' . $request->route()->uri == $request->url())
                $same_directory = true;
            if ($res['results']) {
                $outputLog = $this->installer->migrateAndSeed();
                if ($outputLog['message'] == 'error')
                    return response()->json(['status_code' => 500, 'errors' => $outputLog['status']]);
                $final = $this->installer->finish($same_directory, $data['customer_details'], $data['app_timezone']);
            } else
                return response()->json(['status_code' => 500, 'errors' => $res['message']]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            if ($e instanceof ValidationException) {
                $errors = $e->errors();
               
                return response()->json(['status_code' => 422, 'errors' => $errors,]);
            }
            return response()->json(['status_code' => 500, 'errors' => 'something went wrong']);
        }

        return response()->json(['status_code' => 200, 'dbOutputLog' => $outputLog['dbOutputLog'], 'final' => $final]);
    }

    public function checkDbConnection(Request $request)
    {
        try {
            $request->validate([
                'database_connection' => 'required',
                'database_hostname'   => 'required',
                'database_port'       => 'required',
                'database_name'       => 'required',
                'database_user_name'  => 'required',
                'database_password'   => 'nullable'
            ]);

            $database = config('database.connections.' . $request->database_connection);

            $database["host"]     = $request->database_hostname;
            $database["port"]     = $request->database_port;
            $database["database"] = $request->database_name;
            $database["username"] = $request->database_user_name;
            $database["password"] = $request->database_password;

            config(['database.connections.test_connection' => $database]);

            DB::connection('test_connection')->getPdo();
        } catch (Exception $e) {
            if ($e instanceof ValidationException) {
                $errors = $e->errors();
                return response()->json(['status_code' => 422, 'errors' => $errors, 'message' => 'something went wrong']);
            }
            return response()->json(['status_code' => 500, 'errors' => null, 'message' => 'connection does not exists']);
        }
        return response()->json(['status_code' => 200, 'data' => null, 'message' => 'success']);
    }

}