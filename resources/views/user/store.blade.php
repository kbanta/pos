@extends('layouts.app')
@section('content')
@include('cart_canvass')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row row-cols-1 row-cols-md-4 g-3">
                @foreach($products as $product)
                <div class="col mb-4">
                    <div class="card h-100 hoverable-card">
                        <a href="{{ route('viewProduct', ['id' => $product->pid]) }}">
                            <div class="image-container hoverable-image" style="height: 250px; background-image: url('@if(!empty($product->url)) {{ Storage::url('product_images/' . $product->url) }} @else {{ Storage::url('product_images/' . $product->noImage()) }} @endif'); background-size: cover; background-position: center;">
                            </div>
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">Price: {{ $product->price }}</p>
                            <a href="#" class="btn btn-warning text-white add-to-cart-btn" data-product-id="{{ $product->pid }}">Add to Cart</a>
                            <!-- <a href="#" class="btn btn-warning text-white view-item" data-product-id="{{ $product->pid }}">Add to Cart</a> -->
                            <!-- <a href="{{ route('viewCheckoutItem', ['id' => $product->pid]) }}" class="btn btn-warning text-white">Add to Cart</a> -->
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<!-- <script src="/js/store.js"></script> -->
@endsection
<style>
    .hoverable-card:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
    }

    .hoverable-image:hover {
        transform: scale(1.1);
        /* Increase scale on hover */
        transition: transform 0.3s ease;
        /* Add smooth transition */
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchCartItemCount();
        fetchCartItem();
    });
    // count cart item...
    // function fetchCartItemCount() {
    //     $.ajax({
    //         url: "{{ route('countCartItem') }}",
    //         type: "GET",
    //         success: function(response) {
    //             console.log(response);
    //             if (response == 0) {
    //                 $('.count-cart-item').hide(); // For example, hide the span
    //             } else {
    //                 $('.count-cart-item').show(); // For example, hide the span
    //                 $('.count-cart-item').text(response);
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             console.error(error);
    //         }
    //     });
    // }
    // JavaScript for AJAX functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Select all "Add to Cart" buttons
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

        addToCartButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                const productId = button.getAttribute('data-product-id');

                // Send AJAX request
                fetch('products/addtocart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Handle success or error response
                        if (data.error) {
                            alert(data.error);
                        } else {
                            toastr.success(data.success);
                            fetchCartItemCount();
                            fetchCartItem(); // Fetch again after emptying
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        // $('.view-item').click(function(e) {
        //     e.preventDefault(); // Prevent default link behavior

        //     var productId = $(this).data('product-id');

        //     // Send AJAX request to the controller
        //     $.ajax({
        //         url: "{{ route('viewCheckoutItem') }}",
        //         type: "GET",
        //         data: { productId: productId },
        //         success: function(response) {
        //             // Handle success response if needed
        //             console.log(response);
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle error if needed
        //             console.error(error);
        //         }
        //     });
        // });

    });
</script>