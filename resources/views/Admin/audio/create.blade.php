@extends('layouts.master')


@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="d-inline">{{isset($pageTitle) ? $pageTitle: trans('messages.back') }}</h3>
            <a href="{{route('audio.index')}}" class="btn btn-sm btn-primary float-right text-white d-inline">
                <i class="fa fa-angle-double-left"></i>
                {{ trans('messages.back') }}
            </a>
        </div>
        {!! Form::model($audiodata,['method' => 'POST', 'route'=>'audio.store', 'files'=>true, 'id'=>'audio', 'data-toggle'=>"validator"] ) !!}
        @csrf
        <div class="card-body">
            <div class="col-md-12 padd-custom">
                {!! Form::hidden('audio_id')!!}

                <div class="row text-title">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('title', trans('messages.title_name', ['name' => trans('messages.audio')])." *", array('class' => 'form-control-label')) !!}
                            {!! Form::text('title',null, array('placeholder' => trans('messages.title_name',['name' => trans('messages.audio')]),'class' =>'form-control','required')) !!}
                             <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Keywords',trans('messages.keywords')." *",array('class'=>'form-control-label'))!!}
                            {!! Form::text('keywords',null, array('placeholder' => trans('messages.keywords'),'class' =>'keywords form-control','data-role'=>"tagsinput",'required')) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('author', trans('messages.select_name',['select' => trans('messages.author')])." *",array('class'=>'form-control-label'))!!}
                            {!! Form::select('author_id', $author_id, null, ['class' => ' select2js form-control', 'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('category_id', trans('messages.select_name',['select' => trans('messages.category')])." *",array('class' =>'form-control-label'))!!}
                            {!! Form::select('category_id', $category_id, null, ['class' => 'select2js form-control','onchange' => 'getSubCategory()',"id"=>"category",'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        {!!Form::label('subcategory_id',trans('messages.select_name',['select' => trans('messages.subcategory')])." *",array('class'=>'form-control-label'))!!}
                            <?php
                            $sub_category_arr = [];
                            if(isset($audiodata->subcategory_id)){
                                $sub_category_arr=[
                                                    $audiodata->subcategory_id => $audiodata->subCategoryName->name
                                                ];
                            }
                            ?>
                            {!! Form::select('subcategory_id', $sub_category_arr,null, ['class' => 'select2js form-control','id'=>"subcat"]) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        {!!Form::label('image',trans('messages.upload') ." ".trans('messages.cover_image'),array('class'=>'form-control-label'))!!}
                        <div class="custom-file">
                            {!!Form::file('cover_image',['class'=>'custom-file-input custom-file-input-sm detail','accept'=>'image/*','onchange'=>"readURL(this,'fcover','fcoverlabel');"])!!}
                            {!!Form::label('Image',isset($audiodata->cover_image) ? $audiodata->cover_image : null, array('id'=>'fcoverlabel','class'=>'custom-file-label', ''))!!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="hw-100">
                            @if(getSingleMedia($audiodata,'cover_image',null) !== '')
                            <img id="fcover" src="{{getSingleMedia($audiodata,'cover_image',null)}}" class="h-100 obj-fit-cov rounded-circle w-100 image mt-10">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row ml-1">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 pl-0">
                                {!!Form::label('file',trans('messages.upload'),array('class'=>'form-control-label','id'=>'upload'))!!}
                            </div>
                            <div class="custom-file col-md-4">
                                {!! Form::file('auio_file_path',['id'=>"file_path",'class'=>"custom-file-input custom-file-input-sm detail file_path_remove", 'accept'=>'audio/*', 'required','onchange'=>"readURL(this,'audio_file_path','file_path1');"]) !!}
                                {!!Form::label('File',isset($audiodata->audio_file_path) ? $audiodata->audio_file_path : null,array('class'=>'custom-file-label file_path_lable','id'=>'file_path1' ))!!}
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="custom-file col-md-4">
                                <button type="button" @if ($audiodata->audio_id)  onclick="myFunction2({{ $audiodata->audio_id }},'audio_file_path')" @else  onclick="myFunction2()"  @endif  class="btn btn-sm btn-danger" ><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mt-3">
                        {!!Form::label('description',trans('messages.audio')." ".trans('messages.description')." ",['class'=>'form-control-label'])!!}
                        {!! Form::textarea('description', null, ['placeholder' => trans('messages.audio')." ".trans('messages.description').'...' , 'id' => 'description', 'class' => 'form-control','rows' => 5]) !!}
                        <div class="help-block with-errors"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-1 mt-30 pl-0">
                        {!! Form::submit('Save', ['class'=>'btn btn-md btn-primary']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('body_bottom')

<script type="text/javascript">
    $(document).ready(function(){
        // $('#format_pdf').attr('checked',true);
        $('#upload').text( "{{ trans('messages.upload') }} {{ trans('messages.audio') }} ");
        $('#subcat').select2({
            placeholder: "{{ trans('messages.select_name',['select' => trans('messages.subcategory')]) }}",
            width: '100%'
        });
        if($('#category :selected').val()){
            getSubCategory();
        }
        // uploadType();
        // $('input[name=format]').change(function() {
        //     uploadType();
        // });
    });

    function getSubCategory() {
        var category = $('#category :selected').val();
        var subcategory = $('#subcat :selected').val();
        $.ajax({
            url: '{{route("subcategory.dropdown")}}',
            type: 'GET',
            data: {
                'category_id': category
            },
            dataType: 'JSON',
            success: function (data) {
                $('#subcat').empty();
                data=data.data;
                $.each(data, function (key, value) {
                    var selected = (value.subcategory_id == subcategory) ? "selected" : "";
                    $('#subcat').append('<option value="' + value.subcategory_id +'"'+ selected +'>' + value.name + '</option>');
                })
            }
        });
    }

    function readURL(input, id ,labelid) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#" + id).attr('src', e.target.result);
                $("#" + labelid).text((input.files[0].name));
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function myFunction() {
        var txt;
        if (confirm("Press a button!")) {
            txt = "You pressed OK!";
        } else {
            txt = "You pressed Cancel!";
        }
        document.getElementById("demo").innerHTML = txt;
    }

    function myFunction2(id, type){
        let path = '{{ url("/") }}';

        if (confirm("ARE YOU SURE WANT TO DELETE !")) {
            txt = "You pressed OK!";

            $('.file_path_remove').attr('src',null);
        $('.file_path_remove').val('');
        $('#file_path1').html('File');

        $.ajax({
                    url: `${path}/admin/audio-removefile/${id}/${type}`,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (data) {
                    console.log(data);
                    }
                });

        }else {
            txt = "You pressed Cancel!";
        }
    }
</script>

@endsection
