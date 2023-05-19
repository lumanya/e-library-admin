@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{ ($viewdata->title) ? $viewdata->title : '-'}}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 plr-20 pb-20 book-detail-image">
                            <div class="w-315">
                                <a id="home">
                                    <img class="image_on obj-fit-cov max-hw-315 w-100" src="{{ getSingleMedia($viewdata,'cover_image', null) }}" alt="logo" />
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto">
                                {!!Form::label('name',trans('messages.field_name',['field' => trans('messages.audio')]), array('class'=>'form-control-label'))!!}
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto">
                                {{ ($viewdata->name) ? $viewdata->name : '-'}}
                            </div>
                        </div>
                        <div class="col-md-12 mt-10">
                            <div class="rateYo m-auto" data-rating="{{ $like_count }}"> </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto"> {{ trans('messages.from') }} ({{ $view_count }}) {{ trans('messages.users') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
