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
    public $updateData = false;
    public $employee_id;
    public $kata_kunci;
    public $employee_select_id = [];

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
        $this->clear();
    }

    public function edit($id)
    {
        $data = ModelsEmployee::find($id);

        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->alamat = $data->alamat;

        $this->updateData = 'true';
        $this->employee_id = $id;
    }

    public function update()
    {
        $rules =
            [
                'nama' => 'required',
                'email' => 'required|email|unique:employees,email,' . $this->employee_id . ',id',
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

        $data = ModelsEmployee::find($this->employee_id);
        $data->update($validated);
        session()->flash('message', 'Data berhasil di perbarui');
        $this->clear();
    }

    public function destroy()
    {
        if ($this->employee_id != '') {
            $id = $this->employee_id;
            $data = ModelsEmployee::find($id);
            $data->delete();
        }
        $array_id = $this->employee_select_id;
        if (count($array_id)) {
            for ($i = 0; $i < count($array_id); $i++) {
                ModelsEmployee::find($array_id[$i])->delete();
            }
        }

        session()->flash('message', 'Data berhasil di hapus');

        $this->clear();
    }

    public function clear()
    {
        $this->nama = '';
        $this->email = '';
        $this->alamat = '';

        $this->updateData = 'false';
        $this->employee_id = '';
        $this->employee_select_id = [];
    }

    public function confirmation_destroy($id)
    {
        if ($id != '') {
            $this->employee_id = $id;
        } else {
            # code...
        }
    }

    public function render()
    {
        if ($this->kata_kunci != null) {
            $table = ModelsEmployee::where('nama', 'like', '%' . $this->kata_kunci . '%')
                ->orWhere('email', 'like', '%' . $this->kata_kunci . '%')
                ->orWhere('alamat', 'like', '%' . $this->kata_kunci . '%')
                ->orderBy('nama', 'asc')->paginate(10);
        } else {
            $table = ModelsEmployee::orderBy('nama', 'asc')->paginate(10);
        }
        $data =
            [
                'dataEmployees' => $table,
            ];
        return view('livewire.employee', $data);
    }
}
