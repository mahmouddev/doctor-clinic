<?php

namespace App\Repositories;

use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Symfony\Component\Console\Output\BufferedOutput;
use Throwable;
use Prettus\Repository\Eloquent\BaseRepository;

class InstallerRepositoryEloquent extends BaseRepository implements InstallerRepository
{
    protected $results = [];

    protected $envPath;
    protected $_minPhpVersion;

    protected $envExamplePath;

    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Specify Model class name
     *
     * @return void
     */
    public function model()
    {

    }

    public function checkPHPversion(string $minPhpVersion = null)
    {

        $minVersionPhp = $minPhpVersion;
        $currentPhpVersion = $this->getPhpVersionInfo();
        $supported = false;

        if ($minPhpVersion == null) {
            $minVersionPhp = $this->getMinPhpVersion();
        }
        if (version_compare($currentPhpVersion['version'], $minVersionPhp) >= 0) {
            $supported = true;
        }

        $phpStatus = [
            'full'      => $currentPhpVersion['full'],
            'current'   => $currentPhpVersion['version'],
            'minimum'   => $minVersionPhp,
            'supported' => $supported,
        ];

        return $phpStatus;
    }

    private function getPhpVersionInfo()
    {
        $currentVersionFull = PHP_VERSION;
        preg_match("#^\d+(\.\d+)*#", $currentVersionFull, $filtered);
        $currentVersion = $filtered[0];

        return [
            'full'    => $currentVersionFull,
            'version' => $currentVersion,
        ];
    }

    protected function getMinPhpVersion()
    {
        return $this->_minPhpVersion;
    }

    public function check(array $requirements)
    {
        $results = [];

        foreach ($requirements as $type => $requirement) {
            switch ($type) {
                // check php requirements
                case 'php':
                    foreach ($requirements[$type] as $requirement) {
                        $results['requirements'][$type][$requirement] = true;

                        if (!extension_loaded($requirement)) {
                            $results['requirements'][$type][$requirement] = false;

                            $results['errors'] = true;
                        }
                    }
                    break;
                // check apache requirements
                case 'apache':
                    foreach ($requirements[$type] as $requirement) {
                        // if function doesn't exist we can't check apache modules
                        if (function_exists('apache_get_modules')) {
                            $results['requirements'][$type][$requirement] = true;

                            if (!in_array($requirement, apache_get_modules())) {
                                $results['requirements'][$type][$requirement] = false;

                                $results['errors'] = true;
                            }
                        }
                    }
                    break;
            }
        }

        return $results;
    }

    public function checkPermission(array $folders)
    {
        foreach ($folders as $folder => $permission) {
            if (!($this->getPermission($folder) >= $permission)) {
                $this->addFileAndSetErrors($folder, $permission, false);
            } else {
                $this->addFile($folder, $permission, true);
            }
        }

        return $this->results;
    }

    private function getPermission($folder)
    {
        return substr(sprintf('%o', fileperms(base_path($folder))), -4);
    }

    /**
     * Add the file to the list of results.
     *
     * @param $folder
     * @param $permission
     * @param $isSet
     */
    private function addFile($folder, $permission, $isSet)
    {
        if (!isset($this->results['permissions']))
            $this->results['permissions'] = [];
        array_push($this->results['permissions'], [
            'folder'     => $folder,
            'permission' => $permission,
            'isSet'      => $isSet,
        ]);
    }

    /**
     * Add the file and set the errors.
     *
     * @param $folder
     * @param $permission
     * @param $isSet
     */
    private function addFileAndSetErrors($folder, $permission, $isSet)
    {
        $this->addFile($folder, $permission, $isSet);

        $this->results['errors'] = true;
    }

