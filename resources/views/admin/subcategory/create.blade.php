@extends('layouts.master')
@section('content')
    @include('layouts.partials.header')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Create Subcategory') }}</h6>
            <div class="mt-5">
                <form action="{{route('subcategories.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col col-md-4">
                            <label for="name">{{ __('SubCategory Name') }}</label>
                            <input required class="form-control" type="text" name="name" id="name">
                        </div>
                        <div class="col col-md-4">
                            <label for="category_id">{{ __('Categories') }}</label>
                            <select required class="form-control mb-2" name="category_id" id="category_id">
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
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
