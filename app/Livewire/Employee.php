<?php

namespace App\Livewire;

use App\Models\Employee as ModelsEmployee;
use Livewire\Component;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama;
    public $email;
    public $alamat;

    public function store()
    {
        $rules =
            [
                'nama' => 'required',
                'email' => 'required|email|unique:employees,email',
                'alamat' => 'required'
            ];
        $pesan =
            [
                'nama.required' => 'Nama wajib di isi.',
                'email.required' => 'Email wajib di isi.',
                'email.email' => 'Format email tidak sesuai.',
                'email.unique' => 'Email sudah terdaftar.',
                'alamat.required' => 'alamat wajib di isi.',
            ];
        $validated = $this->validate($rules, $pesan);

        ModelsEmployee::create($validated);
        session()->flash('message', 'Data berhasil dimasukan');
    }

    public function render()
    {
        $table = ModelsEmployee::orderBy('nama', 'asc')->paginate(10);
        $data =
            [
                'dataEmployees' => $table,
            ];
        return view('livewire.employee', $data);
    }
}
