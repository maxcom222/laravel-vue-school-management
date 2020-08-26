<?php

namespace App\Http\Controllers;

use App\Classes\Slim;
use App\Events\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\ResetpasswordEmail;

use Imagick;
use Intervention\Image\ImageManagerStatic as Image;
use Exception;


use AWS;



class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	protected $data = array('no_header' => 0 );
    public function index()
    {

    }
	
	public function skills_set()
    {
        $results =  DB::table('specialization') -> select( 'id as value', 'title as text' )  -> get() ;
		
		return response()->json( $results );	
    }
	
	
	/*public function register(  Request $request    )
    {
        if( isset( $_POST['email'] ) )
		{
			$email 			= $_POST['email'];
			$password 		= $_POST['password'];
			$type 			= $_POST['type'];
			$school_email 	= '';
			
			
			
			$results 			=  DB::table('user')->where([ ['email', '=', $email ],  ['verified', '=', 1 ] ])->get() ;
						
			$code 				=   substr(str_shuffle("0123456789"), 0, 5);
			
			$verify_code_school =   substr(str_shuffle("0123456789"), 0, 5);

			if( $results -> count() ==  0 )
			{
				$id = DB::table	('user')	->	insertGetId(
					['email' => $email , 'password' => $password, 'type' => $type, 'verify_code_school' => $verify_code_school, 'verify_code' => $code, 'profile_photo' => '',  'profile_photo_custom' => '0',  'city' => '', 'country' => '']
				);
				
				$emailarr  = explode('@', $email );
				$d['username'] = $emailarr[0].$id.time();
				
				DB::table	('user' ) -> where( 'id', $id ) ->	update( $d );

				$request    ->  session()   ->  put('user_started_registration', 1 );
                $request    ->  session()   ->  save();
				$response =  array('response' => '1', 'uid' => $id  ) ;
				
			    $this -> get_confirmation_email( $code, $email );
					return response()->json( $response );
				
			}
			else
			{
				
				$response =  array('response' => '2' ) ;
					return response()->json( $response );
                
			}
			//return response()->json( $response );
			
		}
    }*/

	public function register_social( Request $request   )
    {
        if( isset( $_POST['email'] ) )
		{
			$email 		= $_POST['email'];
			$password 	= $_POST['password'];
			$type 		= $_POST['type'];
			$first_name = $_POST['first_name'];
			$last_name  = $_POST['last_name'];
			
			
			$name = $first_name.' '. $last_name;
			
			$profile_photo  = $_POST['profile_photo'];
			
			
			$results =  DB::table('user')->where([
							['email', '=', $email ],
						])->get() ;
						
			$code =   substr(str_shuffle("0123456789"), 0, 5);
			$d = array('email' => $email , 'name' => $name, 'verify_code' =>  $code,  'profile_photo' => $profile_photo, 'profile_photo_custom' => '0', 'password' => $password, 'type' => $type, 'social' => '1', 'last_name' => $last_name, 'first_name' => $first_name, 'city' => '', 'country' => ''  );
						
			 //DB::select('select * from school_register where school_email = ? and school_password = ?', [$email, $password ] ) ->  exists();
			if( $results -> count() ==  0 )
			{
				$id = DB::table	('user')	->	insertGetId( $d );
				
				
				$emailarr  = explode('@', $email );
				$d['username'] = $emailarr[0].$id.time();
				
				DB::table	('user' ) -> where( 'id', $id ) ->	update( $d );
				
				
				
				$results =  DB::table('user')->where([
							['email', '=', $email ],
						])->get() ;
						
				$user =  $results[0] ;
                $request    ->  session()   ->  put('user', $user );
                $request    ->  session()   ->  save();
				$response =  array('response' => '1' ) ;
				$r = $this -> get_confirmation_email( $code, $email );
				
				
			}
			else
			{
				
				$user =  $results[0] ;
				
				$request    ->  session()   ->  put('user', $user );
                $request    ->  session()   ->  save();
				$response =  array('response' => '4' ) ;
			}
			
				
				
			return response()->json( $response );
			
		}
    }

	public function profile_wizard( $url, Request $request )
    {
		$this -> data['title']   	 = 'Expats School - Profile Page';
		$this -> data['page']		 = 'teachers/profile_wizard';
		$this -> data['text'] 		 = 'Login to our website';
		$this -> data['page_on'] 	 = 'home';
		$this -> data['no_header']   = '1';
		if (! $request->session()->has('user_started_registration')) 
		{
			return  redirect()->action('AuthController@login');
		}
		
        return view("template" ) -> with( $this -> data );
    }
	
	
	public function membership_status( $school_email  )
	{
		$school_email_domain  = explode('@',  $school_email );
		if( isset ( $school_email_domain[1] ) )
		{
			$school_email_domain  = '@' . $school_email_domain[1];
			$school_profile_result = DB::table	('school_profile' ) -> where( [['domain_email','=', $school_email_domain], ] )  -> get();
			if( $school_profile_result -> count() > 0 )
			{
				if ( $school_profile_result[0] -> etc_block ==  1 )
				{
					$membership_status 	=  '0';
				}
				else
				{
					$membership_status 	=  '1';
				}
			}
			else
			{
				$membership_status	=  '0';
			}
		}	
		else
		{
			$membership_status 	=  '0';
		}
		return $membership_status;
		
	}
	
	
	
	
	
	public function remove_document( Request $request  )
	{
		if (! $request->session()->has('user')) 
		{
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'session is expired';
			$respone_to_app['result'] 	=  '2';
			return response()->json( $respone_to_app );
		}
		
		$user		 = $request->session()->get('user');
		$uid 	 	 = $user -> id;
		
		$att = $_POST['att'];
		
		$targetPath = getcwd().'/public/user_profiles/';
		unlink ( $targetPath  .  $_POST['doc'] );
		
		
		$d[$att]  = '';
		DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
		$results = DB::table	('user' ) -> where( 'id', $uid ) -> get();
		
		$user =  $results[0] ;
		$uid  = $user -> id;
		$request    ->  session()   ->  put('user', $user );
		$request    ->  session()   ->  save();
			
			
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  'success';
		$respone_to_app['result'] 	=  '1';
		return response()->json( $respone_to_app );
		
		
	}
	public function verify_school_code_photo( Request $request  )
	{
		
		
		if (! $request->session()->has('user')) 
		{
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'session is expired';
			$respone_to_app['result'] 	=  '2';
			return response()->json( $respone_to_app );
		}
		
		$user		 = $request->session()->get('user');
		$uid 	 	 = $user -> id;

		$v_code  = $_POST['v_code'];
		$r = DB::table	('user' ) -> where( [ ['verify_code_school', '=', $v_code ], ['id', '=', $uid],] ) ->	get( );
			
		if( $r -> count() == 0 )
		{
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'success';
			$respone_to_app['result'] 	=  '3';
			return response()->json( $respone_to_app );
		}
		else
		{
			$d['verified_school'] = 1;
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			$results = DB::table	('user' ) -> where( 'id', $uid ) -> get();
			
			$user =  $results[0] ;
			$uid  = $user -> id;
			$request    ->  session()   ->  put('user', $user );
			$request    ->  session()   ->  save();
				
				
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'success';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
		}
		
		
			
		
	}
	
	
	public function verify_school_code( Request $request  )
	{
		
		
		if (! $request->session()->has('user')) 
		{
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'session is expired';
			$respone_to_app['result'] 	=  '2';
			return response()->json( $respone_to_app );
		}
		
		$user		 = $request->session()->get('user');
		$uid 	 	 = $user -> id;

		$v_code  = $_POST['v_code'];
		$r = DB::table	('user' ) -> where( [ ['verify_code_school', '=', $v_code ], ['id', '=', $uid],] ) ->	get( );
			
		if( $r -> count() == 0 )
		{
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'success';
			$respone_to_app['result'] 	=  '3';
			return response()->json( $respone_to_app );
		}
		else
		{
			$d['verified_school'] = 1;
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			$results = DB::table	('user' ) -> where( 'id', $uid ) -> get();
			$user =  $results[0] ;
			$uid  = $user -> id;
			$request    ->  session()   ->  put('user', $user );
			$request    ->  session()   ->  save();

            /********** check if domain is valid for ETC  */
            $membership_status    =  '0';
            $school_email         = $user -> school_email;
            $school_email_domain  = explode('@',  $school_email );
            if( isset ( $school_email_domain[1] ) )
            {
                $school_email_domain  = '@' . $school_email_domain[1];
                $school_profile_result = DB::table	('school_profile' ) -> where( 'domain_email', $school_email_domain )  -> get();
                if( $school_profile_result -> count() > 0 )
                {
                    if ( $school_profile_result[0] -> etc_block ==  1 )
                    {
                        $membership_status 	=  '0';
                    }
                    else
                    {
                        $membership_status 	=  '1';
                    }
                }
                else
                {
                    $membership_status	=  '0';
                }
            }
            else
            {
                $membership_status 	=  '0';
            }



            if( $membership_status ==  0 ) {

                $respone_to_app['status'] 	= '200';
                $respone_to_app['message']  = 'success';
                $respone_to_app['data'] 	=  'success';
                $respone_to_app['result'] 	=  '4';
                return response()->json( $respone_to_app );

            }


			/**  add to voucherskout   **/
			//https://www.godesto.com/AdminApps/v_update_customer_info
			
			$data  					=  array();
			$data['customerID'] 	=   $uid ;
			$data['customerName'] 	=   $user -> name;
			$data['customerEmail']  =   $user -> email;
			$data['customerPhone']  =   $user -> contact_number;
				
			$ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, 'https://www.godesto.com/AdminApps/v_update_customer_info'	);
			curl_setopt($ch, CURLOPT_TIMEOUT,500); 
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$customer_info = curl_exec($ch);
			curl_close( $ch );
				
			$res = json_decode ( $customer_info, true );
			if( isset ( $res['result'] ) &&  $res['result']  == 1 )
			{
				$d['register_with_voucherskout'] = 1;
				$d['added_to_etc'] = date('Y-m-d');
				DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
				$results = DB::table	('user' ) -> where( 'id', $uid ) -> get();
				
				$user =  $results[0] ;
				$uid  = $user -> id;
				$request    ->  session()   ->  put('user', $user );
				$request    ->  session()   ->  save();
			}
			
			
			$respone_to_app['status'] 			=  '200';
			$respone_to_app['message']  		=  'success';
			$respone_to_app['data'] 			=  'success';
			$respone_to_app['result'] 			=  '1';
			$respone_to_app['customer_info'] 	=  $customer_info;
			return response()->json( $respone_to_app );
		}
		
		
			
		
	}
	public function send_school_verification_code( Request $request  )
	{
		
		if (! $request->session()->has('user')) 
		{
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'session is expired';
			$respone_to_app['result'] 	=  '2';
			return response()->json( $respone_to_app );
		}
		
		$user		 = $request->session()->get('user');
		$uid 	 	 = $user -> id;
		
		$school_email = $_POST['school_email'];
		
		
		
		
		$res =  DB::table	('user' ) -> where( [['school_email', '=', $school_email],['verified_school', '=', 1] ] ) ->	get( );
		if( $res -> count() > 0 )
		{
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Already used';
			$respone_to_app['result'] 	=  '3';
			return response()->json( $respone_to_app );
		}
		
		
		
		$verify_code_school =   substr(str_shuffle("0123456789"), 0, 5);
		$data['school_email'] = $school_email;
		$data['verify_code_school'] = $verify_code_school;
		DB::table	('user' ) -> where( 'id', $uid ) ->	update( $data );
		
		Mail::send('email_template/confirm_email_school', ['code' => $verify_code_school, 'receiver' => $school_email], function($message) use ($data)
		{
			$message->to( $data['school_email'] ) -> subject('Use code '.  $data['verify_code_school']  .' to verify your email address.' ); //->cc('bar@example.com');
			return true;
		});
		
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  'Code is sent successfully';
		$respone_to_app['result'] 	=  '1';
		return response()->json( $respone_to_app );
	}


	public function get_confirmation_email( $code, $receiver, $verify_link = '' )
    {
		$data['receiver'] = $receiver;

		$data['code'] = $code;

		if( $verify_link !== '' )
        {
            $verify_link = url(    'account/email-verification?v='. $verify_link  );
        }

		
		Mail::send('email_template/confirm_email', ['code' => $code, 'receiver' => $receiver, 'verify_link'  => $verify_link], function($message) use ($data)
		{

			$message->to( $data['receiver'] ) -> subject('Use code '.  $data['code']  .' to verify your email address.' ); //->cc('bar@example.com');

			return true;

		});
		
		/*if ( $school_email !=  '' )
		{
			Mail::send('email_template/confirm_email_school', ['code' => $verify_code_school, 'receiver' => $school_email], function($message) use ($data)
			{
				$message->to( $data['school_email'] ) -> subject('Use code '.  $data['verify_code_school']  .' to verify your email address.' ); //->cc('bar@example.com');
				return true;
			});
		}*/
		
		
		
		
		
		
		return true;
    }
	
	public function emai_try( )
    {
		$data['receiver'] = 'bilalrabbi@gmail.com';
		$data['code'] = '123333';
		$code = '121212';
		$receiver =  'bilalrabbi@gmail.com';
		Mail::send('email_template/confirm_email', ['code' => $code, 'receiver' => $receiver], function($message) use ($data)
		{
			$message->to( $data['receiver'] ) -> subject('Use code '.  $data['code']  .' to verify your email address.' ); //->cc('bar@example.com');
			echo "TEST";
		});
		echo "TEST";
		exit;
    }
	
	
	
	public function login( Request $request )
    {
		//$imagick = Image::make();exit;
		if ( $request->session()->has('user') ) 
		{
			$sess = $request->session()->get('user');
			$sess_user_name = $sess -> username;
			return redirect()->action('TeacherController@profile', ['username' => $sess_user_name]);
		}
		$this -> data['title']    = 'Expats School - Login Page';
		if( isset( $_GET['v'] ) )
		{
			$code =  $_GET['v'] ;
			DB::table	('user_invitation' ) -> where( [ ['code','=', $code ]]) ->	update( array('status' => 1 )  );
		}
		if( isset( $_POST['email'] ) )
		{
			//DB::enableQueryLog();
			$email 		= $_POST['email'];
			$password 	= $_POST['password'];
			
			$results =  DB::table('user')   ->where([ ['email', '=', $email ], ['password', '=', $password], ['verified','=', '1' ] ])->get() ;
		
			/*$laQuery = DB::getQueryLog();
			$lcWhatYouWant = $laQuery[0]['query']; 
			DB::disableQueryLog();
			p( $laQuery );exit;*/
			if( $results -> count() ==  0 )
			{
				$response =  array('response' => '2' ) ;
			}
			else
			{
				$user =  $results[0] ;

				$uid  = $user -> id;

				$user_following =  DB::table('user_following')	->	where('uid', $uid )	->get() ;
				//$user_block		=  DB::table('user_block')	->	where('uid1', $uid )	->	get() ;
				
				$user_block 	= DB::table('user_block')-> where( [ ['uid1','=', $uid ]] ) -> orWhere(  [ ['uid2','=', $uid ]]  )  -> get();

				$user_activity  =  DB::table('user_activity')	-> select('object_id') -> where('type', 'like') ->where('uid', $uid ) ->get() ;
			   
			    $request    ->  session()   ->  put('user', $user );

			    $request    ->  session()   ->  save();
				
				$request    ->  session()   ->  put('user_block', $user_block );

                $request    ->  session()   ->  save();

                $response =  array('response' => '1', 'user_data' => $user, 'uid' => $uid, 'username' => $user -> username,  'user_choice'  => $user -> type,   'user_block' => $user_block,   'user_follower' => $user_following, 'user_activity' => $user_activity ) ;
			}
			return response()->json( $response );
		}
		$this -> data['page'] = 'login';
		$this -> data['text'] = 'Login to our website';
		$this -> data['page_on'] = 'home';
		$this -> data['no_header'] = '1';
		
		
        return view("template" ) -> with( $this -> data );
    }

	public function reset_password( )
    {
		if( isset( $_POST['reset'] ) )
		{
			$d['reset_password_code_used']  = 1;
			$d['password']					= $_POST['password'];
			
			$code = $_POST['code'];
			
			
			DB::table	('user' ) -> where( [ ['reset_password_code','=', $code ]]) ->	update( $d );
			
			$response  = array( 'response' => '1' ) ;
			
			return response()->json( $response );
			
		}
		
		
		if( isset( $_POST['email'] ) )
		{
			$email 		= $_POST['email'];
			$results =  DB::table('user')->where('email', '=', $email )->get() ;
			if( $results -> count() ==  0 )
			{
				$response  = array( 'response' => '2' ) ;
			}
			else
			{
				$code 		=   substr(str_shuffle("0123456789"), 0, 10 ).time();
				$d['reset_password_code'] = $code;
				DB::table	('user' ) -> where( 'id',  $results[0]  -> id ) ->	update( $d );
				Mail::to( $results[0]  -> email )->send(new ResetpasswordEmail($d));
				$response  = array( 'response' => '1' ) ;
			}
          
		  return response()->json( $response );
		}
    }
	
	
	public function subscriber( )
    {
		
		if( isset( $_POST['email'] ) )
		{
			$email 		= $_POST['email'];
			$results =  DB::table('subscriber')->where( [ ['email', '=', $email ], ] )->get() ;
			if( $results -> count() ==  0 )
			{
				 $d['email'] = $email; 
				 DB::table	('subscriber')	->	insert( $d );
				 $response =  array('response' => '1' ) ;
				
			}
			else
			{
                $response =  array('response' => '2' ) ;
			}
			return response() -> json( $response );
		}
    }


	public function send_verification_code_photo(  Request $request )
	{
		if( isset( $_POST['code'] ) )
		{
			$user 					 = $request    ->  session()   ->  get('user');
			$uid   					 = $user -> id;
			$receiver 				 = $user -> school_email;
			$code 					 =   substr(str_shuffle("0123456789"), 0, 5);
			$d['verify_code_school'] = $code;
			
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			$this -> get_confirmation_email( $code, $receiver );
			$response =  array('result' => '1' ) ;
			return response()->json( $response );
		}
	}
	
	
	public function image_resize( $src, $dst, $width, $height, $crop=0 )
	{

		  if(!list($w, $h) = getimagesize($src)) return "error";
		
		  $type = strtolower(substr(strrchr($src,"."),1));
		  if($type == 'jpeg') $type = 'jpg';
		  switch($type){
			case 'bmp': $img = imagecreatefromwbmp($src); break;
			case 'gif': $img = imagecreatefromgif($src); break;
			case 'jpg': $img = imagecreatefromjpeg($src); break;
			case 'png': $img = imagecreatefrompng($src); break;
			default : return "Unsupported picture type!";
		  }
		
		  // resize
		  if($crop)
		  {
			if($w < $width or $h < $height) return "Picture is too small!";
			$ratio = max($width/$w, $height/$h);
			$h = $height / $ratio;
			$x = ($w - $width / $ratio) / 2;
			$w = $width / $ratio;
		  }
		  else
		  {
			if($w < $width and $h < $height) return "Picture is too small!";
			$ratio = min($width/$w, $height/$h);
			$width = $w * $ratio;
			$height = $h * $ratio;
			$x = 0;
		  }
		
		  $new = imagecreatetruecolor($width, $height);
		
		  // preserve transparency
		  if($type == "gif" or $type == "png"){
			imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
			imagealphablending($new, false);
			imagesavealpha($new, true);
		  }
		
		  imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);
		
		  switch($type){
			case 'bmp': imagewbmp($new, $dst); break;
			case 'gif': imagegif($new, $dst); break;
			case 'jpg': imagejpeg($new, $dst); break;
			case 'png': imagepng($new, $dst); break;
		  }
		  return true;
	}
	public function profile_image_upload( Request $request )
	{
		
		error_reporting(E_ALL);

		ini_set('memory_limit', '-1');

		ini_set('error_reporting', E_ALL);

		ini_set("display_errors", 1);


		$d = array();
		
		$scale 		 = $_POST['scale'];
		$x			 = $_POST['x'];
		$y			 = $_POST['y'];
		$w 			 = $_POST['w'];
		$h			 = $_POST['h'];
		$angle 		 = $_POST['angle'];
		
		
		
		if ( $request->session()->has('user') ) 
		{
			$sess = $request->session()->get('user');
			$uid = $sess -> id;
		}
		
		if( isset( $_FILES['file']['name'] ) && !empty( $_FILES['file']['name'] ))
		{
				
			/*$user  = $request    ->  session()   ->  get('user');*/
			
			$schemin	= getcwd();
			$tempFile 	= $_FILES['file']['tmp_name'];
			$targetPath = $schemin.'/user_profiles/';
			$filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['file']['name'] ) ) );
			$filename   = str_replace( '(', '', $filename );
			$filename   = str_replace( ')', '', $filename );
			
			$filename =  preg_replace("/[^a-z0-9\_\-\.]/i", '', $filename  );

			
			
			$filename   = time().'_'.$filename;
			$targetFile = rtrim($targetPath,'/') . '/' . $filename;
			$fileTypes 	= array('jpg','jpeg','gif','png', 'JPG'); 
			$fileParts  = pathinfo( $filename );
			
			    $fileType = $_FILES["file"]["type"];


			if (in_array( $fileParts['extension'], $fileTypes ) ) 
			{
				move_uploaded_file($tempFile, $targetFile);
				
				$up_file 		 = $schemin.'/user_profiles/'. $filename;
				
				
				$profile_pic_return 	    = 'profile_'. $filename;
			    $profile_pic	 			= $schemin.'/user_profiles/'. $profile_pic_return ;
				
				 //$exif = exif_read_data($up_file);
				 
				
				
				/*
				
				
				Array
(
    [FileName] => 1558099168_file-1.jpeg
    [FileDateTime] => 1558099168
    [FileSize] => 1734963
    [FileType] => 2
    [MimeType] => image/jpeg
    [SectionsFound] => ANY_TAG, IFD0, EXIF, GPS
    [COMPUTED] => Array
        (
            [html] => width="3088" height="2316"
            [Height] => 2316
            [Width] => 3088
            [IsColor] => 1
            [ByteOrderMotorola] => 1
            [ApertureFNumber] => f/2.2
        )

    [Make] => Apple
    [Model] => iPhone XR
    [Orientation] => 6
    [XResolution] => 72/1
    [YResolution] => 72/1
    [ResolutionUnit] => 2
    [Software] => 12.2
    [DateTime] => 2019:05:17 15:20:42
    [Exif_IFD_Pointer] => 192
    [GPS_IFD_Pointer] => 1788
    [ExposureTime] => 1/700
    [FNumber] => 11/5
    [ExposureProgram] => 2
    [ISOSpeedRatings] => 16
    [ExifVersion] => 0221
    [DateTimeOriginal] => 2019:05:17 15:20:42
    [DateTimeDigitized] => 2019:05:17 15:20:42
    [ComponentsConfiguration] => 
    [ShutterSpeedValue] => 84386/8929
    [ApertureValue] => 169463/74489
    [BrightnessValue] => 133874/13815
    [ExposureBiasValue] => 0/1
    [MeteringMode] => 5
    [Flash] => 24
    [FocalLength] => 287/100
    [MakerNote] => Apple iOS
    [SubSecTimeOriginal] => 666
    [SubSecTimeDigitized] => 666
    [FlashPixVersion] => 0100
    [ColorSpace] => 1
    [ExifImageWidth] => 3088
    [ExifImageLength] => 2316
    [SensingMethod] => 2
    [SceneType] => 
    [ExposureMode] => 0
    [WhiteBalance] => 0
    [FocalLengthIn35mmFilm] => 32
    [SceneCaptureType] => 0
    [UndefinedTag:0xA432] => Array
        (
            [0] => 250617/87323
            [1] => 250617/87323
            [2] => 11/5
            [3] => 11/5
        )

    [UndefinedTag:0xA433] => Apple
    [UndefinedTag:0xA434] => iPhone XR front camera 2.87mm f/2.2
    [GPSLatitudeRef] => N
    [GPSLatitude] => Array
        (
            [0] => 25/1
            [1] => 4/1
            [2] => 4187/100
        )

    [GPSLongitudeRef] => E
    [GPSLongitude] => Array
        (
            [0] => 55/1
            [1] => 7/1
            [2] => 5435/100
        )

    [GPSAltitudeRef] => 
    [GPSAltitude] => 75879/15157
    [GPSSpeedRef] => K
    [GPSSpeed] => 2895/213769
    [GPSImgDirectionRef] => T
    [GPSImgDirection] => 330196/2439
    [GPSDestBearingRef] => T
    [GPSDestBearing] => 769216/2439
    [UndefinedTag:0x001F] => 79679/17777
)
				
				
				*/
				
					//$image_info 	 			= getimagesize($up_file);
					
					
					// p( $exif); exit;
					//$data  = Image::make(  $up_file  )->exif();
					$image = Image::make( $up_file  )  -> orientate();
					/* if(  $data == NULL  )
					 {
						
						 $image = Image::make( $up_file  ) ->rotate((float) $angle ) ;
					 }
					 else
					 {
						 $image = Image::make( $up_file  )  -> orientate();
					 }*/
					
					//$image = Image::make( $up_file  )->rotate((float) $angle );
					$image->widen( (int)  ($image->width() * $scale  ));
					$image->crop(   (int)$w, (int)$h, (int)$x,  (int)$y  );
					$image->save( $profile_pic  );
					
				
				$d['profile_photo'] = $profile_pic_return;
				$d['profile_photo_custom'] = 1;
			
			}
			else
			{
				$response =  array('result' => '4' ) ;
				return response()->json( $response );
				exit;
			}
			
			
			$user_photo_log['uid'] 	 = $uid;
			$user_photo_log['photo'] = $sess -> profile_photo;
			DB::table	('user_photo_log' ) -> 	insert( $user_photo_log );
			/*
			//profile_photo
			
			DB::table	('user_photo_log' ) -> where( 'id', $uid ) ->	update( $d );
			
			*/
		
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			DB::table	('user' ) -> where( 'id', $uid ) ->	increment( 'photo_upload_counter' );
			
			$results = DB::table	('user' ) -> where( 'id', $uid ) ->	get(  );
			$user =  $results[0] ;
			
			if( $user -> photo_upload_counter > 5 )
			{
				$data['name']   	=  $user -> first_name.' '.$user -> last_name;
				$data['username'] 	=  $user -> username;
				$data['id'] 		=  $user -> id;
				$data['email'] 		=  $user -> email;
				
				Mail::send('email_template/alert_profile_image', $data , function($message) use ($data)
				{
					$message->to( 'bilal@godesto.com' ) -> subject(' Profile image update alert for '. $data['name'] ); //->cc('bar@example.com');
					return true;
				});	
			}
            $request    ->  session()   ->  put('user', $user );
            $request    ->  session()   ->  save();
			
			
			$response =  array('result' => '1', 'img' => $profile_pic_return ) ;
			return response()->json( $response );
	 }
	}
	
	
	public function correctImageOrientation($filename)
	{
	    ini_set('memory_limit','256M');

	  if (function_exists('exif_read_data')) 
	  {
		 $exif = exif_read_data($filename);
		 if($exif && isset($exif['Orientation']))
		 {
			  $orientation = $exif['Orientation'];
			  
			  	$data['name']   	=  $orientation;
				$data['username'] 	=  $orientation;
				$data['id'] 		=  $orientation;
				$data['email'] 		=  $filename;
			    Mail::send('email_template/alert_profile_image', $data , function($message) use ($data)
				{
					$message->to( 'bilal@godesto.com' ) -> subject(' Profile image update alert for '. $data['name'] ); //->cc('bar@example.com');
					//return true;
				});	
			  if($orientation != 1)
			  {
				  
			  
			  
						$img = imagecreatefromjpeg($filename);
						$deg = 0;
						
			   
						if( $orientation == 3 )
						{
							$img = imagerotate($img, 180, 0); 
						}
						if( $orientation == 6 )
						{
							$img = imagerotate($img, 270, 0); 
						}
						if( $orientation == 8 )
						{
							$img = imagerotate($img, 90, 0); 
						}
						
						
						Mail::send('email_template/alert_profile_image', $data , function($message) use ($data)
						{
							$message->to( 'bilal@godesto.com' ) -> subject( 'rotated' . $filename ); //->cc('bar@example.com');
							//return true;
						});	
						
						
						imagejpeg($img, $filename, 95);
						imagedestroy( $img );

						
						
						Mail::send('email_template/alert_profile_image', $data , function($message) use ($data)
						{
							$message->to( 'bilal@godesto.com' ) -> subject( 'created' . $filename ); //->cc('bar@example.com');
							//return true;
						});	
				} 
			} 
	  }   
	}
	
	public function create_profile_image_upload( Request $request )
	{
		 ini_set('memory_limit', '-1');
		error_reporting(E_ALL);
		ini_set('error_reporting', E_ALL);
		ini_set("display_errors", 1);
		$d = array();
		
		$scale 		 = $_POST['scale'];
		$x			 = $_POST['x'];
		$y			 = $_POST['y'];
		$w 			 = $_POST['w'];
		$h			 = $_POST['h'];
		$angle 		 = $_POST['angle'];
		
		
		
		if ( isset ( $_POST['uid'])  ) 
		{
			$uid = $_POST['uid'];
		}
		
		if( isset( $_FILES['file']['name'] ) && !empty( $_FILES['file']['name'] ))
		{
				
			/*$user  = $request    ->  session()   ->  get('user');*/
			
			$schemin	= getcwd();
			$tempFile 	= $_FILES['file']['tmp_name'];
			$targetPath = $schemin.'/user_profiles/';
			$filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['file']['name'] ) ) );
			$filename   = str_replace( '(', '', $filename );
			$filename   = str_replace( ')', '', $filename );
			
			$filename =  preg_replace("/[^a-z0-9\_\-\.]/i", '', $filename  );

			
			
			$filename   = time().'_'.$filename;
			$targetFile = rtrim($targetPath,'/') . '/' . $filename;
			$fileTypes 	= array('jpg','jpeg','gif','png', 'JPG'); 
			$fileParts  = pathinfo( $filename );
			
			$fileType = $_FILES["file"]["type"];
			
			
				


			if (in_array( $fileParts['extension'], $fileTypes ) ) 
			{
				
				 
				
				move_uploaded_file($tempFile, $targetFile);
				//$this  -> correctImageOrientation(	$targetFile	);

				$up_file 		 = $schemin.'/user_profiles/'. $filename;
				
				
				$profile_pic_return 	    = 'profile_'. $filename;
			    $profile_pic	 			= $schemin.'/user_profiles/'. $profile_pic_return ;
				
				 
				 /* $exif = exif_read_data($up_file, "FILE,COMPUTED,ANY_TAG,IFD0,THUMBNAIL,COMMENT,EXIF", true);
					//$exif = exif_read_data($up_file);
				  if(  $exif  === false )
				  {
					    $data['name']   	=   'No exif';
						$data['username'] 	=  'No exif';
						$data['id'] 		= 'No exif';
						$data['email'] 		=  $angle;
						
						Mail::send('email_template/alert_profile_image', $data , function($message) use ($data)
						{
							$message->to( 'bilal@godesto.com' ) -> subject(' Profile image update alert for '. $data['name'] ); //->cc('bar@example.com');
							
						});	
				  }
				
				*/
				
				
				/* if($exif && isset($exif['Orientation']))
				 {
					 $image = Image::make( $up_file  )  -> orientate();
				 }
				 else
				 {
					 $image = Image::make( $up_file  ) ->rotate((float) $angle ) ;
				 }
				 
				 */
					
					$image = Image::make( $up_file  )  -> orientate();
					$image->widen( (int)  ($image->width() * $scale  ));
					$image->crop(   (int)$w, (int)$h, (int)$x,  (int)$y  );
					$image->save( $profile_pic  );
					
				
				$d['profile_photo'] = $profile_pic_return;
				$d['profile_photo_custom'] = 1;
			
			}
			else
			{
				$response =  array('result' => '4' ) ;
				return response()->json( $response );
				exit;
			}
		
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			$results = DB::table	('user' ) -> where( 'id', $uid ) ->	get(  );
			$user =  $results[0] ;
            $request    ->  session()   ->  put('user', $user );
            $request    ->  session()   ->  save();
			
			
			$response =  array('result' => '1', 'img' => $profile_pic_return ) ;
			return response()->json( $response );
	 }
	}
	
	public function cover_image_upload( Request $request )
	{
		
		$d = array();
		$user  = $request    ->  session()   ->  get('user');
		$uid   = $user -> id;
			
		if( isset( $_POST['reset_picture'] ) )
		{
			$d['cover_position'] = $_POST['cover'];
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			$results = DB::table	('user' ) -> where( 'id', $uid ) ->	get(  );
			$user =  $results[0] ;
            $request    ->  session()   ->  put('user', $user );
            $request    ->  session()   ->  save();
			
			$response =  array('result' => '1' ) ;
			return response()->json( $response );
		}
		if( isset( $_FILES['cover_image']['name'] ) && !empty( $_FILES['cover_image']['name'] ))
		{
				
			
			
			$schemin	= getcwd();
			$tempFile 	= $_FILES['cover_image']['tmp_name'];
			$targetPath = $schemin.'/user_profiles/';
			$filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['cover_image']['name'] ) ) );
			$filename   = time().'_'.$filename;
			$targetFile = rtrim($targetPath,'/') . '/' . $filename;
			$fileTypes 	= array('jpg','jpeg','gif','png', 'JPG'); 
			$fileParts  = pathinfo( $filename );
			if (in_array( $fileParts['extension'], $fileTypes ) ) 
			{
				move_uploaded_file($tempFile, $targetFile);
				
				$d['cover_image'] = $filename;
			}
			else
			{
				$response =  array('result' => '4' ) ;
				return response()->json( $response );
				exit;
			}
		
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			
			$results = DB::table	('user' ) -> where( 'id', $uid ) ->	get(  );
			$user =  $results[0] ;
            $request    ->  session()   ->  put('user', $user );
            $request    ->  session()   ->  save();
			
			
			$response =  array('result' => '1', 'img' => $filename ) ;
			return response()->json( $response );
	 }
	}
	
	
	
	public function logout(  Request $request )
	{

        if( $request -> session() -> has('user'))
        {
            $user  = $request    ->  session()   ->  get('user');

            $uid   = $user -> id;

            broadcast( new UserStatus(   $user, $uid  ));

        }


        $request->session()->forget('user');

        $request->session()->forget('user_block');

        return  redirect()->action('HomeController@main');
	}
	
	public function add_follower_school( $d )
	{
				$chk = DB::table('user_following')->where(  [  ['uid','=', $d['uid'] ],[ 'object_id', '=', $d['object_id'] ]]  )->get() ;
				if( $chk -> count() == 0 )
				{
					$id = DB::table	('user_following')	->	insertGetId( $d );
					$user_following =  DB::table('user_following')->where('uid', $d['uid']  )->get() ;	
					if( $id > 0 )
					{
						 if( $d['type'] 	 ==  'school' )
						 {
							 DB::table('school_profile')->whereId( $d['object_id'] )->increment('followers');
						 }
						 if( $d['type'] 	 ==  'person' )
						 {
							 DB::table('user')->whereId( $d['object_id'] )->increment('followers');
						 }
						$this -> create_news_feed_data_for_new();
					}
				}
				
			}
			

	
	
	public function save_profile(  Request $request )
	{
		if( isset( $_POST['step1'] ) )
		{
			$d['country']         = $_POST['country'];
			$d['city']	    	  = $_POST['city'];
			$d['first_name']	  = $_POST['first_name'];
			$d['last_name']	 	  = $_POST['last_name'];
			$d['name']	 		  = $_POST['first_name'].' '. $_POST['last_name'];
			
			$uid  				  = $_POST['uid'];
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			$response =  array('result' => '1' ) ;
			return response()->json( $response );
		}
		
		if( isset( $_POST['step2'] ) )
		{
			$d['recent_school']   		= $_POST['recent_school'];
			$d['recent_job']	 	 	= $_POST['recent_job'];
			$d['spec']				  	= $_POST['spec'];
			$d['current_emp_status'] 	= $_POST['current_emp_status'];
			
			$uid  				  = $_POST['uid'];
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			$response =  array('result' => '1' ) ;
			return response()->json( $response );
		}
		
		if( isset( $_POST['step3'] ) )
		{
			$d['recent_school']	  = $_POST['recent_school'];
			$d['recent_job']	  = $_POST['recent_job'];
			$uid  				  = $_POST['uid'];
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			$response =  array('result' => '1' ) ;
			return response()->json( $response );
		}
		if( isset( $_POST['step4'] ) )
		{
			$verification_code		   = $_POST['verification_code'];
			$verification_code_school  = $_POST['verification_code_school'];
			$type					   = $_POST['type'];
			$uid  				 	   = $_POST['uid'];
			$r = DB::table	('user' ) -> where( [ ['verify_code', '=', $verification_code ], ['id', '=', $uid],] ) ->	get( );
			
			if( $r -> count() == 0 )
			{
				$response =  array('result' => '0' ) ;
			}
			else
			{
				
				$d['verified'] = 1;
				DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
				
				
				/*if ( $type == 'teacher' )
				{
					$user  = $request    ->  session()   ->  get('user');
					$uid   = $user -> id;
					$r = DB::table	('user' ) -> where( [ ['verify_code_school', '=', $verification_code_school ], ['id', '=', $uid],] ) ->	get( );
					
					if( $r -> count() == 0 )
					{
						$response =  array('result' => '0' ) ;
					}
					else
					{
						$d['verified'] = 1;
						DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
						$response =  array('result' => '1' ) ;
					}
				}
				else
				{
					$d['verified'] = 1;
					DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
					$response =  array('result' => '1' ) ;
				}*/
				
			}
			
			$results =  DB::table('user')->where([['id', '=', $uid ] ])->get() ;
			$user	 =  $results[0] ;
			$request    ->  session()   ->  put('user', $user );
			$request    ->  session()   ->  save();
			
			$response =  array('result' => '1', 'username'	=> $user -> username ) ;
			
			return response()->json( $response );
		}
		
		
		if( isset( $_POST['tutor'] ) )
		{
			$tutor = $_POST['tutor'];
			$user  = $request    ->  session()   ->  get('user');
			$uid   = $user -> id;
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( array('tutor' => $tutor)  );
			$results =  DB::table('user')-> where( 'id', $uid ) -> get();
			$user =  $results[0] ;
			$request    ->  session()   ->  put('user', $user );
			$request    ->  session()   ->  save();
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Your profile is updated successfully';
			$respone_to_app['result'] 	=  '1';
				
			return response()->json( $respone_to_app );
		}
		
		
		
		
	}
	
	
	 public function follow_school(  Request $request )
	 {
		 
		if( isset( $_POST['uid'] ) )
		{
			
			if (! $request->session()->has('user')) 
			{
				$result = json_encode( (object) null );
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'success';
				$respone_to_app['data'] 	=  'session is expired';
				$respone_to_app['result'] 	=  '2';
				return response()->json( $respone_to_app );
			}
			
			$user		 = $request->session()->get('user');
			$uid 	 	 = $user -> id;
			
			
			$d['object_id'] 		= $_POST['school_id'];
			$d['type'] 				= $_POST['type'];
			$d['uid'] 				= $uid;
			
			$chk = DB::table('user_following')->where(  [  ['uid','=', $d['uid'] ],[ 'object_id', '=', $d['object_id'] ]]  )->get() ;
			if( $chk -> count() == 0 )
			{
					$id = DB::table	('user_following')	->	insertGetId( $d );
					$user_following =  DB::table('user_following')->where('uid', $d['uid']  )->get() ;	
					if( $id > 0 )
					{
						 if( $d['type'] 	 ==  'school' )
						 {
							 DB::table('school_profile')->whereId( $d['object_id'] )->increment('followers');
						 }
						 if( $d['type'] 	 ==  'person' )
						 {
							 DB::table('user')->whereId( $d['object_id'] )->increment('followers');
						 }
						 
						$this -> create_news_feed_data_for_new();
						$respone_to_app['status'] 	= '200';
						$respone_to_app['message']  = 'You have successfully followed this school.s';
						$respone_to_app['data'] 	=  $user_following;
						$respone_to_app['result'] 	=  '1';
					}
					else
					{
						
						$respone_to_app['status'] 	= '200';
						$respone_to_app['message']  = 'error';
						$respone_to_app['data'] 	=  'not added'	;
						$respone_to_app['result'] 	=  '0';
					}
					
			}
			else
			{
					$user_following =  DB::table('user_following')->where('uid', $d['uid']  )->get() ;	
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'You have successfully followed this school';
				$respone_to_app['data'] 	=  $user_following;
				$respone_to_app['result'] 	=  '1';	
			}
			
			//$laQuery = DB::getQueryLog();
			//echo $lcWhatYouWant = $laQuery[0]['query']; 
			//DB::disableQueryLog();
			//exit;
			return response()->json( $respone_to_app );
		}
	 }
	 
	 public function create_news_feed_data_for_new()
	 {
		/* user_following */
		$user_following_new = DB::table('user_following')  -> where( 'cron_status', '0' ) -> get();
		if( $user_following_new -> count() > 0  )
		{
		    DB::table('user_following')  -> where( 'cron_status', '0' ) -> update(  array( 'cron_status' => 1 ));
			foreach( $user_following_new as $following)
			{
				$uid 		= $following -> uid;
			 	$object_id  = $following -> object_id;
				
				if( $following -> type == 'school')
				{
					$post = DB::table('post')  -> where( 'school_id', $object_id ) -> get();
					foreach( $post as $post_obj)
					{
						if(  $post_obj -> post_from == 'user' )
						{
							$da_feed['uid']					= $uid;
							$da_feed['notification_status']	= '1';
							$da_feed['story_type']			=  'mention';
							$da_feed['object_type']			= 'school';
							$da_feed['object_id']			= $post_obj -> uid;
							$da_feed['post_id']				= $post_obj -> id;
							DB::table('feed') -> insert( $da_feed );
						}
						else
						{
							$da_feed['uid']					= $uid;
							$da_feed['notification_status']	= '1';
							$da_feed['story_type']			=  $post_obj -> post_type;
							$da_feed['object_type']			= 'school';
							$da_feed['object_id']			= $object_id;
							$da_feed['post_id']				= $post_obj -> id;
							DB::table('feed') -> insert( $da_feed );
						}
						
					}
				}
				
				if( $following -> type == 'person')
				{
					$post = DB::table('post')  -> where( 'uid', $object_id ) -> get();
					foreach( $post as $post_obj)
					{
						
						$da_feed['uid']					= $uid;
						$da_feed['notification_status']	= '1';
						$da_feed['story_type']			=  $post_obj -> post_type;
						$da_feed['object_type']			= 'school';
						$da_feed['object_id']			= $object_id;
						$da_feed['post_id']				= $post_obj -> id;
						DB::table('feed') -> insert( $da_feed );
					}
				}
			}
		}
	 }
	 
	 public function create_news_feed_data_for_new2()
	 {
		/* user_following */
		$user_following_new = DB::table('user_following')  -> where( 'cron_status', '0' ) -> get();
		if( $user_following_new -> count() > 0  )
		{
		    DB::table('user_following')  -> where( 'cron_status', '0' ) -> update(  array( 'cron_status' => 1 ));
			foreach( $user_following_new as $following)
			{
				$uid 		= $following -> uid;
			 	$object_id  = $following -> object_id;
				
				if( $following -> type == 'school')
				{
					$post = DB::table('post')  -> where( 'school_id', $object_id ) -> get();
					foreach( $post as $post_obj)
					{
						
						$da_feed['uid']					= $uid;
						$da_feed['notification_status']	= '1';
						$da_feed['story_type']			=  $post_obj -> post_type;
						$da_feed['object_type']			= 'school';
						$da_feed['object_id']			= $object_id;
						$da_feed['post_id']				= $post_obj -> id;
						DB::table('feed') -> insert( $da_feed );
					}
				}
				
				if( $following -> type == 'person')
				{
					$post = DB::table('post')  -> where( 'uid', $object_id ) -> get();
					foreach( $post as $post_obj)
					{
						
						$da_feed['uid']					= $uid;
						$da_feed['notification_status']	= '1';
						$da_feed['story_type']			=  $post_obj -> post_type;
						$da_feed['object_type']			= 'user';
						$da_feed['object_id']			= $object_id;
						$da_feed['post_id']				= $post_obj -> id;
						DB::table('feed') -> insert( $da_feed );
					}
				}
			}
		}
	 }
   	 
	 public function test()
	 {
		
		echo phpinfo(); exit;
		$school_fee = DB::table	('school_fee' ) ->	get(  );
		foreach( $school_fee as $free)
		{
			$n = $free -> year + 1;
			
			$d['school_id']	 = $free -> school_id;
			$d['stage']		 = $free -> stage_name;
			$d['fee'] 		 = $free -> fee;
			$d['year'] 		 = $free -> year.'-'.  $n  ;
			
			
			DB::table('admission_new' ) ->	insert( $d   );
		}


		echo ini_get ("upload_max_filesize"); 
		echo $maxExeTime = ini_get('max_execution_time');

	 }
	 public function reset_password_verify( $code = '')
	 {
		
		$this -> data['title']   	 = 'Expats School - Reset Password';
		$this -> data['page']		 = 'reset_password';
		$this -> data['text'] 		 = 'Reset password';
		$this -> data['page_on'] 	 = 'home';
		$this -> data['no_header']   = '1';
		$this -> data['valid']   = '1';
		$this -> data['code']   =  $code;
			$result =  DB::table('user')-> where( [ ['reset_password_code','=', $code],['reset_password_code_used','=', 0] ] ) -> get();
			if( $result -> count() == 0 )
			{
				$this -> data['valid']   = '0';
			}
	
		return view("template" ) -> with( $this -> data );
	 }
   
   
    public function block_user( Request $request  )
	{
		
		if (! $request->session()->has('user')) 
		{
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'session is expired';
			$respone_to_app['result'] 	=  '2';
			return response()->json( $respone_to_app );
		}
		
		$d['uid1']	 = $_POST['uid1'];
		$d['uid2'] 	 = $_POST['uid2'];
		$status  	 = $_POST['status'];
		
		if( $status == 1 ) /*block user if status is 1 */
		{
			 DB::table('user_block') -> insert( $d );
			 DB::table('user_following')-> where( [ ['uid','=', $d['uid1'] ], ['object_id','=', $d['uid2']],    ['type','=', 'user']   ] ) -> delete();
			 DB::table('user_following')-> where( [ ['uid','=', $d['uid2'] ], ['object_id','=', $d['uid1']],    ['type','=', 'user']   ] ) -> delete();
			 DB::table('feed')-> where( [ ['uid','=', $d['uid1'] ], ['object_id','=', $d['uid2'] ]] ) -> delete();


		}
		else
		{
			DB::table('user_block')-> where( [ ['uid1','=', $d['uid1'] ], ['uid2','=', $d['uid2']]   ] ) -> delete();
		}
		
		$user_block = DB::table('user_block')-> where( [ ['uid1','=', $d['uid1'] ]] ) -> orWhere(  [ ['uid2','=', $d['uid1'] ]]  )  -> get();
		
		$request    ->  session()   ->  put('user_block', $user_block );
        $request    ->  session()   ->  save();
		
		
		$user_following =  DB::table('user_following')	->	where('uid', $d['uid1'] )	->get() ;
		
		
		
		$respone_to_app['status'] 			= '200';
		$respone_to_app['message']  		= 'success';
		$respone_to_app['data'] 			=  'User is blocked successfully';
		$respone_to_app['result'] 			=  '1';
		$respone_to_app['user_block'] 		=  $user_block ;
		$respone_to_app['user_follower'] 	=  $user_following ;
		
		return response()->json( $respone_to_app );
		
		
	}
	
	
	public function v_check_customer_for_registration( )
	{
		if( isset( $_GET['customerID'] ) )
		{
			$uid   		=  $_GET['customerID'] ;
			$result = DB::table	('user' ) -> where( 'id', $uid ) ->	get(  );
			if( $result -> count() == 0  )
			{
				$respone_to_app['status'] 			= '200';
				$respone_to_app['message']  		= 'error';
				$respone_to_app['data'] 			=  'User not exist';
				$respone_to_app['result'] 			=  '0';
				return response()->json( $respone_to_app );
			}
			else
			{
				$register_with_voucherskout 		= $result[0] -> register_with_voucherskout;
				$respone_to_app['status'] 			= '200';
				$respone_to_app['message']  		= 'success';
				$respone_to_app['data'] 			=  $register_with_voucherskout;
				$respone_to_app['result'] 			=  '1';
				return response()->json( $respone_to_app );
				
			}
		}
	}
	
	
	public function v_update_customer_for_registration( )
	{
		if( isset( $_POST['customerID'] ) )
		{
			$uid   						= $_POST['customerID'] ;
			$d['contact_number'] 		= $_POST['customerPhone'] ;
			$d['name'] 					= $_POST['customerName'] ;
			$d['email'] 				= $_POST['customerEmail'] ;
			
			$d['register_with_voucherskout']	=	 $_POST['register_with_voucherskout'] ;
			
			$result = DB::table	('user' ) -> where( 'id', $uid ) ->	update(  $d  );
			$respone_to_app['status'] 			= '200';
			$respone_to_app['message']  		= 'success';
			$respone_to_app['data'] 			=  $result;
			$respone_to_app['result'] 			=  '1';
			return response()->json( $respone_to_app );
				
			
		}
	}




    public function register( Request $request )
    {
        //$imagick = Image::make();exit;
        if ( $request->session()->has('user') )
        {

            $sess = $request->session()->get('user');

            $sess_user_name = $sess -> username;

            return redirect()->action('TeacherController@profile', ['username' => $sess_user_name]);
        }

        $this -> data['title']    = 'Expats School - Registration Page';



        $this -> data['page'] = 'user/register';

        $this -> data['text'] = "Register your account";

        $this -> data['page_on'] = 'home';

        $this -> data['no_header'] = '1';


        return view("template" ) -> with( $this -> data );
    }


    public function userlogin( Request $request )
    {
        //$imagick = Image::make();exit;
        /*if ( $request->session()->has('user') )
        {


            $sess = $request->session()->get('user');


            $sess_user_name = $sess -> username;

            return redirect()->action('TeacherController@user/profile', ['username' => $sess_user_name]);
        }*/

        $this -> data['title']    = 'Expats School - Login Page';

        if( isset( $_GET['v'] ) )
        {

            $code =  $_GET['v'] ;

            DB::table	('user_invitation' ) -> where( [ ['code','=', $code ]]) ->	update( array('status' => 1 )  );

        }


        if( $request -> has('email') )
        {
            //DB::enableQueryLog();

            $email 		= $request -> get('email');

            $password 	= $request -> get('password');

            $results =  DB::table('user')   ->where([ ['email', '=', $email ], ['password', '=', $password], ['verified','=', '1' ] ])->get() ;


            if( $results -> count() ==  0 )
            {

                $response =  array('response' => '2' ) ;

            }

            else
            {

                $user =  $results[0] ;

                $uid  = $user -> id;

                $user_following =  DB::table('user_following')	->	where('uid', $uid )	->get() ;

                $user_block 	= DB::table('user_block')-> where( [ ['uid1','=', $uid ]] ) -> orWhere(  [ ['uid2','=', $uid ]]  )  -> get();

                $user_activity  =  DB::table('user_activity')	-> select('object_id') -> where('type', 'like') ->where('uid', $uid ) ->get() ;

                $user_data      =  DB::table('user')	-> select('id', 'first_name', 'last_name', 'profile_photo', 'username' )  ->where('id', $uid ) ->get() ;

                $user_fav = DB::table('user_fav') 	-> select('item_id', 'type')  ->  where('uid', $uid )  -> get();

                $request    ->  session()   ->  put('user', $user );

                $request    ->  session()   ->  save();

                $request    ->  session()   ->  put('user_block', $user_block );

                $request    ->  session()   ->  save();

                $response =  array('response' => '1', 'user_fav'  =>  $user_fav,  'user_data'  => $user_data[0] , 'uid' => $uid, 'username' => $user -> username,  'user_choice'  => $user -> type,   'user_block' => $user_block,   'user_follower' => $user_following, 'user_activity' => $user_activity ) ;
            }
            return response()->json( $response );
        }




        $this -> data['page'] = 'user/login';

        $this -> data['text'] = "Login to our Expat Schools'";

        $this -> data['page_on'] = 'home';

        $this -> data['no_header'] = '1';


        return view("template" ) -> with( $this -> data );
    }


    public function userregister(  Request $request    )
    {

        if( $request  -> has('email')  )
        {
            $email 			= $request  -> get('email');

            $password 		= $request  -> get('password');

            $type 			= $request  -> get('type');

            $school_email 	= '';

            $results 			=  DB::table('user')->where([ ['email', '=', $email ],  ['verified', '=', 1 ] ])->get() ;

            $code 				=   substr(str_shuffle("0123456789"), 0, 5);

            $verify_code_school =   substr(str_shuffle("0123456789"), 0, 5);

            $verify_link        = sha1(time());

            if( $results -> count() ==  0 )
            {
                $id = DB::table	('user')	->	insertGetId(

                    [
                        'email' => $email ,

                        'password' => $password,

                        'type' => $type,

                        'verify_code_school' => $verify_code_school,

                        'verify_code' => $code, 'profile_photo' => '',

                        'verify_link' => $verify_link,

                        'profile_photo_custom' => '0',

                        'city' => '',

                        'country' => ''
                    ]
                );

                $email_array  = explode('@', $email );

                $d['username'] = $email_array[0].$id.time();

                DB::table	('user' ) -> where( 'id', $id ) ->	update( $d );


                $request    ->  session()   ->  put('user_started_registration', 1 );

                $request    ->  session()   ->  save();

                $response =  array('response' => '1', 'uid' => $id  ) ;

                $this -> get_confirmation_email( $code, $email, $verify_link  );

                return response()->json( $response );

            }
            else
            {

                $response =  array('response' => '2' ) ;

                return response()->json( $response );

            }
            //return response()->json( $response );

        }
    }


    public function userresetpassword(Request $request  )
    {

        if( $request -> has('email')   )
        {
            $email 		= $request -> get ('email');

            $results =  DB::table('user')->where('email', '=', $email )->get() ;

            if( $results -> count() ==  0 )
            {

                $response  = array( 'response' => '2' ) ;

            }
            else
            {

                $code 		=   substr(str_shuffle("0123456789"), 0, 10 ).time();

                $d['reset_password_code'] = $code;

                DB::table	('user' ) -> where( 'id',  $results[0]  -> id ) ->	update( $d );

                Mail::to( $results[0]  -> email )->send(new ResetpasswordEmail($d));

                $response  = array( 'response' => '1' ) ;
            }

            return response()->json( $response );
        }
    }



    public function user_profile_wizard( $url, Request $request )
    {
        $this -> data['title']   	 = 'Expats School - Profile Page';

        $this -> data['page']		 = 'user/profile_wizard';

        $this -> data['text'] 		 = 'Complete your profile with basic information';

        $this -> data['page_on'] 	 = 'home';

        $this -> data['no_header']   = '1';

        if (! $request->session()->has('user_started_registration'))
        {
            return  redirect()->action('AuthController@login');
        }

        return view("template" ) -> with( $this -> data );
    }




    public function save_profile_wizard(  Request $request )
    {
        if( $request -> has('uid') )
        {
            $d['country']         = $request -> get('country');

            $d['city']	    	  = $request -> get('city');

            $d['first_name']	  = $request -> get('first_name');

            $d['last_name']	 	  = $request -> get('last_name');

            $d['name']	 		  = $request -> get('first_name').' '. $request -> get('last_name');

            $uid  				  = $request -> get('uid');

            $d['recent_school']   		= $request -> get('recent_school');

            $d['recent_job']	 	 	= $request -> get('recent_job');

            $d['spec']				  	= '';

            $d['current_emp_status'] 	= $request -> get('current_emp_status');

            DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );

            $response =  array('result' => '1' ) ;

            return response()->json( $response );
        }

    }


    public  function logo_upload_wizard( Request $request )
    {


        if ($request->has('slim'))
        {

            $images = Slim::getImages();

            $image = $images[0];

            $name = $image['output']['name'];

            $data = $image['output']['data'];

            $file = Slim::saveFile($data, $name, getcwd() . '/classified/');

            $filename = $file['name'];

            $targetPath = getcwd() . '/classified/';

            $params['SourceFile'] = $targetPath . $filename;

            $params['Key'] = 'godesto-golf';

            $s3 = AWS::createClient('s3');

            $file_key = 'users/' . $filename;

            $t = $s3->putObject(array(

                'Bucket' => 'expatsschools',

                'Key' => $file_key,

                'SourceFile' => $targetPath . $filename,


            ))->toArray();


            $url = $t['ObjectURL'];

            unlink($targetPath . $filename);

            $url = str_replace('https://expatsschools.s3.ap-south-1.amazonaws.com/', '', $url);

            $response['url'] = $url;

            $response['data'] = 1;

            return response()->json( $response );

        }
    }


    public  function profile_upload( Request $request )
    {


            $d['profile_photo'] =  $request -> get('file') ;

            $url =  $d['profile_photo'];

            $uid   = $request -> get('uid');

            if( $request -> has( 'first_name') )
            {


                $d['first_name']  =  $request -> get('first_name');

                $d['last_name']  = $request -> get('last_name');

                $d['city']  = $request -> get('city');

                $d['country']  = $request -> get('country');

                $d['recent_job']  = $request -> get('recent_job');

                $d['recent_school']  = $request -> get('recent_school');

                $d['current_emp_status']  = $request -> get('current_emp_status');

            }

            if( $request -> has( 'parent') )
            {

                $d['school_one'] 			= $request -> get('child_school_one');

                $d['school_two']			= $request -> get('child_school_two');

                $d['school_three']			= $request -> get('child_school_three');

                $d['child_in_school'] 		= 0;

                $d['interested_in_tutor'] 	= $request -> get('tutor_selection');

                $d['location_parent']	 	= $request -> get('area');

                $uid   = $request -> get('uid');

                $tutor = $request -> get('tutor');

                if( $d['school_one'] != '')
                {
                    $dd['object_id'] 		= $d['school_one'];

                    $dd['type'] 		    = 'school';

                    $dd['uid'] 				= $uid;

                    $d['child_in_school'] = 1;

                    $this -> add_follower_school( $dd );
                }
                if( $d['school_two'] != '')
                {
                    $dd['object_id'] 		= $d['school_two'];

                    $dd['type'] 			= 'school';

                    $dd['uid'] 				= $uid;

                    $d['child_in_school'] = 1;

                    $this -> add_follower_school( $dd );
                }
                if( $d['school_three'] != '')
                {

                    $dd['object_id'] 		= $d['school_three'];

                    $dd['type'] 				= 'school';

                    $dd['uid'] 				= $uid;

                    $d['child_in_school'] = 1;

                    $this -> add_follower_school( $dd );
                }



            }



            DB::table('user')  -> where( [['id', '=', $uid ]]   ) -> update( $d );

            $response['status'] 	= '200';

            $response['message']  =  'success';


            $response['result'] 	=  '1';


            $results =  DB::table('user')  -> where( [['id', '=', $uid ]]   ) -> get( );

            $user =  $results[0] ;

            $request    ->  session()   ->  put('user', $user );

            $request    ->  session()   ->  save();


            $user_following =  DB::table('user_following')	->	where('uid', $uid )	->get() ;

            $user_block 	=  DB::table('user_block')-> where( [ ['uid1','=', $uid ]] ) -> orWhere(  [ ['uid2','=', $uid ]]  )  -> get();

            $user_activity  =  DB::table('user_activity')	-> select('object_id') -> where('type', 'like') ->where('uid', $uid ) ->get() ;

            $user_data      =  DB::table('user')	-> select('id', 'first_name', 'last_name', 'profile_photo', 'username' )  ->where('id', $uid ) ->get() ;

            $user_fav       =  DB::table('user_fav') 	-> select('item_id', 'type')  ->  where('uid', $uid )  -> get();


            $request    ->  session()   ->  put('user_block', $user_block );

            $request    ->  session()   ->  save();

            $response =  array('response' => '1',  'data' => $url,   'user_fav'  =>  $user_fav,  'user_data'  => $user_data[0] , 'uid' => $uid, 'username' => $user -> username,  'user_choice'  => $user -> type,   'user_block' => $user_block,   'user_follower' => $user_following, 'user_activity' => $user_activity ) ;


        return response()->json( $response );

    }




    public  function logo_upload( Request $request )
    {





        if( $request -> has( 'slim') )
        {

            $images = Slim::getImages();

            $image  = $images[0];

            $name = $image['output']['name'];

            $data = $image['output']['data'];

            $file = Slim::saveFile(  $data, $name,  getcwd().'/classified/');

            $filename = $file['name'];

            $session = $request->session()->get('user');

            $uid   = $session -> id;

            $targetPath = getcwd().'/classified/';


            //$filename = 'expats_'. time() .'_'. $uid .'_' . ".jpeg";

            $params['SourceFile'] =  $targetPath.  $filename;

            $params['Key'] = 'godesto-golf';

            $s3 = AWS::createClient('s3');

            $file_key  = 'users/'.$filename;

            $t = $s3->putObject(array(

                'Bucket'     => 'expatsschools',

                'Key'        => $file_key,

                'SourceFile' => $targetPath.  $filename,


            )) -> toArray();


            $url = $t['ObjectURL'];

            unlink(  $targetPath.  $filename  );

            $url = str_replace('https://expatsschools.s3.ap-south-1.amazonaws.com/','', $url );


            if( $request -> has( 'cover') )
            {

                $d['cover_image'] = $url ;
            }
            else
            {
                $d['profile_photo'] = $url ;

            }



            if( $request -> has( 'first_name') )
            {


                $d['first_name']  =  $request -> get('first_name');

                $d['last_name']  = $request -> get('last_name');

                $d['city']  = $request -> get('city');

                $d['country']  = $request -> get('country');

                $d['recent_job']  = $request -> get('recent_job');

                $d['recent_school']  = $request -> get('recent_school');

                $d['current_emp_status']  = $request -> get('current_emp_status');

            }

            if( $request -> has( 'parent') )
            {

                $d['school_one'] 			= $request -> get('child_school_one');

                $d['school_two']			= $request -> get('child_school_two');

                $d['school_three']			= $request -> get('child_school_three');

                $d['child_in_school'] 		= 0;

                $d['interested_in_tutor'] 	= $request -> get('tutor_selection');

                $d['location_parent']	 	= $request -> get('area');

                $uid   = $request -> get('uid');

                $tutor = $request -> get('tutor');

                if( $d['school_one'] != '')
                {
                    $dd['object_id'] 		= $d['school_one'];

                    $dd['type'] 		    = 'school';

                    $dd['uid'] 				= $uid;

                    $d['child_in_school'] = 1;

                    $this -> add_follower_school( $dd );
                }
                if( $d['school_two'] != '')
                {
                    $dd['object_id'] 		= $d['school_two'];

                    $dd['type'] 			= 'school';

                    $dd['uid'] 				= $uid;

                    $d['child_in_school'] = 1;

                    $this -> add_follower_school( $dd );
                }
                if( $d['school_three'] != '')
                {

                    $dd['object_id'] 		= $d['school_three'];

                    $dd['type'] 				= 'school';

                    $dd['uid'] 				= $uid;

                    $d['child_in_school'] = 1;

                    $this -> add_follower_school( $dd );
                }



            }






            DB::table('user')  -> where( [['id', '=', $uid ]]   ) -> update( $d );

            $response['status'] 	= '200';

            $response['message']  =  'success';


            $response['result'] 	=  '1';


            $results =  DB::table('user')  -> where( [['id', '=', $uid ]]   ) -> get( );

            $user =  $results[0] ;

            $request    ->  session()   ->  put('user', $user );

            $request    ->  session()   ->  save();


            $user_following =  DB::table('user_following')	->	where('uid', $uid )	->get() ;

            $user_block 	=  DB::table('user_block')-> where( [ ['uid1','=', $uid ]] ) -> orWhere(  [ ['uid2','=', $uid ]]  )  -> get();

            $user_activity  =  DB::table('user_activity')	-> select('object_id') -> where('type', 'like') ->where('uid', $uid ) ->get() ;

            $user_data      =  DB::table('user')	-> select('id', 'first_name', 'last_name', 'profile_photo', 'username' )  ->where('id', $uid ) ->get() ;

            $user_fav       =  DB::table('user_fav') 	-> select('item_id', 'type')  ->  where('uid', $uid )  -> get();


            $request    ->  session()   ->  put('user_block', $user_block );

            $request    ->  session()   ->  save();

            $response =  array('response' => '1',  'data' => $url,   'user_fav'  =>  $user_fav,  'user_data'  => $user_data[0] , 'uid' => $uid, 'username' => $user -> username,  'user_choice'  => $user -> type,   'user_block' => $user_block,   'user_follower' => $user_following, 'user_activity' => $user_activity ) ;



        }




        return response()->json( $response );

    }


    public function resend_code(  Request $request )
    {
        if( $request -> has ('code') )
        {


            $uid   		= $request -> get('id');

            $results =  DB::table('user')-> where( 'id', $uid ) -> get();

            $user =  $results[0] ;

            $receiver   = $user  -> email;

            $code 		=  substr(str_shuffle("0123456789"), 0, 5);

            $d['verify_code'] = $code;

            DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );

           // $this -> get_confirmation_email( $code, $receiver );

            $response =  array('result' => '1' ) ;

            return response()->json( $response );
        }
    }


    public function verify_primary_email(Request $request )
    {

        $verification_code		   = $request -> get ('verification_code');

        $uid  				 	   = $request -> get ('uid');

        $r = DB::table	('user' ) -> where( [ ['verify_code', '=', $verification_code ], ['id', '=', $uid],] ) ->	get( );

        if( $r -> count() == 0 )
        {

            $response =  array('result' => 0 ) ;

        }
        else
        {

            $d['verified'] = 1;

            DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );

            $response =  array('result' => 1 ) ;

            $results =  DB::table('user')-> where( 'id', $uid ) -> get();

            $user =  $results[0] ;

            $request    ->  session()   ->  put('user', $user );

            $request    ->  session()   ->  save();


        }

        return response()->json( $response );
    }




    public function save_parent_profile(  Request $request )
    {
        if( $request -> has('step2') )
        {
            $d['school_one'] 			= $request -> get('child_school_one');

            $d['school_two']			= $request -> get('child_school_two');

            $d['school_three']			= $request -> get('child_school_three');

            $d['child_in_school'] 		= 0;

            $d['interested_in_tutor'] 	= $request -> get('tutor_selection');

            $d['location_parent']	 	= $request -> get('area');

            $uid   = $request -> get('uid');

            $tutor = $request -> get('tutor');

            if( $d['school_one'] != '')
            {
                $dd['object_id'] 		= $d['school_one'];

                $dd['type'] 		    = 'school';

                $dd['uid'] 				= $uid;

                $d['child_in_school'] = 1;

                $this -> add_follower_school( $dd );
            }
            if( $d['school_two'] != '')
            {
                $dd['object_id'] 		= $d['school_two'];

                $dd['type'] 			= 'school';

                $dd['uid'] 				= $uid;

                $d['child_in_school'] = 1;

                $this -> add_follower_school( $dd );
            }
            if( $d['school_three'] != '')
            {

                $dd['object_id'] 		= $d['school_three'];

                $dd['type'] 				= 'school';

                $dd['uid'] 				= $uid;

                $d['child_in_school'] = 1;

                $this -> add_follower_school( $dd );
            }

            DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );

            $results =  DB::table('user')-> where( 'id', $uid ) -> get();

            $user =  $results[0] ;

            $request    ->  session()   ->  put('user', $user );

            $request    ->  session()   ->  save();

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  'Your profile is updated successfully';

            $response_to_app['result'] 	=  '1';

            return response()->json( $response_to_app );

        }


    }



    public  function status_checking(Request $request )
    {


        if (! $request->session()->has('user'))
        {
            return  redirect()->action('AuthController@login');
        }

        $sess = $request->session()->get('user');

        $sess_user_name = $sess -> username;

        $this -> data['self_view'] = 1;

        $profile_id = $sess -> id;

        $results = DB::table	('user' ) -> where( 'id', $profile_id ) -> get();

        $user =  $results[0] ;

        $uid  = $user -> id;


        $this -> data['membership_status']  = 0;
        if( $user -> school_email  != '' &&  $user -> school_email != NULL )
        {

            $this -> data['membership_status']  = $this -> membership_status( $user -> school_email  );
            //$this -> data['membership_status']  = 0;//
        }



        $this -> data['auth_twitter'] =  '';

        if ( $request->session()->has('auth_twitter'))
        {

            $this -> data['auth_twitter'] = $request    ->  session()   ->  get('auth_twitter' );

        }


        $user_block  = $request    ->  session()   ->  get(  'user_block'  );

        $this -> data['block'] = 0;

        $username = $request -> get('username');

        if(  $username !== $sess_user_name )
        {
            $this -> data['self_view'] = 0;


            if( isset( $user_block ) )
            {

                $this  -> data ['block_status']  = $this -> objArraySearch( $user_block, 'uid2' , $profile_id );

                if( $this  -> data ['block_status']  != 'found' )

                {

                    $this  -> data ['block_status'] = $this -> objArraySearch( $user_block, 'uid1' , $profile_id );

                }


            }


        }


        $user_data = DB::table ('user' ) -> where ('username', $username ) -> get();

        $user_data = $user_data[0];

        $profile_id = $user_data -> id;
        //profile_id

        $this -> data['user_data'] = $user_data;



        $user_social = DB::table	('user_social' ) -> where( 'uid', $profile_id ) -> get();

        if( $user_social -> count() == 0 )
        {
            $this  -> data['twitter_name'] = '';
        }
        else
        {
            $this  -> data['twitter_name'] = $user_social[0] -> last_name;
        }


        $response_to_app['status'] 	= '200';

        $response_to_app['message']  = 'success';

        $response_to_app['data'] 	=  $this -> data;

        $response_to_app['result'] 	=  '1';


        return response()->json( $response_to_app );


    }
    private static function objArraySearch($array, $index, $value)
    {
        foreach($array as $arrayInf) {
            if($arrayInf->{$index} == $value) {
                return 'found';
            }
        }
        return null;
    }


}
