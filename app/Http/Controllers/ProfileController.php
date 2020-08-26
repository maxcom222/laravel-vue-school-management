<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Mail;

use AWS;


class ProfileController extends Controller
{
    //

    public $data = [];

    public function user_profile($username, Request $request )
    {

        if (! $request->session()->has('user'))
        {

            return redirect()->route('user_login');

            //return redirect()->route('login');

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

        if(  $username !== $sess_user_name )
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

        $this -> data['page']		 = 'user/profile';

        $this -> data['title'] 		 = 'Expats School - Profile Page';

        $this -> data['page_on']	 = 'home';

        $this -> data['no_header'] 	 = '0';

        return view( "template" ) -> with( $this -> data ) ;
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


    public function get_education ( Request $request )
    {

        if (!$request->session()->has('user'))
        {

            $response = array('result' => 'expire');

            return response()->json($response);
        }

        if ( $request   ->  has('del') )
        {
            $id = $request -> get('id');

            DB::table	('user_profile_education' ) -> where( 'id', $id ) -> delete();

            $response['data']      = 1;

            return response()->json(    $response  );
        }

        $user = $request    ->  session()   ->  get('user');

        $uid = $user->id;

        $uid = $request  -> get('uid');

        $education 			   = DB::table	('user_profile_education' ) -> where( 'uid', $uid )   -> orderBy('from_year', 'DESC')   ->	 get( );

        $response['data']      = $education;

        return response()->json(    $response  );

    }


    public function get_experience ( Request $request )
    {

        if (!$request->session()->has('user'))
        {

            $response = array('result' => 'expire');

            return response()->json($response);
        }

        if ( $request   ->  has('del') )
        {
            $id = $request -> get('id');

            DB::table	('user_profile_experience' ) -> where( 'id', $id ) -> delete();

            $response['data']      = 1;

            return response()->json(    $response  );
        }

        $user = $request    ->  session()   ->  get('user');

        $uid = $user->id;

        $uid = $request  -> get('uid');

        $experience			   = DB::table	('user_profile_experience' ) -> where( 'uid', $uid )   -> orderBy('from_year', 'DESC')   ->	 get( );

        $response['data']      = $experience;

        return response()->json(    $response  );

    }


    public function get_followers ( Request $request )
    {

        if (!$request->session()->has('user'))
        {

            $response = array('result' => 'expire');

            return response()->json($response);
        }


        $user = $request    ->  session()   ->  get('user');

        $uid = $user->id;

        $query =   DB::table('user_following') -> where([['user_following.object_id','=', $uid],['user_following.uid', '<>', $user -> id] ]  ) ;

        $query	->	join('user', 'user.id','=','user_following.uid');

        $query	->	where('user.verified', '=', '1');

        $query  ->   select('user_following.*','user.first_name',  'user.followers', 'user.about', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username','recent_job' );

        $user_following = $query -> get();


        $response['data']      = $user_following;

        return response()->json(    $response  );

    }

    public function  get_post(  Request $request  )
    {

        if (!$request->session()->has('user'))
        {

            $response = array('result' => 'expire');

            return response()->json($response);
        }

        $user = $request    ->  session()   ->  get('user');

        $uid = $user->id;

        $uid  = $request -> get('uid');

        $faqs 			= DB::table	('post' ) -> select('id','title','description','url', 'dated') -> where('post_type', 'article'  ) -> where('uid', $uid  )   ->	 get( );

        $response['data']      = $faqs;

        return response()->json(    $response  );

    }


    public function schools ( Request $request )
    {

        if (!$request->session()->has('user'))
        {

            $response = array('result' => 'expire');

            return response()->json($response);
        }


        $user = $request    ->  session()   ->  get('user');

        $uid = $user->id;

        $query =   DB::table('user_following') -> where([['user_following.object_id','=', $uid],['user_following.uid', '<>', $user -> id] ]  ) ;

        $query	->	join('user', 'user.id','=','user_following.uid');

        $query	->	where('user.verified', '=', '1');

        $query  ->   select('user_following.*','user.first_name',  'user.followers', 'user.about', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username','recent_job' );

        $user_following = $query -> get();


        $response['data']      = $user_following;

        return response()->json(    $response  );

    }



    public function send_user_invite( Request $request )
    {

        if ( ! $request->session()->has('user') )
        {

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  'session expire';

            $response_to_app['result'] 	=  '2';

            return response()->json( $response_to_app );
        }

        $user = $request->session()->get('user');

        $uid = $user -> id;

        if ( $request -> has ('invite_friend') )
        {

            $email 		=  explode(',', trim( $request -> get('email')  ,  ','  ) );

            if( $email[0] == $user -> email  )
            {
                $response_to_app['status'] 	= '200';

                $response_to_app['message']  = 'success';

                $response_to_app['data'] 	=  'Your message is sent successfully.';

                $response_to_app['result'] 	=  '3';

                return response()->json( $response_to_app );
            }


            foreach( $email as $mail_ob)
            {
                if( $mail_ob  == $user -> email   )
                {

                    continue;

                }

                $d = array();

                $d['friend_email'] = $mail_ob;

                $d['uid']          = $uid;

                $d['code']		   =   substr(str_shuffle("0123456789"), 0, 5);

                $query =  DB::table('user_invitation') -> insert( $d );

                $d['name'] = $user ->  first_name.' '. $user ->  last_name;

                Mail::send('email_template/send_invite', $d  , function( $message  ) use ( $d )
                {

                    $message

                        ->  to  ( $d['friend_email'] )

                        -> subject( $d['name'] . ' sent you an invitation' );


                });
            }






            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  'Your message is sent successfully.';

            $response_to_app['result'] 	=  '1';

            return response()->json( $response_to_app );
        }



    }


    public function send_school_verification_code( Request $request  )
    {

        if (! $request->session()->has('user'))
        {
            $result = json_encode( (object) null );

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  'session is expired';

            $response_to_app['result'] 	=  '2';

            return response()->json( $response_to_app );
        }


        $user		 = $request->session()->get('user');

        $uid 	 	 = $user -> id;


        if( $request -> has('send_code')  )
        {




            $school_email = $request ->  get( 'school_email' );

            $res =  DB::table	('user' ) -> where( [['school_email', '=', $school_email],['verified_school', '=', 1] ] ) ->	get( );

            if( $res -> count() > 0 )
            {
                $response_to_app['status'] 	= '200';

                $response_to_app['message']  = 'success';

                $response_to_app['data'] 	=  'Already used';

                $response_to_app['result'] 	=  '3';

                return response()->json( $response_to_app );
            }



            $verify_code_school =   substr(str_shuffle("0123456789"), 0, 5);

            //$data['school_email'] = $school_email;

            $data['verify_code_school'] = $verify_code_school;

            DB::table	('user' ) -> where( 'id', $uid ) ->	update( $data );

            /*Mail::send(

                'email_template/confirm_email_school',

                ['code' => $verify_code_school, 'receiver' => $school_email],

                function($message) use ($data) {

                $message->to( $data['school_email'] ) -> subject('Use code '.  $data['verify_code_school']  .' to verify your email address.' ); //->cc('bar@example.com');

                return true;

            });*/

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  'Code is sent successfully';

            $response_to_app['result'] 	=  '1';


        }



        if( $request -> has('verify') )
        {


            $v_code  = $request ->  get ('verification_code');

            $r = DB::table	('user' ) -> where( [ ['verify_code_school', '=', $v_code ], ['id', '=', $uid],] ) ->	get( );

            if( $r -> count() == 0 )
            {

                $response_to_app['status'] 	= '200';

                $response_to_app['message']  = 'success';

                $response_to_app['data'] 	=  'success';

                $response_to_app['result'] 	=  '3';

                return response()->json( $response_to_app );
            }
            else
            {

                $d['verified_school'] = 1;

                $d['school_email']  = $request -> get('email');

                DB::table	('user' ) -> where( 'id', $uid ) ->	update( $d );

                $results = DB::table	('user' ) -> where( 'id', $uid ) -> get();

                $user =  $results[0] ;

                $uid  = $user -> id;

                $request    ->  session()   ->  put('user', $user );

                $request    ->  session()   ->  save();

                $response_to_app['status'] 	= '200';

                $response_to_app['message']  = 'success';

                $response_to_app['data'] 	=  'success';

                $response_to_app['result'] 	=  '1';

                return response()->json( $response_to_app );
            }

        }

        return response()->json( $response_to_app );
    }




    public function  save_about(  Request $request  )
    {

        if (    !$request->session()->has('user')   )
        {

            $response = array('result' => 'expire');

            return response()->json($response);
        }

        $user = $request    ->  session()   ->  get('user');

        $uid = $user    ->  id;

        if(  $request ->  has('skill')  )
        {

            $d = array();

            $d['spec'] =  trim($request -> get('spec'), ',' );

            DB::table	('user' )   -> where( [ [ 'id','=', $uid ] ]  ) -> update( $d );

        }
        else {

            $d = array();

            $d['about'] =  $request -> get('about_text');

            DB::table	('user' )   -> where( [ [ 'id','=', $uid ] ]  ) -> update( $d );

        }


        $response['data']        = 1;

        $response['uid']         = $uid ;

        return response()->json(    $response  );

    }


    public function  save_experience( Request $request )
    {

        if (!$request->session()->has('user'))
        {

            $response = array('result' => 'expire');

            return response()->json($response);
        }

        $user = $request    ->  session()   ->  get('user');

        $uid = $user->id;

        $d['title'] 			 = $request -> get('title');

        $d['company']			 =  $request -> get('company');

        $d['description'] 		 =  $request -> get('description');

        $d['location']	 		 =  $request -> get('location');

        $d['to_year']	 	 	 =  $request -> get('to_year');

        $d['to_month']	 	 	 =  $request -> get('to_month');

        $d['from_year']	 	 	 =  $request -> get('from_year');

        $d['from_month']	 	 =  $request -> get('from_month');

        $d['uid']	 	 		 = $uid ;

        $d['current_job']	  	 =  $request -> get('current_job');

        if(    $d['current_job']	  ==    '' ){

            $d['current_job'] =  0;
        }

        if(  $request -> get('edit_id')  !== 0 )
        {
            $id =  $request -> get('edit_id');

            DB::table	('user_profile_experience' ) -> where( 'id', $id ) ->	update( $d );

        }
        else
        {

            DB::table	('user_profile_experience' ) ->	insert( $d );

        }

        if( $d['current_job']  == '1' )
        {
            $d = array();

            $d['recent_school']  		=  $request -> get('company');

            $d['recent_job']  	 		= $request -> get('title');

            $d['current_emp_status'] 	=  $request -> get('title');

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

    public function  save_education( Request $request )
    {

        if (!$request->session()->has('user'))
        {

            $response = array('result' => 'expire');

            return response()->json($response);
        }

        $user = $request    ->  session()   ->  get('user');

        $uid = $user->id;

        if( $request ->  has(  'add_edu' ) )
        {

            $d['school'] 			 = $request -> get('school');

            if( $request -> get('qualification')    === 'Other'  ||    $request -> get('qualification')    === '' )
            {

                $d['degree']		= $request -> get('degree');

            }
            else
            {
                $d['degree']		= $request -> get('qualification');

            }

            $d['field_of_study'] 	 =  $request -> get('field_of_study');

            $d['description']	 	 =  $request -> get('description');

            $d['from_year']	 	 	 =  $request -> get('from_year');

            $d['to_year']	 	 	 =  $request -> get('to_year');

            $d['grade']	 	 		 =  $request -> get('grade');

            $d['uid']	 	 		 = $uid ;

            if(  $request -> get('edit_id')  !== 0 )
            {
                $id =  $request -> get('edit_id');

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




    }



    public function  save_contact_info( Request $request )
    {

        if (!$request->session()->has('user'))
        {

            $response = array('result' => 'expire');

            return response()->json($response);
        }

        $user = $request    ->  session()   ->  get('user');

        $uid = $user->id;


        if( $request -> has('tutor') )
        {
            $d['tutor'] = 1;

            DB::table	('user' ) -> where( 'id', $uid  ) ->	update( $d );

        }
        else
        {

            $d['first_name'] 			 =  $request -> get('first_name');

            $d['last_name']			     =  $request -> get('last_name');

            $d['email'] 		         =  $request -> get('email');

            $d['skype']	 		         =  $request -> get('skype');

            $d['birthday']	 	 	     =  $request -> get('dob');

            $d['contact_number']         =  $request -> get('contact_number');

            if( $request -> has('contact_number_public') )
            {
                $d['contact_number_public']  =  $request -> get('contact_number_public');

            }
            if( $request -> has('email_public') )
            {
                $d['email_public']  =  $request -> get('email_public');

            }
            if( $request -> has('skype_public') )
            {
                $d['skype_public']  =  $request -> get('skype_public');

            }
            if( $request -> has('dob_public') )
            {
                $d['dob_public']  =  $request -> get('dob_public');

            }

            DB::table	('user' ) -> where( 'id', $uid  ) ->	update( $d );



        }



        $user = DB::table	('user' )-> where( 'id', $uid )   ->	get( );

        $request    ->  session()   ->  put('user', $user[0] );

        $request    ->  session()   ->  save();

        $response =  array( 'result' => '1'   ) ;

        return response()->json( $response );

    }


    public  function search_user_by_name(Request $request )
    {


        $user = $request    ->  session()   ->  get('user');

        $uid = $user->id;

        $name = $request -> get('q');

        $v = DB::table	('user' )

            -> select( 'name', 'profile_photo',  'email', 'username', 'id')

            -> where( [ [ 'name','LIKE', '%'. $name . '%' ], [ 'id','<>', $uid  ] , ['verified', '=', 1 ] ]  ) -> get( );

        $response['data']        = $v;

        return response()->json(    $response  );

    }


    public function verify_from_link( Request $request )
    {


            $results =  DB::table	('user' ) -> where( [['verify_link', $_GET['v']],['verified','=', '0'] ]) ->	get( );


            if( $results  -> count() <= 0 )
            {

                $this -> data['page']		 = 'user/invalid';

                $this -> data['title'] 		 = 'Expats School - Invalid link';

                $this -> data['page_on']	 = 'home';

                $this -> data['no_header'] 	 = '1';


                return view( "template" ) -> with( $this -> data ) ;


            }
            else
            {
                $d['verified']   =   1;

                DB::table	('user' ) -> where( 'verify_link', $_GET['v'] ) ->	update( $d );

                $user =  $results[0] ;

                $uid  = $user -> id;

                $user_following =  DB::table('user_following')	->	where('uid', $uid )	->get() ;

                $user_block     = DB::table('user_block')-> where( [ ['uid1','=', $uid ]] ) -> orWhere(  [ ['uid2','=', $uid ]]  )  -> get();

                $user_activity  =  DB::table('user_activity')	-> select('object_id') -> where('type', 'like') ->where('uid', $uid ) ->get() ;

                $user_data      =  DB::table('user')	-> select('id', 'first_name', 'last_name', 'profile_photo', 'username' )  ->where('id', $uid ) ->get() ;

                $user_fav       = DB::table('user_fav') 	-> select('item_id', 'type')  ->  where('uid', $uid )  -> get();

                $request    ->  session()   ->  put('user', $user );

                $request    ->  session()   ->  save();

                $request    ->  session()   ->  put('user_block', $user_block );

                $request    ->  session()   ->  save();

                $response =  array('response' => '1', 'user_fav'  =>  $user_fav,  'user_data'  => $user_data[0] , 'uid' => $uid, 'username' => $user -> username,  'user_choice'  => $user -> type,   'user_block' => $user_block,   'user_follower' => $user_following, 'user_activity' => $user_activity ) ;


                $this -> data['response'] 	 = $response;

            }





        $this -> data['page']		 = 'user/profile_wizard';

        $this -> data['title'] 		 = 'Expats School - Profile Wizard';

        $this -> data['page_on']	 = 'home';

        $this -> data['no_header'] 	 = '1';



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

    public function upload_album(Request $request  )
    {

        $user = $request    ->  session()   ->  get('user');

        $uid = $user->id;

        $uid = $request -> get('uid');

        if( $request  -> has('del') )
        {
            $id = $request  -> get('id');

            $d['status'] = 0;

            DB:: table('user_albums')  -> where( 'id',  $id  ) -> update( $d );

            $albums_data   = $this -> get_albums( $uid );

            $response['status'] 	= '200';

            $response['message']  =  'error';

            $response['data'] 	= $albums_data;

            $response['result'] 	=  '1';

            return response()->json( $response );

        }

        if( $request  -> has('fetch_album') )
        {
            $albums_data   = $this -> get_albums( $uid );

            $response['status'] 	= '200';

            $response['message']  =  'error';

            $response['data'] 	= $albums_data;

            $response['result'] 	=  '1';

            return response()->json( $response );

        }
        if( $request  -> has('album') )
        {

            $d['name'] = $request -> get('title');

            $d['description'] = $request -> get('description');

            $d['location'] = $request -> get('location');

            $d['uid'] =  $uid;

            $album_id = DB:: table('user_albums')  -> insertGetId(  $d );

            $images  = $request -> get('images');

            $images = explode('##', trim( $images, '##' ) );

            foreach ($images  as $obj )
            {
                $insert_album_data = [];

                $insert_album_data['image']= $obj;

                $insert_album_data['album_id'] = $album_id;

                DB::table('user_albums_photos') -> insert( $insert_album_data  );
            }


            $albums_data   = $this -> get_albums( $uid );

            $response['status'] 	= '200';

            $response['message']  =  'error';

            $response['data'] 	= $albums_data;

            $response['result'] 	=  '1';

            return response()->json( $response );



        }


        if( isset( $_FILES ) )
        {
            $uploads = '';



            $tempFile 	= $_FILES['file']['tmp_name'];

            $targetPath = getcwd().'/classified/';

            $filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['file']['name'] ) ) );

            $filename   = 'expats_'.time().'__classifieds_'.  $filename ;

            $targetFile = rtrim($targetPath,'/') . '/' . $filename;

            $fileTypes 	= array('jpg','jpeg','gif','png', 'JPG');

            $fileParts = pathinfo($_FILES['file']['name']);

            if (in_array($fileParts['extension'], $fileTypes))
            {

                move_uploaded_file($tempFile, $targetFile);

                $uploads = $filename;

                $save_name   = 'expats_'.time().'__classifieds.jpg';


                $params['SourceFile'] =  $targetPath.  $filename;

                $params['Key'] = 'godesto-golf';

                $s3 = AWS::createClient('s3');

                $file_key  = 'albums/'.$filename;

                $t = $s3->putObject(array(

                    'Bucket'     => 'expatsschools',

                    'Key'        => $file_key,

                    'SourceFile' => $targetPath.  $filename,


                )) -> toArray();


                $url = $t['ObjectURL'];

                unlink(  $targetPath.  $filename  );

                $url = str_replace('https://expatsschools.s3.ap-south-1.amazonaws.com/','', $url );

                $response['status'] 	= '200';

                $response['message']  =  'success';

                $response['data'] 	= $uploads;

                $response['result'] 	=  '1';

            }
            else
            {

                $response['status'] 	= '200';

                $response['message']  =  'error';

                $response['data'] 	= 0;

                $response['result'] 	=  '1';
            }



        }


        return response()->json( $response );

    }

    public function Recommendation(Request $request )
    {

        //profile/user/

        $user = $request    ->  session()   ->  get('user');

        $uid = $user->id;

        if( $request  -> has('add') )
        {
            $d['object_id']    =  $request -> get('friend_id') ;

            $d['uid']          =  $uid;

            $d['text']		   =  $request -> get('text');

            DB::table('user_recommendation') -> insert( $d );

        }


        $query  = DB::table('user_recommendation');

        $query -> leftJoin('user', 'user_recommendation.uid', '=', 'user.id');

        $query -> where('user_recommendation.object_id','=',  $request -> get('friend_id')  );

        $query -> where('user_recommendation.approval','=', '1' );

        $query -> select('user_recommendation.*', 'user_recommendation.id as rid', 'user.first_name','user.last_name','user.username','user.profile_photo','user.followers','user.type','user.city','user.recent_school','user.recent_job','user.tutor','user.profile_photo_custom','user.about','user.id' ) ;

        $user_recommendation = $query -> get();


        $response['status'] 	= '200';

        $response['message']    =  'done';

        $response['data'] 	    = $user_recommendation;

        $response['result'] 	=  '1';

        return response()->json( $response );



    }

    private  function  get_albums( $uid )
    {

        $albums  = DB::table ('user_albums' ) -> where ('uid', $uid ) ->  where('status', 1) -> get();



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

        return  $albums_data;

    }


    public function profile_school ( Request $request )
    {

        if (!$request->session()->has('user'))
        {

            $response = array('result' => 'expire');

            return response()->json($response);
        }

        $uid = $request -> get('uid');

        $schools  = DB::table ('user' ) -> where ('id', $uid ) ->  select('school_one', 'school_two', 'school_three' ) -> get();

        $school_ids = [];

        if( $schools[0] ->  school_one  !== null )
        {
            $school_ids[] = $schools[0] ->  school_one;
        }
        if( $schools[0] ->  school_two  !== null )
        {
            $school_ids[] = $schools[0] ->  school_two;
        }
        if( $schools[0] ->  school_three  !== null )
        {
            $school_ids[] = $schools[0] ->  school_three;
        }


        if( count( $school_ids ) > 0 )
        {

            $school_profile			   = DB::table	('school_profile' )

                -> whereIn('id',  $school_ids )

                -> select('id', 'name', 'url', 'logo' )

                ->	 get( );

            $response['data']      = $school_profile;
        }
        else
        {
            $response['data']      = [];
        }


        return response()->json(    $response  );

    }





}
