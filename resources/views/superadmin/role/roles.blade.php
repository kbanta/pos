@extends('layouts.app')

@section('content')
@include('layouts.superadmin_sidebar')
<main class="main-content position-relative border-radius-lg ">
    @include('layouts.main_navbar')
    <div class="container-fluid py-4">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5 id="titleHeading"></h5>
                <a class="btn btn-success btn-sm" style="float: right;" onClick="addRole()" data-bs-toggle="modal" data-bs-target="#addRoleModal"> Create Role</a>
            </div>
                <!-- <div class="card-header">{{ __('Role List') }}
                    <div class="mb-2" style="float: right;">
                        <a class="btn btn-success" onClick="addRole()" data-bs-toggle="modal" data-bs-target="#addRoleModal"> Create Role</a>
                    </div>
                </div> -->
                <div class="card-body">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" id="datatable-crud-role">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Id</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Name</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Created at</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                        </table>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('superadmin.role.role_modal_form')
<script type="text/javascript">
    var title = "Roles List";
    var breadcrumb_title = "Roles";
    document.getElementById("titleHeading").innerHTML = title;
    document.getElementById("pageHeading").innerHTML = breadcrumb_title;
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#datatable-crud-role').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('roles') }}",
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

        $('body').on('click', '.delete-role', function(e) {
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
                        url: "roles/deleterole/" + id,
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(res) {
                            var oTable = $('#datatable-crud-role').dataTable();
                            oTable.fnDraw(false);
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'User has been deleted.',
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