    public function getEnvContent()
    {
        if (!file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    public function saveFileWizard($request, $app_url)
    {
        $results = true;
        $message = 'Your .env file settings have been saved.';

        $envFileData =
            'APP_NAME=\'' . $request['app_name'] . "'\n" .
            'APP_ENV=local' . "\n" .
            'APP_KEY=' . 'base64:' . base64_encode(Str::random(32)) . "\n" .
            'APP_DEBUG=false' . "\n" .
            'APP_LOG_LEVEL=debug' . "\n" .
            'APP_URL=' . $app_url . "\n\n" .
            'DB_CONNECTION=' . $request['database_connection'] . "\n" .
            'DB_HOST=' . $request['database_hostname'] . "\n" .
            'DB_PORT=' . $request['database_port'] . "\n" .
            'DB_DATABASE=' . $request['database_name'] . "\n" .
            'DB_USERNAME=' . $request['database_username'] . "\n" .
            'DB_PASSWORD=' . $request['database_password'] . "\n\n" .
            'DEFAULT_IMAGE="'.$app_url .'/images/default/image.jpg"' . "\n" .
            'DEFAULT_IMAGE_FAVICON="'.$app_url .'/images/default/favicon.png"'  . "\n" .
            'DEFAULT_IMAGE_AVATAR="'.$app_url .'/images/default/avatar.png"'  . "\n" .
            'DEFAULT_IMAGE_LOGO="'.$app_url .'/images/default/logo.png"'  . "\n" .
            'DEFAULT_IMAGE_WIDELOGO="'.$app_url .'/images/default/wide-logo.png"'  . "\n" .
            'DEFAULT_IMAGE_COVER="'.$app_url .'/images/default/cover.png"'  . "\n" .
            'DEFAULT_IMAGE_NOTIFICATION="'.$app_url .'/images/default/notification.png"' . "\n\n";
            

        try {
            file_put_contents($this->envPath, $envFileData);
            $database = config('database.connections.' . $request['database_connection']);

            $database["host"]     = $request['database_hostname'];
            $database["port"]     = $request['database_port'];
            $database["database"] = $request['database_name'];
            $database["username"] = $request['database_username'];
            $database["password"] = $request['database_password'];

            config(['database.connections.' . $request['database_connection'] => $database]);
        } catch (Exception $e) {
            $results = false;
            $message = 'Unable to save the .env file, Please create it manually.';
        }
        return [
            'results' => $results, 
            'message' => $message
        ];
    }

    public function migrateAndSeed()
    {
        $outputLog = new BufferedOutput();

        return $this->migrate($outputLog);
    }

    private function migrate(BufferedOutput $outputLog)
    {
        try {
            Artisan::call('optimize:clear');
            Artisan::call('optimize');
            Artisan::call('migrate:fresh', ['--force' => true], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->seed($outputLog);
    }

    private function seed(BufferedOutput $outputLog)
    {
        try {
            Artisan::call('db:seed', ['--force' => true], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response('Successfully Completed', 'success', $outputLog);
    }

    private function response($message, $status, BufferedOutput $outputLog)
    {
        return [
            'status' => $status,
            'message' => $message,
            'dbOutputLog' => $outputLog->fetch(),
        ];
    }

    public function finish($same_directory, $customer_details, $timezone)
    {
        $finalMessages = $this->runFinal($same_directory);
        $this->setTimezone($timezone);
        $this->updateInstalledStatus();
        $finalStatusMessage = $this->createdInfo();
        $finalEnvFile = $this->getEnvContent();

        return [
            'finalMessages' => $finalMessages, 
            'finalStatusMessage' => $finalStatusMessage, 
            'finalEnvFile' => $finalEnvFile
        ];
    }

    public function runFinal($same_directory)
    {
        $outputLog = new BufferedOutput;

        $this->generateKey($outputLog);
        $this->linkStorage($outputLog);
        if (!$same_directory){
            $this->clearRoute($outputLog);
        }

        $this->clearConfig();
        return $outputLog->fetch();
    }
    private function generateKey(BufferedOutput $outputLog)
    {
        try {
           
            Artisan::call('key:generate', ['--force' => true], $outputLog);
            
        } catch (Exception $e) {
            return static::response('error', $e->getMessage(), $outputLog);
        }

        return $outputLog;
    }

    private function linkStorage(BufferedOutput $outputLog)
    {
        try {
            Artisan::call('storage:link');
        } catch (Exception $e) {
            return null;
        }

        return $outputLog;
    }

    private function updateInstalledStatus()
    {
        try {
            Setting::updateOrCreate(
                ['key' =>  'installed'],
                ['value' => 1]
            );
        } catch (Throwable $th) {
            return null;
        }
        return true;
    }

    private function setTimezone($timezone)
    {
        try {
            Setting::updateOrCreate(
                ['key' =>  'timezone'],
                ['value' => $timezone]
            );
        } catch (Throwable $th) {
            return null;
        }
        return true;
    }

    private function clearRoute(BufferedOutput $outputLog)
    {
        try {
            Artisan::call('route:clear');
        } catch (Exception $e) {
            return null;
        }


        try {
            Artisan::call('config:clear');
        } catch (Exception $e) {
            return null;
        }

        return $outputLog;
    }

    private function clearConfig()
    {
    
        try {
            Artisan::call('config:clear');
        } catch (Exception $e) {
            return null;
        }

        return true;
    }

    public function createdInfo()
    {
        return 'Doctor clinic successfully INSTALLED on' . date('Y/m/d h:i:sa') . "\n";
    }
}