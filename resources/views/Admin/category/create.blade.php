@extends('layouts.master')

@section('content')
<div class="col-md-6 offset-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : trans('messages.list') }}</h3>
            <a href="{{ route('category.index') }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
        </div>
        <div class="card-block pall-10">
            {!! Form::open(['route' => 'category.store','data-toggle'=>"validator"])!!}
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::hidden('category_id', isset($category->category_id) ? $category->category_id : '') !!}
                        <div class="form-group  has-feedback">
                            {!!Form::label('name',trans('messages.field_name',['field' => trans('messages.category')]).' *',['class'=>'form-control-label'])!!}
                            {!! Form::text('name',isset($category->name) ? $category->name : null,['class'=>'form-control', 'required', 'placeholder' => trans('messages.enter_field_name',['field' => trans('messages.category')]) ])!!}
                            <div class="help-block with-errors"></div>   
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif    
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit(trans('messages.save'),['class' => 'btn btn-md btn-primary']) !!}
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('body_bottom')
<script>
    $(document).ready(function(){
        $('.category-list-item').addClass('active');
    });
</script>
@endsection