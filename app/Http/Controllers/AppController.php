<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\ResetpasswordEmail;
use QrCode;
use Imagick;
use ImagickDraw;
use Intervention\Image\ImageManagerStatic as Image;
use Exception;
use Memcached;

class AppController extends Controller
{
    public function login()
    {
		
		
		if( isset( $_POST['email'] ) )
		{
			$email 		= $_POST['email'];
			$password 	= $_POST['password'];
			
			$results =  DB::table('user')->where([ ['email', '=', $email ], ['password', '=', $password],  ['verified', '=', 1]])->get() ;
			
			
			if( $results -> count() ==  0 )
			{
				$result = json_encode( (object) null );
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'Your email address or password is incorrect.';
				$respone_to_app['data'] 	=  $result;
				$respone_to_app['result'] 	=  '2';
				$respone_to_app['membership_status'] 	=  0;
				return response()->json( $respone_to_app );
			}
			else
			{
				$user		  =  $results[0] ;
				$uid  		  = $user -> id;
				$school_email = $user -> school_email;
				
				$invitation_send  = DB::select("SELECT user_invitation.*, coalesce(user.first_name,x.first_name) as u_first_name,coalesce(user.last_name,x.last_name) as u_last_name,coalesce(user.username,x.username) as u_username, coalesce(user.profile_photo,x.profile_photo) as u_profile_photo
				FROM user_invitation
				LEFT JOIN `user` ON user.email = user_invitation.friend_email 
				LEFT JOIN `user` x ON x.school_email = user_invitation.friend_email 
				where user_invitation.status  = 1 and user_invitation.uid = $uid  HAVING  u_first_name IS NOT NULL");
				$invitation_send = count ( $invitation_send );
				
				$membership_status 						=	$this	-> 	membership_status( $school_email  );  
				$user -> invitation_send    			= $invitation_send;
				$respone_to_app['status'] 				= '200';
				$respone_to_app['membership_status'] 	=  $membership_status;
				$respone_to_app['message']  			= 'success';
				$respone_to_app['data'] 				=  $user;
				$respone_to_app['result'] 				=  '1';
				return response()->json( $respone_to_app );
			}
		}
		

		$result = json_encode( (object) null );
		$respone_to_app['status'] 				= '200';
		$respone_to_app['message'] 				= 'Bad request';
		$respone_to_app['data'] 				=  $result;
		$respone_to_app['result'] 				=  '0';
		$respone_to_app['membership_status'] 	=  0;
		return response()->json( $respone_to_app );	
    }

	public function membership_status( $school_email  )
	{
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
		return $membership_status;
		
	}
	public function register( )
    {
        if( isset( $_POST['email'] ) )
		{
			$email 			= $_POST['email'];
			$password 		= $_POST['password'];
			$type 			= $_POST['type'];
			//$school_email 	= $_POST['school_email'];
			$results 			=  DB::table('user')->where([ ['email', '=', $email ], ['verified', '=', 1 ] ])->get() ;
			$code 				=   substr(str_shuffle("0123456789"), 0, 5);
			//$verify_code_school =   substr(str_shuffle("0123456789"), 0, 5);
			
			if( $results -> count() ==  0 )
			{
				$id = DB::table	('user')	->	insertGetId(
					['email' => $email , 'password' => $password, 'type' => $type, 'verify_code' => $code, 'profile_photo' => '',  'profile_photo_custom' => '0',  'city' => '', 'country' => '']
				);
				
				$emailarr  		= explode('@', $email );
				$d['username']  = $emailarr[0].$id.time();
				DB::table	('user' ) -> where( 'id', $id ) ->	update( $d );
				
				$results  =  DB::table('user')->where([ ['id', '=', $id ]  ])->get() ;
				$user	  =  $results[0] ;
				$response =  array('response' => '1' ) ;
				
			    $this -> get_confirmation_email( $code, $email );

				$user -> invitation_send 	= 0;
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'You have successfully registered your account.';
				$respone_to_app['data'] 	=  $user;
				$respone_to_app['result'] 	=  '1';
				return response()->json( $respone_to_app );
			}
			else
			{
				$result 				    = json_encode( (object) null );
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'This email address is already registered';
				$respone_to_app['data'] 	=  $result;
				$respone_to_app['result'] 	=  '2';
				return response()->json( $respone_to_app );
                
			}
		}
		
		$result = json_encode( (object) null );
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'Bad request';
		$respone_to_app['data'] 	=  $result;
		$respone_to_app['result'] 	=  '0';
		return response()->json( $respone_to_app );	
    }
	public function get_confirmation_email( $code, $receiver )
    {
		$data['receiver']   = $receiver;
		$data['code'] 		= $code;
		//$data['school_email'] = $school_email;
		//$data['verify_code_school'] = $verify_code_school;
		Mail::send('email_template/confirm_email', ['code' => $code, 'receiver' => $receiver], function($message) use ($data)
		{
			$message->to( $data['receiver'] ) -> subject('Use code '.  $data['code']  .' to verify your email address.' ); //->cc('bar@example.com');
			return true;
		});
		
		/*Mail::send('email_template/confirm_email_school', ['code' => $verify_code_school, 'receiver' => $school_email], function($message) use ($data)
		{
			$message->to( $data['school_email'] ) -> subject('Use code '.  $data['verify_code_school']  .' to verify your email address.' ); //->cc('bar@example.com');
			return true;
		});*/
		
		return true;
    }
	
	public function update_profile()
	{
		if( isset( $_POST['save_data'] ) )
		{
			
			
			$d['first_name']	  = $_POST['first_name'];
			$d['last_name']	 	  = $_POST['last_name'];
			$d['country']  		  = $_POST['country'];
			$d['city']	 		  = $_POST['city'];
			//$d['recent_school']   = $_POST['recent_school'];
			//$d['recent_job']	  = $_POST['recent_job'];
			$d['password']	  	  = $_POST['password'];
			$d['contact_number']  = $_POST['contact_number'];
			
			$d['address']		  = $_POST['address'];
			$d['contact_number']  = $_POST['contact_number'];
			
			$uid   = $_POST['user_id'];
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d ) ;
			$result = DB::table	('user' ) -> where( 'id', $uid )  -> get();
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  $result;
			$respone_to_app['result'] 	=  '1';

			return response()->json( $respone_to_app );
		}
		
	}
	public function save_profile( )
	{
		if( isset( $_POST['save_data'] ) )
		{
			
			$d['first_name']	  = $_POST['first_name'];

			$d['last_name']	 	  = $_POST['last_name'];

			$d['name']	 	 	  = $_POST['first_name'].' '.$_POST['last_name'];

			$d['country']  		  = $_POST['country'];

			$d['city']	 		  = $_POST['city'];

            if( !isset( $POST['recent_school']  ))
            {

                $d['recent_school']    = '';

            }
            else
            {

                $d['recent_school']   = $_POST['recent_school'];
            }

            if( !isset( $POST['recent_job']  ))
            {

                $d['recent_job']    = '';

            }
            else
            {

                $d['recent_job']   = $_POST['recent_job'];
            }

            if( !isset( $POST['current_emp_status']  ))
            {

                $d['current_emp_status']    = '';

            }


			if( $d['current_emp_status']  == ''  || !isset( $POST['current_emp_status']  ))
			{

				$d['current_emp_status']    = $d['recent_job']	;

			}

			$verification_code		   = $_POST['verification_code'];
			//$verification_code_school  = $_POST['verification_code_school'];
		
			
			$uid   = $_POST['user_id'];
			
			
			
			
			$r = DB::table	('user' ) -> where( [ ['verify_code', '=', $verification_code ], ['id', '=', $uid] ] ) ->	get( );
			
			if( $r -> count() == 0 )
			{
				$result = json_encode( (object) null );

				$respone_to_app['status'] 	= '200';

				$respone_to_app['message']  = 'Verification code is not correct';

				$respone_to_app['data'] 	=  $result;

				$respone_to_app['result'] 	=  '0';
				
				$respone_to_app['membership_status'] 			=	0;


				return response()->json( $respone_to_app );
			}
			
			
			if( isset( $_FILES['file']['name'] ) && !empty( $_FILES['file']['name'] ))
			{
				$schemin	= getcwd();

				$tempFile 	= $_FILES['file']['tmp_name'];

				$targetPath = $schemin.'/user_profiles/';

				$filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['file']['name'] ) ) );

