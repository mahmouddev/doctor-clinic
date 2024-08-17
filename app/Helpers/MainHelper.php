<?php
namespace App\Helpers;
use Illuminate\Support\Carbon;

class MainHelper {
    protected static $generated = array();
    
    public static function recaptcha($cap){
        
         $ipAddress = 'NA';
        if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])){ 
            $ipAddress = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else{ 
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        } 

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        //$remoteip = $_SERVER['REMOTE_ADDR'];
        $data = [
                'secret' => env("RECAPTCHA_SECRET_KEY"),
                'response' => $cap,
                'remoteip' => $ipAddress
              ];
        $options = [
                'http' => [
                  'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                  'method' => 'POST',
                  'content' => http_build_query($data)
                ]
            ];
        $context = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                $resultJson = json_decode($result);

        if ($resultJson->success != true) {
            return 0; 
        }else{
         return json_decode(json_encode($resultJson),true)['score']; 
        } 

    }

    public static function get_conversion($file_name,$conversion="original",$new_extension="webp"){
        if($new_extension=="main" || $conversion ==null)
            $new_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $explode = explode("/",$file_name);
        if(isset($explode[0]) && isset($explode[1]) && $conversion!=null){
            $new_file_name =pathinfo($file_name, PATHINFO_FILENAME).'-'.$conversion.'.'.$new_extension;
            return $explode[0] .'/'."conversions".'/'.$new_file_name;
        }
        return $file_name;
    }

    /**
     * @param $locale
     */
    public static function setAllLocale($locale)
    {
        static::setAppLocale($locale);
        static::setPHPLocale($locale);
        static::setCarbonLocale($locale);
        static::setLocaleReadingDirection($locale);
    }

    /**
     * @param $locale
     */
    public static  function setAppLocale($locale)
    {
        app()->setLocale($locale);
    }

    /**
     * @param $locale
     */
    public static function setPHPLocale($locale)
    {
        setlocale(LC_TIME, $locale);
    }

    /**
     * @param $locale
     */
    public static function setCarbonLocale($locale)
    {
        Carbon::setLocale($locale);
    }

    /**
     * @param $locale
     */
    public static function setLocaleReadingDirection($locale)
    {
        /*
         * Set the session variable for whether or not the app is using RTL support
         * For use in the blade directive in BladeServiceProvider
         */
        if (! app()->runningInConsole()) {
            if (config('core.locale.languages')[$locale]['rtl']) {
                session(['lang-rtl' => true]);
            } else {
                session()->forget('lang-rtl');
            }
        }
    }

    /**
     * @param $locale
     * @return mixed
     */
    public static function getLocaleName($locale)
    {
        return config('core.locale.languages')[$locale]['name'];
    }

}