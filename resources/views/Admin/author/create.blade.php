@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : trans('messages.list') }}</h3>
            <a href="{{ route('author.index') }}" class="btn btn-sm btn-primary float-right d-inline"><i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
        </div>
        <div class="card-block pall-30">
            {!! Form::model($author_data,['route' => 'author.store','files'=>true,'data-toggle'=>"validator"]) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! Form::hidden('author_id') !!}
                        <div class="form-group">
                            {!!Form::label('name',trans('messages.field_name',['field' => trans('messages.author')]).' *',['class'=>'form-control-label'])!!}
                            {!! Form::text('name', null, ['class'=>'form-control', 'required', 'placeholder' => trans('messages.enter_field_name',['field' => trans('messages.author')])]) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('designation',trans('messages.designation')." *",['class'=>'form-control-label'])!!}
                            {!! Form::text('designation', null, ['class'=>'form-control', 'required', 'placeholder' => trans('messages.enter_field_name',['field' => trans('messages.designation')])]) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('education',trans('messages.education')." *",['class'=>'form-control-label'])!!}
                            {!! Form::text('education', null, ['class'=>'form-control', 'required', 'placeholder' => trans('messages.enter_field_name',['field' => trans('messages.education')])]) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('mobile',trans('messages.mobile'),['class'=>'form-control-label'])!!}
                            {!! Form::text('mobile', null, ['class'=>'form-control', 'pattern'=>"[0-9]{6,12}", 'placeholder' => trans('messages.enter_field',['field' => trans('messages.mobile')])]) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('email',trans('messages.email'),['class'=>'form-control-label'])!!}
                            {!! Form::email('email', null, ['class'=>'form-control', 'placeholder' => trans('messages.enter_field',['field' => trans('messages.email')])]) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form-group">
                                {!!Form::label('address',trans('messages.address'),['class'=>'form-control-label'])!!}
                                {!! Form::text('address',null,['class'=>'form-control', 'placeholder' => trans('messages.enter_field',['field' => trans('messages.address')] ) ]) !!}
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                {!!Form::label('image',trans('messages.upload') ." ".trans('messages.profile_picture') ,array('class'=>'form-control-label'))!!}
                                <div class="custom-file">
                                    {!! Form::file('profile_image', ['id'=>"profile_image", 'class'=>"custom-file-input custom-file-input-sm detail form-control-sm", 'accept'=>'image/*', 'onchange'=>"readURL(this);"]) !!}
                                    {!!Form::label('Image',isset($author_data->profile_image) ? $author_data->profile_image : '',array('id'=>'imagelabel','class'=>'custom-file-label',''))!!}
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="hw-150 m-auto">
                                    <img id="author_profile" src="{{getSingleMedia($author_data,'profile_image',null)}}" class="h-100 obj-fit-cov rounded-circle w-100 image mt-10">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            {!!Form::label('description',trans('messages.description')." *",['class'=>'form-control-label'])!!}
                            {!! Form::textarea('description',null,['class'=>'form-control','rows' => 8, 'required', 'placeholder' => trans('messages.enter_field',['field' => trans('messages.description')]) ]) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::submit(trans('messages.save'),['class' => 'btn btn-md btn-primary pull-right']) !!}
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('body_bottom')
<script>
    $(document).ready(function(){
        $('.author-list-item').addClass('active');
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#author_profile').attr('src', e.target.result);
                $("#imagelabel").text((input.files[0].name));
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
