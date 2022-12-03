<?php

namespace App\Http\Controllers;
use App\Http\Resources\PlannerResource;

use Illuminate\Http\Request;

class PlannerController extends Controller
{
    public function index(){
        // $destinasi = Destinasi::get();
        $planner = Planner::latest()->get();

        return new PlannerResource(true, 'List data planner', $planner);
    }
}
