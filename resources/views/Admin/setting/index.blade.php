
@extends('layouts.master')

@section('content')
    <?php $auth_user=authSession(); ?>
    <div class="card">
        <div class="card-header">
            <h2>{{ isset($pageTitle) ? ucwords($pageTitle) : ''}}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="tabs-text" role="tablist">
                                @if($auth_user->is('admin') || $auth_user->is('demo_admin'))
                                <li class="nav-item">
                                    <a href="javascript:void(0)" data-href="{{ route('layout_page') }}?page=general-setting" data-target=".paste_here" class="nav-link {{$page=='general-setting'?'active':''}}"  data-toggle="tabajax" rel="tooltip"> General settings</a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a href="javascript:void(0)" data-href="{{ route('layout_page') }}?page=profile_form" data-target=".paste_here" class="nav-link {{$page=='profile_form'?'active':''}}"  data-toggle="tabajax" rel="tooltip"> Profile </a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0)" data-href="{{ route('layout_page') }}?page=password_form" data-target=".paste_here" class="nav-link {{$page=='password_form'?'active':''}}"  data-toggle="tabajax" rel="tooltip"> Change Password </a>
                                </li>
                                @if($auth_user->is('admin')  || $auth_user->is('demo_admin'))
                                <li class="nav-item">
                                    <a href="javascript:void(0)" data-href="{{ route('layout_page') }}?page=mail-setting" data-target=".paste_here" class="nav-link {{$page=='mail-setting'?'active':''}}"  data-toggle="tabajax" rel="tooltip"> Mail Settings</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="tab-content">
                        <div class="tab-pane active p-4" >
                            <div class="paste_here"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('body_bottom')
<script type="text/javascript">
$(document).ready(function(event)
{
    var $this = $('.nav-item').find('a.active'),
    loadurl = '{{route('layout_page')}}?page={{ $page}}',
    targ = $this.attr('data-target'),
    id = this.id || '';

    $.post(loadurl,function(data) {
        $(targ).html(data);
    });

    $this.tab('show');
    return false;

});



</script>

@endsection
