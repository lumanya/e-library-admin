<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Author;
use App\User;
use App\Transaction;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $book=Book::orderBy('book_id','DESC')->with(['getAuthor'])->get();
        $transaction = Transaction::with(['getSingleTransactionDetail'])->orderBy('transaction_id','DESC')->get();
        $user = User::where('user_type','user')->orderBy('id','DESC')->get();
        $author = Author::orderBy('author_id','DESC')->get();

        $data=[];
        $data['card']=[
            'total_book' => $book->count('book_id'),
            'total_author' => $author->count('author_id'),
            'total_user' => $user->count('id'),
            'total_sale' => $transaction->count('transaction_id'),
        ];

        for($i=1;$i<=12;$i++) {
            $data['graph']['sales'][] = $transaction->filter(function ($value, $key) use ($i) {
                                                            return date('Y-m', strtotime($value->datetime)) == (date('Y').'-'.sprintf('%02d', $i));
                                                        })->sum('total_amount');
            $data['graph']['users'][] = $user->filter(function ($value, $key) use ($i) {
                                                            return date('Y-m', strtotime($value->created_at)) == (date('Y').'-'.sprintf('%02d', $i));
                                                        })->count('id');
        }


        $data['list']=[
            'book' => $book->take(5),
            'transaction' => $transaction->take(5),
        ];
        return view('Admin.home',compact(['data']));
    }

    public function checkEnvironment(Request $request)
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        $message = "";
        if($request->tab == "tab3"){
            try{
                $con = mysqli_connect($request->database_hostname.':'.$request->database_port,$request->database_username,$request->database_password,$request->database_name);
                $status = true;
                if(empty($request->database_name)){
                    $message = "Database not found in your server";
                    $status = false;
                }
            }
            catch (\Exception $e){
                $con = false;
                if(strpos($e->getMessage(), 'Access denied for user') !== false){
                    $message = "Please enter correct database username or password";
                }elseif(strpos($e->getMessage(), 'Unknown database') !== false){
                    $message = "Database not found in your server";
                }elseif(strpos($e->getMessage(), "Connection refused") !== false){
                    $message = "Please enter valid database port ";
                }elseif(strpos($e->getMessage(), "Connection timed out") !== false || strpos($e->getMessage(), "Invalid argument") !== false){
                    $message = "Please enter valid database host";
                }else{
                    $message = $e->getMessage();
                }
                $status = false;
            }
        }elseif ($request->tab == "tab4"){

            $envFileData =
                'APP_NAME=\'' . optional($request)->app_name . "'\n" .
                'APP_ENV=' . optional($request)->environment . "\n" .
                'APP_KEY=' . 'base64:bODi8VtmENqnjklBmNJzQcTTSC8jNjBysfnjQN59btE=' . "\n" .
                'APP_DEBUG=' . optional($request)->app_debug . "\n" .
                'APP_LOG_LEVEL=' . optional($request)->app_log_level . "\n" .
                'APP_URL=' . optional($request)->app_url . "\n\n" .
                'DB_CONNECTION=' . optional($request)->database_connection . "\n" .
                'DB_HOST=' . optional($request)->database_hostname . "\n" .
                'DB_PORT=' . optional($request)->database_port . "\n" .
                'DB_DATABASE=' . optional($request)->database_name . "\n" .
                'DB_USERNAME=' . optional($request)->database_username . "\n" .
                'DB_PASSWORD=' . optional($request)->database_password . "\n\n" .
                'BROADCAST_DRIVER=' . optional($request)->broadcast_driver . "\n" .
                'CACHE_DRIVER=' . optional($request)->cache_driver . "\n" .
                'SESSION_DRIVER=' . optional($request)->session_driver . "\n" .
                'QUEUE_DRIVER=' . optional($request)->queue_driver . "\n\n" .
                'REDIS_HOST=' . optional($request)->redis_hostname . "\n" .
                'REDIS_PASSWORD=' . optional($request)->redis_password . "\n" .
                'REDIS_PORT=' . optional($request)->redis_port . "\n\n" .
                'MAIL_DRIVER=' . optional($request)->mail_driver . "\n" .
                'MAIL_HOST=' . optional($request)->mail_host . "\n" .
                'MAIL_PORT=' . optional($request)->mail_port . "\n" .
                'MAIL_USERNAME=' . optional($request)->mail_username . "\n" .
                'MAIL_PASSWORD=' . optional($request)->mail_password . "\n" .
                'MAIL_ENCRYPTION=' . optional($request)->mail_encryption . "\n\n";

            try {
                // dd($envFileData);
                file_put_contents(base_path('.env'), $envFileData);
                // Artisan::call('storage:link');
//                $mail_vals=[optional($request)->mail_driver,optional($request)->mail_host,optional($request)->mail_port,optional($request)->mail_username,optional($request)->mail_password,optional($request)->mail_encryption];
                $mail_vals=[optional($request)->mail_driver];
                if(in_array('null',$mail_vals) || in_array('',$mail_vals)){
                    $message = "Please check mail configuration";
                    $status = false;
                }else{
                    $status = true;
                }
            }
            catch(Exception $e) {
                $results = trans('Mail Server Not Connected, Please check you mail configuration');
                $status = false;
            }

        }else{
            $status = true;
            if(empty($request->app_name)){
                $status = false;
                $message = "Please enter the app name";
            }elseif ($request->environment=="other" && isset($request->environment_custom)){
                $status = false;
                $message = "Please enter the app environment";
            }
        }
        return response()->json([ 'status' => $status , 'message' => $message , 'tab' => $request->tab ]);
    }

}
