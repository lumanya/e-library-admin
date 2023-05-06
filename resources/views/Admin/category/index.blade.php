@extends('layouts.master')
@section('content')
<div id="newapp" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : trans('messages.list') }}</h3>
                <a href="{{ route('category.create') }} " class="btn btn-sm float-right btn-primary"><i class="fa fa-plus-circle"  ></i> {{ trans('messages.add_button_form',['form' => trans('messages.category')  ]) }}</a>
            </div>
            <div class="card-body">
                <div class="card-block pall-10 text-center">
                    <div>
                        <data-table class="table table-responsive-sm md-responsive" ajax="{{ route('category.list') }}" :columns="[
                                {data: 'DT_RowIndex', name: 'DT_RowIndex', title : '{{ trans('messages.srno') }}','orderable' : 'false' },
                                {data: 'name','name' : 'name', 'title' : '{{ trans('messages.field_name',['field' => trans('messages.category')]) }}'},
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
