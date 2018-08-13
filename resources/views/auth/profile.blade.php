@extends('layouts.form') 

@section('css')
    
@endsection

@section('content')
  <h2 class="page-header">
      CẬP NHẬT HỒ SƠ CÁ NHÂN                                                    
  </h2>
  <form class="form-horizontal" method="POST" action="{{ route('profile') }}">
    {{ csrf_field() }} 
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <label for="name" class="control-label">Tên</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" autofocus required tabindex="1">

                <label for="name" class="control-label">Tài khoản</label>
                <input type="text" class="form-control" id="username" disabled value="{{$user->username}}" tabindex="2" required>

                <label for="email" class="control-label">Email</label>
                <input type="email" class="form-control" id="email" value="{{$user->email}}" tabindex="3">

                <label for="role" class="control-label">Quyền</label>  
                <input type="text" class="form-control" id="role" disabled value="{{$user->role->name}}" tabindex="4">
            </div>
        </div>
    </div>

    <div class="box-footer">                    
        <button type="submit" class="btn bg-olive btn-flat pull-right" tabindex="6">
            <i class="fa fa-edit"></i> {{__('button.edit')}}
        </button>                     
        <a href="{{route('home')}}" id="btnback" class="btn btn-default btn-flat" tabindex="7">
            <i class="fa fa-undo"></i> {{__('button.back')}}
        </a>
        <a href="#" data-toggle="modal" data-target="{{'#modal-auth-changepassword-' . $user->id}}" class="btn bg-olive btn-flat" tabindex="5">
            <i class="fa fa-undo"></i> Thay đổi mật khẩu
        </a>
       
    </div>                                                
  </form>
  @include('auth.passwords.change')
@endsection


