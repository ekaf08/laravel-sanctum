<div>
    <div class="container">
        @if (session()->has('message'))
            <div class="pt-3">
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <!-- START FORM -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <form>
                @csrf
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="nama">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" wire:model="email">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" wire:model="alamat">
                    </div>
                </div>

                @if ($errors->any())
                    <div class="pt-3">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        @if ($updateData == false)
                            <button type="button" class="btn btn-primary" name="submit"
                                wire:click="store()">SIMPAN</button>
                        @else
                            <button type="button" class="btn btn-primary" name="submit"
                                wire:click="update()">UPDATE</button>
                        @endif
                        <button type="button" class="btn btn-secondary" name="submit"
                            wire:click="clear()">BATAL</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- AKHIR FORM -->

        <!-- START DATA -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h1>Data Pegawai</h1>
            <div class="pb-3 pt-3">
                <input type="text" class="form-control mb-3 w-25" placeholder="Cari pegawai .."
                    wire:model.live="kata_kunci">
            </div>
            @if ($employee_select_id)
                <a wire:click="confirmation_destroy('')" class="btn btn-danger btn-sm my-3" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Delete {{ count($employee_select_id) }} data</a>
            @endif
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="col-md-1">No</th>
                        <th class="col-md-4">Nama</th>
                        <th class="col-md-3">Email</th>
                        <th class="col-md-2">Alamat</th>
                        <th class="col-md-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataEmployees as $key => $item)
                        <tr>
                            <th>
                                <input type="checkbox" name="" id="" value="{{ $item->id }}"
                                    wire:key="{{ $item->id }}" wire:model.live="employee_select_id">
                            </th>
                            <td>{{ $dataEmployees->firstItem() + $key }}</td>
                            <td>{{ ucwords($item->nama) }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ ucwords($item->alamat) }}</td>
                            <td>
                                <a wire:click="edit({{ $item->id }})" class="btn btn-warning btn-sm">Edit</a>
                                <a wire:click="confirmation_destroy({{ $item->id }})" class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $dataEmployees->links() }}
        </div>
        <!-- AKHIR DATA -->
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin akan menghapus data ini ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" wire:click="destroy()"
                            data-bs-dismiss="modal">Ya</button>
                        <button type="button" class="btn btn-secondary" wire:click="clear()">Tidak</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
