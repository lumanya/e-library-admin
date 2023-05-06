<?php


use App\AppSetting;

function getColor(){
    $color = ['warning','danger','success','info','primary'];
    $index=array_rand($color);
    return $color[$index];
}

function setActive($path)
{
    if(!\Request::ajax()){
        return \Request::is($path . '*') ? 'active' :  '';
    }
}

function showDate($date = ''){
    if($date == '' || $date == null)
        return;

    $format = config('config.date_format') ? : 'd-m-Y';
    return date($format,strtotime($date));
}

function isSecure(){
    if(!getMode())
        return 1;

    $url = \Request::url();
    $result = strpos($url, 'wmlab');
    if($result === FALSE)
        return 0;
    else
        return 1;
}

function getRemoteIPAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];

    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $_SERVER['REMOTE_ADDR'];
}

function getClientIp(){
    $ips = getRemoteIPAddress();
    $ips = explode(',', $ips);
    return !empty($ips[0]) ? $ips[0] : \Request::getClientIp();
}

function sendMail($to,$from,$maildata,$mail_subject){
    $data['mail_body'] = $maildata;
    Mail::send('Admin.mail_template.mail_template',$data, function($message) use($to,$from,$maildata,$mail_subject){
         $message->to($to)->subject($mail_subject);
         $message->from($from,env('APP_NAME'));
     });
}

function uploadImage($file, $path, $id, $field_name)
{

    if ($file != null) {
        $paths = public_path().$path;
        if (!file_exists($paths)) {
            File::makeDirectory($paths, $mode = 0777, true, true);
        }
    } else {
        $filename = \DB::table('users')->where('id', $id)->value($field_name);
    }

    if ($file!='') {
        $filename =time().'-'.$file->getClientOriginalName();
        $file->move($paths, $filename);

        $images[$field_name]=$filename;
        return \App\User::updateOrCreate(['id' => $id], $images);
    }
}
function uploadFile($file, $path,$id = '' , $field_name = '')
{
 

    if ($file != null) {

  
        $paths = public_path().'/'.$path.'/';
        if (!file_exists($paths)) {
            File::makeDirectory($paths, $mode = 0777, true, true);
        }
        $filename =time().'-'.$file->getClientOriginalName();

       // dd($paths);
        move_uploaded_file($file,$paths.$filename);
        return $filename;
    }
    else{
        return null;
    }
}




function envChanges($type,$value){
    $path = base_path('.env');
    if (file_exists($path)) {
        file_put_contents($path, str_replace(
            $type.'='.env($type), $type.'='.$value, file_get_contents($path)
        ));
        if( in_array( $type ,['ONESIGNAL_API_KEY','ONESIGNAL_REST_API_KEY','BRAINTREE_ENV','BRAINTREE_MERCHANT_ID','BRAINTREE_PUBLIC_KEY','BRAINTREE_PRIVATE_KEY','BRAINTREE_Merchant_Account_Id']) ){
            if(env($type) === null){
                file_put_contents($path,"\n".$type.'='.$value ,FILE_APPEND);
            }
        }
    }
}

function CheckRecordExist($table_list,$column_name,$id){
    $search_keyword = $column_name;
    if(count($table_list) > 0){
        foreach($table_list as $table){
            $check_data = \DB::table($table)->where('category_id',$id)->WhereNull('deleted_at')->count();
            if($check_data > 0)
            {
                return false ;
            }
        }
        return true;
    }
    else {
        return true;
    }
}

function sendOneSignalMessage($device_ids, $device_data) {
    if(env('ONESIGNAL_API_KEY') != null && env('ONESIGNAL_REST_API_KEY') != null){
        $content = array(
            "en" => isset($device_data['message']) ? $device_data['message'] :  env('APP_NAME').' Message'
        );
        $heading = array(
            "en" =>isset($device_data['title']) ? $device_data['title'] :  env('APP_NAME').' Title'
        );
        $device_contents = array(
                "type"       => isset($device_data['type']) ? $device_data['type'] :  env('APP_NAME'),
                "title"      =>  isset($device_data['title']) ? $device_data['title'] :  env('APP_NAME').' Title',
                "message"    => isset($device_data['message']) ? $device_data['message'] :  env('APP_NAME').' Message',
                "book_id"    => isset($device_data['book_id']) ? $device_data['book_id'] : 'book_id',
                "notification_type"    => isset($device_data['notification_type']) ? $device_data['notification_type'] : 'notification_type',
            );
    
        $fields = array(
            'app_id' => env('ONESIGNAL_API_KEY'),
            'include_player_ids' => $device_ids,
            'data' => $device_contents,
            'contents' => $content,
            'headings' => $heading,
            'big_picture' => isset($device_data['image']) ? $device_data['image'] : 'Image',
        );
    
        $header=[
            "title" => isset($device_data['title']) ? $device_data['title'] :  env('APP_NAME').' Title',
            "message" => isset($device_data['message']) ? $device_data['message'] :  env('APP_NAME').' Message',
        ];
    
    
    
        $sendContent = json_encode($fields);
        \Log::info('Content :- '.$sendContent);
        oneSignalAPI($sendContent);
    }
}

