@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>{{($viewdata->title)?$viewdata->title:'-'}}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 plr-20 pb-20 book-detail-image">
                            <div class="w-315">
                                <a id="home">
                                    <img class="image_on obj-fit-cov max-hw-315 w-100" src="{{ getSingleMedia($viewdata,'front_cover',null) }}" alt="logo" />
                                    <img class="image_off obj-fit-cov max-hw-315 w-100" src="{{ getSingleMedia($viewdata,'back_cover',null) }}" alt="logo" /></a>    
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto">
                                {!!Form::label('name',trans('messages.field_name',['field' => trans('messages.book')]),array('class'=>'form-control-label'))!!}
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto">
                                {{($viewdata->name)?$viewdata->name:'-'}}
                            </div>
                        </div>
                        <div class="col-md-12 mt-10">
                            <div class="rateYo m-auto" data-rating="{{ $avg_rating }}"> </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="m-auto"> {{ trans('messages.from') }} ({{ $count_rating }}) {{ trans('messages.users') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                   <h3 class="d-inline">{{$pageTitle}}</h3>
                    <a id="back" href="{{ isset($extra['redirect_url']) ? $extra['redirect_url'] : route('book.index')}}"  class="btn btn-sm btn-primary float-right text-white inline ml-3"> <i class="fa fa-angle-double-left"></i> {{ trans('messages.back') }}</a>
                    @if($viewdata->format == 'pdf' || $viewdata->format == 'video')
                        
                        {{-- <a class="btn btn-sm btn-primary float-right text-white inline  ml-3" href="{{getSingleMedia($viewdata,'file_sample_path','',$viewdata->format)}} " target="_blank"><i class="fa fa-eye"></i> {{ trans('messages.open') }} {{$viewdata->format}}</a> --}}
                    @endif
                   {{-- @if($viewdata->format == 'video' )
                        @php
                            $default = \URL::asset('assets/sample_file/sample.mp4');
                            $file_sample_path = $default;
                            if(isset($viewdata->file_sample_path) && $viewdata->file_sample_path != null) {
                                $file_sample_path = fileExitsCheck($default,'uploads/sample-file',$viewdata->file_sample_path);
                            }
                        @endphp
                        <a class="btn btn-sm btn-primary float-right text-white inline  ml-3" href="{{ $file_sample_path }} " target="_blank"><i class="fa fa-eye"></i> {{ trans('messages.open') }} {{$viewdata->format}}</a>
                    @endif
                    --}}
                    @if($viewdata->format =='epub')
                     {{--  @php
                            $default = \URL::asset('assets/sample_file/sample.epub');
                            $file_sample_path = $default;
                            if(isset($viewdata->file_sample_path) && $viewdata->file_sample_path != null) {
                                $file_sample_path = fileExitsCheck($default,'uploads/sample-file',$viewdata->file_sample_path);
                            }
                        @endphp 
                    <!-- <a class="btn btn-sm btn-primary float-right text-white inline  ml-3" href="{{"https://www.ofoct.com/viewer/viewer_url.php?fileurl=".$file_sample_path}} " target="_blank"><i class="fa fa-eye"></i> {{ trans('messages.open') }} {{ trans('messages.epub') }}</a> -->
                    --}}
                    <?php
                        $url = str_replace( 'https://', 'http://', getSingleMedia($viewdata,'file_sample_path','','epub'));
                    ?>
                    <a class="btn btn-sm btn-primary float-right text-white inline  ml-3" href="{{"https://www.ofoct.com/viewer/viewer_url.php?fileurl=".$url}} " target="_blank"><i class="fa fa-eye"></i> {{ trans('messages.open') }} {{ trans('messages.epub') }}</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <td>
                                        {!!Form::label('date_of_publication',trans('messages.date_publication').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($viewdata->date_of_publication)? showDate($viewdata->date_of_publication):'-'}}</label>
                                    </td>
                                    <td>
                                        {!!Form::label('lang',trans('messages.language').' :',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($book_language->value)?$book_language->value:'-'}}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!!Form::label('authornm',trans('messages.field_name',['field' => trans('messages.author')]).' :',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($viewdata->getAuthor)?$viewdata->getAuthor->name:'-'}}</label>
                                    </td>
                                    <td>
                                        {!!Form::label('bookpublisher',trans('messages.book')." ".trans('messages.publisher').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{isset($viewdata->publisher)?$viewdata->publisher:'-'}}</label>
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
                                        {!!Form::label('price',trans('messages.price').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{ money(optional($viewdata)->price)}}</label>
                                    </td>
                                    <td>
                                        {!!Form::label('qty',trans('messages.quantity').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{max(optional($viewdata)->in_stock,0)}}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!!Form::label('discount',trans('messages.discount').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label>{{max(optional($viewdata)->discount,0)}} %</label>
                                    </td>
                                    <td>
                                            {!!Form::label('format',trans('messages.format').' : ',array('class'=>'form-control-label'))!!}
                                    </td>
                                    <td>
                                        <label class="text-uppercase">{{isset($viewdata->format)?$viewdata->format :'-'}}</label>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(count($viewdata->getBookRating) > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="d-inline">{{ trans('messages.list_of_books_review_rating') }}</h3>
            </div>
            <div class="col-md-12 mt-4 mb-4">
                @foreach ($viewdata->getBookRating as $rating)
                    <div class="card shadow mb-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="hw-80">
                                        @php
                                            $default=URL::asset(\Config::get('constant.DEFAULT_IMAGE'));
                                                if(isset(optional($rating->getUsername)->image)){
                                                    $image = fileExitsCheck($default,'/uploads/profile-image',(optional($rating->getUsername)->image));
                                                }else{
                                                    $image = $default;
                                                }
                                        @endphp
                                        <!-- <img src="{{ $image }}" class="book-detail-user-rating-img obj-fit-cov max-hw-80"> -->
                                        <img src="{{ getSingleMedia($rating->getUsername,'image',null) }}"  class="book-detail-user-rating-img obj-fit-cov max-hw-80">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h3>{{ isset($rating->getUsername) ? ucwords($rating->getUsername->name) : '' }}</h3>
                                    <p class="description">{{ $rating->review}}</p>
                                </div>
                                <div class="col-md-3">
                                    <div class="rateYo" data-rating="{{ $rating->rating }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($viewdata->description)
    <div class="card mt-3">
        <div class="card-header"><h3>{{ trans('messages.book') }} {{ trans('messages.description') }}:</h3></div>
        <div class="col-md-12 mb-3">
            <div class="ml-3 col-md-12 mt-3">
                <div>
                    <?php echo html_entity_decode(optional($viewdata)->description); ?>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection
@section('body_bottom')
    <script>
        $(".rateYo").each(function(){
            var rating = $(this).attr("data-rating");
            $(this).rateYo({
                rating: rating,
                readOnly: true,
            });
        });
        $('.book-list-item').addClass('active');
    </script>
@endsection
