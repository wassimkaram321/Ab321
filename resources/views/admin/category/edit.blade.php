@extends('layouts.master')
@section('content')
    @include('layouts.partials.header')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Edit Category') }}</h6>
            <div class="mt-5">
                <form action="{{route('categories.update',['category'=>$category])}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col col-md-4">
                            <label for="category_name">{{ __('Category Name') }}</label>
                            <input value="{{$category->category_name}}"  class="form-control" type="text" name="category_name" id="category_name">
                        </div>
                    </div>
                    <div class="ac">
                       
                        <button class="btn btn-primary btn-icon-split" type="submit"><span class="icon text-white-50">
                            <i class="fas fa-check"></i>
                        </span>
                        <span class="text">{{ __('Update') }}</span></button>
                    </div>
                </form>
            </div>
        </div>
        
    @endsection
    