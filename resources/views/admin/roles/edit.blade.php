@extends('layouts.master')
@section('content')
    @include('layouts.partials.header')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Edit Role') }}</h6>
            <div class="mt-5">
                <form action="{{route('roles.update',['role'=>$role])}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col col-md-4">
                            <label for="category_name">{{ __('Role Name') }}</label>
                            <input required value="{{$role->name}}" class="form-control" type="text" name="name" id="category_name">
                        </div>
                        <div style="display: none;" class="col col-md-4">
                            <label for="guard_name">{{ __('Category Name') }}</label>
                            <input hidden value="web" required class="form-control" type="text" name="guard_name" id="category_name">
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
