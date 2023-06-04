@extends('layouts.master')
@section('content')
    @include('layouts.partials.header')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Edit User') }}</h6>
            <div class="mt-5">
                <form action="{{route('users.update',['user'=>$user])}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col col-md-4">
                            <label for="name">{{ __('User Name') }}</label>
                            <input required value="{{$user->name}}" class="form-control" type="text" name="name" id="name">
                        </div>
                        <div class="col col-md-4">
                            <label for="name">{{ __('User Email') }}</label>
                            <input required value="{{$user->email}}" class="form-control" type="email" name="email" id="email">
                        </div>
                        <div class="col col-md-4">
                            <label for="name">{{ __('User Password') }}</label>
                            <input   class="form-control" type="password" name="password" id="password">
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
