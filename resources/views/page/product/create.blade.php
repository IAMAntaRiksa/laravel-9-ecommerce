@extends('layouts.app', ['title' => 'Tambah Produk'])
@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-shopping-bag"></i> TAMBAH PRODUK</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if($errors->first('message'))
                        <div class=" col-12">
                            <div class="border-left-primary shadow-2">
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('message') }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label>GAMBAR <span style="color : red"> *</label>
                            <input type="file" name="file" class="form-control">
                            <small class="form-text text-danger">{{ $errors->first('file') }}</small>
                        </div>
                        <div class="form-group">
                            <label>NAMA PRODUK <span style="color : red"> *</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                placeholder="Masukkan Nama Produk" class="form-control">
                            <small class="form-text text-danger">{{ $errors->first('title') }}</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>KATEGORI <span style="color : red"> *</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">-- PILIH KATEGORI --</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-danger">{{ $errors->first('category_id') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>BERAT (gram)<span style="color : red"> *</label>
                                    <input type="number" name="weight" class="form-control" value="{{ old('weight') }}"
                                        placeholder="Berat Produk (gram)">
                                    <small class="form-text text-danger">{{ $errors->first('weight') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>DESKRIPSI <span style="color : red"> *</label>
                            <textarea class="form-control content" name="content" rows="6"
                                placeholder="Deskripsi Produk">{{ old('content') }}</textarea>
                            <small class="form-text text-danger">{{ $errors->first('content') }}</small>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>HARGA <span style="color : red"> *</label>
                                    <input type="number" name="price" class="form-control" value="{{ old('price') }}"
                                        placeholder="Harga Produk">
                                    <small class="form-text text-danger">{{ $errors->first('price') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>DISKON (%)</label>
                                    <input type="number" name="discount" class="form-control "
                                        value="{{ old('discount') }}" placeholder="Diskon Produk (%)">
                                    <small class="form-text text-danger">{{ $errors->first('discount') }}</small>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            @lang('web.submit')</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i>
                            @lang('web.reset')
                        </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.4/tinymce.min.js"></script>
<script>
var editor_config = {
    selector: "textarea.content",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak ",
        "searchreplace wordcount visualblocks visualchars code fullscreen ",
        "insertdatetime media nonbreaking save table contextmenu directionality ",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media ",
    relative_urls: false,
};
tinymce.init(editor_config);
</script>
@endsection