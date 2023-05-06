@extends('layouts.master')

@section('content')
<div class="col-md-12">
    <div class="card">
            <div class="card-header">
                <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : "List" }}</h3>
                <a class="btn btn-sm btn-primary float-right d-inline" href="{{route('mobileslider.create')}}" title="{{ trans('messages.add_button_form',['form' => trans('messages.mobileslider_image')  ]) }}"><i class="fa fa-plus-circle"></i>  {{ trans('messages.add_button_form',['form' => trans('messages.mobileslider_image')  ]) }}</a>
            </div>
            <div class="card-body">
                <div class="card-block p-2">
                        <div class="row" id='newapp'>
                            <div class="col-md-12">
                                    <data-table class="table text-center table-responsive-sm md-responsive"  ajax="{{ route('mobileslider.list') }}" :columns="[
                                        {data: 'DT_RowIndex', name: 'DT_RowIndex', title : '{{ trans('messages.srno') }}','orderable' : 'false' },
                                        {data: 'slide_image' ,'name': 'slide_image' , 'title' :'{{ trans('messages.image')}}'},
                                        {data: 'action', name: 'action',title : '{{ trans('messages.action') }}',orderable : false},
                                    ]">
                                    </data-table>
                            </div>
                        </div>
                </div>
            </div>
    </div>
</div>
@endsection
@section('body_bottom')

@endsection
