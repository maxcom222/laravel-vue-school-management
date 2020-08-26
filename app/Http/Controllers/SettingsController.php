<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
	
	//return  redirect()->action('AuthController@login');
	protected $data = array('no_header' => 0 );
     public function settings_ads(  Request $request  )
	 {
		if ( !$request->session()->has('user') ) 
		{
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'session expire';
			$respone_to_app['result'] 	=  '2';
			return response()->json( $respone_to_app );
		} 
		$user = $request->session()->get('user');
		$user = $user -> id;
		$this -> data['page'] = 'settings/settings-ads';
		$this -> data['setting_page'] = 'settings-ads';
		$this -> data['title'] = 'Expats School -  Your Ads';
		$this -> data['page_on'] = '';
        return view("template") -> with( $this -> data );
		
	 }
	 
	 
	 
	 public function settings_basic(  Request $request  )
	 {
		if ( !$request->session()->has('user') ) 
		{
			return  redirect()->action('AuthController@login');
		} 
		
		$this -> data['page'] = 'settings/settings-basic';
		$this -> data['setting_page'] = 'settings-basic';
		$this -> data['title'] = 'Expats School -  Security Basic';
		$this -> data['page_on'] = '';
        return view("template") -> with( $this -> data );
	 }



	 public function settings_recommendation(  Request $request  )
	 {
		if ( !$request->session()->has('user') ) 
		{
			return  redirect()->action('AuthController@login');
		}


		$this -> data['page'] = 'settings/settings-recommendation';
		$this -> data['title'] = 'Expats School -  Security Basic';
		$this -> data['page_on'] = '';
		$this -> data['setting_page'] = 'settings-recommendation';
		
        return view("template") -> with( $this -> data );
	 }
	 
	 
	 public function settings_security(  Request $request  )
	 {
		if ( !$request->session()->has('user') ) 
		{
			return  redirect()->action('AuthController@login');
		} 
		
		$this -> data['page'] = 'settings/settings-security';
		$this -> data['setting_page'] = 'settings-security';
		$this -> data['title'] = 'Expats School -  Security Settings';
		$this -> data['page_on'] = '';
        return view("template") -> with( $this -> data );
	 }
	 
	 
	 public function restricted_user(  Request $request  )
	 {
		 
		
		if ( !$request->session()->has('user') ) 
		{
			return  redirect()->action('AuthController@login');
		} 
		
		$this -> data['page'] = 'settings/settings-block';
		$this -> data['setting_page'] = 'settings-block';
		$this -> data['title'] = 'Expats School -  Followers';
		$this -> data['page_on'] = '';
        return view("template") -> with( $this -> data );
	 }
	 
	 
	 public function settings_followers(  Request $request  )
	 {
		 
		
		if ( !$request->session()->has('user') ) 
		{
			return  redirect()->action('AuthController@login');
		} 
		
		$this -> data['page'] = 'settings/settings-followers';
		$this -> data['setting_page'] = 'settings-followers';
		$this -> data['title'] = 'Expats School -  Followers';
		$this -> data['page_on'] = '';
        return view("template") -> with( $this -> data );
	 }
	 
	 public function schools_followers(  Request $request  )
	 {
		 
		if ( !$request->session()->has('user') ) 
		{
			return  redirect()->action('AuthController@login');
		} 
		
		$this -> data['page'] = 'settings/settings-schools-followers';
		$this -> data['setting_page'] = 'settings-schools-followers';
		$this -> data['title'] = 'Expats School -  Followers';
		$this -> data['page_on'] = '';
        return view("template") -> with( $this -> data );
	 }
	 
	 public function remove_follower(  Request $request  )
	 {
		 
            if ( !$request->session()->has('user') )
            {

                $response_to_app['status'] 	= '200';

                $response_to_app['message']  = 'success';

                $response_to_app['data'] 	=  'session expire';

                $response_to_app['result'] 	=  '2';

                return response()->json( $response_to_app );
            }


            $user = $request->session()->get('user');

            $uid = $user -> id;

            $object_id 		 = $_POST['object_id'];

            $d['uid']		 = $uid;

            $d['object_id']  = $object_id;

            DB::table('user_following') -> where( $d ) -> delete (  );

            $query  = DB::table('user_following');

            $query -> join('user', 'user_following.object_id', '=', 'user.id');

            $query -> where('user_following.type','=', 'person' );

            $query -> where('user_following.uid','=', $uid );

            $query -> select('user_following.*', 'user.first_name','user.last_name','user.username','user.profile_photo','user.followers','user.type','user.city','user.recent_school','user.recent_job', 'user.current_emp_status' ,'user.tutor','user.profile_photo_custom','user.about','user.id' ) ;

            $result = $query -> get();

            p($result  );exit;

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $result;

            $response_to_app['result'] 	=  '1';

            return response()->json( $response_to_app );
	 }
	 
	 
	 public function remove_following(  Request $request  )
	 {
		 
		if ( !$request->session()->has('user') ) 
		{

            $response['status'] 	= '200';

            $response['message']  = 'success';

            $response['data'] 	=  'session expire';

            $response['result'] 	=  '2';

			return response()->json( $response );
		} 
		
		
        $user            = $request->session()->get('user');

        $uid             = $user -> id;

        $object_id 		 = $request -> get('object_id');

        $d['uid']		 = $uid ;

        $d['object_id']  = $object_id;

        DB::table('user_following') -> where( $d ) -> delete (  );

        if( $request -> get( 'type')   ==  'user')
        {

            $query  = DB::table('user_following');

            $query -> join('user', 'user_following.object_id', '=', 'user.id');

            $query -> where('user_following.type','=', 'person' );

            $query -> where('user_following.uid','=', $uid );

            $query -> select('user_following.*', 'user.first_name','user.last_name','user.username','user.profile_photo','user.followers','user.type','user.city','user.recent_school','user.recent_job', 'user.current_emp_status' ,'user.tutor','user.profile_photo_custom','user.about','user.id' ) ;

            $result = $query -> get();

        }
        else
        {

            $query  = DB::table('user_following');

            $query -> join('school_profile', 'user_following.object_id', '=', 'school_profile.id');

            $query -> where('user_following.type','=', 'school' );

            $query -> where('user_following.uid','=', $uid );

            $query -> select('user_following.*', 'school_profile.name','school_profile.description','school_profile.url','school_profile.followers','school_profile.id','school_profile.logo' ) ;

            $result = $query -> get();

        }






        $response['status'] 	= '200';

        $response['message']    = 'success';

        $response['data']     	=  $result;

        $response['schools']    =  $result;

        $response['result'] 	=  '1';

        return response()->json( $response  );

	 }

	 
	 public function  get_followers( Request $request   )
	 {
		 
		DB::enableQueryLog();

		if ( !$request->session()->has('user') )
		{

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  'session expire';

            $response_to_app['result'] 	=  '2';

			return response()->json( $response_to_app );
		} 
		
		
		$user = $request->session()->get('user');

		$uid  = $user -> id;
		
		
		$query  = DB::table('user_following');

		$query -> join('user', 'user_following.object_id', '=', 'user.id');

		$query -> where('user_following.type','=', 'person' );

		$query -> where('user_following.uid','=', $uid );

		$query -> select('user_following.*', 'user.first_name','user.last_name','user.username','user.profile_photo','user.followers','user.type','user.city','user.recent_school','user.recent_job', 'user.current_emp_status' ,'user.tutor','user.profile_photo_custom','user.about','user.id' ) ;

		$result = $query -> get();
		
		$laQuery = DB::getQueryLog();

		$lcWhatYouWant = $laQuery[0]['query'];

		DB::disableQueryLog();
		

		$response_to_app['query'] 	=  $lcWhatYouWant;

		if( $result -> count() ==  0 )
		{

			$result = json_encode( (object) null );

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $result;

            $response_to_app['result'] 	=  '0';
		}
		else
		{


            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $result	;

            $response_to_app['result'] 	=  '1';

		}
		

		return response()->json( $response_to_app );


	 }

	 public function  get_restricted_user( Request $request   )
	 {
		 
		DB::enableQueryLog();

		if ( !$request->session()->has('user') )
		{

			$response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  'session expire';

            $response_to_app['result'] 	=  '2';

			return response()->json( $response_to_app );
		} 
		
		
		$user = $request->session()->get('user');

		$uid  = $user -> id;
		
		

		$query  = DB::table('user_block');

		$query -> join('user', 'user_block.uid2', '=', 'user.id');

		$query -> where('user_block.uid1','=', $uid );

		$query -> select('user_block.*', 'user.first_name','user.last_name','user.username','user.profile_photo','user.followers','user.type','user.city','user.recent_school','user.recent_job',  'user.current_emp_status', 'user.tutor','user.profile_photo_custom','user.about','user.id' ) ;

		$result = $query -> get();


        $laQuery = DB::getQueryLog();

        $lcWhatYouWant = $laQuery[0]['query'];

        DB::disableQueryLog();


		$response_to_app['query'] 	=  $lcWhatYouWant;
		if( $result -> count() ==  0 )
		{
			$result = json_encode( (object) null );

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $result;

            $response_to_app['result'] 	=  '0';
		}
		else
		{


            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $result	;

            $response_to_app['result'] 	=  '1';
		}
		

		return response()->json( $response_to_app );
	 }
	 
	 
	 public function  update_approve_status( Request $request   )
	 {
		 
		DB::enableQueryLog();
		if ( !$request->session()->has('user') ) 
		{
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'session expire';
			$respone_to_app['result'] 	=  '2';
			return response()->json( $respone_to_app );
		} 
		
		
		$user = $request->session()->get('user');
		$uid  = $user -> id;
		
		$id		  = $_POST['rid'];
		$approval = $_POST['approve_status'];
		DB::table('user_recommendation') -> where ( 'id', $id ) -> update ( array( 'approval' => $approval ) );
		
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  'approval status is changed';
		$respone_to_app['result'] 	=  '1';
		return response()->json( $respone_to_app );
		
		
	 }


	 public function  get_recommendations( Request $request   )
	 {
		 
		DB::enableQueryLog();

		if ( !$request->session()->has('user') ) 
		{

			$response_to_app['status'] 	= '200';

			$response_to_app['message']  = 'success';

			$response_to_app['data'] 	=  'session expire';

			$response_to_app['result'] 	=  '2';

			return response()->json( $response_to_app );

		}
         if ( $request  ->  has('approve') ) {

                $d['approval']  = $request  -> get('status');

                $id =    $request  -> get('id');

                DB::table('user_recommendation') -> where('id', $id ) -> update( $d  );

         }

        $user = $request->session()->get('user');

		$uid  = $user -> id;
		
		$query  = DB::table('user_recommendation');

		$query -> leftJoin('user', 'user_recommendation.uid', '=', 'user.id');

		$query -> where('user_recommendation.object_id','=', $uid );

		$query -> select('user_recommendation.*', 'user_recommendation.id as rid', 'user.first_name','user.last_name','user.username','user.profile_photo','user.followers','user.type','user.city','user.recent_school', 'user.current_emp_status', 'user.recent_job','user.tutor','user.profile_photo_custom','user.about','user.id' ) ;

		$result = $query -> get();
		
		$laQuery = DB::getQueryLog();

		$lcWhatYouWant = $laQuery[0]['query'];

		DB::disableQueryLog();

        $response_to_app['query'] 	=  $lcWhatYouWant;

		if( $result -> count() ==  0 )
		{
			$result = json_encode( (object) null );

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $result;

            $response_to_app['result'] 	=  '0';
		}

		else
		{

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $result	;

            $response_to_app['result'] 	=  '1';
		}
		
		
		//exit;
		return response()->json( $response_to_app );
	 }
	 
	 
	 
	 public function  get_school_followers( Request $request   )
	 {
		 
		DB::enableQueryLog();

		if ( !$request->session()->has('user') )
		{

			$respone_to_app['status'] 	= '200';

			$respone_to_app['message']  = 'success';

			$respone_to_app['data'] 	=  'session expire';

			$respone_to_app['result'] 	=  '2';

			return response()->json( $respone_to_app );
		} 
		
		

		$user = $request->session()->get('user');

		$uid  = $user -> id;

		$query  = DB::table('user_following');

		$query -> join('school_profile', 'user_following.object_id', '=', 'school_profile.id');

		$query -> where('user_following.type','=', 'school' );

		$query -> where('user_following.uid','=', $uid );

		$query -> select('user_following.*', 'school_profile.name','school_profile.description','school_profile.url','school_profile.followers','school_profile.id','school_profile.logo' ) ;

		$result = $query -> get();
		
		$laQuery = DB::getQueryLog();

		$lcWhatYouWant = $laQuery[0]['query'];

		DB::disableQueryLog();
		
		$respone_to_app['query'] 	=  $lcWhatYouWant;

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
		
		
		return response()->json( $respone_to_app );
	 }
	 
	 
	 
	 public function settings_favorties(  Request $request  )
	 {
		if ( !$request->session()->has('user') ) 
		{
			return  redirect()->action('AuthController@login');
		} 
		$this -> data['setting_page'] = 'settings-favorties';
		$this -> data['page'] = 'settings/settings-favorties';
		$this -> data['title'] = 'Expats School -  Favorties';
		$this -> data['page_on'] = '';
        return view("template") -> with( $this -> data );
	 }
	 
	 public function user_update_account(  Request $request  )
	 {
		if ( !$request->session()->has('user') ) 
		{
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'session expire';
			$respone_to_app['result'] 	=  '2';
			return response()->json( $respone_to_app );
		} 
		$user = $request->session()->get('user');
		$uid = $user -> id;
		
		$d['first_name'] 		= $_POST['first_name'];
		$d['last_name']  		= $_POST['last_name'];
		$d['email']  			= $_POST['email'];
		$d['contact_number']    = $_POST['phone'];
		
		DB::table('user') -> where('id', $uid ) -> update ( $d );
		
		$results = DB::table('user') -> where('id', $uid ) -> get ( );
		$user =  $results[0] ;
		$request    ->  session()   ->  put('user', $user );
		$request    ->  session()   ->  save();
		
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  'Your account is updated successfully.';
		$respone_to_app['result'] 	=  '1';
		return response()->json( $respone_to_app );
	 }
	 
	 
	 
	 
	 
    public function user_update_password(  Request $request  )
    {
    if ( !$request->session()->has('user') )
    {

    $respone_to_app['status'] 	= '200';

    $respone_to_app['message']  = 'success';

    $respone_to_app['data'] 	=  'session expire';

    $respone_to_app['result'] 	=  '2';

    return response()->json( $respone_to_app );
    }
    $user = $request->session()->get('user');

    $uid = $user -> id;

    $d['password']  		=   $request -> get( 'new_password');

    $current_password		=   $request -> get( 'current_password');



    if( $current_password != $user -> password )
    {

    $respone_to_app['status'] 	= '200';

    $respone_to_app['message']  = 'error';

    $respone_to_app['data'] 	=  'You have entered incorrect current password';

    $respone_to_app['result'] 	=  '3';

    return response()->json( $respone_to_app );

    }



    DB::table('user') -> where('id', $uid ) -> update ( $d );

    $results = DB::table('user') -> where('id', $uid ) -> get ( );

    $user =  $results[0] ;

    $request    ->  session()   ->  put('user', $user );

    $request    ->  session()   ->  save();

    $respone_to_app['status'] 	= '200';

    $respone_to_app['message']  = 'success';

    $respone_to_app['data'] 	=  'Your password is updated successfully.';

    $respone_to_app['result'] 	=  '1';

    return response()->json( $respone_to_app );
    }

    public function user_classifieds(Request $request  )
    {

    if( isset( $_POST['delete'] ) )
    {
        $id = $_POST['id'];

        DB::table('classifieds') -> where('id', $id ) -> delete();
    }


    if ( !$request->session()->has('user') )
    {

        $respone_to_app['status'] 	= '200';

        $respone_to_app['message']  = 'success';

        $respone_to_app['data'] 	=  'session expire';

        $respone_to_app['result'] 	=  '2';

        return response()->json( $respone_to_app );
    }

     if ( $request  ->    has('delete') )
     {

         $cid = $request  ->    get('cid');

         DB::table('classifieds') -> where('id', $cid ) -> delete();

     }

    $user = $request->session()->get('user');

    $uid  = $user -> id;

    $query =  DB::table('classifieds') -> where('uid', $uid );

    $query	->	join('classified_category', 'classified_category.id','=','classifieds.category');

    $query  ->   select('classifieds.*','classified_category.text' );

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

    return response()->json( $respone_to_app );
    }

    public function user_classifieds_fav(Request $request  )
    {



    if ( !$request->session()->has('user') )
    {
        $respone_to_app['status'] 	= '200';
        $respone_to_app['message']  = 'success';
        $respone_to_app['data'] 	=  'session expire';
        $respone_to_app['result'] 	=  '2';
        return response()->json( $respone_to_app );
    }


    $user = $request->session()->get('user');
    $uid  = $user -> id;

    $query =  DB::table('classifieds') -> where('user_fav.uid', $uid );
    $query	->	join('classified_category', 'classified_category.id','=','classifieds.category');
    $query	->	join('user_fav', 'user_fav.item_id','=','classifieds.id');
    $query  ->   select('classifieds.*','classified_category.text' );
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
    return response()->json( $respone_to_app );
    }



    public function get_user_ads(  Request $request  )
    {

        if ( !$request->session()->has('user') )
        {

            return  redirect()->action('AuthController@login');

        }



    }

    public function index(  Request $request  )
    {

        if ( !$request->session()->has('user') )
        {

            return  redirect()->action('AuthController@login');

        }

        if( $request -> has('save_basic_info') )
        {

            $user = $request->session()->get('user');

            $uid  = $user -> id;

            $d['contact_number'] = $request -> get('contact_number');

            $d['email'] = $request -> get('email');

            $d['first_name'] = $request -> get('first_name');

            $d['last_name'] = $request -> get('last_name');

            DB::table('user')  -> where( 'id', $uid ) -> update($d );

            $respone_to_app['status'] 	= '200';

            $respone_to_app['message']  = 'success';

            $respone_to_app['data'] 	= 1	;

            $respone_to_app['result'] 	=  '1';

            return response()->json( $respone_to_app );

        }

        if( $request -> has('save_security') )
        {

            $user = $request->session()->get('user');

            $uid  = $user -> id;

            $d['password'] = $request -> get('new_password');

            DB::table('user')  -> where( 'id', $uid ) -> update($d );

            $respone_to_app['status'] 	= '200';

            $respone_to_app['message']  = 'success';

            $respone_to_app['data'] 	= 1	;

            $respone_to_app['result'] 	=  '1';

            return response()->json( $respone_to_app );

        }




        $this -> data['page'] = 'settings/settings';

        $this -> data['setting_page'] = 'settings';

        $this -> data['title'] = 'Expats School -  Your account settings';

        $this -> data['page_on'] = '';

        return view("template") -> with( $this -> data );
    }


    public function main(  Request $request  )
    {

        if ( !$request->session()->has('user') )
        {

            return  redirect()->action('AuthController@login');

        }

        $this -> data['page'] = 'settings/main';

        $this -> data['setting_page'] = 'settings';

        $this -> data['title'] = 'Expats School -  Settings';

        $this -> data['page_on'] = '';

        return view("template") -> with( $this -> data );
    }


    public function block_user( Request $request  )
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

        $user = $request->session()->get('user');

        $uid  = $user -> id;


        $d['uid1']	 = $uid;

        $d['uid2'] 	 =  $request -> get('uid2');

        $status  	 =  $request -> get('status');

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


        $query  = DB::table('user_block');

        $query -> join('user', 'user_block.uid2', '=', 'user.id');

        $query -> where('user_block.uid1','=', $uid );

        $query -> select('user_block.*', 'user.first_name','user.last_name','user.username','user.profile_photo','user.followers','user.type','user.city','user.recent_school','user.recent_job',  'user.current_emp_status', 'user.tutor','user.profile_photo_custom','user.about','user.id' ) ;

        $result = $query -> get();




        $response_to_app['status'] 			= '200';

        $response_to_app['message']  		= 'success';

        $response_to_app['data'] 			=  'User is blocked successfully';

        $response_to_app['result'] 			=  '1';

        $response_to_app['user_block'] 		=  $result ;

        $response_to_app['user_follower'] 	=  $user_following ;

        return response()->json( $response_to_app );


    }


}
