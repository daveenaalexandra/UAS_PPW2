<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan; // Import Model Pekerjaan
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(Request $request) {
        $keyword = $request->get('keyword');
        $data = Pegawai::with('pekerjaan')
        ->when($keyword, function ($query) use ($keyword){
            $query->where('nama', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%");
        })->paginate(5);
        return view('pegawai.index', compact('data'));
    }

    public function add() {
        $pekerjaan = Pekerjaan::all();
        return view('pegawai.add', compact('pekerjaan'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:pegawai,email',
            'pekerjaan_id' => 'required',
            'gender' => 'required',
        ]);

        Pegawai::create($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }
    public function edit($id) {
        $data = Pegawai::findOrFail($id);
        $pekerjaan = Pekerjaan::all(); // Ambil data pekerjaan lagi untuk dropdown
        return view('pegawai.edit', compact('data', 'pekerjaan'));
    }

    public function update(Request $request) {
        $id = $request->id;
        $validatedData = $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:pegawai,email,'.$id, 
            'pekerjaan_id' => 'required',
            'gender' => 'required',
        ]);
        $data = Pegawai::findOrFail($id);
        $data->update($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai diperbarui');
    }

    public function destroy(Request $request) {
        $id = $request->id; 
        Pegawai::findOrFail($id)->delete();
        return redirect()->route('pegawai.index')->with('success', 'Data pegawai dihapus');
    }
}