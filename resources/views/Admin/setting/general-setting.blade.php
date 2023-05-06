
    {!! Form::model($settings, ['method' => 'POST','route' => ['settingsUpdates'],'enctype'=>'multipart/form-data','data-toggle'=>'validator']) !!}

    {!! Form::hidden('id', null, array('placeholder' => 'id','class' => 'form-control')) !!}
    {!! Form::hidden('page', $page, array('placeholder' => 'id','class' => 'form-control')) !!}

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="avatar" class="col-sm-3 control-label">Logo</label>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    @php
                                        $default=URL::asset(\Config::get('constant.DEFAULT_IMAGE'));
                                        if(isset($settings->site_logo)){
                                            $logo = fileExitsCheck($default,'/uploads/app',$settings->site_logo) ;
                                        }else{
                                            $logo = $default;
                                        }
                                    @endphp
                                    <!-- <img src="{{ $logo }}" width="150" alt="person" class="image site_logo"> -->
                                    <img src="{{ getSingleMedia($settings,'site_logo',null) }}" width="150" alt="person" class="image">
                                </div>
                                <div class="col-sm-6">
                                    <div class="custom-file col-md-12">
                                        {!! Form::file('site_logo', ['class'=>"custom-file-input custom-file-input-sm detail" , 'id'=>"site_logo" , 'lang'=>"en"]) !!}
                                        <label class="custom-file-label site_logo" for="site_logo">Logo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="avatar" class="col-sm-3 control-label">Favicon</label>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    @php
                                        $default=URL::asset(\Config::get('constant.DEFAULT_IMAGE'));
                                        if(isset($settings->site_favicon)){
                                            $favicon = fileExitsCheck($default,'/uploads/app',$settings->site_favicon) ;
                                        }else{
                                            $favicon = $default;
                                        }
                                    @endphp
                                    <!-- <img src="{{ $favicon }}" height="150" alt="person" class="image site_favicon"> -->
                                    <img src="{{ getSingleMedia($settings,'site_favicon',null) }}" width="150" alt="person" class="image">
                                </div>
                                <div class="col-sm-6">
                                    <div class="custom-file col-md-12">
                                        {!! Form::file('site_favicon', ['class'=>"custom-file-input custom-file-input-sm detail" , 'id'=>"site_favicon" , 'lang'=>"en"]) !!}
                                        <label class="custom-file-label site_favicon" for="site_favicon">Favicon</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-offset-3 col-sm-12 ">
                            {!! Form::submit('Save Changes', ['class'=>"btn btn-md btn-primary float-md-right"]) !!}
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>
{!! Form::close() !!}

<script type="text/javascript">
    function getExtension(filename) {
            var parts = filename.split('.');
            return parts[parts.length - 1];
        }
        function isImage(filename) {
            var ext = getExtension(filename);
            switch (ext.toLowerCase()) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                case 'ico':
                    return true;
            }
            return false;
        }
        function readURL(input,className) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var res=isImage(input.files[0].name);
                if(res==false){
                    var msg='Image should be png/PNG, ico/ICO, jpg/JPG & jpeg/JPG.';
                    Snackbar.show({text: msg ,pos: 'bottom-right',backgroundColor:'#d32f2f',actionTextColor:'#fff'});
                    return false;
                }
                reader.onload = function(e){
                    $(document).find('img.'+className).attr('src', e.target.result);
                    $(document).find("label."+className).text((input.files[0].name));
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function (){
            $(document).on('change','#site_logo',function(){
                readURL(this,'site_logo');
            });
            $(document).on('change','#site_favicon',function(){
                readURL(this,'site_favicon');
            });
        })

</script>
