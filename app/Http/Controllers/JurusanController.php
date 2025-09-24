<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::get();
        return view('admin.jurusan.index',compact('jurusan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'=> 'required|max:255',
            'kode' => 'required|unique:jurusan',
        ]);
  
        Jurusan::create($validatedData);

        return response()->json(['message' => 'Data created successfully']);
    }
    public function edit($id)
    {
        $data = Jurusan::find($id);
        return response()->json($data);
    }
    public function update($id, Request $request)
    {
        $jurusan = Jurusan::findOrFail($id); 


        $validatedData = $request->validate([
            'nama'=> 'required|max:255',
            'kode' => [
                'required',
                Rule::unique('jurusan')->ignore($id),
            ],
        ]);
 
        

        $jurusan->update($validatedData);

        return response()->json(['message' => 'Data Updated successfully']);
    }

    
    public function destroy($id)
    {
        $jurusan = Jurusan::find($id);        
        $jurusan->delete();
        return response()->json(['message' => 'Data deleted successfully']);
    }
}