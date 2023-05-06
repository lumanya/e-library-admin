<div class="row">
    <div class="col-md-12 pall-40 pt-20">
        {!! Form::model($envSettting, ['route'=>'envSetting','method' => 'POST','data-toggle' => 'validator', 'enctype'=> 'multipart/form-data','id' => 'mail-setup']) !!}
        {!! Form::hidden('page', $page, array('placeholder' => 'id','class' => 'form-control')) !!}
        {!! Form::hidden('type','mail') !!}
        <div class="row">
        @foreach($envSettting as $key=>$value)
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="{{ $key }}">{{ str_replace('MAIL_','',$key) }}</label>
                        <?php
                            $data=$envSettting_value->where('key',$key)->first();
                            if($data!=''){
                                $value=$data->value;
                            }
                        ?>
                        {!! Form::text($key, isset($value) ? $value : null, ['class'=>"form-control",'required']) !!}
                    </div>
                </div>
        @endForeach
        </div>
        {!! Form::submit('Save Changes', ['class'=>"btn btn-md btn-primary float-md-right"]) !!}
        {!! Form::close() !!}
    </div>
</div>
