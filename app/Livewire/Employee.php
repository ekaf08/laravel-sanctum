<?php

namespace App\Livewire;

use Livewire\Component;

class Employee extends Component
{
    public $nama;
    public $email;
    public $alamat;

    public function store()
    {
        $this->nama = 'Azka';
        $this->email = 'azka@email.com';
        $this->alamat = 'Surabaya';
    }

    public function render()
    {
        return view('livewire.employee');
    }
}
