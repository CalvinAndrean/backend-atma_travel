<?php

namespace App\Http\Controllers;
use App\Http\Resources\RatingResource;

use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(){
        // $destinasi = Destinasi::get();
        $rating = Rating::latest()->get();

        return new RatingResource(true, 'List data rating', $rating);
    }
}
