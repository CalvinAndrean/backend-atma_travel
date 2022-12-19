<?php

namespace App\Http\Controllers;
use App\Http\Resources\RatingResource;
use App\Models\Rating;
use App\Models\Destinasi;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $rating = Rating::with(['destinasi', 'user'])->latest()->get();

        return new RatingResource(true, 'List Data Rating', $rating);
    }

    public function create()
    {
        $destinasi = Destinasi::all();
        $user = User::all();
        return view('rating.create', compact('destinasi', 'user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_destinasi' => 'required',
            'komentar' => 'required',
            'rating' => 'numeric|required|max:5|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = auth()->user();

        $data = Rating::create([
            'id_user' => $user->id,
            'id_destinasi' => $request->id_destinasi,
            'komentar' => $request->komentar,
            'rating' => $request->rating,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rating Created',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        
        if($rating){
            $rating->delete();
            return response()->json([
                'success' => true,
                'message' => 'Rating Deleted',
                'data' => $rating
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Rating Not Found',
            'data' => ''
        ], 404);
    }

    public function show($id)
    {
        $data = Rating::find($id);
        return new RatingResource(true, 'Detail Data Rating', $data);
    }

    public function edit($id)
    {
        $data = Rating::find($id);
        $destinasi = Destinasi::all();
        $user = User::all();
        return view('rating.edit', compact('data', 'destinasi', 'user'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_destinasi' => 'required',
            'komentar' => 'required',
            'rating' => 'numeric|required|max:5|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Rating::find($id)->update([
            'id_destinasi' => $request->id_destinasi,
            'komentar' => $request->komentar,
            'rating' => $request->rating,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rating Updated',
            'data' => $data
        ], 200);
    }
}