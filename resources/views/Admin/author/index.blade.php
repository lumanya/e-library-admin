@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : "List" }}</h3>
        <a class="btn btn-sm btn-primary float-right d-inline" href="{{route('author.create')}}"><i class="fa fa-plus-circle"  ></i> {{ trans('messages.add_button_form',['form' => trans('messages.author')  ]) }}</a>
    </div>
    <div class="card-body">
        <div class="card-block p-2">
                <div class="row" id='newapp'>
                    <div class="col-sm-12">
                        <data-table class="table table-responsive-sm text-center" ajax="{{ route('dataList') }}" :columns="[
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', title : '{{ trans('messages.srno') }}','orderable' : 'false' },
                            {data: 'name','name' : 'name', 'title' : '{{ trans('messages.field_name',['field' => trans('messages.author')]) }}'},
                            {data: 'designation','name': 'designation', 'title' : '{{ trans('messages.designation')}}' },
                            {data: 'email','name': 'email', 'title' : '{{ trans('messages.email')}}' },
                            {data: 'action', name: 'action',title : '{{ trans('messages.action') }}',orderable : false},
                            ]">
                        </data-table>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
@section('body_bottom')

@endsection
