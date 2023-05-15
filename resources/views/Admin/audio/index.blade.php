@extends('layouts.master')

@section('content')
<link href="{{ asset('/plugin/tooltip/tooltip-flip.css') }}" rel="stylesheet" type="text/css" />

<div id="newapp" class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="d-inline">{{isset($pageTitle) ? $pageTitle: trans('messages.list')  }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection
