@extends('layouts.app')

@section('css')
    
@endsection

@section('title')
    <h1>THÔNG TIN NHÂN SỰ</h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::route('nhansu')}}"><i class="fa fa-dashboard"></i> Quản lý nhân sự</a></li>
        <li><a href="#">Thông tin nhân sự</a></li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-sm-12 col-md-3 col-lg-2 col-xl-1">
            @include('nhansu.menu')
        </div>
        <div class="col-12 col-sm-12 col-md-9 col-lg-10 col-xl-11">
            <section class="form-detail">
                <h2 class="page-header">
                    @yield('title_detail')
                </h2> 
                @yield('content_detail')  
            </section>            
        </div>
    </div>
@endsection

@section('script')
    @yield('script')
@endsection