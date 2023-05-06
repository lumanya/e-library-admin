@extends('template_partials.index')

@section('content')

<div class="col-md-6 offset-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : "List" }}</h3>
            <a href="{{ route('mobileslider.index') }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> Back</a>
        </div>
        <div class="card-block pall-10">
            {!! Form::open(['route' => 'mobileslider.store','files'=>true]) !!}
            {!! Form::hidden('mobile_slider_id', isset($slider_data->mobile_slider_id) ? $slider_data->mobile_slider_id : '') !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!!Form::label('File','Image *',array('class'=>'form-control-label'))!!}
                            <div class="custom-file">
                                <input id="image" value="{{isset($slider_data->image) ?$slider_data->image: ''}}" name="image" {{ !isset($slider_data->image) ? 'required' : ''}} type="file" class="custom-file-input custom-file-input-sm detail form-control-sm" onchange="readURL(this);">
                                    
                                    {!!Form::label('File',isset($slider_data->image)?$slider_data->image:'',array('id'=>'imagelabel','class'=>'custom-file-label'))!!}
                                    @if ($errors->has('image'))
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    @endif
                            </div>
                        </div>   
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        @php
                            $default=URL::asset(\Config::get('constant.NO_IMAGE.DEFAULT_IMAGE'));
                                if(isset($slider_data->image)){
                                $slider_image = fileExitsCheck($default,'/uploads/mobile_slider/',$slider_data->image) ;
                                }else{
                                $slider_image = $default;
                            }
                        @endphp
                        <img id="slider_image"  src="{{ $slider_image}}" class="img rounded-circle w-100 img-responisve image d-block ml-20 mb-20">
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