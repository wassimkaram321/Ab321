@extends('layouts.master')
@section('content')
    @include('layouts.partials.header')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Products') }}</h6>



        </div>
        <div class="card-body">
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-icon-split fr">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">{{ __('Create') }}</span>
            </a>
            <a href="#" class="btn btn-danger btn-icon-split fl mb-3 delete-selected-confirm">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
                <span class="text">{{ __('Delete Selected') }}</span>
            </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Product Image') }}</th>
                            <th>{{ __('Product Name') }}</th>
                            <th>{{ __('Product Description') }}</th>
                            <th>{{ __('Product Price') }}</th>
                            <th>{{ __('Actions') }}</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $index => $product)
                            <tr>
                                <td>

                                    <input type="checkbox" class="form-control"
                                        onchange="storeProductIds(this, {{ $product->id }})">
                                </td>
                                <td>
                                    <img class="mini_image" src="{{ asset('images/products' . '/' . $product->image) }}"
                                        alt="">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->price }}</td>

                                <td>
                                    <a href="#" data-id="{{ $product->id }}"
                                        class="btn btn-danger btn-circle fr delete-confirm mr-2">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </a>

                                    <a href="{{ route('products.edit', ['product' => $product]) }}"
                                        class="btn btn-info btn-circle fr mr-2">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>

                                    </a>
                                    <a href="{{ route('products.show', ['product' => $product]) }}"
                                        class="btn btn-warning  btn-circle fr mr-2">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-eye"></i>
                                        </span>

                                    </a>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@include('layouts.partials.scripts')

<script>
    $(document).ready(function() {
        $('.delete-confirm').click(function() {
            var id = $(this).data('id');
            var route = "{{ route('products.destroy', ['product' => ':id']) }}";
            route = route.replace(':id', id);
            showDeleteConfirmation(id, route);
        });
        $('.delete-selected-confirm').click(function() {
            var id = productIds;
            if (id != '') {
                var encodedIds = encodeURIComponent(JSON.stringify(productIds));
                var decodedIds = decodeURIComponent(JSON.stringify(encodedIds));
                var route = "{{ route('products_delete') }}";
                route = route.replace(':id', decodedIds);

                deleteIds(id, route);
            }
        });
    });
</script>

<script>
    let productIds = [];

    function storeProductIds(checkbox, id) {
        if (checkbox.checked) {
            productIds.push(id);
        } else {
            productIds = productIds.filter(item => item !== id);
        }

    }
</script>
{{-- <script src="https://cdnjs.deepai.org/deepai.min.js"></script>
<script>
    // const deepai = require('deepai'); // OR include deepai.min.js as a script tag in your HTML

deepai.setApiKey('44db322a-ab05-4ca4-ad61-00177870375a');

(async function() {
    var resp = await deepai.callStandardApi("image-similarity", {
            image1: "https://thumbs.dreamstime.com/z/red-black-gaming-laptop-red-black-gaming-laptop-luminous-keyboard-119291509.jpg",
            image2: "https://thumbs.dreamstime.com/z/red-black-gaming-laptop-luminous-keyboard-119291367.jpg",
    });
    console.log(resp);
})()
</script> --}}
