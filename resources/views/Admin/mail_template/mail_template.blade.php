<?php
    // $default = URL::asset(\Config::get('constant.DEFAULT_IMAGE'));
    // $logo = fileExitsCheck($default,'assets/img/brand','logo.png');
    // $app_data = \App\AppSetting::first();
    // $default=URL::asset(\Config::get('constant.DEFAULT_IMAGE'));
    // if(isset($app_data->site_logo)){
    //     $logo = fileExitsCheck($default,'/uploads/app',$app_data->site_logo) ;
    // }else{
    //     $logo = $default;
    // }
?>
<table class="m_-4201929443178390926wrapper" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;margin:0;padding:0;width:100%" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
      <tr>
        <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box" align="center">
          <table class="m_-4201929443178390926content" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0;padding:0;width:100%" cellspacing="0" cellpadding="0" width="100%">
            <tbody>
              <tr>
                <td class="m_-4201929443178390926header" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px 0;text-align:center"> <a href="#" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#bbbfc3;font-size:19px;font-weight:bold;text-decoration:none" target="_blank" data-saferedirecturl=""><img src="{{ getSingleMedia(settingSession('get'),'site_logo',null,'',false) }}" height="65"  alt="logo"/></a> </td>
              </tr>
              <tr>
                <td class="m_-4201929443178390926body" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;border-bottom:1px solid #edeff2;border-top:1px solid #edeff2;margin:0;padding:0;width:100%" width="100%">
                  <table class="m_-4201929443178390926inner-body" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px" cellspacing="0" cellpadding="0" align="center" width="100%">
                    <tbody>
                      <tr>
                        <td class="m_-4201929443178390926content-cell" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                            <?php echo html_entity_decode($mail_body); ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
             <tr>
                <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                  <table class="m_-4201929443178390926footer" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0 auto;padding:0;text-align:center;width:570px" cellspacing="0" cellpadding="0" align="center" width="570">
                    <tbody>
                      <tr>
                        <td class="m_-4201929443178390926content-cell" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px" align="center">
                          <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;line-height:1.5em;margin-top:0;color:#aeaeae;font-size:12px;text-align:center">© {{ date('Y') }} <a href="{{ route('home') }}" class="iq-font-green">{{ env('APP_NAME') }}</a>.
                            {{trans('messages.all_rights_reserved')}}</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
