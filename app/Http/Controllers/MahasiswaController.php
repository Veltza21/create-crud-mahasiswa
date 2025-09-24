<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with(['jurusan', 'user'])->get();
        $jurusan = Jurusan::all();

        return view('admin.mahasiswa.index', compact('mahasiswa', 'jurusan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim'           => 'required|max:50|unique:mahasiswa,nim',
            'nama'          => 'required|max:255',
            'jurusan_id'    => 'required|exists:jurusan,id',
            'tempat_lahir'  => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:500',
        ]);

        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('foto_mahasiswa', 'public');
        }

        $validatedData['created_by'] = auth()->id();

        Mahasiswa::create($validatedData);

        return response()->json(['message' => 'Data created successfully']);
    }

    public function edit($id)
    {
        $data = Mahasiswa::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $validatedData = $request->validate([
            'nim'           => ['required', 'max:50', Rule::unique('mahasiswa')->ignore($id)],
            'nama'          => 'required|max:255',
            'jurusan_id'    => 'required|exists:jurusan,id',
            'tempat_lahir'  => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:500',
        ]);

        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('foto_mahasiswa', 'public');
        }

        $mahasiswa->update($validatedData);

        return response()->json(['message' => 'Data updated successfully']);
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
            Storage::disk('public')->delete($mahasiswa->foto);
        }

        $mahasiswa->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }
}
