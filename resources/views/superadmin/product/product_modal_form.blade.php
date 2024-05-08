<!-- Modal-->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle" class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="mode" name="mode" class="form-control" />
                        <input type="hidden" id="pid" name="pid" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" id="category_id" class="brand_id form-control">
                            <option value="" disabled selected>Select Category</option>
                            @foreach($category as $categories)
                            <option value="{{$categories->id}}">{{$categories->name}}</option>
                            @endforeach
                        </select>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        <span class="text-danger">
                            <strong id="category_id-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Barcode</label>
                        <input autocomplete="off" type="text" id="barcode" name="barcode" value="{{ old('name') }}" class="barcode form-control" placeholder="Barcode">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        <span class="text-danger">
                            <strong id="barcode-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label>Product Name</label>
                        <input autocomplete="off" type="text" id="product" name="product" value="{{ old('name') }}" class="product form-control" placeholder="Product">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        <span class="text-danger">
                            <strong id="product-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="prod_description">Description</label>
                        <textarea class="form-control" id="prod_description" name="prod_description" rows="3" placeholder="Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price" class="form-control-label">Price</label>
                        <input class="form-control" type="number" id="price" name="price" placeholder="Price" min="0" step="0.01">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        <span class="text-danger">
                            <strong id="price-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submitForm" class="btn btn-success">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function addProduct() {
        $('#mode').val(0);
        $("#createForm")[0].reset();
        $('#modalTitle').html("Create Product");
    }
    //Saving Process...
    $('#createForm').on('submit', function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var mode = parseInt($('#mode').val());
        if (mode === 0) {
            var title = 'Create Product';
            var method = 'POST';
            var url = "{{route('registerProduct')}}";
        } else {
            var id = $('#pid').val();
            var title = 'Update Product';
            var method = 'PATCH';
            var url = "products/update/" + id;
        }
        Swal.fire({
            title: title,
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: method,
                    url: url,
                    data: $('#createForm').serialize(),
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.errors) {
                            if (response.errors.product) {
                                $('#product-error').html(response.errors.product[0]);
                            }
                            if (response.errors.price) {
                                $('#price-error').html(response.errors.price[0]);
                            }
                            if (response.errors.barcode) {
                                $('#barcode-error').html(response.errors.barcode[0]);
                            }
                        }
                        if (response.success) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Your work has been saved',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            $('#addProductModal').modal('hide');
                            var oTable = $('#datatable-crud-product').dataTable();
                            oTable.fnDraw(false);
                            $('#pid').val('');
                            $('#product').val('');
                            $('#price').val('');
                            $('#category_id').val('');
                            $('#prod_description').val('');
                            $('#barcode').val('');
                        }
                    },
                });
            }
        });
    });
    //edit
    function editProduct(id) {
        $.ajax({
            type: "GET",
            url: "products/edit/" + id,
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                // console.log(res);
                $('#modalTitle').html("Edit Product");
                $('#addProductModal').modal('show');
                $('#pid').val(res.pid);
                $('#product').val(res.name);
                $('#price').val(res.price);
                $('#prod_description').val(res.description);
                $('#barcode').val(res.barcode);
                // $('#category_id').val(res.category_name);
                $('#category_id option').each(function() {
                    if ($(this).text() === res.category_name) {
                        $(this).prop('selected', true);
                    }
                });
                $('#mode').val(1);
            }
        });
    }
</script>