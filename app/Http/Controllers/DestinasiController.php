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

        $requestData = $request->all();
        $fileName = time().$request->file('foto')->getClientOriginalName();
        $path = $request->file('foto')->storeAs('destinasi', $fileName, 'public');
        $requestData['foto'] = 'storage/'. $path;

        // Menyimpan foto kedalam file local storage/app/public/destinasi

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

            //Fungsi Simpan Data ke dalam Database
            $destinasi = Destinasi::create($requestData);

        // $destinasi = Destinasi::create([
        //     'nama' => $request->nama,
        //     'total_rating' => $request->total_rating,
        //     'deskripsi' => $request->deskripsi,
        //     'foto' => $request->foto->hashName(),
        // ]);

        // $request->foto->store('public/destinasi');

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
            return new DestinasiResource(true, 'Data Destinasi Berhasil Diambil!', $destinasi);
        }

        public function update(Request $request, $id){
            $this->validate($request, [
                'nama',
                'total_rating',
                'deskripsi',
                'foto'
            ]);

            $destinasi = Destinasi::find($id);

            $destinasi->nama = $request->get('nama');
            $destinasi->total_rating = $request->get('total_rating');
            $destinasi->deskripsi = $request->get('deskripsi');

            $requestData = $request->all();
            $fileName = time().$request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('destinasi', $fileName, 'public');
            $requestData['foto'] = 'storage/'. $path;

            $destinasi->save();
    
            // Departemen::edit([
            //     'nama_departemen' => $request->get('nama_departemen'),
            //     'nama_manager' => $request->get('nama_manager'),
            //     'jumlah_pegawai' => $request->get('jumlah_pegawai')
            // ]);

            return new DestinasiResource(true, 'Data Destinasi Berhasil Diubah!', $destinasi);
        }

        public function destroy(Request $request, $id){
            $destinasi = Destinasi::find($id);
            $tempHapus = Destinasi::find($id);
            $destinasi->delete();
            return new DestinasiResource(true, 'Data Destinasi Berhasil Dihapus!', $tempHapus);

            // try{ 
            //     //Mengisi variabel yang akan ditampilkan pada view mail
            //         $content = [
            //         'body' => $request->nama_departemen,
            //         ];
            //     //Mengirim email ke emailtujuan@gmail.com
            //     Mail::to('calvinandrean456@gmail.com')->send(new DepartemenMail($content));
            //     //Redirect jika berhasil mengirim email
            //     return redirect()->route('departemen.index')->with(['success' => 'Data Berhasil Dihapus, email telah terkirim!']);
            // } catch(Exception $e){
            // //Redirect jika gagal mengirim email
            //     return redirect()->route('departemen.index')->with(['success' => 'Data Berhasil Dihapus, namun gagal mengirim email!']);
            // }
        }
}
