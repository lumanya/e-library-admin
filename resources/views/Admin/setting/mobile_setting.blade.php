
@extends('layouts.master')

@section('content')
    <?php $auth_user=authSession(); ?>
    <div class="card">
        <div class="card-header">
            <h2>{{ isset($pageTitle) ? ucwords($pageTitle) : ''}}</h2>
        </div>
        <div class="card-body">
            {!! Form::model($setting_value, ['route'=>'mobile_app.config.save','method' => 'POST','data-toggle' => 'validator']) !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                @foreach($setting as $key => $value)
                    <div class="col-md-12 col-sm -12 card shadow mb-10">
                        <div class="card-header">
                            <h4>{{ $key }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($value as $sub_keys=>$sub_value)
                                    @php
                                        $data=null;
                                        foreach($setting_value as $v){
                                            if($v->key==($key.'_'.$sub_keys)){
                                                $data= $v->value;
                                            }
                                        }
                                        $class = 'col-md-4';
                                        $type = 'text';
                                        switch ($key){
                                            case 'COLOR' : $type = 'color'; break;
                                            default : break;
                                        }
                                    @endphp
                                    <div class=" {{ $class }} col-sm-12">
                                        <div class="form-group">
                                            <label for="{{ $key }}">{{ str_replace('_',' ',$sub_keys) }}</label>
                                            <input type="hidden" name="key[]" value="{{ $key.'_'.$sub_keys }}">
                                            <input type="{{ $type }}" name="value[]" value="{{ $data }}" class="form-control" placeholder="{{ str_replace('_',' ',$sub_keys) }}">
                                        </div>
                                    </div>
                                @endforeach
                                <div class="col-md-12">
                                    {!! Form::submit('Save',['class'=>'btn btn-md btn-primary']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endForeach
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
