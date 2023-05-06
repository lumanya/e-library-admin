@extends('layouts.master')

@section('content')

<div class="col-md-6 offset-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : trans('messages.list') }}</h3>
            <a href="{{ route('mobileslider.index') }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
        </div>
        <div class="card-block pall-10">
            {!! Form::model($slider_data,['route' => 'mobileslider.store','files'=>true]) !!}
            {!! Form::hidden('mobile_slider_id', isset($slider_data->mobile_slider_id) ? $slider_data->mobile_slider_id : '') !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!!Form::label('image',trans('messages.image')." *",array('class'=>'form-control-label'))!!}
                            <div class="custom-file">
                                    {!!Form::file('slide_image',['accept'=>'image/*','class'=>'custom-file-input custom-file-input-sm detail','onchange'=>"readURL(this);"])!!}
                                    {!!Form::label('Image',isset($slider_data->slide_image)?$slider_data->slide_image:'',array('id'=>'imagelabel','class'=>'custom-file-label'))!!}
                                    <div class="help-block with-errors"></div>  
                            </div>
                        </div>   
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <img id="slider_image"  src="{{ getSingleMedia($slider_data,'slide_image',null)}}" class="img w-75 h-50 img-responisve image d-block mb-20">
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit(trans('messages.save'),['class' => 'btn btn-md btn-primary pull-right']) !!}
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
        
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#slider_image').attr('src', e.target.result);
                    $("#imagelabel").text((input.files[0].name));
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
@endsection