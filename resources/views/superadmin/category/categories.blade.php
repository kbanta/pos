@extends('layouts.app')

@section('content')
@include('layouts.superadmin_sidebar')
<main class="main-content position-relative border-radius-lg ">
    @include('layouts.main_navbar')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">{{ __('Categories List') }}
                <div class="mb-2" style="float: right;">
                    <a class="btn btn-success" onClick="addCategory()" data-bs-toggle="modal" data-bs-target="#addCategoryModal"> Create Category</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable-crud-category">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created at</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('superadmin.category.category_modal_form')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#datatable-crud-category').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('categories') }}",
            columns: [{
                    data: 'id',
                    name: 'id',
                    render: function(data) {
                        return '<p class="text-xs font-weight-bold mb-0">' + data + '</p>';
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data) {
                        return '<p class="text-xs font-weight-bold mb-0">' + data + '</p>';
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data) {
                        return '<p class="text-xs font-weight-bold mb-0">' + moment(data).format('MMMM Do YYYY, h:mm:ss a') + '</p>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

        $('body').on('click', '.delete-category', function(e) {
            e.preventDefault(); // Prevent default link action

            var deleteUrl = $(this).attr('href'); // Get the delete URL from the button's href attribute

            // Display SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this record!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, proceed with delete action
                    var id = $(this).data('id');
                    // ajax
                    $.ajax({
                        type: "PATCH",
                        url: "categories/deletecategory/" + id,
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(res) {
                            var oTable = $('#datatable-crud-category').dataTable();
                            oTable.fnDraw(false);
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Category has been deleted.',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        }
                    });
                }
            });
        });

    });
</script>
@endsection