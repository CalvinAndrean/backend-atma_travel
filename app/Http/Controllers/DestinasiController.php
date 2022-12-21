<?php

namespace App\Http\Controllers;
use App\Models\Destinasi;
use App\Http\Resources\DestinasiResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DestinasiController extends Controller
{
    public function index(){
        // $destinasi = Destinasi::get();
        $destinasi = Destinasi::latest()->get();

        return new DestinasiResource(true, 'List data destinasi', $destinasi);
    }

    public function create(){
        return view('destinasi.create');
    }

    public function store(Request $request){ 
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'total_rating' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required'
        ]);

        // Menyimpan foto kedalam file local storage/app/public/destinasi

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        // ambil id user yang login
        $user = auth()->user();

        $uploadFolder = 'users';
        $image = $request->file('foto');

        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $registrationData["image"] = basename($image_uploaded_path);

            //Fungsi Simpan Data ke dalam Database
        $destinasi = Destinasi::create([
            'id_user' => $user->id,
            'nama' => $request->nama,
            'total_rating' => $request->total_rating,
            'deskripsi' => $request->deskripsi,
            'foto' => $request->foto->hashName(),
        ]);

        // $request->foto->store('users');

        // if($destinasi){
        //     if($request->hasFile('foto') && $request->file('foto')->isValid()){
        //         $request->foto->store('foto');
        //     }
        // }

        return new DestinasiResource(true, 'Data Destinasi Berhasil Ditambahkan!', $destinasi);
    }

        public function edit($id){
            $destinasi = Destinasi::find($id);
            return view('destinasi.edit', compact('destinasi'));
        }

        public function show($id){
            $destinasi = Destinasi::find($id);

            if($destinasi == null){
                return new DestinasiResource(false, 'Data Destinasi Tidak Ditemukan!', null);
            }

            return new DestinasiResource(true, 'Data Destinasi Berhasil Diambil!', $destinasi);
        }

        public function update(Request $request, $id){
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'total_rating' => 'required|numeric|max:5',
                'deskripsi' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $destinasi = Destinasi::find($id)->update([
                'nama' => $request->nama,
                'total_rating' => $request->total_rating,
                'deskripsi' => $request->deskripsi,
            ]);

            return new DestinasiResource(true, 'Data Destinasi Berhasil Diubah!', $destinasi);
        }

        public function destroy(Request $request, $id){
            $destinasi = Destinasi::find($id);
            $tempHapus = Destinasi::find($id);

            if($destinasi == null){
                return new DestinasiResource(false, 'Data Destinasi Tidak Ditemukan!', null);
            }

            $destinasi->delete();
            return new DestinasiResource(true, 'Data Destinasi Berhasil Dihapus!', $tempHapus);
        }
}