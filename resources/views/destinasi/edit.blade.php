@extends('dashboard') 

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Departemen</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">Departemen</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        <form action="{{ route('departemen.update', $departemen->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="font-weightbold">Nama Departemen</label>
                                    <input type="text" class="form-control name="nama_departemen" value="{{ $departemen->nama_departemen }}"/>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weightbold">Nama Manager</label>
                                    <input type="text" class="form-control name="nama_manager" value="{{ $departemen->nama_manager }}" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weightbold">Jumlah Pegawai</label>
                                    <input type="number" class="form-control name="jumlah_pegawai" value="{{ $departemen->jumlah_pegawai }}" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md btn-primary" id="simpanBtn">
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
<script src="toastr.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script>
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}")
    @endif
</script>
@endsection
