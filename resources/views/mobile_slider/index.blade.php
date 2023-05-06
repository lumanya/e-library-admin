@extends('template_partials.index')

@section('content')
<div class="col-md-12">
    <div class="card">
            <div class="card-header">
                <h3 class="d-inline">{{ isset($pageTitle) ? $pageTitle : "List" }}</h3>
                <a class="btn btn-sm btn-primary float-right d-inline" href="{{route('mobileslider.create')}}"><i class="fa fa-plus-circle"></i>  Add Slider Image</a>
            </div>
            <div class="card-body">
                <div class="card-block p-2">
                        <div class="row" id='newapp'z>
                            <div class="col-md-12">
                                    <data-table class="table table-responsive-sm text-center" ajax="{{ route('mobileslider.list') }}" :columns="[
                                        {data: 'DT_RowIndex', name: 'DT_RowIndex', title : '{{ trans('messages.srno') }}','orderable' : 'false' },
                                        {data: 'image' ,'name': 'image' , 'title' :'Image' , type:'image'},
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
