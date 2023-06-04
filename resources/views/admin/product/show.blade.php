@extends('layouts.master')
@section('content')
    @include('layouts.partials.header')
    <style>
        .select2-container {
            box-sizing: border-box;
            display: inline !important;
            margin: 0;
            position: relative;
            vertical-align: middle;
        }
    </style>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Product Details') }}</h6>
            <div class="mt-5">
                <form action="{{ route('products.index') }}" method="GET">

                    <div class="row">
                        <div class="col col-md-4">
                            <label for="name">{{ __('Product Name') }}</label>
                            <p class="text-primary">{{ $product->name }}</p>
                        </div>
                        <div class="col col-md-4">
                            <label for="description">{{ __('Product Description') }}</label>
                            <p class="text-primary">{{ $product->description }}</p>
                        </div>
                        <div class="col col-md-4">
                            <label for="price">{{ __('Product Price') }}</label>
                            <p class="text-primary">{{ $product->price }}</p>
                        </div>
                        <div class="col col-md-4">
                            <label for="price">{{ __('Product Categories') }}</label>

                            @foreach ($categories as $cat)
                                <p class="text-primary">{{ $cat->category_name }}</p>
                            @endforeach

                        </div>
                        <div class="col col-md-4">
                            <label for="image">{{ __('Product Image') }}</label>
                            <br>
                            <img class="mini_image" src="{{ asset('images/products' . '/' . $product->image) }}"
                                alt="">
                        </div>


                    </div>
                    <br>
                    <div class="row">
                        <label for="image">{{ __('Product Gallery') }}</label>
                        @foreach (json_decode($product->images) as $image)
                            <div class="col col-sm-1">
                                <img class="mini_image" src="{{ asset('images/products' . '/' . $image) }}"
                                    alt="">
                            </div>
                        @endforeach
                    </div>


                    <h6 class="m-0 font-weight-bold text-primary">{{ __('Variants') }}</h6>

                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>{{ __('Variant Name') }}</th>
                                    <th>{{ __('Variant Content') }}</th>


                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($variants as $variant)
                                    <tr>

                                        <td>{{ $variant->title }}</td>
                                        <td>{{ $variant->content }}</td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="ac mt-5">

                        <button class="btn btn-primary btn-icon-split" type="submit"><span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">{{ __('Back') }}</span></button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    @include('layouts.partials.scripts')
