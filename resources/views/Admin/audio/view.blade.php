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
                                <a id="home"><img class=" obj-fit-cov max-hw-315 w-100" src="{{ getSingleMedia($viewdata,'cover_image', null) }}" alt="logo" /></a>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto">
                                {!!Form::label('name',trans('messages.field_name',['field' => trans('messages.audio')]), array('class'=>'form-control-label'))!!}
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto">
                                {{ ($viewdata->title) ? $viewdata->title : '-'}}
                            </div>
                        </div>
                        {{-- <div class="col-md-12 mt-10 text-center">
                            <div class="m-auto">
                                {{ trans('messages.liked_by') }} ({{ $like_count }}) {{ trans('messages.users') }}
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto"> {{ trans('messages.viewed_by') }} ({{ $view_count }}) {{ trans('messages.users') }}</div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="d-inline">{{ $pageTitle }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <td>
                                        {!!Form::label('authornm',trans('messages.field_name',['field' => trans('messages.author')]).' :',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($viewdata->getAuthor)?$viewdata->getAuthor->name:'-'}}</label>
                                    </td>
                                    <td>
                                        {!!Form::label('duration',trans('messages.duration').' :', array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>
                                            {{ isset($viewdata->duration) ? $viewdata->duration : '-'}}
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!!Form::label('category',trans('messages.category').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($viewdata->categoryName)?$viewdata->categoryName->name:'-'}}</label>
                                    </td>
                                    <td>
                                        {!!Form::label('subcategory',trans('messages.subcategory').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($viewdata->subCategoryName)?$viewdata->subCategoryName->name:'-'}}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!!Form::label('likes',trans('messages.likes').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($like_count)?$like_count:'-'}}</label>
                                    </td>
                                    <td>
                                        {!!Form::label('views',trans('messages.views').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($view_count)?$view_count:'-'}}</label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
