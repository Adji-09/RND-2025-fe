@extends('layouts.master')

@section('title') {{ $title }} @endsection

@section('css')
    <link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/js/pages/dashboard-crm.init.js') }}"></script>
@endsection
