<?php

namespace App\Http\Controllers;
use App\Http\Resources\PlannerResource;
use App\Models\Planner;
use App\Models\Destinasi;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class PlannerController extends Controller
{
    public function index()
    {
        $planner = Planner::with(['destinasi', 'user'])->latest()->get();

        return new PlannerResource(true, 'List data planner', $planner);
    }

    public function create()
    {
        $destinasi = Destinasi::all();
        $user = User::all();
        return view('planner.create', compact('destinasi', 'user'));
    }

    // public function indexById($id_user)
    // {
    //     $planner = Planner::where('id_user', $id_user)->with(['destinasi', 'user'])->latest()->get();

    //     return new PlannerResource(true, 'List data planner', $planner);
    // }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_destinasi' => 'required',
            'tgl' => 'required|date',
            'jumlah_orang' => 'required',
            'note' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = auth()->user();

        $data = Planner::create([
            'id_user' => $user->id,
            'id_destinasi' => $request->id_destinasi,
            'tgl' => $request->tgl,
            'jumlah_orang' => $request->jumlah_orang,
            'note' => $request->note,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Planner Created',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $planner = Planner::findOrFail($id);
        
        if($planner){
            $planner->delete();
            return response()->json([
                'success' => true,
                'message' => 'Planner Deleted',
                'data' => $planner
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Planner Not Found',
            'data' => ''
        ], 404);
    }

    public function show($id)
    {
        $data = Planner::where('id_user', $id)->with(['destinasi', 'user'])->latest()->get();
        return new PlannerResource(true, 'Detail Data Planner', $data);
    }

    public function edit($id)
    {
        $data = Planner::find($id);
        $destinasi = Destinasi::all();
        $user = User::all();
        return view('planner.edit', compact('data', 'destinasi', 'user'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_destinasi' => 'required',
            'tgl' => 'required|date',
            'jumlah_orang' => 'required',
            'note' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Planner::find($id)->update([
            'id_destinasi' => $request->id_destinasi,
            'tgl' => $request->tgl,
            'jumlah_orang' => $request->jumlah_orang,
            'note' => $request->note,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Planner Updated',
            'data' => $data
        ], 200);
    }
}