<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class ValidateSerialMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            # Reading from files
            // `t` catch time file
            $oldCatchedDateFile = File::get(base_path() . '/vendor/laravel/framework/src/Illuminate/Encryption/t');
            // `ed` expiration date file
            $expirationDateFile = File::get(base_path() . '/vendor/laravel/framework/src/Illuminate/Encryption/ed');
            // am` algorithm meta data encryption/decryption as `cipher_algo` and `cipher_algo_key` file
            $algorithmMetaFile = File::get(base_path() . '/vendor/laravel/framework/src/Illuminate/Encryption/am');

            // Check first time there is no serial data
            if ($oldCatchedDateFile == 'cyber-mode' && $expirationDateFile == 'cyber-mode' && $algorithmMetaFile == 'cyber-mode')
                if (Route::is('serial.index') || Route::is('serial.check'))
                    return $next($request);
                else
                    return redirect()->route('serial.index');

            $algorithmMetaData = json_decode(decrypt($algorithmMetaFile));
            $dateEncrypter = new Encrypter(base64_decode($algorithmMetaData->cipher_algo_key), $algorithmMetaData->cipher_algo);
            $expirationDate = $dateEncrypter->decrypt($expirationDateFile);
            $oldCatchedDate = $dateEncrypter->decrypt($oldCatchedDateFile);

            $today = Carbon::now()->second(0);
            // Check old stored date
            $oldCatchedDateCarbon = new Carbon($oldCatchedDate);
            // if ($oldCatchedDateCarbon->gt($today)) { // Server date changed
            //     if (Route::is('serial.manipulation'))
            //         return $next($request);
            //     else
            //         return redirect()->route('serial.manipulation');
            // } else {
            //     if ($today->gt($oldCatchedDateCarbon)) { // set current date
            //         $dateFileWriter = fopen(base_path() . '/vendor/laravel/framework/src/Illuminate/Encryption/t', "w");
            //         fwrite($dateFileWriter, $dateEncrypter->encrypt($today->format('Y-m-d h:i')));
            //         fclose($dateFileWriter);
            //     }
            // }

            // $today->addMonth(); // for test
            $expirationDateCarbon = (new Carbon($expirationDate))->endOfDay();

            if ($expirationDateCarbon->gte($today)) { // License is valid
                if (Route::is('serial.index'))
                    return redirect()->route('admin.dashboard');
                else
                    return $next($request);
            } else { // License was expired
                if (Route::is('serial.index') || Route::is('serial.check'))
                    return $next($request);
                else
                    return redirect()->route('serial.index');
            }
        } catch (\Throwable $th) {
            // redirect to error page (System Hacked via change app Key or deleted files)
            if (Route::is('serial.manipulation'))
                return $next($request);
            else
                return $next($request);
                // return redirect()->route('serial.manipulation');
        }
    }
}
