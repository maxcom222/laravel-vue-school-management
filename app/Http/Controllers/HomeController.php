<?php

namespace App\Http\Controllers;

use App\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\ExpatsMail;

use stdClass;

use Memcached;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	protected $data = array('no_header' => 0 );

    public function index()
    {

        $this -> data['home_gallery']		    		=  DB::table('home_gallery') -> get() ;

        $this -> data['home_ads']		    			=  DB::table('home_ads') -> get() ;


        $this -> data['page']		 = 'main';

        $this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';

        $this -> data['page_on']	 = 'home';

        $this -> data['no_header'] 	 = '0';

        $this -> data['top_schools']		    		=  DB::table('school_profile') -> where('popular', 1 ) -> get() ;

        $expats_friends		    		=  DB::table('expats_friends') -> where('status', 1 ) -> get() ;

        array_walk_recursive($expats_friends, function(&$item, $key)
        {

            $item -> deal_type  = addslashes($item -> deal_type );

            $item -> deal_details  = addslashes($item -> deal_details );

            $item -> intro  = addslashes($item -> intro );

        });



        $this -> data['expats_friends']	 = $expats_friends;

        return view( "template" ) -> with( $this -> data ) ;
    }

    public function school_domains()
    {
        $domain_email =  DB::table('school_profile') -> where ('domain_email', '!=', 'NULL' ) -> where ('domain_email', '!=', '' )  -> select( 'domain_email', 'name' ) -> orderBy('name', 'asc') -> get() ;

        $obj =  new stdClass();

        $obj -> domain_email = '@expatsschools.com';

        $domain_email[] = $obj ;

        $obj =  new stdClass();

        $obj -> domain_email = '@lsg.sch.ae';

        $domain_email[] = $obj ;

        $obj =  new stdClass();

        $obj -> domain_email = '@rsb.sch.ae';

        $domain_email[] = $obj ;
        //$school_profile =  DB::table('school_profile') -> where ('domain_email', '!=', 'NULL' )  -> select( 'domain_email' ) -> get() ;

        $response_to_app['status'] 	= '200';

        $response_to_app['message']  = 'success';

        $response_to_app['data'] 	=  $domain_email	;

        $response_to_app['result'] 	=  '1';

        return response()->json( $response_to_app );
    }

    public function school_detail( $url )
    {

        $query =  DB::table('school_profile');

        $query -> where( 'url', '=', $url );

        $result = $query -> get();

        $school_id = $result[0] -> id;


        $school_profile  	=  DB::table('school_profile') -> where( 'id', '=', $school_id ) -> get() ;


        $school_news  		=  DB::table('post') -> where( [ ['school_id', '=', $school_id], ['post_type','=','article' ] ] ) -> get() ;

        $school_fee    		=  DB::table('school_fee') -> where( 'school_id', '=', $school_id ) -> get() ;

        $school_albums 	    =  DB::table('school_albums') -> where( 'school_id', '=', $school_id ) -> get() ;

        $school_reviews     =  DB::table('school_reviews') -> where( 'school_id', '=', $school_id ) -> get() ;

        $school_images      =  DB::table('school_images') -> where( 'school_id', '=', $school_id ) -> get() ;

        $jobs			    =  DB::table('jobs') ->  whereRaw( 'apply_before >= CURRENT_DATE')	-> where( 'school_id', '=', $school_id ) -> get() ;

        $school_uniform	    =  DB::table('school_uniform') -> where( 'school_id', '=', $school_id ) -> get() ;


        $year1	    =  DB::table('admission_new') -> where([ [ 'school_id', '=', $school_id], ['year', '=', '2018-2019'  ] ] ) -> get() ;

        $year2	    =  DB::table('admission_new') -> where([ [ 'school_id', '=', $school_id], ['year', '=', '2019-2020'  ] ] ) -> get() ;

        $year3	    =  DB::table('admission_new') -> where([ [ 'school_id', '=', $school_id], ['year', '=', '2020-2021'  ] ] ) -> get() ;

        $data['school_news']	 = $school_news;

        $data['school_fee'] 	 = $school_fee;

        $data['jobs']			 = $jobs;

        $data['school_albums']   = $school_albums;

        $data['school_reviews']  = $school_reviews;

        $data['school_images']   = $school_images;

        $data['school_profile']  = $school_profile;

        $data['school_uniform']  = $school_uniform;



        $data['year1']  = $year1;

        $data['year2']  = $year2;

        $data['year3']  = $year3;

        $data['page'] = 'schools/school_detail';

        $data['title'] = 'Expats School - Profile Page';

        $data['page_on'] = 'school';


        return $data;
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


    public function school_search()
    {
        $school_profile =  DB::table('school_profile') -> select('id','name')-> get() ;
        if( $school_profile -> count() ==  0 )
        {

            $respone_to_app['status'] 	= '200';
            $respone_to_app['message']  = 'success';
            $respone_to_app['data'] 	=  'not found';
            $respone_to_app['result'] 	=  '0';
        }
        else
        {

            $respone_to_app['status'] 	= '200';
            $respone_to_app['message']  = 'success';
            $respone_to_app['data'] 	=  $school_profile	;
            $respone_to_app['result'] 	=  '1';
        }
        return response()->json( $respone_to_app );
    }


    public function get_prof_collection()
    {
        $job_titles =  DB::table('job_titles') -> select('id','title')-> get() ;
        if( $job_titles -> count() ==  0 )
        {

            $respone_to_app['status'] 	= '200';
            $respone_to_app['message']  = 'success';
            $respone_to_app['data'] 	=  'not found';
            $respone_to_app['result'] 	=  '0';
        }
        else
        {

            $respone_to_app['status'] 	= '200';
            $respone_to_app['message']  = 'success';
            $respone_to_app['data'] 	=  $job_titles	;
            $respone_to_app['result'] 	=  '1';
        }
        return response()->json( $respone_to_app );
    }



    public function invalidLink()
    {
        $this -> data['page']		 = 'user/invalid';

        $this -> data['title'] 		 = 'Expats School - Invalid link';

        $this -> data['page_on']	 = 'home';

        $this -> data['no_header'] 	 = '1';

        return view( "template" ) -> with( $this -> data ) ;
    }

    public function main( Request $request)
    {



        $url = $request -> url();

        $url_arr  = explode( '/', $url );

        $this -> data['expats_friends']	 = 0;

        $username = '';

        $this -> data['membership_status']  = 0;

        $this -> data['self_view'] = 0;

        $this  -> data['twitter_name'] = '';

        $this  -> data['no_header'] = 0;

        $this  -> data['user_data_standard'] = 0;

        $this  -> data['v'] = 0;

        if(  $request  -> has('v')   )
        {
            $results =  DB::table	('user' ) -> where( [['verify_link', $_GET['v']],['verified','=', '0'] ]) ->	get( );

            if( $results  -> count() <= 0 )
            {

               $this -> invalidLink();

            }
            else
            {

                $d['verified'] = 0;

                $user = $results[0];

                $uid = $user->id;

                $v = $request -> get('v');

                DB::table('user')->where('verify_link', $v   )->update($d);

                $user_data = DB::table('user')->select('id', 'first_name', 'last_name', 'profile_photo', 'username')->where('id', $uid)->get();

                $this->data['user_data_standard'] = $user_data[0];

                $this->data['v'] = 1;

                $user_block = DB::table('user_block')->where([['uid1', '=', $uid]])->orWhere([['uid2', '=', $uid]])->get();

                $request->session()->put('user', $user);

                $request->session()->save();

                $request->session()->put('user_block', $user_block);

                $request->session()->save();

                $this  -> data['no_header'] = 1;

            }
        }

        if(  isset( $url_arr[3]  ) )
        {

            if(  $url_arr[3] === 'login'  ||    $url_arr[3] === 'registration' )
            {

                $this  -> data['no_header'] = '1';

            }
        }








        if( isset( $url_arr[4] )   && $url_arr[3] === 'school'  )
        {
            $this -> data['data'] = $this -> school_detail( $url_arr[4]  ) ;
        }

        if( isset( $url_arr[4] )   && $url_arr[3] === 'profile'  )
        {
            $username = $url_arr['4'];
        }

        if( ( !isset( $url_arr[4] )   && !isset( $url_arr[3]  )  ) ||   $url_arr[3]   === 'expat-teachers-club' )
        {


            $expats_friends	=  DB::table('expats_friends') -> where('status', 1 ) -> get() ;

            array_walk_recursive($expats_friends, function(&$item, $key)
            {

                $item -> deal_type  = addslashes($item -> deal_type );

                $item -> deal_details  = addslashes($item -> deal_details );

                $item -> intro  = addslashes($item -> intro );

            });

            $this -> data['expats_friends']	 = $expats_friends;

        }

        if ( $request->session()->has('user'))
        {
            $session 			= $request->session()->get('user');

            $sess_user_name = $session -> username;

            $this -> data['self_view'] = 1;

            $profile_id = $session -> id;

            $results = DB::table	('user' ) -> where( 'id', $profile_id ) -> get();

            $user =  $results[0] ;

            $uid  = $user -> id;



            if( $user -> school_email  != '' &&  $user -> school_email != NULL )
            {

                $this -> data['membership_status']  = $this -> membership_status( $user -> school_email  );

            }

            $request    ->  session()   ->  put('user', $user );

            $request    ->  session()   ->  save();

            $user_block  = $request    ->  session()   ->  get(  'user_block'  );

            $this -> data['block'] = 0;

            if(  $username != $sess_user_name )
            {

                $this -> data['self_view'] = 0;
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


        }



        $this -> data['page']		 = 'single_main';

        $this -> data['title'] 		 = 'Expats\'s schools: discover the right school, the right job, the right staff';

        $this -> data['page_on']	 = 'home';



        return view( "template" ) -> with( $this -> data ) ;
    }



    public function friends_of_expats( $url = '' )
    {
		
		$this -> data['expats_friends']		   =  DB::table('expats_friends') -> where( 'url', $url ) -> get() ;

		$this -> data['expats_friends'] = $this -> data['expats_friends'][0];

		$this -> data['page']		 = 'friends';

		$this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';

		$this -> data['page_on']	 = '';

		$this -> data['no_header'] 	 = '0';

		$this -> data['top_schools']		    		=  DB::table('school_profile') -> where('popular', 1 ) -> get() ;

        return view( "template" ) -> with( $this -> data ) ;
    }
	

	
	public function teachers(Request $request )
    {
		if (! $request->session()->has('user')) { return  redirect()->action('AuthController@login'); }
		
		$this -> data['page']		 = 'teachers/teachers';
		$this -> data['title'] 		 = 'Expats School - Home Page';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	public function parents(Request $request )
    {
		if (! $request->session()->has('user')) { return  redirect()->action('AuthController@login'); }
		$this -> data['page']		 = 'teachers/parents';
		$this -> data['title'] 		 = 'Expats School - Home Page';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	public function friends_contract( )
    {
		if( isset ( $_POST['t'] ) )
		{
			$d['friend_name']			= $_POST['friend_name'];
			$d['contract_s_date']		= $_POST['contract_s_date'];
			$d['contract_e_date']		= $_POST['contract_e_date'];
			$d['venu']					= $_POST['venu'];
			$d['deal_desc']				= $_POST['deal_desc'];
			$d['redemption']			= $_POST['redemption'];
			$d['terms']					= $_POST['terms'];
			$d['addational_offers']		= $_POST['addational_offers'];
			$d['reservation_place']		= $_POST['reservation_place'];
			
			
			$d['c_name']		= $_POST['c_name'];
			$d['c_date']		= $_POST['c_date'];
			$d['c_title']		= $_POST['c_title'];
			
			
			$d['ex_name']		= $_POST['ex_name'];
			$d['ex_date']		= $_POST['ex_date'];
			$d['ex_title']		= $_POST['ex_title'];
			$id = $_POST['id'];
			DB::table('contracts') -> where ('id',$_POST['id']) -> update( $d );
			exit;
		}
			
			
		
		
		
		
		
		if( isset ( $_GET['id'] ) )
		{
			$query = DB::table('contracts');
			$this  -> data['id']	 =  $_GET['id'] ;
			$query -> where ('id', $_GET['id'] );
			$contracts 					 =  $query -> get() ;
			$this -> data['contracts']	 = $contracts;
		}
		else
		{
			$d['friend_name'] 				 = 'JA The Resort Golf Course';
			$d['contract_s_date']			 = '27/11/2018';
			$d['contract_e_date'] 			 = '31/05/2019';
			$d['reservation_place'] 			 = '- Golf Reception Desk<br>- +971 4 8145023';
			$d['addational_offers'] 			 = '- None';
			$d['redemption'] 				 = '-  a valid ETC Membership Card-upon redemption';
			$d['deal_desc'] 					 = '- JA The Resort Golf Course will offer special rates of AED195 per person for 9 holes and AED295 for 18 holes midweek which include AED50 off F&B in the sports café.<br>- For weekends the special offer will be AED235 for 9 holes and AED385 for 18 holes (Fridays/Saturdays and Public holidays) which include AED50 off F&B in the sports café.';
			$d['venu'] 						 = 'JA The Resort Golf Course';
			$d['terms'] 						 = '- The above offer for midweek golf (Sunday – Thursday) does not include Public holidays ';
		
			
			$d['c_name'] 						 = 'Jon Dove';
			$d['c_title'] 						 = 'Cluster General Manager';
			$d['c_date']						 = '27/11/2018';
			
			$d['ex_name'] 						 = 'Graham Davies';
			$d['ex_title'] 						 = 'Share Holder – Developer';
			$d['ex_date']						 = '27/11/2018';
			$id = DB::table('contracts') -> insertGetId( $d );
			//return  redirect()->action('AuthController@login');
			return redirect()->action('HomeController@friends_contract', ['id' => $id]);

			
		}
		
		$this -> data['page']		 = 'friends_contract';
		$this -> data['title'] 		 = 'Expats School - Home Page';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '1';
        return view( "template" ) -> with( $this -> data ) ;
    }
	
	
	
	
	
	public function you_are()
    {		
		$this -> data['page']		 = 'who-you-are';
		$this -> data['title'] 		 = 'Expats School - Home Page';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '1';
        return view( "template" ) -> with( $this -> data ) ;
    }
	
    public function home()
    {
		$this -> data['top_schools']		    		=  DB::table('school_profile') -> where('popular', 1 ) -> get() ;
		$this -> data['page']		 = 'news_feed';
		$this -> data['title'] 		 = 'Expats School - Home Page';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	

	 
	 public function school_social( $url )
	 {
		
		$query =  DB::table('school_profile');
		$query -> where( 'url', '=', $url );
		$result = $query -> get();
		
		$school_id = $result[0] -> id;
		
		
		$school_profile  		=  DB::table('school_profile') -> where( 'id', '=', $school_id ) -> get() ;
		
		$school_news  		=  DB::table('post') -> where( [ ['school_id', '=', $school_id], ['post_type','=','article' ] ] ) -> get() ;
		$school_fee    		=  DB::table('school_fee') -> where( 'school_id', '=', $school_id ) -> get() ;
		
		$school_albums 	    =  DB::table('school_albums') -> where( 'school_id', '=', $school_id ) -> get() ;
		$school_reviews     =  DB::table('school_reviews') -> where( 'school_id', '=', $school_id ) -> get() ;

		$school_images      =  DB::table('school_images') -> where( 'school_id', '=', $school_id ) -> get() ;
		$jobs			    =  DB::table('jobs') ->  whereRaw( 'apply_before >= CURRENT_DATE')	-> where( 'school_id', '=', $school_id ) -> get() ;

		$school_uniform			    =  DB::table('school_uniform') -> where( 'school_id', '=', $school_id ) -> get() ;


		$this -> data['school_news']	 = $school_news;
		$this -> data['school_fee'] 	 = $school_fee;
		$this -> data['jobs']			 = $jobs;
		$this -> data['school_albums']   = $school_albums;
		$this -> data['school_reviews']  = $school_reviews;
		$this -> data['school_images']   = $school_images;
		$this -> data['school_profile']  = $school_profile;
		$this -> data['school_uniform']  = $school_uniform;
		
		
		$this -> data['page'] = 'schools/school_social';
		$this -> data['title'] = 'Expats School - Profile Page';
		$this -> data['page_on'] = 'school';
		
        return view("template") -> with( $this -> data );
	 }
	 

	 public function epc()
	 {
		 		$this -> data['expats_friends']		    		=  DB::table('expats_friends')  -> where('status', 1 )-> get() ;

		$this -> data['page'] = 'ecp';
		$this -> data['title'] = 'Expats School - Listing Page';
		$this -> data['page_on'] = 'school';
        return view("template" ) -> with( $this -> data );
	 }


	 public function contact()
	 {
		
		$memcache = new memcached;
		$memcache	->	addServer('localhost', 11211);
		
		
		$job_titles 	=  DB::table('job_titles') -> select('id','title')-> get() ;
		$school_profile =  DB::table('school_profile') -> select('id','name')-> get() ;
		$domain_email =  DB::table('school_profile') -> where ('domain_email', '!=', 'NULL' ) -> groupBy('domain_email') -> where ('domain_email', '!=', '' )  -> select( 'domain_email' ) -> orderBy('name', 'asc') -> get() ;

		
		$memcache->set('job_titles', $job_titles  );
		$memcache->set('schools', $school_profile  );
		$memcache->set('domain_email', $domain_email  );
		
		
		/*
		$domain_email =  DB::table('school_profile') -> where ('domain_email', '!=', 'NULL' ) -> where ('domain_email', '!=', '' )  -> select( 'domain_email' ) -> orderBy('name', 'asc') -> get() ;
		
		$obj =  new stdClass();
		$obj -> domain_email = '@expatsschools.com';
		$domain_email[] = $obj ;
		
		$obj =  new stdClass();
		$obj -> domain_email = '@lsg.sch.ae';
		$domain_email[] = $obj ;
		
		$obj =  new stdClass();
		$obj -> domain_email = '@rsb.sch.ae';
		$domain_email[] = $obj ;
		
		
		$memcache->set('domain_email', $domain_email  );
		p( $memcache->get('domain_email') );
		exit;
		
	*/
		/*$memcache = new memcached;
		$memcache	->	addServer('localhost', 11211);
		
		
		$job_titles 	=  DB::table('job_titles') -> select('id','title')-> get() ;
		$school_profile =  DB::table('school_profile') -> select('id','name')-> get() ;
		$domain_email =  DB::table('school_profile') -> where ('domain_email', '!=', 'NULL' ) -> where ('domain_email', '!=', '' )  -> select( 'domain_email' ) -> orderBy('name', 'asc') -> get() ;

		
		$memcache->set('job_titles', $job_titles  );
		$memcache->set('schools', $school_profile  );
		$memcache->set('domain_email', $domain_email  );
		echo $memcache->get('job_titles');
		
		exit;*/
		
		
		
		$this -> data['page'] = 'contact';
		$this -> data['title'] = 'Expats School -  Contact Us Page';
		$this -> data['page_on'] = 'home';
		
		
        return view("template") -> with( $this -> data );
	 }

	 public function top_search( Request $request)
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
		
		$user = $request->session()->get('user');
		$uid  = $user -> id;

		if( isset( $_POST['a'] ) )
		{
			
			$search_txt			= $_POST['q'];
			
			$query =  DB::table('user');
			$query ->  where( [  ['user.verified', 1], ['user.close_account', '0' ] ] );
			if( $search_txt != '' )
			{
				$query -> whereRaw( "name LIKE '%$search_txt%' " );
			}
			
			
            $query -> limit( 10 );
			$users = $query -> select('first_name','last_name','username','followers','type','city','recent_school','recent_job','id' )  -> get();
			
			$query =  DB::table('school_profile');
			if( $search_txt != '' )
			{
				$query -> whereRaw( "name LIKE '%$search_txt%' " );
			}
            $query -> limit( 10 );
			$schools = $query -> select('name','url','id' )  -> get();
			
			DB::enableQueryLog();
			$query =  DB::table('jobs') ;
			if( $search_txt != '' )
			{
				$query -> whereRaw( "title LIKE '%$search_txt%' and apply_before >= CURRENT_DATE  OR  description LIKE '%$search_txt%' and apply_before >= CURRENT_DATE " );
			}
            $query -> limit( 10 );
			$jobs = $query -> select('title','url','id' )  -> get();
			
			
			$result['jobs']  	= $jobs;
			$result['schools']  = $schools;
			$result['users'] 	= $users;
			
			
			$laQuery = DB::getQueryLog();
			$lcWhatYouWant = $laQuery[0]['query']; 
			
				
                $respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'success';
				$respone_to_app['data'] 	=  $result	;
				$respone_to_app['result'] 	=  '1';
				$respone_to_app['lcWhatYouWant'] = $lcWhatYouWant;
			
			
			
			DB::disableQueryLog();
			//exit;
			return response()->json( $respone_to_app );
		}
	 
		 
	 
		$this -> data['page'] = 'search';
		$this -> data['title'] = 'Expats School -  search Page';
		$this -> data['page_on'] = '';
		$page_on  = 'home'; 
        return view("template") -> with( $this -> data );
	 }
	
	 public function get_social_data()
	 {
		/*
		
		benefits: ""contract_type: "Local"gender: ""load_data: 1page: 0position: ""salary_band: ""search_text: ""_token: "9ztVjwIA9MxCFmDEGR5QeUA6O9ToIxbKj1bUfY7S"__proto__: Object

		*/
		if( isset( $_POST['load_data'] ) )
		{
			
			$page 				= $_POST['page'];
			DB::enableQueryLog();
			$twitter		 =  $_POST['twitter'] ;
			$youtube		 =  $_POST['youtube'] ;
			$facebook		 =  $_POST['facebook'] ;
			$instagram 		 =  $_POST['instagram'] ;
			
			$query =  DB::table('school_social_media_content')	->  where( "school_id", '=', $_POST['school_id'] ) ;
			
			$flag = 0;
			if( $twitter != '' )
			{
				 $query ->  where( "social", '=', 'twitter' );
				 $flag  = 1;
			}
			if( $facebook != '' )
			{
				if ( $flag ==  1 ) 
				{
					 $query ->  orWhere( "social", '=', 'facebook' );
				}
				else
				{
					 $query ->  where( "social", '=', 'facebook' );
					  $flag  = 1;
				}
			}
			if( $youtube != '' )
			{
				if ( $flag ==  1 ) 
				{
					 $query ->  orWhere( "social", '=', 'youtube' );
				}
				else
				{
					 $query ->  where( "social", '=', 'youtube' );
					  $flag  = 1;
				}
			}
			if( $instagram != '' )
			{
				if ( $flag ==  1 ) 
				{
					 $query ->  orWhere( "social", '=', 'instagram' );
				}
				else
				{
					 $query ->  where( "social", '=', 'instagram' );
					  $flag  = 1;
				}
			}
			
			
			
			if( $page > 0 ) { $page = $page * 30  ; }
			$query -> offset( $page );
			$query -> limit( 30 );
			$result = $query -> orderBy ('post_date', 'DESC')-> get();
			
			$laQuery = DB::getQueryLog();
			$lcWhatYouWant = $laQuery[0]['query']; 
			DB::disableQueryLog();
			
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
			$respone_to_app['query'] 	=  $lcWhatYouWant;
			
			//exit;
			return response()->json( $respone_to_app );
		}
	 }




	
	 public function register_your_school()
    {
		
		if( isset( $_POST['register_sch'] ) )
		{
			$d['name'] = $_POST['name'];
			$d['phone'] = $_POST['phone'];
			$d['email'] = $_POST['email'];
			$d['msg'] = $_POST['msg'];
			
			Mail::send('email_template/reg_school_request', $d  , function($message) use ($d)
			{
				$message->to( 'hello@@expatsschools.com' ) -> subject( 'New request for registration' ); //->cc('bar@example.com');
			});
			
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Your message is sent successfully.';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
		}
		
		$this -> data['page']		 = 'register_your_school';
		$this -> data['title'] 		 = 'Expats School - Register your school';
		$this -> data['page_on']	 = '';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	 
	 public function unsub()
    {
		if( isset ( $_GET['email'] ))
		{
			$d = array();
			$d['email'] = $_GET['email'];
			DB::table('unsub') -> insert( $d );
		}
		$this -> data['page']		 = 'unsub';
		$this -> data['title'] 		 = 'Expats School - Unsubscribe';
		$this -> data['page_on']	 = '';
		$this -> data['no_header'] 	 = '1';
        return view( "template" ) -> with( $this -> data ) ;
    }



	 
	 
    
}
