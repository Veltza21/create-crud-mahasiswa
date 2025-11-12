<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
  public function index()
{
    if (auth()->user()->is_admin == 1) {
        $mahasiswa = Mahasiswa::with(['jurusan', 'user'])->get();
    } else {
        $mahasiswa = Mahasiswa::with(['jurusan', 'user'])
            ->where('user_id', auth()->id())
            ->get();
    }

    $jurusan = Jurusan::all();

    return view('admin.mahasiswa.index', compact('mahasiswa', 'jurusan'));
}

public function mahasiswa_role_mahasiswa()
{
      if (auth()->user()->is_admin == 1) {
        $mahasiswa = Mahasiswa::with(['jurusan', 'user'])->get();
    } else {
        $mahasiswa = Mahasiswa::with(['jurusan', 'user'])
            ->where('user_id', auth()->id())
            ->get();
    }

    $jurusan = Jurusan::all();

    return view('admin.mahasiswa_role_mahasiswa.index', compact('mahasiswa', 'jurusan'));
}

    public function store(Request $request)
    {
      
        $validated = $request->validate([
          
            'nim'           => 'required|max:50|unique:mahasiswa,nim',
            'nama'          => 'required|max:255',
            'jurusan_id'    => 'required|exists:jurusan,id',
            'tempat_lahir'  => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:500',

          
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:5|max:255',
            'is_admin' => 'required|boolean',
        ]);

        return DB::transaction(function () use ($request, $validated) {
          
            $pathFoto = null;
            if ($request->hasFile('foto')) {
                $pathFoto = $request->file('foto')->store('foto_mahasiswa', 'public');
            }

          
            $user = User::create([
                'name'     => $validated['nama'],
                'email'    => $validated['email'],
                'nim'      => $validated['nim'],    
                'is_admin' => (bool) $validated['is_admin'],
                'password' => Hash::make($validated['password']),
            ]);

          
            $mahasiswa = Mahasiswa::create([
                'nim'           => $validated['nim'],
                'nama'          => $validated['nama'],
                'jurusan_id'    => $validated['jurusan_id'],
                'tempat_lahir'  => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'foto'          => $pathFoto,
                'user_id'       => $user->id,     
                'created_by'    => auth()->id(),
            ]);

            return response()->json([
                'message' => 'Mahasiswa dan user berhasil dibuat',
                'data'    => [
                    'mahasiswa_id' => $mahasiswa->id,
                    'user_id'      => $user->id,
                ],
            ], 201);
        });
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
