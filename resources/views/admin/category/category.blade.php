@extends('layout.admin.main')
@section('contentAdmin')
<section class="container-fluid py-4">
    <div class="w-full">
        <div class="flex justify-center xl:w-11/13">
            <div class="w-11/12 xl:w-11/13 mb-8">
                <div class="w-full bg-white rounded-lg min-h-screen">
                    <div class="w-full flex justify-center p-3">
                        <div class="w-11/12">
                        <div class="title-container flex items-center">
                                <h4 class="text-primary flex items-center">@isset($dataId) Update Category <a href="{{ url('admin/category') }}"><button class="btn btn-primary" type="button"><i class="fa-solid fa-circle-plus"></i></button></a> @else Add New Category @endisset</h2>
                            </div>
                            <form  @isset($dataId) action=" {{ route('category.update',$dataId->id) }}"  @else action=" {{ route('category.store') }}" @endisset method="POST" enctype="multipart/form-data">
                                <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/super-build/ckeditor.js"></script>
                                @csrf
                                @isset($dataId)
                                @method('PUT')
                                @endisset
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label text-black font-semibold">Name</label>
                                            <input type="text" id="name" class="form-control border" name="name" @isset($dataId) value="{{ $dataId ->name }}" @endisset>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-0">
                                        <div class="mb-3">
                                            <label for="description" class="form-label text-black font-semibold">Description</label>
                                            <textarea id="description" class="form-control border" name="description" rows="4">@isset($dataId) {{ $dataId ->description }} @endisset</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <input type="submit" class="btn btn-primary text-white rounded-lg px-4 py-2 text-sm font-semibold" value="@isset($dataId) Update Category @else Add Category @endisset">
                                </div>
                                <input type="hidden" value="1" name="author_id">
                            </form>
                            <div class="title-container flex items-center">
                                <h4 class="text-primary ">All Categories</h2>
                            </div>
                            <table id="example" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 2%">ID</th>
                                        <th>Name</th>
                                        <!-- <th>Description</th> -->
                                        <th>Description</th>
                                        <th style="width: 3%">Show</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            <form action="{{ route('admin.category.status', $item->id ) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" name="status" value="1" {{ $item->status == 1 ? 'checked' : '' }} onchange="this.form.submit()">
                                                </div>
                                            </form>
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('category.update',$item->id) }}">
                                                <i class="fa-solid fs-5 fa-pen-to-square text-primary mr-2"></i>
                                            </a>
                                            <span onclick="confirmDelete(event,{{ $item->id }})"> 
                                                <form id="delete-form-{{ $item->id }}" action="{{ route('category.destroy', $item->id) }}" method="POST" style="display:inline;" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="border: none; background: none; color: red; cursor: pointer;">
                                                        <i class="fa-solid fs-5 fa-trash-can text-danger"></i>
                                                    </button>
                                                </form>
                                            </span>
                                        </div>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        new DataTable('#example');
        // $(document).ready(function() {
        //     $('#example').DataTable({
        //         "scrollX": true
        //     });
        // });
    </script>
    <script>
        function confirmDelete(event, articleId) {
            event.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${articleId}`).submit();
                } else {
                    Swal.fire({
                        title: "Cancelled!",
                        text: "Action cancelled. Item was not deleted.",
                        icon: "error"
                    });
                }
            });
        }
    </script>
</section>
@endsection