<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class LanguageController extends Controller
{
    //
    public function swap($locale){
         // available language in template array
         $availLocale=['en'=>'en', 'ar'=>'ar'];
         // check for existing language
        if(array_key_exists($locale,$availLocale)){
            session()->put('locale',$locale);
            if($locale == 'ar') {
                Helper::updatePageConfig([
                    'direction' => 'rtl'
                ]);
            } else {
                Helper::updatePageConfig([
                    'direction' => 'ltr'
                ]);
            }

            // dd(Config::get('custom.' . 'custom' . '.' . 'direction'));
        }
         return redirect()->back();
    }
}
