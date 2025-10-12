<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Dcblogdev\MsGraph\Facades\MsGraph;
use Illuminate\Http\Request;

class PageController extends Controller
{
     public function __invoke()
    {
        // handle logic
    }
    
    public function app(){
        MsGraph::get('me');
    }
}
