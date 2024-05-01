@extends('layouts.app')

@section('content')
@include('cart_canvass')
<style>
    .container {
        margin-top: 20px;
        /* Add margin space above the container */
    }

    .card {
        margin-top: 100px;
        /* Add margin space above the container */
    }

    #image-container {
        width: 100%;
        /* Make the container take full width */
        max-width: 500px;
        /* Set a maximum width */
        margin: 0 auto;
        /* Center the container horizontally */
        margin-left: 0;
        /* Reset margin-left */
    }

    .main-image-prod {
        max-width: 100%;
        /* Ensure the main image fits container width */
        height: auto;
        /* Maintain aspect ratio */
        display: block;
        /* Prevent any extra space below the image */
    }

    #thumbnails {
        width: 100%;
        /* Ensure thumbnails container takes full width */
        margin-top: 10px;
        /* Add some margin space */
        text-align: center;
        /* Center thumbnails horizontally */
        /* margin-left: 0; Reset margin-left */
    }

    .thumbnail {
        max-width: 20%;
        /* Set maximum width for the thumbnails */
        height: auto;
        /* Maintain aspect ratio */
        margin: 5px;
        /* Add some margin between thumbnails */
        display: inline-block;
        /* Display thumbnails inline */
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div id="image-container">
                @if(!empty($product->url))
                <a href="{{ Storage::url('product_images/' . $product->url) }}" data-lightbox="images" data-title="{{$product->url}}">
                    <img src="{{ Storage::url('product_images/' . $product->url) }}" alt="Image 1" class="main-image-prod">
                    @else
                    <img src="{{ '/storage/product_images/no-image-2.png' }}" alt="Image 1" class="main-image-prod">
                    @endif
                </a>

                <div id="thumbnails">
                    @if(!empty($prod_add_image))
                    @foreach($prod_add_image as $additional_images)
                    <a href="{{ Storage::url('product_images/' . $additional_images['url']) }}" data-lightbox="images" data-title="{{$additional_images['url']}}">
                        <img src="{{ Storage::url('product_images/' . $additional_images['url']) }}" alt="Thumbnail 1" class="thumbnail">
                    </a>
                    @endforeach
                    @else
                    <img src="{{ '/storage/product_images/no-image-2.png' }}" class="images-preview-div-additional-holder" alt="Image Preview" style="width: 250px;height: auto; border: 2px dashed #cacaca;">
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><b>{{$product->name}}</b></h4>
                    <p class="card-text">Price: {{ $product->price }}</p>
                    <p class="card-text">{{$product->description}}.</p>
                    <!-- Display Color Options -->
                    @if(count($colorNames) > 0)
                    <div>
                        <p>Select Color:</p>
                        @foreach($colorNames as $colorName)
                        <input type="radio" id="{{ $colorName }}" name="color" value="{{ $colorName }}" style="display: inline-block;">
                        <label for="{{ $colorName }}" style="display: inline-block; margin-right: 10px;">{{ $colorName }}</label>
                        @endforeach
                    </div>
                    @endif

                    <!-- Display Size Options -->
                    @if(count($sizeNames) > 0)
                    <div>
                        <p>Select Size:</p>
                        @foreach($sizeNames as $sizeName)
                        <input type="radio" id="{{ $sizeName }}" name="size" value="{{ $sizeName }}" style="display: inline-block;">
                        <label for="{{ $sizeName }}" style="display: inline-block; margin-right: 10px;">{{ $sizeName }}</label>
                        @endforeach
                    </div>
                    @endif
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    <input id="quantity" type="number" class="form-control quantity-input product_quantity" min="1">
                    <br>
                    <a href="#" class="btn btn-warning text-white add-to-cart-btn" data-product-id="{{ $product->pid }}">Add to Cart</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Lightbox initialization
    $(document).ready(function() {
        // Initialize Lightbox
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        fetchCartItemCount();
        fetchCartItem();
    });
</script>
@endsection