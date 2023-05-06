@extends('layouts.master')

@section('content')
<link href="{{ asset('/plugin/tooltip/tooltip-flip.css') }}" rel="stylesheet" type="text/css" />
<div id="newapp" class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="d-inline">{{isset($pageTitle) ? $pageTitle: trans('messages.list')  }}</h3>
                @if(!in_array($type,["recommended",'top-sell']))
                    <a class="btn btn-sm btn-primary float-right d-inline" href="{{route('book.create')}}">
                        <i class="fa fa-plus-circle"></i> {{ trans('messages.add_button_form',['form' => trans('messages.book')  ]) }}</a>
                @endif
            </div>
            <div class="card-body">
                <div class="card-block pall-10 text-center">
                    <div class="col-md-12">
                        @if($type=="recommended")
                            <data-table class="table table-responsive-sm md-responsive" ajax="{{ route('book.list',['type' => $type]) }}" :columns="[
                                {data: 'DT_RowIndex','searchable':false, name: 'DT_RowIndex', title : '{{ trans('messages.srno') }}','orderable' : false },
                                {data: 'front_cover'  ,'name' : 'front_cover' ,'title' : '{{ trans('messages.image') }}','type' : 'image'},
                                {data: 'name'    ,'name' : 'name'  ,'title' : '{{ trans('messages.field_name',['field' => trans('messages.book')]) }}'},
                                {data: 'author_name'    ,'name' : 'getAuthor.name'  ,'title' : '{{ trans('messages.author') }}'},
                                {data: 'category_name' ,'name' : 'categoryName.name'  ,'title' : '{{ trans('messages.field_name',['field' => trans('messages.category')]) }}'},
                                {data: 'flag_recommend'    ,'name' : 'flag_recommend'  ,'title' : '{{ trans('messages.recommended_book') }}'},
                                {data: 'action'       ,'name' : 'action'     ,'title' : '{{ trans('messages.action') }}',orderable : false,'searchable':false},
                            ]">
                            </data-table>
                        @elseif($type=="top-sell")
                            <data-table class="table table-responsive-sm md-responsive" ajax="{{ route('book.list',['type' => $type]) }}" :columns="[
                                {data: 'DT_RowIndex','searchable':false, name: 'DT_RowIndex', title : '{{ trans('messages.srno') }}','orderable' : false },
                                {data: 'front_cover'  ,'name' : 'front_cover' ,'title' : '{{ trans('messages.image') }}','type' : 'image'},
                                {data: 'name'    ,'name' : 'name'  ,'title' : '{{ trans('messages.field_name',['field' => trans('messages.book')]) }}'},
                                {data: 'author_name'    ,'name' : 'getAuthor.name'  ,'title' : '{{ trans('messages.author') }}'},
                                {data: 'category_name' ,'name' : 'categoryName.name'  ,'title' : '{{ trans('messages.field_name',['field' => trans('messages.category')]) }}'},
                                {data: 'flag_top_sell'    ,'name' : 'flag_top_sell'  ,'title' : '{{ trans('messages.top_selling_book') }}'},
                                {data: 'action'       ,'name' : 'action'     ,'title' : '{{ trans('messages.action') }}',orderable : false,'searchable':false},
                                ]">
                            </data-table>
                        @else
                            <data-table class="table table-responsive" ajax="{{ route('book.list',['type' => $type]) }}" :columns="[
                                {data: 'DT_RowIndex','searchable':false, name: 'DT_RowIndex', title : '{{ trans('messages.srno') }}','orderable' : false },
                                {data: 'front_cover'  ,'name' : 'front_cover' ,'title' : '{{ trans('messages.image') }}','type' : 'image'},
                                {data: 'name'    ,'name' : 'name'  ,'title' : '{{ trans('messages.field_name',['field' => trans('messages.book')]) }}'},
                                {data: 'author_name'    ,'name' : 'getAuthor.name'  ,'title' : '{{ trans('messages.author') }}'},
                                {data: 'category_name' ,'name' : 'categoryName.name'  ,'title' : '{{ trans('messages.field_name',['field' => trans('messages.category')]) }}'},
                                {data: 'flag_top_sell'    ,'name' : 'flag_top_sell'  ,'title' : '{{ trans('messages.top_selling_book') }}'},
                                {data: 'flag_recommend'    ,'name' : 'flag_recommend'  ,'title' : '{{ trans('messages.recommended_book') }}'},
                                {data: 'action'       ,'name' : 'action'     ,'title' : '{{ trans('messages.action') }}',orderable : false,'searchable':false},
                                ]">
                            </data-table>
                        @endif
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

@endsection
@section('body_bottom')
<script>
    function addChapter(id) {
        $('#chaptermodal').modal('show');
    }

    function bookActions(ele,postData) {

        var loadurl = "{{ route('book.actions') }}";
        $.post(loadurl,postData ,function(data) {
            if(data.status == true && data.message!=''){
                showMessage(data.message);
            }
        });

        return true;
    }

    $(document).ready(function () {
        $("#addmore").click(function () {
            $('#fieldsrow').clone().insertAfter(this);
        });

        $(document).on('click',".flag_recommend_toggle",function (event) {
            if($(this).is(":checked")){
                var postData = {'book_id':$(this).val(),'flag_recommend':1,'event':'add'};
            }else{
                var postData = {'book_id':$(this).val(),'flag_recommend':0};
            }
            bookActions($(this),postData);
        });
        $(document).on('click',".flag_top_sell_toggle",function (event) {
            if($(this).is(":checked")){
                var postData = {'book_id':$(this).val(),'flag_top_sell':1,'event':'add'};
            }else{
                var postData = {'book_id':$(this).val(),'flag_top_sell':0};
            }
            bookActions($(this),postData);
        });
    });
</script>
@endsection