				$filename   = str_replace( '(', '', $filename );

				$filename   = str_replace( ')', '', $filename );

				$filename   =  preg_replace("/[^a-z0-9\_\-\.]/i", '', $filename  );

				$filename   = time().'_'.$filename;

				$targetFile = rtrim($targetPath,'/') . '/' . $filename;

				$fileTypes 	= array('jpg','jpeg','gif','png');

				$fileParts  = pathinfo( $filename );

				$fileType = $_FILES["file"]["type"];

				ini_set('memory_limit','256M');
	
				if (in_array( $fileParts['extension'], $fileTypes ) ) 
				{
					move_uploaded_file($tempFile, $targetFile);
					$up_file 		 = $schemin.'/user_profiles/'. $filename;
						/*$profile_pic_return 	    = 'profile_'. $filename;
					$profile_pic	 			= $schemin.'/public/user_profiles/'. $profile_pic_return ;
					$image_info 	 			= getimagesize($up_file);
						$image = Image::make( $up_file  )->rotate((float) $angle );
						$image->widen( (int)  ($image->width() * $scale  ));
						$image->crop(   (int)$w, (int)$h, (int)$x,  (int)$y  );
						$image->save( $profile_pic  );*/

						$d['profile_photo'] =  $filename;

					$d['profile_photo_custom'] = 1;
				}
			}
			
			
			$d['verified'] = 1;
			
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d ) ;

			$result = DB::table	('user' ) -> where( 'id', $uid )  -> get();
			
			$membership_status 		    			= 0;//	$this	-> 	membership_status( $result[0] -> school_email  );  

            $respone_to_app['status'] 				= '200';

			$respone_to_app['membership_status'] 	= $membership_status;

			$respone_to_app['message']  			= 'success';

			$respone_to_app['data'] 				=  $result;

			$respone_to_app['result'] 				=  '1';
			


			return response()->json( $respone_to_app );
		}
		
	
		
		
	}
	
	 public function get_prof_collection()
	 {
		/*$job_titles 	=  DB::table('job_titles') -> select('id','title')-> get() ;
		$school_profile =  DB::table('school_profile') -> select('id','name')-> get() ;
		*/
		
		$memcache = new memcached;
		
		/*$job_titles 	=  DB::table('job_titles') -> select('id','title')-> get() ;
		$school_profile =  DB::table('school_profile') -> select('id','name')-> get() ;
		$domain_email =  DB::table('school_profile') -> where ('domain_email', '!=', 'NULL' ) -> groupBy('domain_email') -> where ('domain_email', '!=', '' )  -> select( 'domain_email' ) -> orderBy('name', 'asc') -> get() ;
*/
		$memcache	->	addServer('localhost', 11211) ;
		
		$job_titles		=	$memcache->get('job_titles');
		$school_profile =   $memcache->get('schools');
		$domain_email	=   $memcache->get('domain_email');
		
		$d['jobs']		=	 $job_titles;
		$d['schools'] 	= 	$school_profile;
		$d['domain_email'] 	= 	$domain_email;
		
		
		$respone_to_app['data'] 	=  $d	;
		$respone_to_app['len'] 	=  strlen( $job_titles ) + strlen( $school_profile )  + strlen( $domain_email ) 	;
		
		
		 return response()->json( $d );
	 }
	 
	 public function etc_card2()
	 {
		 date_default_timezone_set('Asia/Dubai');
		if( isset( $_GET['uid'] ) )
		{
			  $uid  = $_GET['uid'];
		}
		else
		{
			  $uid  = '5025';
		}
	  
		$result = DB::table	('user' ) -> where( 'id', $uid )  -> get();
		
		$user_name = $result[0] -> first_name.' '. $result[0] -> last_name;
		
		$profile   = '/home/expatss/public_html/public/user_profiles/'. $result[0] -> profile_photo;
		$etc_blank = '/home/expatss/public_html/public/css/img/400-etc-card.png';
		$name	   = $uid. '_.png';
		$new_image = '/home/expatss/public_html/etc_cards/'. $name  ; 
		
		$profile_url = url('/profile/'. $result[0] -> username);
		$qr_code = QrCode::format('png')->size(96)->generate( $profile_url  );
		// $qr_code = base64_encode($qr_code);
		
		
		
		 $fontUrl = 'https://fonts.googleapis.com/css?family=Roboto';
		 $fontDescription = file_get_contents($fontUrl);
	 
		 $startStr = 'url(';
		 $startStrLen = strlen($startStr);
		 $start = strpos($fontDescription, $startStr) + $startStrLen;
		 $end = strpos($fontDescription, ')', $start);
		 $tffUrl = substr($fontDescription, $start, $end - $start);
	
		 $tffFile = '/tmp/Roboto.ttf';
		 file_put_contents($tffFile, file_get_contents($tffUrl));
	
	

		
		$overlay = new Imagick( $profile  );
		$image   = new Imagick( $etc_blank );
		
		$image->setImageColorspace($overlay->getImageColorspace() ); 
		$image->compositeImage($overlay, Imagick::COMPOSITE_DEFAULT, 14, 56);
		
		
		
		$overlay = new Imagick();
		$overlay ->readImageBlob( $qr_code );

		
		
		
		$image->setImageColorspace($overlay->getImageColorspace() ); 
		$image->compositeImage($overlay, Imagick::COMPOSITE_DEFAULT, 283, 128);
		
		
		$draw = new ImagickDraw();
		$draw->setFillColor('white');
		$draw->setFont($tffFile);

		$draw->setFontSize( 14 );
		$image->annotateImage($draw, 250, 124, 0, date('d/m/Y h:i A') );
		
		/*$draw->setTextAlignment(Imagick::ALIGN_CENTER);
		$draw->setFontSize( 14 );
		$image->annotateImage($draw, 270, 80, 0, $user_name );*/
		
		$rect = ['x' => 254, 'y' => 70, 'h' => 15, 'w' => 146,];

		// Draw a Region-of-interest for reference.
		$roi = new ImagickDraw();
		$roi->setStrokeColor('RED');
		$roi->setStrokeWidth(2);
		$roi->setStrokeOpacity(0);

		$roi->setFillColor('TRANSPARENT');
		$roi->rectangle($rect['x'], $rect['y'], $rect['x'] + $rect['w'], $rect['y'] + $rect['h']);
		$image->drawImage($roi);
		
		// Define your text-rendering context.
		$ctx = new ImagickDraw();
		$ctx->setFillColor('WHITE');
		$ctx->setFontSize( 14 );
		$ctx->setFont($tffFile);
		// Query who it will render with the image stack.
		$metrics = $image->queryFontMetrics($ctx, $user_name );
		// Adjust starting x,y as needed to meet your requirements.
		$offset = ['x' => $rect['x'] + $rect['w'] / 2 - $metrics['textWidth'] / 2, 'y' => $rect['y'] + $rect['h'] / 2 + $metrics['textHeight'] / 2 + $metrics['descender'], ];
		// Draw text.
		$image->annotateImage($ctx,$offset['x'], $offset['y'], 0, $user_name);
		$image->writeImage( $new_image ); //replace original background
		$overlay->destroy();
		$image->destroy();
		 
		 
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  url('/etc_cards/'. $name ) ;
		$respone_to_app['result'] 	=  '1';

		return response()->json( $respone_to_app );
		/* echo '<a href="'. url('/etc_cards/'. $name ) .'">test</a>';*/
	 }
	 
	 
	 public function etc_card_test()//etc_card_app
	 {
		 date_default_timezone_set('Asia/Dubai');
		if( isset( $_GET['uid'] ) )
		{
			  $uid  = $_GET['uid'];
		}
		else
		{
			  $uid  = '5025';
		}
	  	$uniq_id =  sprintf('%06d',  $uid );
		$result = DB::table	('user' ) -> where( 'id', $uid )  -> get();
		
		$user_name = $result[0] -> first_name.' '. $result[0] -> last_name;
		
		$profile   = '/home/expatss/public_html/public/user_profiles/'. $result[0] -> profile_photo;
		$etc_blank = '/home/expatss/public_html/public/css/img/400-etc-card.png';
		$name	   = $uid.'_'. time() . '_.png';
		$new_image = '/home/expatss/public_html/etc_cards/'. $name  ; 
		
		$profile_url = url('/profile/'. $result[0] -> username);
		$qr_code = QrCode::format('png')->size(96)->generate( $profile_url  );
		// $qr_code = base64_encode($qr_code);
		
		
		
		 $fontUrl = 'https://fonts.googleapis.com/css?family=Roboto';
		 $fontDescription = file_get_contents($fontUrl);
	 
		 $startStr = 'url(';
		 $startStrLen = strlen($startStr);
		 $start = strpos($fontDescription, $startStr) + $startStrLen;
		 $end = strpos($fontDescription, ')', $start);
		 $tffUrl = substr($fontDescription, $start, $end - $start);
	
		 $tffFile = '/tmp/Roboto.ttf';
		 file_put_contents($tffFile, file_get_contents($tffUrl));
	
	

		
		$overlay = new Imagick( $profile  );
		$image   = new Imagick( $etc_blank );
		
		
		$overlay->setImageColorspace(255); 
		$overlay->resizeImage(200, 170, imagick::FILTER_LANCZOS, 1);  

		
		
		
		
		
		$image->setImageColorspace($overlay->getImageColorspace() ); 
		$image->compositeImage($overlay, Imagick::COMPOSITE_DEFAULT, 14, 56);
		
		
		
		$overlay = new Imagick();
		$overlay ->readImageBlob( $qr_code );

		
		
		
		$image->setImageColorspace($overlay->getImageColorspace() ); 
		$image->compositeImage($overlay, Imagick::COMPOSITE_DEFAULT, 283, 128);
		
		
		$draw = new ImagickDraw();
		$draw->setFillColor('white');
		$draw->setFont($tffFile);

		$draw->setFontSize( 14 );
		$image->annotateImage($draw, 250, 124, 0, date('d/m/Y h:i A') );
		
		/*$draw->setTextAlignment(Imagick::ALIGN_CENTER);
		$draw->setFontSize( 14 );
		$image->annotateImage($draw, 270, 80, 0, $user_name );*/
		
		$rect = ['x' => 254, 'y' => 70, 'h' => 15, 'w' => 146,];

		// Draw a Region-of-interest for reference.
		$roi = new ImagickDraw();
		$roi->setStrokeColor('RED');
		$roi->setStrokeWidth(2);
		$roi->setStrokeOpacity(0);

		$roi->setFillColor('TRANSPARENT');
		$roi->rectangle($rect['x'], $rect['y'], $rect['x'] + $rect['w'], $rect['y'] + $rect['h']);
		$image->drawImage($roi);
		
		// Define your text-rendering context.
		$ctx = new ImagickDraw();
		$ctx->setFillColor('WHITE');
		$ctx->setFontSize( 14 );
		$ctx->setFont($tffFile);
		// Query who it will render with the image stack.
		$metrics = $image->queryFontMetrics($ctx, $user_name );
		// Adjust starting x,y as needed to meet your requirements.
		$offset = ['x' => $rect['x'] + $rect['w'] / 2 - $metrics['textWidth'] / 2, 'y' => $rect['y'] + $rect['h'] / 2 + $metrics['textHeight'] / 2 + $metrics['descender'], ];
		// Draw text.
		$image->annotateImage($ctx,$offset['x'], $offset['y'], 0, $user_name);
		$image->writeImage( $new_image ); //replace original background
		$overlay->destroy();
		$image->destroy();
		 
		 
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  url('/etc_cards/'. $name ) ;
		$respone_to_app['result'] 	=  '1';

		return response()->json( $respone_to_app );
		/* echo '<a href="'. url('/etc_cards/'. $name ) .'">test</a>';*/
	 }
	 
	 public function etc_card()
	 {
		 date_default_timezone_set('Asia/Dubai');
		if( isset( $_GET['uid'] ) )
		{
			  $uid  = $_GET['uid'];
		}
		else
		{
			  $uid  = '5025';
		}
	  	$uniq_id =  sprintf('%06d',  $uid );
		$result = DB::table	('user' ) -> where( 'id', $uid )  -> get();
		
		$user_name 		= $result[0] -> first_name.' '. $result[0] -> last_name;
		$school_email   = $result[0] ->  school_email;
		
		
		$school_email_domain  = explode('@',  $school_email );
		if( isset ( $school_email_domain[1] ) )
		{
			$school_email_domain  = '@' . $school_email_domain[1];
			$school_profile_result = DB::table	('school_profile' ) -> where( 'domain_email', $school_email_domain )  -> get();
			if( $school_profile_result -> count() > 0 )
			{
				if ( $school_profile_result[0] -> etc_block ==  1 )
				{
					$respone_to_app['status'] 	= '200';
					$respone_to_app['message']  = 'success';
					$respone_to_app['data'] 	=  'please activate your membership to access your card.' ;
					$respone_to_app['result'] 	=  '0';
					return response()->json( $respone_to_app );
				}
			}
			else
			{
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'success';
				$respone_to_app['data'] 	=  'please activate your membership to access your card.' ;
				$respone_to_app['result'] 	=  '0';
				return response()->json( $respone_to_app );
			}
		}
		else
		{
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'please activate your membership to access your card.' ;
			$respone_to_app['result'] 	=  '0';
			return response()->json( $respone_to_app );
		}
		
		
		
		
		
		
		
		
		
		$profile   = '/home/expatsschools.com/public_html/public/user_profiles/'. $result[0] -> profile_photo;
		$etc_blank = '/home/expatsschools.com/public_html/public/css/img/400-etc-card.png';
		$name	   = $uid . '_.png';
		$new_image = '/home/expatsschools.com/public_html/public/etc_cards/'. $name  ; 
		
		$profile_url = url('/profile/'. $result[0] -> username);
		$qr_code = QrCode::format('png')->size(96)->generate( $profile_url  );
		// $qr_code = base64_encode($qr_code);
		
		
		
		 $fontUrl = 'https://fonts.googleapis.com/css?family=Roboto';
		 $fontDescription = file_get_contents($fontUrl);
	 
		 $startStr = 'url(';
		 $startStrLen = strlen($startStr);
		 $start = strpos($fontDescription, $startStr) + $startStrLen;
		 $end = strpos($fontDescription, ')', $start);
		 $tffUrl = substr($fontDescription, $start, $end - $start);
	
		 $tffFile = '/tmp/Roboto.ttf';
		 file_put_contents($tffFile, file_get_contents($tffUrl));
	
	

		
		$overlay = new Imagick( $profile  );
		$image   = new Imagick( $etc_blank );
		
		
		$overlay->setImageColorspace(255); 
		$overlay->resizeImage(190, 150, imagick::FILTER_LANCZOS, 1);  
		$image->setImageColorspace($overlay->getImageColorspace() ); 
		$image->compositeImage($overlay, Imagick::COMPOSITE_DEFAULT, 14, 56);
		
		
		/*add qr code image to current image*/
		$overlay = new Imagick();
		$overlay ->readImageBlob( $qr_code );
		$image->setImageColorspace($overlay->getImageColorspace() ); 
		$image->compositeImage($overlay, Imagick::COMPOSITE_DEFAULT, 283, 128);
		
		
		$draw = new ImagickDraw();
		$draw->setFillColor('white');
		$draw->setFont($tffFile);
		$draw->setFontSize( 14 );
		$image->annotateImage($draw, 250, 124, 0, date('d/m/Y h:i A') );
		
		$draw = new ImagickDraw();
		$draw->setFillColor('white');
		$draw->setFont($tffFile);
		$draw->setFontSize( 14 );
		$draw->setStrokeWidth(3);

		$image->annotateImage($draw, 20, 225, 0, 'Membership ID: '.$uniq_id );
		
		/*$draw->setTextAlignment(Imagick::ALIGN_CENTER);
		$draw->setFontSize( 14 );
		$image->annotateImage($draw, 270, 80, 0, $user_name );*/
		
		$rect = ['x' => 254, 'y' => 70, 'h' => 15, 'w' => 146,];

		// Draw a Region-of-interest for reference.
		$roi = new ImagickDraw();
		$roi->setStrokeColor('RED');
		$roi->setStrokeWidth(2);
		$roi->setStrokeOpacity(0);

		$roi->setFillColor('TRANSPARENT');
		$roi->rectangle($rect['x'], $rect['y'], $rect['x'] + $rect['w'], $rect['y'] + $rect['h']);
		$image->drawImage($roi);
		
		// Define your text-rendering context.
		$ctx = new ImagickDraw();
		$ctx->setFillColor('WHITE');
		$ctx->setFontSize( 14 );
		$ctx->setFont($tffFile);
		// Query who it will render with the image stack.
		$metrics = $image->queryFontMetrics($ctx, $user_name );
		// Adjust starting x,y as needed to meet your requirements.
		$offset = ['x' => $rect['x'] + $rect['w'] / 2 - $metrics['textWidth'] / 2, 'y' => $rect['y'] + $rect['h'] / 2 + $metrics['textHeight'] / 2 + $metrics['descender'], ];
		// Draw text.
		$image->annotateImage($ctx,$offset['x'], $offset['y'], 0, $user_name);
		$image->writeImage( $new_image ); //replace original background
		$overlay->destroy();
		$image->destroy();
		 
		 
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  url('/public/etc_cards/'. $name.'?t='. time()  ) ;
		$respone_to_app['result'] 	=  '1';

		return response()->json( $respone_to_app );
		/* echo '<a href="'. url('/etc_cards/'. $name ) .'">test</a>';*/
	 }
	 
	
	 
	 public function verify_mem_service()
	 {
		date_default_timezone_set('Asia/Dubai');
		if( isset( $_GET['uid'] ) )
		{
			  $uid  = $_GET['uid'];
		}
		else
		{
			  $uid  = '5025';
		}
	  	$uniq_id =  sprintf('%06d',  $uid );
		$result = DB::table	('user' ) -> where( 'id', $uid )  -> get();
		
		$user_name 		= $result[0] -> first_name.' '. $result[0] -> last_name;
		$school_email   = $result[0] ->  school_email;
		
		
		$school_email_domain  = explode('@',  $school_email );
		if( isset ( $school_email_domain[1] ) )
		{
			$school_email_domain  = '@' . $school_email_domain[1];
			$school_profile_result = DB::table	('school_profile' ) -> where( 'domain_email', $school_email_domain )  -> get();
			if( $school_profile_result -> count() > 0 )
			{
				if ( $school_profile_result[0] -> etc_block ==  1 )
				{
					$respone_to_app['status'] 	= '200';
					$respone_to_app['message']  = 'success';
					$respone_to_app['data'] 	=  'please activate your membership to access your card.' ;
					$respone_to_app['result'] 	=  '0';
					return response()->json( $respone_to_app );
				}
			}
			else
			{
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'success';
				$respone_to_app['data'] 	=  'please activate your membership to access your card.' ;
				$respone_to_app['result'] 	=  '0';
				return response()->json( $respone_to_app );
			}
		}
		else
		{
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'please activate your membership to access your card.' ;
			$respone_to_app['result'] 	=  '0';
			return response()->json( $respone_to_app );
		}
		
		 
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  '1' ;
		$respone_to_app['result'] 	=  '1';
		return response()->json( $respone_to_app );
		/* echo '<a href="'. url('/etc_cards/'. $name ) .'">test</a>';*/
	 }
	 
	
	 
	 public function send_invite( )
	 {
		
		$uid = $_POST['user_id'];
		if( isset( $_POST['invite_friend'] ) )
		{
			
			$email 		=  explode(',', trim( $_POST['email'] , ','));
			$u_emaail   = $_POST['user_email'];
			$first_name = $_POST['first_name'];
			$last_name  = $_POST['last_name'];
			
			if( $email[0] == $u_emaail )
			{
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'success';
				$respone_to_app['data'] 	=  'You can not invite yourself.';
				$respone_to_app['result'] 	=  '3';
				return response()->json( $respone_to_app );	
			}
			foreach( $email as $mail_ob)
			{
				if( $mail_ob  == $u_emaail )
				{
					continue;
				}
				$d = array();
				$d['friend_email'] = $mail_ob;
				$d['uid']          = $uid;
				$d['code']		   =   substr(str_shuffle("0123456789"), 0, 5);
				
				$query =  DB::table('user_invitation') -> insert( $d );
				$d['name'] = $first_name.' '. $last_name;
				
				Mail::send('email_template/send_invite', $d  , function($message) use ($d)
				{
					$message->to( $d['friend_email'] ) -> subject( $d['name'] . ' sent you an invitation' ); //->cc('bar@example.com');
				});
			}
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Your message is sent successfully.';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
		}
	 }
	 
	 
	 
	 
	 
	 
	 
	 
	public function terms()
    {
		$this -> data['page']		 = 'static/terms';
		$this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '1';
        return view( "template" ) -> with( $this -> data ) ;
    }
	public function privacy()
    {
		$this -> data['page']		 = 'static/privacy';
		$this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '1';
        return view( "template" ) -> with( $this -> data ) ;
    }
	public function about()
    {
		$this -> data['page']		 = 'static/about';
		$this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '1';
        return view( "template" ) -> with( $this -> data ) ;
    }
	
	public function faqs()
    {
		$query =  DB::table('faqs') -> get();
		$this -> data['page']		 = 'coffe_club/faqs_from_admin';
		$this -> data['faq']		 = $query;
		$this -> data['title'] 		 = 'expatsschools faqs ';
		$this -> data['page_on']	 = 'coffee-club';
		$this -> data['no_header'] 	 = '1';
        return view( "template" ) -> with( $this -> data ) ;
    }
	public function security()
    {
		$query =  DB::table('faqs') -> get();
		$this -> data['page']		 = 'coffe_club/faqs_from_admin';
		$this -> data['faq']		 = $query;
		$this -> data['title'] 		 = 'expatsschools faqs ';
		$this -> data['page_on']	 = 'coffee-club';
		$this -> data['no_header'] 	 = '1';
        return view( "template" ) -> with( $this -> data ) ;
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
				
					$respone_to_app['status'] 	= '200';
					$respone_to_app['message']  = 'success';
					$respone_to_app['data'] 	=  'Email address is not registered with us.';
					$respone_to_app['result'] 	=  '1';
					
					
			}
			else
			{
				$code 		=   substr(str_shuffle("0123456789"), 0, 10 ).time();
				$d['reset_password_code'] = $code;
				DB::table	('user' ) -> where( 'id',  $results[0]  -> id ) ->	update( $d );
				Mail::to( $results[0]  -> email )->send(new ResetpasswordEmail($d));
				
					$respone_to_app['status'] 	= '200';
					$respone_to_app['message']  = 'success';
					$respone_to_app['data'] 	=  'Reset passsword mail is sent to your email address';
					$respone_to_app['result'] 	=  '1';
			}
          
		  
		  
		  
		  
			return response()->json( $respone_to_app );
		  
		  
		}
    }
	
	
	
	
	public function resend_code(  )
	{
		if( isset( $_POST['user_id'] ) )
		{
			$uid 			= $_POST['user_id'];
			$user 			= DB::table	('user' ) -> where( 'id', $uid ) ->	get( );
			$user 			= $user[0];
			$uid   			= $user -> id;
			$receiver 		= $user -> email;
			$school_email 	= $user -> school_email;
			$code 			=   substr(str_shuffle("0123456789"), 0, 5);
			$verify_code_school =   substr(str_shuffle("0123456789"), 0, 5);
			$d['verify_code'] = $code;
			$d['verify_code_school'] = $verify_code_school;
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			
			$this -> get_confirmation_email( $code, $receiver,$verify_code_school, $school_email  );
			
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Verification codes are sent to your emails successfully';
			$respone_to_app['result'] 	=  '1';
					
					
			return response()->json( $respone_to_app );
		}
	}
	
	
	
	
	 ///reply_ad,name,phone_number,email,message,cid
	 //js_rec_email
	 public function reply_to_ad( Request $request )
	 {
		if( isset( $_POST['reply_ad'] ) )
		{
			$uid = $_POST['user_id'];
			
			$d['name'] 				= $_POST['name'];
			$d['phone_number'] 		= $_POST['phone_number'];
			$d['email'] 			= $_POST['email'];
			$d['message'] 			= $_POST['message'];
			
			$d['cid'] 				= $_POST['cid'];
			$d['uid'] 				= $uid;
						
			$query =  DB::table('classifieds_response') -> insert( $d );
			
			$d['ad_link']		= url('/classifieds/detail/' .$_POST['ad_link'] );
			
			unset($d['message'] );
			$d['msg'] =  $_POST['message'];
			$d['email'] = $_POST['js_rec_email'];
			
			
			Mail::send('email_template/ads_response', $d  , function($message) use ($d)
			{
				$message->to( $d['email'] ) -> subject( 'Your ad got a response' ); //->cc('bar@example.com');
				
			});
			
			
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Your message is sent successfully. Please wait for response from buyer';
			$respone_to_app['result'] 	=  '1';
			
			return response()->json( $respone_to_app );
		}
		
		
		 
	 }
	 
 	 public function filter_classifieds()
	 {
		/*
		
		condition,usage,age,search_text,category,sub_category,warranty,page
		
		*/
		if( isset( $_POST['load_data'] ) )
		{
			$condition 			= $_POST['condition'];
			$warranty 			= $_POST['warranty'];
			$usage 				= $_POST['usage'];
			$age	  		 	= $_POST['age'];
			$search_text		= $_POST['search_text'];
			
			$category			= $_POST['category'];
			$sub_category		= $_POST['sub_category'];
			
			$page 				= $_POST['page'];
			
			
			DB::enableQueryLog();

			
			$query =  DB::table('classifieds');
			if( $search_text != '' )
			{
				$query -> where( 'title', 'like', '%' . $search_text . '%' );
			}
			
			if( $condition != '' )
			{
				$query ->  whereRaw( "conditions LIKE '%$condition%'" );
			}
			if( $usage != '' )
			{
				$query ->  whereRaw( "usage LIKE '%$usage%'" );
			}
			if( $age != '' )
			{
				$query ->  whereRaw( "ages LIKE '%$age%'" );
			}
			if( $warranty != '' )
			{
				$query ->  whereRaw( "warranty LIKE '%$warranty%'" );
			}
			if( $category != '' )
			{
				$query ->  where( "category", $category );
			}
			if( $sub_category != '' )
			{
				$query ->  where( "sub_category", $sub_category );
			}
			
			$query ->  where( "is_live", 1 );
			
			$query	->	join('classified_category', 'classified_category.id','=','classifieds.category');
			$query	->	join('user', 'user.id','=','classifieds.uid');
			//select jobs.*, school_profile.id,school_profile.url as school_url, school_profile.name from jobs INNER JOIN school_profile on jobs.school_id=school_profile.id
			
			$query  ->   select('classifieds.*','classified_category.text','user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username' );

			$query  ->  orderBy('id', 'DESC');
			if( $page > 0 ) { $page = $page * 10  ; }
			$query -> offset( $page );
            $query -> limit( 10 );
			
			$result = $query -> get();
			
			
			if( $result -> count() ==  0 )
			{
				$result = json_encode( (object) null );
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'success';
				$respone_to_app['data'] 	=  $result;
				$respone_to_app['result'] 	=  '0';
			}
			else
			{
				
                $respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'success';
				$respone_to_app['data'] 	=  $result	;
				$respone_to_app['result'] 	=  '1';
			}
			
			$laQuery = DB::getQueryLog();
			 $lcWhatYouWant = $laQuery[0]['query']; 
			DB::disableQueryLog();
			//exit;
				$respone_to_app['query'] 	=  $lcWhatYouWant;
			return response()->json( $respone_to_app );
		}
	 }
	 
	
}






		
		
		
		