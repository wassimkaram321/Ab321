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
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Edit Product') }}</h6>
            <div class="mt-5">
                <form action="{{ route('products.update', ['product' => $product]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col col-md-4 border-left-primary mb-2">
                            <label for="name">{{ __('Product Name') }}</label>
                            <input value="{{ $product->name }}" class="form-control" type="text" name="name"
                                id="name">
                        </div>
                        <div class="col col-md-4 border-left-primary mb-2">
                            <label for="description">{{ __('Product Description') }}</label>
                            <input value="{{ $product->description }}" class="form-control" type="text"
                                name="description" id="description">
                        </div>
                        <div class="col col-md-4 border-left-primary mb-2">
                            <label for="price">{{ __('Product Price') }}</label>
                            <input value="{{ $product->price }}" class="form-control" type="number" name="price"
                                id="price">
                        </div>
                        <div class="col col-md-4 border-left-primary mb-2">
                            <label for="price">{{ __('Product Categories') }}</label>
                            <select class="js-example-basic-multiple" name="categories[]" multiple="multiple">
                                @foreach ($categories as $cat)
                                    <option <?php if (
                                        in_array(
                                            $cat->id,
                                            $product
                                                ->categories()
                                                ->pluck('category_id')
                                                ->toArray(),
                                        )
                                    ) {
                                        echo 'selected';
                                    } ?> value="{{ $cat->id }}">{{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col col-md-4 border-left-primary mb-2">

                            <label for="image">{{ __('Product Image') }}</label>
                            <input class="form-control" type="file" name="image" id="image">
                        </div>
                        <img class="mini_image" src="{{ asset('images/products' . '/' . $product->image) }}"
                            alt="">
                    </div>
                    <div class="col col-md-4 mb-2">
                        <label for="">{{ __('Create Variant') }}</label>
                        <a id="create-variant-link" class="btn btn-primary btn-circle .btn-lg btn-create">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                        </a>
                    </div>

                    <div id="container">
                        <div class="row">
                            @foreach ($variants as $index => $variant)
                                <div class="form-group row" id="form-group">
                                    <div class="col col-md-2">

                                        <label for="">{{ __('Variant Name ') . ($index + 1) }}</label>
                                    </div>
                                    <div class="col col-md-2">

                                        <input value="{{ $variant->title }}" class="form-control" type="text"
                                            name="variant_name{{ $index + 1 }}" id="variant_name{{ $index + 1 }}">

                                    </div>
                                    <div class="col col-md-2">

                                        <label for="">{{ __('Variant Content ') . ($index + 1) }}</label>
                                    </div>
                                    <div class="col col-md-2">

                                        <input value="{{ $variant->content }}" class="form-control" type="text"
                                            name="variant_content{{ $index + 1 }}"
                                            id="variant_content{{ $index + 1 }}">

                                    </div>
                                    <div class="col col-md-2">

                                        <a class="btn btn-danger btn-circle remove-variant"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            @endforeach

                    </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Image Gallery</label>
                        <div class="col-sm-10">
                            <div id="multi_image_picker" name="images[]" class="row">
                                @foreach(json_decode($product->images) as $image)
                                <img class="med_image" src="{{ asset('images/products' . '/' . $image) }}" alt="">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="ac">

                        <button class="btn btn-primary btn-icon-split" type="submit"><span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">{{ __('Save') }}</span></button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    @include('layouts.partials.scripts')
    <script>
        $(document).ready(function() {
            var i = {{ count($variants) + 1 }};

            $('#create-variant-link').click(function() {
                var newRow = $('<div class="row"></div>');
                var label = $('<label>Variant Name ' + (i) + '</label>');
                var input = $('<input type="text" name="variant_name' + i + '"  id="variant_name' + i +
                    '" class="form-control" />');
                var label2 = $('<label>Variant Content ' + (i) + '</label>');
                var input2 = $('<input type="text" name="variant_content' + i + '" id="variant_content' +
                    i + '" class="form-control" />');
                var deleteButton = $(
                        '<button class="btn btn-danger btn-circle"><i class="fas fa-trash"></i></button>')
                    .click(function() {
                        label.remove();
                        input.remove();
                        label2.remove();
                        input2.remove();
                        $(this).remove();
                        i--;
                    });
                newRow.append(
                    $('<div class="col col-md-2"></div>').append(label),
                    $('<div class="col col-md-2"></div>').append(input),
                    $('<div class="col col-md-2"></div>').append(label2),
                    $('<div class="col col-md-2"></div>').append(input2),
                    $('<div class="col col-md-2"></div>').append(deleteButton)
                );
                $('#container').append(newRow);
                i++;
            });
            $(document).on('click', '.remove-variant', function() {

                $(this).closest('.form-group').remove();
                i--;
                i++;
            });
        });
    </script>
    <script type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            // var data = {!! $product->images !!};
            // var productImages = [];

            // for (var i = 0; i < data.length; i++) {
            //     productImages.push({
            //         id: i,
            //         thumb_url: 'http://127.0.0.1:8000/images/products/' + data[i]
            //     });
            // }
            var productImages = [{
                    name: 'http://127.0.0.1:8000/images/products/default.jpg',
                    value: ''
                },
                {
                    name: 'http://127.0.0.1:8000/images/products/default.jpg',
                    value: ''
                },
                {
                    name: 'http://127.0.0.1:8000/images/products/default.jpg',
                    value: ''
                }
            ];
           

            $("#multi_image_picker").spartanMultiImagePicker({
                
                init: productImages,
                fieldName: 'images[]',
                maxCount: 5,
                rowHeight: '200px',
                groupClassName: 'col-4',
                maxFileSize: 2500,
                placeholderImage: {
                    image: 'default.png',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                
                onAddRow: function(index,fieldName) {

                    console.log(index);
                    console.log('add new row');
                },
                onRenderedPreview: function(index) {
                    console.log(index);
                    console.log('preview rendered');
                },
                onRemoveRow: function(index) {
                    console.log(index);
                },
                onExtensionErr: function(index, file) {
                    console.log(index, file, 'extension err');
                    alert('Please only input png or jpg type file')
                },
                onSizeErr: function(index, file) {
                    console.log(index, file, 'file size too big');
                    alert('File size too big');
                }
            });
        });
    </script>
