                <div class="pall-20">
                    {!! Form::model($user_data, ['route'=>'user.password.update','method' => 'POST','data-toggle' => 'validator', 'enctype'=> 'multipart/form-data','id' => 'user-password']) !!}
                        {{csrf_field()}}
                        {!! Form::hidden('id', null, array('placeholder' => 'id','class' => 'form-control')) !!}
                        <div class="row">
                            <div class="mlr-auto col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group has-feedback">
                                            <label for="password" class="col-md-12 control-label">{{trans('messages.old_password')}}<span class="required">*</span></label>
                                            <div class="col-md-12">
                                                {!! Form::password('old', ['class'=>"form-control",'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group has-feedback">
                                            <label for="password" class="col-md-12 control-label">{{trans('messages.new_password')}}<span class="required">*</span></label>
                                            <div class="col-md-12">
                                                {!! Form::password('password', ['class'=>"form-control" , 'id'=>"password",'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group has-feedback">
                                            <label for="password-confirm" class="col-md-12 control-label">{{trans('messages.confirm_new_password')}}<span class="required">*</span></label>

                                            <div class="col-md-12">
                                                {!! Form::password('password_confirmation', ['class'=>"form-control" , 'id'=>"password-confirm",'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group ">
                                            <div class="col-md-12">
                                                {!! Form::submit(trans('messages.save'), ['id'=>"submit" ,'class'=>"btn btn-md btn-primary float-md-right mt-15"]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
