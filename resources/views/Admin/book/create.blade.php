@extends('layouts.master')


@section('content')

<div class="container-fluid">
    <div class="card ">
        <div class="card-header">
            <h3 class="d-inline">{{isset($pageTitle) ? $pageTitle: trans('messages.back') }}</h3>
            <a href="{{route('book.index')}}" class="btn btn-sm btn-primary float-right text-white d-inline">
                <i class="fa fa-angle-double-left"></i>
                {{ trans('messages.back') }}</a>
        </div>
        {!! Form::model($bookdata,['method' => 'POST','route'=>'book.store','files'=>true,'id'=>'book','data-toggle'=>"validator"] ) !!}
        @csrf
        <div class="card-body">
            <div class="col-md-12 padd-custom">
                {!! Form::hidden('book_id')!!}
                {{-- Book info panel --}}

                <div class="row text-title">
                    <div class="col-md-4">
                        <div class="form-group">    
                            {!!Form::label('name',trans('messages.field_name',['field' => trans('messages.book')]).' *',array('class'=>'form-control-label'))!!}
                            {!! Form::text('name',null,array('placeholder' => trans('messages.field_name',['field' => trans('messages.book')]),'class' =>'form-control','required')) !!}
                            <div class="help-block with-errors has-error"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('title',trans('messages.title_name',['name' => trans('messages.book')])." *",array('class'=>'form-control-label'))!!}
                            {!! Form::text('title',null, array('placeholder' => trans('messages.title_name',['name' => trans('messages.book')]),'class' =>'form-control','required')) !!}
                             <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('publisher',trans('messages.book')." ".trans('messages.publisher'),array('class'=>'form-control-label'))!!}
                            {!! Form::text('publisher',null, array('placeholder' => trans('messages.book')." ".trans('messages.publisher'),'class'=>'form-control','required')) !!}
                             <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('author',trans('messages.select_name',['select' => trans('messages.author')])." *",array('class'=>'form-control-label'))!!}
                            {!! Form::select('author_id',$author_id,null, ['class' => ' select2js form-control','required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('category_id',trans('messages.select_name',['select' => trans('messages.category')])." *",array('class'=>'form-control-label'))!!}
                            {!! Form::select('category_id',$category_id,null, ['class' => 'select2js form-control','onchange' => 'getSubCategory()',"id"=>"category",'required']) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                        {!!Form::label('subcategory_id',trans('messages.select_name',['select' => trans('messages.subcategory')])." *",array('class'=>'form-control-label'))!!}
                            <?php
                            $sub_category_arr=[];
                            if(isset($bookdata->subcategory_id)){
                                $sub_category_arr=[
                                                    $bookdata->subcategory_id =>$bookdata->subCategoryName->name
                                                ];
                            }
                            ?>
                            {!! Form::select('subcategory_id',$sub_category_arr,null, ['class' => 'select2js form-control','id'=>"subcat"]) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="from-group">
                            {!!Form::label('price',trans('messages.price') ." *",['class'=>'form-control-label'])!!}
                            {!!Form::number('price',null,['class'=>'form-control','placeholder'=>'Price','step'=>"0.01",'min'=>0.00,'id'=>'price','onfocusout' => 'setprice(this)','required'])!!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="from-group">
                            {!!Form::label('in_stock',trans('messages.qty') ." *",['class'=>'form-control-label'])!!}
                            {!!Form::number('in_stock',null,['class'=>'form-control','placeholder'=>'Qty','min'=>0,'required'])!!}
                            <div class="help-block with-errors"></div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="from-group">
                            {!!Form::label('date_of_publication',trans('messages.date_publication')." *",['class'=>'form-control-label'])!!}
                            {!!Form::text('date_of_publication',isset($bookdata->date_of_publication) ? date('d-m-Y',strtotime($bookdata->date_of_publication)) : null,[ 'class'=>'form-control calentimDatepickerCurr','placeholder'=> trans('messages.date_publication'),'required'])!!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">

                            {!!Form::label('language',trans('messages.select_name',['select' => trans('messages.language')])." *",array('class'=>'form-control-label'))!!}
                            {!! Form::select('language',$language, null , ['class' => 'select2js form-control' ,'required']) !!}
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
                    <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Page_Count',trans('messages.page_count')." *",array('class'=>'form-control-label'))!!}
                            {!! Form::number('page_count',null, array('placeholder' => trans('messages.page_count'),'min'=>0,'class' =>'form-control','required')) !!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group col-xs-6">
                            <label class="form-control-label">{{ trans('messages.discount') }} ( <i class="fas fa-percentage"></i> )</label>
                            {!!Form::number('discount',null,['placeholder'=> trans('messages.discount') ,'min'=>0,'step'=>"0.01",'class'=>'form-control','id'=>'discount'])!!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        {!!Form::label('image',trans('messages.upload') ." ".trans('messages.front_cover'),array('class'=>'form-control-label'))!!}
                        <div class="custom-file">
                            {!!Form::file('front_cover',['class'=>'custom-file-input custom-file-input-sm detail','accept'=>'image/*','onchange'=>"readURL(this,'fcover','fcoverlabel');"])!!}
                            {!!Form::label('Image',isset($bookdata->front_cover) ? $bookdata->front_cover : null,array('id'=>'fcoverlabel','class'=>'custom-file-label',''))!!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="hw-100">
                            @if(getSingleMedia($bookdata,'front_cover',null) !== '')
                            <img id="fcover" src="{{getSingleMedia($bookdata,'front_cover',null)}}" class="h-100 obj-fit-cov rounded-circle w-100 image mt-10">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        {!!Form::label('image',trans('messages.upload') ." ".trans('messages.back_cover'),array('class'=>'form-control-label'))!!}
                        <div class="custom-file col-md-12">
                            {!!Form::file('back_cover',['accept'=>'image/*','class'=>'custom-file-input custom-file-input-sm detail','onchange'=>"readURL(this,'bcover','bcoverlabel');"])!!}
                            {!!Form::label('Image',isset($bookdata->back_cover) ? $bookdata->back_cover : null,array('id'=>'bcoverlabel','class'=>'custom-file-label'))!!}
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="hw-100">
                        @if(getSingleMedia($bookdata,'back_cover',null) !== '')
                            <img id="bcover" src="{{getSingleMedia($bookdata,'back_cover',null)}}" class="h-100 obj-fit-cov rounded-circle w-100 image mt-10">
                        @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        {!!Form::label('description',trans('messages.book')." ".trans('messages.description')."  *",['class'=>'form-control-label'])!!}
                        {!! Form::textarea('description', null, ['placeholder' => trans('messages.book')." ".trans('messages.description').'...' , 'id' => 'description', 'class' => 'form-control','rows' => 5, 'required']) !!}
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header"><h3>{{ trans('messages.upload') }} {{ trans('messages.file')}}</h3></div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-12 custom-control custom-radio">
                    <div class="row">
                        <div class="col-md-12">
                            {!!Form::label('format',trans('messages.select_name',['select' => trans('messages.book_format')])." *",['class'=>'form-control-label','id'=>'radio'])!!}
                        </div>
                    </div>
                    <div class="row ml-3">
                        @if(count($book_formate)>0)
                            @foreach($book_formate as $value)
                                <div class="col-md-1 col-sm-3">
                                    {!! Form::radio('format', $value->value,$bookdata->format, ['id'=>"format_".$value->value,'class'=>"mr-10 custom-control-input"]) !!}
                                    <label class="custom-control-label" for="format_{{$value->value}}">{{$value->label}}
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <?php
                // $tag= $bookdata->file_path;
            ?>
            <div class="row ml-15 mt-4" id="pdf">
                <div id="pdftag" class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 pl-0">
                            {!!Form::label('file',trans('messages.upload'),array('class'=>'form-control-label','id'=>'upload'))!!}
                        </div>
                        <div class="custom-file col-md-4">
                            {!! Form::file('file_path',['id'=>"file_path",'class'=>"custom-file-input custom-file-input-sm detail file_path_remove",'required','onchange'=>"readURL(this,'file_path','file_path1');"]) !!}
                            {!!Form::label('File',isset($bookdata->file_path) ? $bookdata->file_path : null,array('class'=>'custom-file-label file_path_lable','id'=>'file_path1' ))!!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="custom-file col-md-4">
                            
                          
                                <button type="button" @if ($bookdata->book_id)  onclick="myFunction2({{ $bookdata->book_id }},'file_path')" @else  onclick="myFunction2()"  @endif  class="btn btn-sm btn-danger" ><i class="fa fa-trash"></i></button>
                                
                           
                        </div>
                    </div>
                </div>
                <div id="pdftag" class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 pl-0">
                            {!!Form::label('file',trans('messages.upload_sample'),array('class'=>'form-control-label','id'=>'upload1'))!!}
                        </div>
                        <div class="custom-file col-md-4">
                            {!! Form::file('file_sample_path',['id'=>"file_sample_path",'class'=>"custom-file-input custom-file-input-sm detail file_sample_path",'required','onchange'=>"readURL(this,'file_sample_path','file_sample_path1');"]) !!}
                            {!!Form::label('File',isset($bookdata->file_sample_path) ? $bookdata->file_sample_path : null,array('class'=>'custom-file-label','id'=>'file_sample_path1' ))!!}
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="custom-file col-md-4">
                            
                            {{-- <button type="button" @if ($bookdata->book_id) href="{{ route('book.removefile',[isset($bookdata->book_id) ? $bookdata->book_id:0,'file_sample_path']) }}"  onclick="myFunction3()" @else  onclick="myFunction3()"  @endif  class="btn btn-sm btn-danger" ><i class="fa fa-trash"></i></button> --}}
                            <button type="button" @if ($bookdata->book_id)  onclick="myFunction3({{ $bookdata->book_id }},'file_sample_path')" @else  onclick="myFunction3()"  @endif  class="btn btn-sm btn-danger" ><i class="fa fa-trash"></i></button>
                            {{-- <a type="button" @if ($bookdata->book_id)  onclick="myFunction3()" @else  onclick="myFunction3()"  @endif  class="btn btn-sm btn-danger" ><i class="fa fa-trash"></i></a> --}}
                           
                        </div>
                    </div>
                </div>
                <div class="col-md-1 mt-30 pl-0">
                    {!! Form::submit('Save', ['class'=>'btn btn-md btn-primary']) !!} 
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- End upload book  -->
</div>
@endsection
@section('body_bottom')

<script type="text/javascript">
    $(document).ready(function(){
        // $('#format_pdf').attr('checked',true);
        $('#upload').text( "{{ trans('messages.upload') }} {{ trans('messages.pdf') }} ");
        $('#upload1').text( "{{ trans('messages.upload_sample') }} {{ trans('messages.pdf') }} ");
        $('#subcat').select2({
            placeholder: "{{ trans('messages.select_name',['select' => trans('messages.subcategory')]) }}",
            width: '100%'
        });
        if($('#category :selected').val()){
            getSubCategory();
        }
        uploadType();
        $('input[name=format]').change(function() {
            uploadType();
        });
    });

    function uploadType(){
        $text= " {{ trans('messages.select_name',['select' => trans('messages.your_choice')]) }} ";
        $case=$('input[name=format]:checked').val();
        switch ($case) {
            case 'pdf':$text=" {{ trans('messages.pdf') }} ";
                        $case='application/pdf';
                        break;
            case 'epub':$text=" {{ trans('messages.epub') }} ";
                        $case='.epub';
                        break;
        }
        $('#upload').text("{{ trans('messages.upload') }}" +$text);
        $('#upload1').text("{{ trans('messages.upload_sample') }}" +$text);
        $('#file_path').attr('accept',$case).attr('src','');
        $('#file_sample_path').attr('accept',$case).attr('src','');
    }

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


function myFunction2(id,type){
let path = '{{ url("/") }}';

   if (confirm("ARE YOU SURE WANT TO DELETE !")) {
    txt = "You pressed OK!";

    $('.file_path_remove').attr('src',null);
 $('.file_path_remove').val('');
 $('#file_path1').html('File');

$.ajax({
            url: `${path}/admin/book-removefile/${id}/${type}`,
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

  function myFunction3(id,type){
    let path = '{{ url("/") }}';
     if (confirm("ARE YOU SURE WANT TO DELETE !")) {
    txt = "You pressed OK!";

    $('.file_path_remove').attr('src',null);
$('.file_sample_path').val('');
$('#file_sample_path1').html('File');

$.ajax({
            url: `${path}/admin/book-removefile/${id}/${type}`,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
               console.log(data);
            }
        });



  } else {
    txt = "You pressed Cancel!";
  }
    

  }

</script>
<script>
    function setprice(ele) {
       // console.log(ele.value);
        if(ele.value <= 0 && ele.value !== ""){            
          document.getElementById("discount").disabled = true;
        //  console.log("hello");
        } else{
            document.getElementById("discount").disabled = false;
           // console.log('abc');
        }


}

</script>

@endsection
