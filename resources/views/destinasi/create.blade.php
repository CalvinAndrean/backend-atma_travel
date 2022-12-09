@extends('dashboard') @section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Departemen</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Departemen</a>
                    </li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form
                            action="{{ route('departemen.store') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold"
                                        >Nama Departemen</label
                                    >
                                    <input
                                        type="text"
                                        class="formcontrol @error('nama_departemen') is-invalid @enderror"
                                        name="nama_departemen"
                                        value="{{ old('nama_departemen') }}"
                                        placeholder="Masukkan Nama Departemen"
                                    />
                                    @error('nama_departemen')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weightbold"
                                        >Nama Manager</label
                                    >
                                    <input
                                        type="text"
                                        class="formcontrol @error('nama_manager') is-invalid @enderror"
                                        name="nama_manager"
                                        value="{{ old('nama_manager') }}"
                                        placeholder="Masukkan Nama Manager"
                                    />
                                    @error('nama_manager')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weightbold"
                                        >Jumlah Pegawai</label
                                    >
                                    <input
                                        type="number"
                                        class="formcontrol @error('jumlah_pegawai') is-invalid @enderror"
                                        name="jumlah_pegawai"
                                        value="{{ old('jumlah_pegawai') }}"
                                        placeholder="Masukkan Jumlah Pegawai"
                                    />
                                    @error('jumlah_pegawai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="btn btn-md btn-primary"
                            >
                                SIMPAN
                            </button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

<script>
        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif(Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif
        });

    </script>
@endsection
