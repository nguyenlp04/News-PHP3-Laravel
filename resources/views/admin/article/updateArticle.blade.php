@extends('layout.admin.main')
@section('contentAdmin')
<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<section class="container-fluid py-4">
    <div class="w-full">
        <div class="flex justify-center xl:w-11/13">
            <div class="w-11/12 xl:w-11/13 mb-8">
                <div class="w-full bg-white rounded-lg min-h-screen">
                    <div class="w-full flex justify-center p-3">
                        <div class="w-11/12">
                            <div class="title-container flex items-center">
                                <h4 class="text-primary ">Update Article</h2>
                            </div>
                            <form action="{{ route('article.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                                <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/super-build/ckeditor.js"></script>
                                @csrf
                                @method('PUT')
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label text-black font-semibold">Title</label>
                                            <input type="text" id="title" class="form-control border" name="title" value="{{ $data->title }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label text-black font-semibold">Category{{$data->category_id}}</label>
                                            <select id="category_id" name="category_id" class="form-select border" required>
                                            @foreach ($categories as $itemCategory )
                                            <option value="{{ $itemCategory->id }}"   {{ $itemCategory->id == old('category_id', $data->category_id) ? 'selected' : '' }} >{{ $itemCategory ->name }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-0">
                                        <div class="mb-3">
                                            <label for="description" class="form-label text-black font-semibold">Description</label>
                                            <textarea id="description" class="form-control border" name="description" rows="4">{{ $data->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label text-black font-semibold">Content</label>
                                    <textarea id="editor" name="content" class="form-control border">{{$data->content}}
                                    </textarea>
                                </div>
                                <div class="mb-3 mt-4">
                                    Tải lên ảnh đại diện </br>
                                    <label for="product_photo" class="text-dark font-weight-semibold pb-1 text-capitalize">
                                        <i class="fas fa-file-image fa-2x"></i>
                                    </label>
                                    <input type="file" class="d-none" id="product_photo" name="img_article">

                                    <img id="preview_img" class="mt-4 border border-secondary rounded" style="width: 100px; height: auto;" src="{{ asset($data->image_url) }}">
                                </div>

                                <div class="d-flex justify-content-end">
                                    <input type="submit" class="btn btn-primary text-white rounded-lg px-4 py-2 text-sm font-semibold" value="Update Articles">
                                </div>
                                <input type="hidden" value="1" name="author_id">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('product_photo');
            const previewImg = document.getElementById('preview_img');

            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewImg.classList.remove('d-none');
                    };

                    reader.readAsDataURL(file);
                } else {
                    previewImg.classList.add('d-none');
                }
            });
        });
    </script>
</section>
@endsection