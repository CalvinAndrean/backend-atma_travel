<?php

namespace App\Http\Controllers;
use App\Http\Resources\DestinasiResource;

use Illuminate\Http\Request;

class DestinasiController extends Controller
{
    public function index(){
        // $destinasi = Destinasi::get();
        $destinasi = Destinasi::latest()->get();

        return new DestinasiResource(true, 'List data destinasi', $destinasi);
    }
}
