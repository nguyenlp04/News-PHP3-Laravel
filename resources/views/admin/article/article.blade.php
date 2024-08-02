@extends('layout.admin.main')
@section('contentAdmin')
<!-- <pre>{{ $data->toJson(JSON_PRETTY_PRINT) }}</pre> -->
<section class="container-fluid py-4">
    <div class="w-full">
        <div class="flex justify-center xl:w-11/13">
            <div class="w-11/12 xl:w-11/13 mb-8">
                <div class="w-full bg-white rounded-lg min-h-screen">
                    <div class="w-full flex justify-center p-3">
                        <div class="w-11/12">
                            <div class="title-container flex items-center">
                                <h4 class="text-primary ">All Articles</h2>
                            </div>
                            <table id="example" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 2%">ID</th>
                                        <th style="width: 10%">Title</th>
                                        <!-- <th>Description</th> -->
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th style="width: 3%">Show</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->title }}</td>
                                        <!-- <td>{{ $item->description }}</td> -->
                                        <td>{{ $item->author_name }}</td>
                                        <td>{{ $item->categories_name }}</td>
                                        <!-- <td>{{ $item->status == 1 ? 'Hiển thị' : 'Ẩn'}}</td> -->
                                        <td>
                                            <form action="{{ route('admin.article.status', $item->id ) }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" name="status" value="1" {{ $item->status == 1 ? 'checked' : '' }} onchange="this.form.submit()">
                                                </div>
                                            </form>
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td><a href="{{ url('article/' . $item->id) }}"> <i class="fa-solid fs-5 fa-eye overlay mr-2 " style="color: blue;"></i></a>
                                            <a href="{{ url('admin/article/' . $item->id) }}">
                                                <i class="fa-solid fs-5 fa-pen-to-square text-primary mr-2"></i>
                                            </a>
                                            <a onclick="confirmDelete(event,{{ $item->id }})"> 
                                                <form id="delete-form-{{ $item->id }}" action="{{ route('article.destroy', $item->id) }}" method="POST" style="display:inline;" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="border: none; background: none; color: red; cursor: pointer;">
                                                        <i class="fa-solid fs-5 fa-trash-can text-danger"></i>
                                                        </button>
                                                </form>
                                            </a>
                                        </div>
                                    </tr>
                                    @endforeach
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