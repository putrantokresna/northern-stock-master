<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index() 
    {
        $employee = User::where('role', 'Karyawan')->get();
        return view('employee', ['employee' => $employee]);
    }

    public function edit($id = null) 
    {
        $employee = null;
        if($id != null) {
            $employee = User::find($id);
        }
        return view('edit.employee', ['employee' => $employee, 'id' => $id]);
    }

    public function delete($id) 
    {
        $rowAffected = User::where('id', $id)->delete();
        if($rowAffected > 0)
            return redirect()->route('employee')->with(['msg' => 'Berhasil menghapus karyawan']);
        return redirect()->route('employee')->with(['errmsg' => 'Gagal menghapus karyawan']);
    }

    public function store(Request $request) 
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], 
        [
            'nama.required' => 'Nama Karyawan Tidak Boleh Kosong!',
            'alamat.required' => 'Alamat Karyawan Tidak Boleh Kosong!',
            'email.required' => 'Email Karyawan Tidak Boleh Kosong!',
            'email.email' => 'Email Harus Di Isi Dengan @ dan .! [contoh@contoh.com]',
            'password.required' => 'Password Karyawan Tidak Boleh Kosong!',
            'password.min' => 'Password Harus Lebih Dari 8 Karakter!'
        ]);

        $employee = null;
        $msg = "";
        if($request->id == null || $request->id == "") {
            $employee = new User;
            $employee->role = 'Karyawan';
            $msg = "Berhasil menambahkan karyawan baru";
        } else {
            $employee = User::find($request->id);
            $msg = "Berhasil menyimpan perubahan data karyawan";
        }
        $employee->nama = $request->nama;
        $employee->email = $request->email;
        if($request->alamat == "")
            $request->alamat = null;
        $employee->alamat = $request->alamat;
        if(strlen($request->password) >= 8) {
            $employee->password = bcrypt($request->password);
        }
        if($employee->save()) {
            return redirect()->route('employee', ['id' => $employee->id])->with(['msg' => $msg]);
        }
        return redirect()->back()->with(['errmsg' => 'Gagal menyimpan karyawan']);
    }
}
