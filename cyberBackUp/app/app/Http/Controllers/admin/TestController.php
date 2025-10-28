<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Family;
use App\Models\RiskCatalog;
use App\Models\MitigationToTeam;
use App\Http\Traits\LdapTrait;
class TestController extends Controller
{
    use LdapTrait;
     // return datatable
     public function test(){

        return $this->GetLdapUsers();
    }

    // fetch data from database by ajax
    public function GetTest(){
        // make map for object to add item to every object
        //if you have relation with any table used function example2 after create relation between table in modals
        $tests= RiskCatalog::all()->map(function($Risk) {
            return (object)[
               'responsive_id' => '',
               'id' => $Risk->id,
               'name' => $Risk->name,
               'number' => $Risk->number,
               'description' => $Risk->description
            ];
        });
        return response()->json($tests,200);
    }

    // function example2(){
    //     $items= Product::with('brand')->get()->map(function($product) {
    //         return (object)[
    //            'id' => $product->id,
    //            'Name' => $product->name,
    //            'product_id' => $product->product_id,
    //            'product_name' => $product->brand->product_name
    //         ];
    //     });
    //      return response()->json($items,200);
    // }
}
