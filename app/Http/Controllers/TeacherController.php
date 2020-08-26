<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Abraham\TwitterOAuth\TwitterOAuth;

define("Consumer_Key", "0u5CjFq0aZ1tXlPiV5Iv9FBye");
 
define("Consumer_Secret", "Y4hOVC2F4j4iGnRRG1MyPyYjZ9iLMCnVRjoO2bUkP4Irf8C0TJ");

class TeacherController extends Controller
{
	protected $data = array('no_header' => 0 );
	
    public function index(Request $request )
    {
		if (! $request->session()->has('user')) { return  redirect()->action('AuthController@login'); }
		$this -> data['page']		 = 'profile_wizard';
		$this -> data['title'] 		 = 'Expats School - Profile Page';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '0';
		
        return view( "template" ) -> with( $this -> data ) ;
    }
	
	
	public function profile_only(Request $request )
    {
		
		if (! $request->session()->has('user')) 
		{
			return  redirect()->action('AuthController@login');
		}
		$sess = $request->session()->get('user');
		$sess_user_name = $sess -> username;
		
		return redirect()->action('TeacherController@profile', ['username' => $sess_user_name]);

		//return  redirect()->action('TeacherController@profile/'. $sess_user_name  );
	}
	public function membership_status( $school_email  )
	{
		$school_email_domain  = explode('@',  $school_email );
		
		if( isset ( $school_email_domain[1] ) )
		{
			$school_email_domain  = '@' . $school_email_domain[1];
			$school_profile_result = DB::table	('school_profile' ) -> where( [['domain_email','=', $school_email_domain] ] )  -> get();
			
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
	
	public function user_from_etc($username, Request $request )
    {
		$request -> session() ->  forget('user');
		$request -> session() ->forget('user_block');
		$this -> go_to_login();
    }
	
	public function go_to_login(   )
    {
		?>
        <script>
		document.location = '<?php echo  url( 'login') ;?>';
		</script>
        <?php
		//return  redirect()->action('AuthController@login');
    }
	
	public function profile($username, Request $request )
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


		$request    ->  session()   ->  put('user', $user );
		$request    ->  session()   ->  save();
		$this -> data['auth_twitter'] =  '';

		if ( $request->session()->has('auth_twitter'))
		{
			$this -> data['auth_twitter'] = $request    ->  session()   ->  get('auth_twitter' );
		}







		$user_block  = $request    ->  session()   ->  get(  'user_block'  );

		$this -> data['block'] = 0;





		if(  $username != $sess_user_name )
		{
			$this -> data['self_view'] = 0;
			$user_data = DB::table ('user' ) -> where ('username', $username ) -> get();
			$user_data = $user_data[0];
			$profile_id = $user_data -> id;
			//profile_id
			$this -> data['user_data'] = $user_data;
			if( isset( $user_block ) )
			{
				$block_status = $this -> objArraySearch( $user_block, 'uid2' , $profile_id );
				if( $block_status != 'found' )
				{
					$block_status = $this -> objArraySearch( $user_block, 'uid1' , $profile_id );
				}
				if( $block_status == 'found' )
				{
						$this -> data['page']		 = 'teachers/profile_teacher_block';
						$this -> data['title'] 		 = 'Expats School - Profile Page';
						$this -> data['page_on']	 = 'home';
						$this -> data['no_header'] 	 = '0';
						return view( "template" ) -> with( $this -> data ) ;
				}
			}


		}
		$albums_data = array();
		$albums  = DB::table ('user_albums' ) -> where ('uid', $profile_id ) -> get();
		if( $albums -> count() ==  0 )
		{
			$albums_data = array();
		}
		else
		{
			$counter = 0;
			foreach( $albums as $albums_obj )
			{
				$albums_data[$counter]['album'] = $albums_obj;
				$album_id 					 	= $albums_obj -> id;
				$user_albums_photos 		 	= DB::table ('user_albums_photos' ) -> where('album_id', $album_id ) -> get();
				if( $user_albums_photos -> count() == 0 ){ $user_albums_photos = array();}
				$albums_data[$counter]['user_albums_photos'] = $user_albums_photos;
				$counter ++;
			}
		}


		$user_social = DB::table	('user_social' ) -> where( 'uid', $profile_id ) -> get();
		if( $user_social -> count() == 0 )
		{
			$this  -> data['twitter_name'] = '';
		}
		else
		{
			$this  -> data['twitter_name'] = $user_social[0] -> last_name;
		}


		$this -> data['albums']		 = $albums_data;

		$this -> data['page']		 = 'teachers/profile_teacher';
		$this -> data['title'] 		 = 'Expats School - Profile Page';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }





    public function profile_view( Request $request )
    {
		
		
		
		$sess_user_name = $_GET['u'];
		$this -> data['self_view'] = 0;
		$user_data = DB::table ('user' ) -> where ('username', $sess_user_name ) -> get();
		$user_data = $user_data[0];
		$profile_id = $user_data -> id;
		//profile_id
		$this -> data['user_data'] = $user_data;
		$this -> data['block'] = 0;
		
		
		$albums_data = array();
		$albums  = DB::table ('user_albums' ) -> where ('uid', $profile_id ) -> get();
		if( $albums -> count() ==  0 )
		{
			$albums_data = array();
		}
		else
		{
			$counter = 0;
			foreach( $albums as $albums_obj )
			{
				$albums_data[$counter]['album'] = $albums_obj;
				$album_id 					 	= $albums_obj -> id;
				$user_albums_photos 		 	= DB::table ('user_albums_photos' ) -> where('album_id', $album_id ) -> get();
				if( $user_albums_photos -> count() == 0 ){ $user_albums_photos = array();}
				$albums_data[$counter]['user_albums_photos'] = $user_albums_photos;
				$counter ++;
			}
		}
		
		$this -> data['albums']		 = $albums_data;
		
		$this -> data['page']		 = 'teachers/profile_public_teacher';
		$this -> data['title'] 		 = 'Expats School - Profile Page';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    
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
	
	public function messages( Request $request )
	{
		if (! $request->session()->has('user')) { return  redirect()->action('AuthController@login'); }
		$this -> data['page']		 = 'messages';
		$this -> data['title'] 		 = 'Expats School - Your messages';
		$this -> data['page_on']	 = 'messages';
		$this -> data['no_header'] 	 = '0';
			

        return view( "template" ) -> with( $this -> data ) ;
	}
	
	public function delete_profile( Request $request )
	{
		if ( ! $request->session()->has('user') ) 
		{
			 $response =  array('result' => 'expire' ) ;
			 return response()->json( $response );
		} 
		$user = $request->session()->get('user');
		$uid = $user -> id;
		
		
		$id = $_POST['id'];
		
		if( isset( $_POST['del_education'] ) )
		{
			DB::table	('user_profile_education' ) -> where( 'id', $id ) ->	delete( );
			$response   =  array( 'result' => '1' ) ;
			return response()->json( $response );	
		}
		
		if( isset( $_POST['del_experience'] ) )
		{
			DB::table	('user_profile_experience' ) -> where( 'id', $id ) ->	delete( );
			$response   =  array( 'result' => '1' ) ;
			return response()->json( $response );	
		}	
	}
	
	
	
	public function upload_latest_cv( Request $request )
	{
		ini_set('memory_limit', '-1');
		error_reporting(E_ALL);
		ini_set('error_reporting', E_ALL);
		ini_set("display_errors", 1);
		$d = array();
		$user  = $request    ->  session()   ->  get('user');
		$uid   = $user -> id;
		
		if( isset ( $_POST['documents_public'] )  )
		{
			$d['documents_public'] = $_POST['documents_public'];
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			$results = DB::table	('user' ) -> where( 'id', $uid ) ->	get(  );
			$user =  $results[0] ;
			$request    ->  session()   ->  put('user', $user );
			$request    ->  session()   ->  save();
			$response =  array('result' => '1', 'documents_public' =>  $_POST['documents_public'] ) ;
			return response()->json( $response );
		}
		if( isset ( $_POST['cover'] ) )
		{
			
			
			if( isset( $_FILES['file']['name'] ) && !empty( $_FILES['file']['name'] ))
			{
					
				/*$user  = $request    ->  session()   ->  get('user');*/
				
				$schemin	= getcwd();
				$tempFile 	= $_FILES['file']['tmp_name'];
				$targetPath = $schemin.'/user_profiles/';
				$filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['file']['name'] ) ) );
				$filename   = str_replace( '(', '', $filename );
				$filename   = str_replace( ')', '', $filename );
				$filename	=  preg_replace("/[^a-z0-9\_\-\.]/i", '', $filename  );
				$filename   = time().'_'.$filename;
				$targetFile = rtrim($targetPath,'/') . '/' . $filename;
				$fileTypes 	= array('pdf','doc','docx','txt'); 
				$fileParts  = pathinfo( $filename );
				$fileType = $_FILES["file"]["type"];
				if (in_array( $fileParts['extension'], $fileTypes ) ) 
				{
					move_uploaded_file($tempFile, $targetFile);
					//$up_file 		 = $schemin.'/public/user_profiles/'. $filename;
					$d['cover_letter'] = $filename;
				}
				else
				{
					$response =  array('result' => '2' ) ;
					return response()->json( $response );
					exit;
				}
				DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
				$results = DB::table	('user' ) -> where( 'id', $uid ) ->	get(  );
				$user =  $results[0] ;
				$request    ->  session()   ->  put('user', $user );
				$request    ->  session()   ->  save();
				$response =  array('result' => '1', 'resume' => $filename ) ;
				return response()->json( $response );
		 }
		 
			
			
			
		}
		else
		{
			if( isset( $_FILES['file']['name'] ) && !empty( $_FILES['file']['name'] ))
			{
					
				/*$user  = $request    ->  session()   ->  get('user');*/
				
				$schemin	= getcwd();
				$tempFile 	= $_FILES['file']['tmp_name'];
				$targetPath = $schemin.'/user_profiles/';
				$filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['file']['name'] ) ) );
				$filename   = str_replace( '(', '', $filename );
				$filename   = str_replace( ')', '', $filename );
				$filename	=  preg_replace("/[^a-z0-9\_\-\.]/i", '', $filename  );
				$filename   = time().'_'.$filename;
				$targetFile = rtrim($targetPath,'/') . '/' . $filename;
				$fileTypes 	= array('pdf','doc','docx','txt'); 
				$fileParts  = pathinfo( $filename );
				$fileType = $_FILES["file"]["type"];
				if (in_array( $fileParts['extension'], $fileTypes ) ) 
				{
					move_uploaded_file($tempFile, $targetFile);
					//$up_file 		 = $schemin.'/public/user_profiles/'. $filename;
					$d['resume'] = $filename;
				}
				else
				{
					$response =  array('result' => '2' ) ;
					return response()->json( $response );
					exit;
				}
				DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
				$results = DB::table	('user' ) -> where( 'id', $uid ) ->	get(  );
				$user =  $results[0] ;
				$request    ->  session()   ->  put('user', $user );
				$request    ->  session()   ->  save();
				$response =  array('result' => '1', 'resume' => $filename ) ;
				return response()->json( $response );
		 }
		 
		}
	 
	 
	 
	 
	 
	 
	 
	 
	 
	}
	public function update_profile ( Request $request )
	{
		
		if ( ! $request->session()->has('user') ) 
		{
			 $response =  array('result' => 'expire' ) ;
			 return response()->json( $response );
		} 
		$user = $request->session()->get('user');
		$uid = $user -> id;
		
		
	
		if( isset( $_POST['contact_number'] ) )
		{
			$d['contact_number']		 = $_POST['contact_number'];
			$d['skype']					 = $_POST['skype'];
			$d['address'] 				 = $_POST['address'];
			$d['email']	 				 = $_POST['email_address'];
			$d['birthday']	 			 = $_POST['birthday'];
			$d['contact_public']	 	 = $_POST['contact_public'];
			$d['mobile_number_public']	 = $_POST['mobile_number_public'];
			
			$d['current_emp_status']	 = $_POST['current_emp_status'];
			$d['recent_job']			 = $_POST['recent_job'];
			$d['first_name']	 		 = $_POST['e_first_name'];
			$d['last_name']				 = $_POST['e_last_name'];
			$d['name']					 = $d['first_name'].' '. $d['last_name'];
			
			if( isset ( $_POST['school_email_address'] ) )
			{
				$d['school_email']	= $_POST['school_email_address'];
			}

			/*
			 * check if ETC member we need to update the code
			 *  voucherskout should be informed about the change
			 * api to call godesto and on godesto pass customer ID, email phone to update information
			 * customerID customerName customerPhone customerEmail

             * */

			if( $user -> register_with_voucherskout ==  1) {

                $po_data                                  = array();
                $po_data['customerID']                    = $uid;
                $po_data['customerName']                  = $d['name'];
                $po_data['customerPhone']                 = $d['contact_number'];
                $po_data['customerEmail']                 = $d['email']	;

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_URL, 'https://www.godesto.com/AdminApps/v_update_customer_info'	);
                curl_setopt($ch, CURLOPT_TIMEOUT,500);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $po_data );
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $customer_info = curl_exec($ch);
                curl_close( $ch );

                $res = json_decode ( $customer_info, true );
                if( isset ( $res['result'] ) &&  $res['result']  == 1 )
                {
                    $d['register_with_voucherskout'] = 1;
                    $d['added_to_etc'] = date('Y-m-d');
                }
            }


		 	DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			$results = DB::table	('user' ) -> where( 'id', $uid ) ->	get( );
						
			$user =  $results[0] ;
			$request    ->  session()   ->  put('user', $user );
			$request    ->  session()   ->  save();
			
			$response =  array( 'result' => '1', 'user' => $d ) ;
			return response()->json( $response );
		}
		
		
		if( isset( $_POST['add_exp'] ) )
		{
			$d['title'] 			 = $_POST['title'];
			$d['company']			 = $_POST['company'];
			$d['description'] 		 = $_POST['description'];
			$d['location']	 		 = $_POST['jlocation'];
			$d['to_year']	 	 	 = $_POST['to_year'];
			$d['to_month']	 	 	 = $_POST['to_month'];
			
			$d['from_year']	 	 	 = $_POST['from_year'];
			$d['from_month']	 	 = $_POST['from_month'];


			$d['uid']	 	 		 = $uid ;
			
			$d['current_job']		= $_POST['current_job'];
			
			if( isset( $_POST['id'] ) )
			{
				$id = $_POST['id'];
				DB::table	('user_profile_experience' ) -> where( 'id', $id ) ->	update( $d );
			}
			else
			{
		 		DB::table	('user_profile_experience' ) ->	insert( $d );
			}
		 	
			if( $d['current_job']  == '1' )
			{
				$d = array();
				$d['recent_school']  		=  $_POST['company'];
				$d['recent_job']  	 		=  $_POST['title']; 
				$d['current_emp_status'] 	=  $_POST['title'];
				DB::table	('user' ) ->	where( 'id', $uid ) ->	update( $d );
				$results =  DB::table('user') -> where( 'id', $uid )->get() ;
			
				$user =  $results[0] ;
				$uid  = $user -> id;
                $request    ->  session()   ->  put('user', $user );
                $request    ->  session()   ->  save();
			}
			
			
			
			$data = DB::table	('user_profile_experience' )-> where( 'uid', $uid ) -> orderBy('from_year', 'DESC') ->	get( );
			
			
			$response =  array( 'result' => '1', 'experience' => $data  ) ;
			return response()->json( $response );
		}
		
		if( isset( $_POST['delete_album'] ) )
		{
			$id = $_POST['id'];
			DB::table ('user_albums' ) -> where ('id', $id ) -> delete();
			DB::table ('user_albums_photos' ) -> where('album_id', $id ) -> delete(); 
			 
			 
			$albums  = DB::table ('user_albums' ) -> where ('uid', $uid ) -> get();
			if( $albums -> count() ==  0 )
			{
				$albums_data = array();
			}
			else
			{
				$counter = 0;
				foreach( $albums as $albums_obj )
				{
					$albums_data[$counter]['album'] = $albums_obj;
					$album_id 					 	= $albums_obj -> id;
					$user_albums_photos 		 	= DB::table ('user_albums_photos' ) -> where('album_id', $album_id ) -> get();
					if( $user_albums_photos -> count() == 0 ){ $user_albums_photos = array();}
					$albums_data[$counter]['user_albums_photos'] = $user_albums_photos;
					$counter ++;
				}
			}
			
			$response   =  array( 'result' => '1', 'albums' => $albums_data  ) ;
			return response()->json( $response );	
		}
		
		if( isset( $_POST['get_data'] ) )
		{
			if( isset( $_POST['uid'] ) )
			{
				$uid = $_POST['uid'];
			}
			$experience 		   = DB::table	('user_profile_experience' ) -> where( 'uid', $uid )  -> orderBy('from_year', 'DESC')  ->	get( );
			$education 			   = DB::table	('user_profile_education' ) -> where( 'uid', $uid )   -> orderBy('from_year', 'DESC')   ->	 get( );
			$job_title_collection  = DB::table	('job_titles' ) -> select('title')   ->	 get( );
			$school_badges		   = array();
			if( $_POST['user_type'] != 'teacher' )
			{
				$school_arr = array();
				if( isset ( $_POST['sid_1'] ) )
				{
					$school_arr[] =  $_POST['sid_1'] ;
				}
				if( isset ( $_POST['sid_2'] ) )
				{
					$school_arr[] =  $_POST['sid_2'] ;
				}
				if( isset ( $_POST['sid_3'] ) )
				{
					$school_arr[] =  $_POST['sid_3'] ;
				}
				
				$school_badges 			= DB::table	('school_profile' ) -> select('id','name','logo','url') -> whereIn('id', $school_arr )   ->	 get( );
			}
			$query =  DB::table('user_following') -> where([['user_following.object_id','=', $uid],['user_following.uid', '<>', $user -> id] ]  ) ; 
			$query	->	join('user', 'user.id','=','user_following.uid');
			$query	->	where('user.verified', '=', '1');
			$query  ->   select('user_following.*','user.first_name', 'user.about', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username','recent_job' );
			$user_following = $query -> get();

			
			$query  = DB::table('user_recommendation');
			$query -> leftJoin('user', 'user_recommendation.uid', '=', 'user.id');
			$query -> where('user_recommendation.object_id','=', $uid );
			$query -> where('user_recommendation.approval','=', '1' );
			$query -> select('user_recommendation.*', 'user_recommendation.id as rid', 'user.first_name','user.last_name','user.username','user.profile_photo','user.followers','user.type','user.city','user.recent_school','user.recent_job','user.tutor','user.profile_photo_custom','user.about','user.id' ) ;
			$user_recommendation = $query -> get();
			
			DB::enableQueryLog();


			$invitation_send  = DB::select("SELECT user_invitation.*, coalesce(user.first_name,x.first_name) as u_first_name,coalesce(user.last_name,x.last_name) as u_last_name,coalesce(user.username,x.username) as u_username, coalesce(user.profile_photo,x.profile_photo) as u_profile_photo
FROM user_invitation
LEFT JOIN `user` ON user.email = user_invitation.friend_email 
LEFT JOIN `user` x ON x.school_email = user_invitation.friend_email
where user_invitation.status  = 1 and user_invitation.uid = $uid  HAVING  u_first_name IS NOT NULL");
			
		
			
			
			$invitation_send = count ( $invitation_send );
			
			$albums  = DB::table ('user_albums' ) -> where ('uid', $uid ) -> get();
			if( $albums -> count() ==  0 )
			{
				$albums_data = array();
			}
			else
			{
				$counter = 0;
				foreach( $albums as $albums_obj )
				{
					$albums_data[$counter]['album'] = $albums_obj;
					$album_id 					 	= $albums_obj -> id;
					$user_albums_photos 		 	= DB::table ('user_albums_photos' ) -> where('album_id', $album_id ) -> get();
					if( $user_albums_photos -> count() == 0 ){ $user_albums_photos = array();}
					$albums_data[$counter]['user_albums_photos'] = $user_albums_photos;
					$counter ++;
				}
			}
			
			
			$faqs 			= DB::table	('post' ) -> select('id','title','description','url', 'dated') -> where('post_type', 'article'  ) -> where('uid', $uid  )   ->	 get( );
			
			$response   =  array( 'result' => '1', 'query' => '', 'faqs' => $faqs,  'school_badges' => $school_badges, 'invitation_send' => $invitation_send, 'user_recommendation' => $user_recommendation, 'job_title_collection' => $job_title_collection, 'education' => $education, 'experience' => $experience, 'albums' => $albums_data, 'user_following' => $user_following  ) ;
			return response()->json( $response );	
		}
		
		
		
		
		
		if( isset( $_POST['add_edu'] ) )
		{
			$d['school'] 			 = $_POST['school'];
			if( isset (  $_POST['degree'] ) )
			{
				$d['degree']			 = $_POST['degree'];
			}
			$d['field_of_study'] 	 = $_POST['fos'];
			$d['description']	 	 = $_POST['description'];
			$d['from_year']	 	 	 = $_POST['from_year'];
			$d['to_year']	 	 	 = $_POST['to_year'];
			$d['grade']	 	 		 = $_POST['grade'];


			$d['uid']	 	 		 = $uid ;
			
			if( isset( $_POST['id'] ) )
			{
				$id = $_POST['id'];
				DB::table	('user_profile_education' ) -> where( 'id', $id ) ->	update( $d );
			}
			else
			{
		 		DB::table	('user_profile_education' ) ->	insert( $d );
			}
			
			$data = DB::table	('user_profile_education' ) -> where( 'uid', $uid )  -> orderBy('from_year', 'DESC') ->	get( );
			$response =  array( 'result' => '1', 'education' => $data   ) ;
			
			return response()->json( $response );
		}
		
		
		if( isset( $_POST['add_skills'] ) )
		{
			$d['spec'] = $_POST['tags'];
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			
			$results =  DB::table('user')->where([
							['id', '=', $uid ],
						])->get() ;
						
				$user =  $results[0] ;
                $request    ->  session()   ->  put('user', $user );
                $request    ->  session()   ->  save();
				
				
			$response =  array( 'result' => '1', 'skills' =>  $d['spec'] ) ;
			return response()->json( $response );
		}
		
		if( isset( $_POST['about'] ) )
		{
			$d['about'] = $_POST['about_you'];
			DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );
			$response =  array( 'result' => '1', 'about' =>  $d['about'] ) ;
			return response()->json( $response );
		}
		
	}
	
	
	
	public function apply_job(Request $request )
	{
		if ( ! $request->session()->has('user') ) 
		{
			 $response =  array('result' => 'expire' ) ;
			 return response()->json( $response );
		} 
		$user = $request->session()->get('user');
		$uid = $user -> id;
	}
	
	public function remove_twitter(Request $request)
	{
		if ( ! $request->session()->has('user') ) 
		{
			 $response =  array('result' => 'expire' ) ;
			 return response()->json( $response );
		} 
		$user = $request->session()->get('user');
		$uid = $user -> id;
		DB::table('user_social' ) -> where('uid', $uid )   -> where('social_media', 'twitter')  -> delete();
		$request->session()->forget('auth_twitter');
		
		$response =  array('result' => '1' ) ;
	    return response()->json( $response );
		
	}
	
	public function twitter(Request $request)
	{
		
		if ( ! $request->session()->has('user') ) 
		{
			 $response =  array('result' => 'expire' ) ;
			 return response()->json( $response );
		} 
		$user = $request->session()->get('user');
		$uid = $user -> id;
		
		
		if( isset ( $_GET['login']  ) )
		{
			$connection 	= new TwitterOAuth(Consumer_Key, Consumer_Secret);
			$request_token  = $connection->oauth("oauth/request_token", array("oauth_callback" => "https://www.expatsschools.com/oauth_callback/twitter"));
			
			$request    ->  session()   ->  put('twitter_request_token', $request_token );
			$request    ->  session()   ->  save();
			
				
			$url = $connection->url("oauth/authorize", array("oauth_token" => $request_token['oauth_token']));
			header('Location: ' . $url);
			exit;
		}
		
		$twitter_request_token   =  $request    ->  session()   ->  get('twitter_request_token');
		$connection				 =  new TwitterOAuth(Consumer_Key, Consumer_Secret, $twitter_request_token['oauth_token'], $twitter_request_token['oauth_token_secret']);
		$access_token 			 =  $connection->oauth('oauth/access_token', array('oauth_verifier' => $_REQUEST['oauth_verifier'], 'oauth_token'=> $_GET['oauth_token']));
		
		$accessToken			 =	$access_token['oauth_token'];
 		$secretToken			 =	$access_token['oauth_token_secret'];
		$connection 			 =  new TwitterOAuth(Consumer_Key, Consumer_Secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$login 					 =  $connection->get('account/verify_credentials');
		
	
		
		$d = array();
		$d['first_name']		 				    	 = $login ->  name  ;
		$d['last_name']		 				     		 = $login -> screen_name;
		$d['email']		 				     	 		 = $secretToken;
		$d['social_media']							     = 'twitter'  ;
		$d['accessToken']							     = $accessToken.'####'.$secretToken;
		$d['userID']									 = $login ->	id_str  ;
		$d['uid']										 = $uid;
			
		
		
		$school_admin_social = DB::table('user_social' ) -> where('uid', $uid )   -> where('social_media', 'twitter')  -> get();
		
		if( $school_admin_social -> count() > 0  )
		{
			DB::table	('user_social' ) -> where('uid', $uid )   -> where('social_media', 'twitter') ->	update( $d );
		}
		else
		{
			DB::table	('user_social' ) -> insert( $d );
		}
		
		$request    ->  session()   ->  put('auth_twitter', "Your  twitter profile is authenticated as: "  .  $login -> screen_name );
		$request    ->  session()   ->  save();
		
		$sess = $request->session()->get('user');
		$sess_user_name = $sess -> username;
		return redirect()->action('TeacherController@profile', ['username' => $sess_user_name]);

	}

}