function oneSignalAPI($sendContent)
{
        $rest_api_key = ENV('ONESIGNAL_REST_API_KEY');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            "Authorization:Basic $rest_api_key"
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sendContent);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
        $response = curl_exec($ch);
        curl_close($ch);
}
function getFileExistsCheck($media)
{
    $mediaCondition = false;

    if($media) {
        if($media->disk == 'public') {
            $mediaCondition = file_exists($media->getPath());
        } else {
            $mediaCondition = \Storage::disk($media->disk)->exists($media->getPath());
        }
    }

    return $mediaCondition;
}
function getSingleMedia($model, $collection = 'image', $skip=true   )
{
    if (!\Auth::check() && $skip) {
        return asset('images/user/user.png');
    }
    $media = null;
    if ($model !== null) {
        $media = $model->getFirstMedia($collection);
    }

    if (getFileExistsCheck($media)) {
        return $media->getFullUrl();
    }else{

        $media = "";
        return $media;
    }
}
function getBookFile($filetype){
    $file = asset('assets/sample_file/sample.pdf');
    
    if( $filetype != null  ){
        switch($filetype){
            case 'video':
                    $file = asset('assets/sample_file/sample.mp4');
                    break;
            case 'epub':
                    $file = asset('assets/sample_file/sample.epub');
                    break;
            case 'pdf':
                    $file = asset('assets/sample_file/sample.pdf');
                    break;
            default :
                return $file;
                break;
        }
    }
    return $file;
}
function storeMediaFile($model,$file,$name)
{
    if($file) {
        if( !in_array($name, ['service_attachment'])){
            $model->clearMediaCollection($name);
        }
        if (is_array($file)){
            foreach ($file as $key => $value){
                $model->addMedia($value)->toMediaCollection($name);
            }
        }else{
            $model->addMedia($file)->toMediaCollection($name);
        }
    }

    return true;
}
function authSession($force=false){
    $session=new \App\User;
    if($force){
        $user=\Auth::user(); //->with('user_role');
        \Session::put('auth_user',$user);
        $session =\Session::get('auth_user');
        return $session;
    }
    if(\Session::has('auth_user')){
        $session =\Session::get('auth_user');
    }else{
        $user=\Auth::user();
        \Session::put('auth_user',$user);
        $session =\Session::get('auth_user');
    }
    return $session;
}

function settingSession($type='get'){
    if(\Session::get('setting_data')==''){
        $type='set';
    }
    switch ($type){
        case "set" : $settings = AppSetting::first();\Session::put('setting_data',$settings); break;
        default : break;
    }
    return \Session::get('setting_data');
}

function money($price,$symbol='$'){
    if($price==''){
        $price=0;
    }
    return $symbol.' '.$price;
}

function fileExitsCheck($defaultimg, $path, $filename)
{
    $image= $defaultimg;
    $imgurl= public_path($path.'/'.$filename);
    if ($filename != null && file_exists($imgurl)) {
        $isimgurl=URL::asset($path.'/'.$filename);
        $image=$isimgurl;
    }
    return $image;
}

function getSettingKeyValue($key=""){
    $setting_data = \App\Setting::where('key',$key)->first();
    return $setting_data->value;
}
function comman_message_response( $message, $status_code = 200)
{
	return response()->json( [ 'message' => $message ], $status_code );
}

function comman_custom_response( $response, $status_code = 200 )
{
    return response()->json($response,$status_code);
}

function comman_list_response( $data )
{
    return response()->json(['data' => $data]);
}

?>
