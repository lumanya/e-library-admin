@extends('layouts.master')
@section('content')
<link href="{{ asset('/plugin/tooltip/tooltip-line.css') }}" rel="stylesheet" type="text/css" />
    <div class="card">
        <div class="card-header">
            <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : trans('messages.list') }}</h3>

        </div>
        <div class="card-body">
            <div class="card-block p-2">
                    <div class="row" id='newapp'>
                        <div class='col-md-12'>
                            <data-table class='table table-responsive-sm md-responsive text-center' ajax="{{ route('users_feedback.list') }}" :columns="[
                                {data: 'DT_RowIndex','searchable':false, name: 'DT_RowIndex', title : '{{ trans('messages.srno') }}','orderable' : false },
                                {data: 'name','name': 'name', 'title' : '{{ trans('messages.name') }}'},
                                {data: 'email','name': 'email', 'title' : '{{ trans('messages.email') }}'},
                                {data: 'comment','name': 'comment', 'title' : '{{ trans('messages.comment') }}'},
                                ]">
                            </data-table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
