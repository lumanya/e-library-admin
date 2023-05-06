@extends('layouts.master')

@section('content')

<div id="newapp" class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-9">
                        <h3 class="d-inline">{{isset($pageTitle) ? $pageTitle: trans('messages.list') }}</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="card-block pall-10 text-center row">
                    <div class="col-md-12">
                            <data-table  ajax="{{ route('user.list') }}" :columns="[                            
                                {data: 'DT_RowIndex','searchable':false, name: 'DT_RowIndex', title : '{{ trans('messages.srno') }}','orderable' : false },
                                {data: 'name'    ,'name' : 'name'  ,'title' : '{{ trans('messages.name') }}'},
                                {data: 'email'   ,'name' : 'email' ,'title' : '{{ trans('messages.email') }}'},
                                {data: 'action'       ,'name' : 'action'     ,'title' : '{{ trans('messages.action') }}',orderable : false,'searchable':false},
                            ]">
                           </data-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection