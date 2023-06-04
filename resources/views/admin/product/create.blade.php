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
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Create Product') }}</h6>
            <div class="mt-5">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row ">
                        <div class="col col-md-4 border-left-primary mb-2">
                            <label for="name">{{ __('Product Name') }}</label>
                            <input required class="form-control" type="text" name="name" id="name">
                        </div>
                        <div class="col col-md-4 border-left-primary mb-2">
                            <label for="description">{{ __('Product Description') }}</label>
                            <input required class="form-control" type="text" name="description" id="description">
                        </div>
                        <div class="col col-md-4 border-left-primary mb-2">
                            <label for="price">{{ __('Product Price') }}</label>
                            <input required class="form-control" type="number" name="price" id="price">
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col col-md-4 border-left-primary mb-2">
                            <label for="price">{{ __('Product Categories') }}</label>
                            <select required class="js-example-basic-multiple" name="categories[]" multiple="multiple">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col col-md-4 border-left-primary mb-2">
                            <label for="image">{{ __('Product Image') }}</label>
                            <input class="form-control" type="file" name="image" id="image">
                        </div>
                        {{-- <div class="col col-md-4 border-left-primary mb-2">
                            <label for="image">{{ __('Image Gallary') }}</label>
                            <div class="row mb-3">
                                
                                    <div id="multi_image_picker" class="row"></div>
                               
                            </div>
                
                        </div> --}}
                    </div>

                    <div class="col col-md-4 mb-2">
                        <label for="">{{ __('Create Variant') }}</label>
                        <a id="create-variant-link" class="btn btn-primary btn-circle .btn-lg btn-create">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                        </a>
                    </div>

                    <div id="container"></div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Image Gallery</label>
                        <div class="col-sm-10">
                            <div id="multi_image_picker" name="images[]" class="row"></div>
                        </div>
                    </div>


                    <div class="ac mt-5">

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
            var i = 1;
            $('#create-variant-link').click(function() {
                var newRow = $('<div class="row"></div>');
                var label = $('<label>Variant Name ' + (i ) + '</label>');
                var input = $('<input type="text" name="variant_name' + i + '"  id="variant_name' + i + '" class="form-control" />');
                var label2 = $('<label>Variant Content ' + (i ) + '</label>');
                var input2 = $('<input type="text" name="variant_content' + i + '" id="variant_content' + i + '" class="form-control" />');
                var deleteButton = $('<button class="btn btn-danger btn-circle"><i class="fas fa-trash"></i></button>').click(function() {
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
        });
    </script>
       <script type="text/javascript">
        $(function(){

            $("#multi_image_picker").spartanMultiImagePicker({
                fieldName     : 'images[]', // this configuration will send your images named "fileUpload" to the server
                maxCount      : 5,
                rowHeight     : '200px',
                groupClassName: 'col-4',
                maxFileSize   : 2500,
                placeholderImage: {
                    image: 'default.png',
                    width: '100%'
                },
                dropFileLabel : "Drop Here",
                onAddRow      : function(index){
                    console.log(index);
                    console.log('add new row');
                },
                onRenderedPreview : function(index){
                    console.log(index);
                    console.log('preview rendered');
                },
                onRemoveRow : function(index){
                    console.log(index);
                },
                onExtensionErr : function(index, file){
                    console.log(index, file,  'extension err');
                    alert('Please only input png or jpg type file')
                },
                onSizeErr : function(index, file){
                    console.log(index, file,  'file size too big');
                    alert('File size too big');
                }
            });
        });
    </script>