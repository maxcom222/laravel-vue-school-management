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
	
    public function index2()
    {
		
		$this -> data['home_gallery']		    		=  DB::table('home_gallery') -> get() ;
		$this -> data['home_ads']		    			=  DB::table('home_ads') -> get() ;

		$this -> data['page']		 = 'index';
		$this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '0';
		$this -> data['top_schools']		    		=  DB::table('school_profile') -> where('popular', 1 ) -> get() ;
		$this -> data['expats_friends']		    		=  DB::table('expats_friends') -> where('status', 1 ) -> get() ;

        return view( "template" ) -> with( $this -> data ) ;
    }

    public function newhome()
    {

        $this -> data['home_gallery']		    		=  DB::table('home_gallery') -> get() ;
        $this -> data['home_ads']		    			=  DB::table('home_ads') -> get() ;

        $this -> data['page']		 = 'newhome';
        $this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';
        $this -> data['page_on']	 = 'home';
        $this -> data['no_header'] 	 = '0';
        $this -> data['top_schools']		    		=  DB::table('school_profile') -> where('popular', 1 ) -> get() ;
        $this -> data['expats_friends']		    		=  DB::table('expats_friends') -> where('status', 1 ) -> get() ;

        return view( "template" ) -> with( $this -> data ) ;
    }

    public function newhome2()
    {

        $this -> data['home_gallery']		    		=  DB::table('home_gallery') -> get() ;
        $this -> data['home_ads']		    			=  DB::table('home_ads') -> get() ;

        $this -> data['page']		 = 'newhome2';
        $this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';
        $this -> data['page_on']	 = 'home';
        $this -> data['no_header'] 	 = '0';
        $this -> data['top_schools']		    		=  DB::table('school_profile') -> where('popular', 1 ) -> get() ;
        $this -> data['expats_friends']		    		=  DB::table('expats_friends') -> where('status', 1 ) -> get() ;

        return view( "template" ) -> with( $this -> data ) ;
    }


    public function index()
    {

        $this -> data['home_gallery']		    		=  DB::table('home_gallery') -> get() ;
        $this -> data['home_ads']		    			=  DB::table('home_ads') -> get() ;

        $this -> data['page']		 = 'newhome3';
        $this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';
        $this -> data['page_on']	 = 'home';
        $this -> data['no_header'] 	 = '0';
        $this -> data['top_schools']		    		=  DB::table('school_profile') -> where('popular', 1 ) -> get() ;
        $this -> data['expats_friends']		    		=  DB::table('expats_friends') -> where('status', 1 ) -> get() ;

        return view( "template" ) -> with( $this -> data ) ;
    }

    public function newhome4()
    {

        $this -> data['home_gallery']		    		=  DB::table('home_gallery') -> get() ;
        $this -> data['home_ads']		    			=  DB::table('home_ads') -> get() ;

        $this -> data['page']		 = 'newhome4';
        $this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';
        $this -> data['page_on']	 = 'home';
        $this -> data['no_header'] 	 = '0';
        $this -> data['top_schools']		    		=  DB::table('school_profile') -> where('popular', 1 ) -> get() ;
        $this -> data['expats_friends']		    		=  DB::table('expats_friends') -> where('status', 1 ) -> get() ;

        return view( "newhome4" ) -> with( $this -> data ) ;
    }
	 public function test()
    {
		 echo phpinfo();exit;
		$this -> data['home_gallery']		    		=  DB::table('home_gallery') -> get() ;
		$this -> data['home_ads']		    			=  DB::table('home_ads') -> get() ;

		$this -> data['page']		 = 'index2';
		$this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '0';
		$this -> data['top_schools']		    		=  DB::table('school_profile') -> where('popular', 1 ) -> get() ;
		$this -> data['expats_friends']		    		=  DB::table('expats_friends') -> where('status', 1 ) -> get() ;

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
	
	public function gallery()
    {
		
		
		$this -> data['page']		 = 'schools/gallery';
		$this -> data['title'] 		 = 'expatsschools: discover the right school, the right job, the right staff';
		$this -> data['page_on']	 = 'home';
		$this -> data['no_header'] 	 = '1';

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
	
	public function job_list()
    {
		
		$this -> data['page']		 = 'joblist';
		$this -> data['title'] 		 = 'Expats School - Job Listing Page';
		$this -> data['page_on']	 = 'jobs';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	public function redirect_to_job( $url )
    {
		$jobs			=  DB::table('jobs') -> where( 'url', '=', $url ) -> get() ;
		$school_id 		= $jobs[0] -> school_id;
		$this -> data['school_profile']  		=  DB::table('school_profile') -> where( 'id', '=', $school_id ) -> get() ;
		$school_url = $this -> data['school_profile'][0] -> url;
		$url = url( '/jobs/' . $school_url  .'/'. 	$jobs[0] -> url );
	?>
    <script>
	document.location = '<?php echo $url;?>';
	</script>
    <?php
		
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
		
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  $domain_email	;
			$respone_to_app['result'] 	=  '1';
		
		 return response()->json( $respone_to_app );
	}
	
	
	
	public function club()
    {
		
		$this -> data['page']		 = 'club';
		$this -> data['title'] 		 = 'Expats School - coffee club';
		$this -> data['page_on']	 = 'coffee-club';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	
	public function classifieds()
    {
		
		$this -> data['page']		 = 'classified';
		$this -> data['title'] 		 = 'Expats School - classified ';
		$this -> data['page_on']	 = 'classified';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	
	
	 public function school( $url )
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


		$this -> data['school_news']	 = $school_news;
		$this -> data['school_fee'] 	 = $school_fee;
		$this -> data['jobs']			 = $jobs;
		$this -> data['school_albums']   = $school_albums;
		$this -> data['school_reviews']  = $school_reviews;
		$this -> data['school_images']   = $school_images;
		$this -> data['school_profile']  = $school_profile;
		$this -> data['school_uniform']  = $school_uniform;
		
		
		$this -> data['year1']  = $year1;
		$this -> data['year2']  = $year2;
		$this -> data['year3']  = $year3;
		
		
		$this -> data['page'] = 'schools/school_profile';
		$this -> data['title'] = 'Expats School - Profile Page';
		$this -> data['page_on'] = 'school';
		
        return view("template") -> with( $this -> data );
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
	 
	 
	 
	 
	 public function school_listing()
	 {
		$this -> data['page'] = 'schools/school_listing';
		$this -> data['title'] = 'Expats School - Listing Page';
		$this -> data['page_on'] = 'school';
		
		$school_profile =  DB::table('school_profile') -> select('id','name')-> get() ;
		$this -> data['school_count'] = $school_profile-> count();
		
        return view("template" ) -> with( $this -> data );
	 }
	 
	 public function epc()
	 {
		 		$this -> data['expats_friends']		    		=  DB::table('expats_friends')  -> where('status', 1 )-> get() ;

		$this -> data['page'] = 'ecp';
		$this -> data['title'] = 'Expats School - Listing Page';
		$this -> data['page_on'] = 'school';
        return view("template" ) -> with( $this -> data );
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
	 
	 public function load_area()
	 {
		$area =  DB::table('school_profile') -> select('area') -> distinct('area')-> get() ;
		if( $area -> count() ==  0 )
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
			$respone_to_app['data'] 	=  $area	;
			$respone_to_app['result'] 	=  '1';
		}
		 return response()->json( $respone_to_app );
	 }
	 
	 
	
	 public function contact4()
	 {
		
       		$memcache = new memcached;
		$memcache->connect('127.0.0.1', 11211) or die ("Could not connect");
		$memcache->set('a', 'tet');
		echo $memcache->get('a');exit;
		$this -> data['page'] = 'contact';
		$this -> data['title'] = 'Expats School -  Contact Us Page';
		$this -> data['page_on'] = 'home';
		
		
        return view("template") -> with( $this -> data );
	 }
	 
	 public function save_in_cache()
	 {
		
		$memcache = new memcached;
		if( $memcache	->	addServer('localhost', 11211)  === FALSE )
		{
				
		}
		 
		//echo $upload_max_size = ini_get('upload_max_filesize');
			//exit;
		$job_titles 	=  DB::table('job_titles') -> select('id','title')-> get() ;
		$school_profile =  DB::table('school_profile') -> select('id','name')-> get() ;
		$domain_email =  DB::table('school_profile') -> where ('domain_email', '!=', 'NULL' ) -> groupBy('domain_email') -> where ('domain_email', '!=', '' )  -> select( 'domain_email' ) -> orderBy('name', 'asc') -> get() ;

		
		$memcache->set('job_titles', $job_titles  );
		$memcache->set('schools', $school_profile  );
		$memcache->set('domain_email', $domain_email  );
		$job_titles   =  $memcache->get('job_titles' );
		p( 	$job_titles  );
		
		
		$schools   =  $memcache->get('schools' );
		p( 	$schools  );
		
		
		
		$domain_email   =  $memcache->get('domain_email' );
		p( 	$domain_email  );
		exit;
		
		
	 }
	  public function save_in_cache2()
	 {
		
		$memcache = new memcached;
		$memcache	->	addServer('localhost', 11211);
		
		
		$job_titles 	=  DB::table('job_titles') -> select('id','title')-> get() ;
		$school_profile =  DB::table('school_profile') -> select('id','name')-> get() ;
		$domain_email =  DB::table('school_profile') -> where ('domain_email', '!=', 'NULL' ) -> groupBy('domain_email') -> where ('domain_email', '!=', '' )  -> select( 'domain_email' ) -> orderBy('name', 'asc') -> get() ;
		p( 	$job_titles  );

		
		$job_titles   =  $memcache->get('job_titles' );
		p( 	$job_titles  );
		exit;
		$memcache->set('schools', $school_profile  );
		$memcache->set('domain_email', $domain_email  );
		
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
	  public function slick()
	 {
		
		$this -> data['page'] = 'slick';
		$this -> data['title'] = 'Expats School -  Contact Us Page';
		$this -> data['page_on'] = 'home';
		
		
        return view("template") -> with( $this -> data );
	 }
	 public function job_detail( $school_url, $job_url, Request $request)
	 {
		 
		if( $school_url  ==  '' )
		{
			echo 'test'; exit;
		}
		if( $job_url  ==  '' )
		{
			echo 's'; exit;
		}
		
		
		$this -> data['jobs']		    		=  DB::table('jobs') -> where( 'url', '=', $job_url ) -> get() ;
		$this -> data['school_profile']  		=  DB::table('school_profile') -> where( 'url', '=', $school_url ) -> get() ;
		
		$school_id = $this -> data['school_profile'][0] -> id;
	
	    $similar_jobs  =  DB::table('jobs') -> where( 'url', '<>', $job_url )   -> where( 'school_id', '=', $school_id ) -> get() ;
		
		$this -> data['similar_jobs']  = $similar_jobs;
		if( $similar_jobs -> count()  ==  0 )
		{
			 $this -> data['similar_jobs']	=  array();
		}
		
	
		$this -> data['user_about']   = '';
		
		if ( $request->session()->has('user') ) 
		{
			$user = $request	->	session()	->	get('user');
			$this -> data['user_about']   = $user -> about;
		}
		
		$result = 	$this -> data['jobs']		;
		
		$this -> data['og_desc'] 	= substr( strip_tags( $result[0] -> description), 0, 100 );
		$this -> data['og_title']   = $result[0] -> title.' | '. $this -> data['school_profile'][0] ->name ;
		//$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expatsschoolslogo_square.jpg' ;
		$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expat_social-01-sig.jpg';//'https://www.expatsschools.com/public/css/img/expatsschoolslogo_square.jpg' ;
		$this -> data['og_url'] 	=  url('/jobs/'. $result[0]  -> url  );
	

		$this -> data['page'] = 'schools/job_detail';
		$this -> data['title'] = 'Expats School -  School Job Page';
		$this -> data['page_on'] = 'jobs';
        return view("template") -> with( $this -> data );
	 }
	 public function news_detail( $school_url, $news_url )
	 {
		 
	
		
		$this -> data['school_news']		    =  DB::table('school_news') -> where( 'url', '=', $news_url ) -> get() ;
		$this -> data['school_profile']  		=  DB::table('school_profile') -> where( 'url', '=', $school_url ) -> get() ;
	
		$this -> data['page'] = 'schools/news_detail';
		$this -> data['title'] = 'Expats School -  School Job Page';
		$this -> data['page_on'] = 'news';
        return view("template") -> with( $this -> data );
	 }
	 public function album_details( $school_url, $album_url )
	 {
		$this -> data['school_albums']		    =  DB::table('school_albums') -> where( 'url', '=', $album_url ) -> get() ;
		$this -> data['school_profile']  		=  DB::table('school_profile') -> where( 'url', '=', $school_url ) -> get() ;
		
		$result =	$this -> data['school_albums']	;
		$sc  = $this -> data['school_profile'];
		$this -> data['og_desc'] 	= substr( strip_tags( $result[0] -> description), 0, 100 );
		$this -> data['og_title']   = $result[0] -> headline ;
		//$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/400-400_logo_200.png' ;
		//		$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expatsschoolslogo_square.jpg' ;
		$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expat_social-01-sig.jpg';
		$this -> data['og_url'] 	= url('albums/'. $sc[0] -> url.  '/' .  $result[0] -> url) ;
		
		
		
		
		$this -> data['page'] = 'schools/school_albums';
		$this -> data['title'] = 'Expats School -  School Job Page';
		$this -> data['page_on'] = 'news';
        return view("template") -> with( $this -> data );
	 }
	 
	 
	 public function news()
	 {
		 
		$this -> data['page'] = 'schools/news_detail';
		$this -> data['title'] = 'Expats School -  News Page';
		$this -> data['page_on'] = 'jobs';
		
		$page_on  = 'home'; 
        return view("template") -> with( $this -> data );
	 }
	 public function search( Request $request)
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
		
		 
		 
		if( isset( $_POST['load_data'] ) )
		{
			
			
			$search_txt	   		= '';
			$teacher		   	= '';
			$tutor				= '';
			$parent			   	= '';
			
			if( isset( $_POST['school'] ) )
			{
				$school	= $_POST['school'];	
			}
			if( isset( $_POST['city'] ) )
			{
				$city	= $_POST['city'];	
			}
			
			$teacher		   	= $_POST['teacher'];
			$tutor				= $_POST['tutor'];
			$parent			   	= $_POST['parent'];
			
			$page 				= $_POST['page'];
			$search_txt			= $_POST['search_text'];
			DB::enableQueryLog();

			
			$query =  DB::table('user');
			$query ->  where( "user.id", '<>', $uid );
			$query ->  where( "user.verified", '=', '1' );
			if( $search_txt != '' )
			{
				$query -> whereRaw( "name LIKE '%$search_txt%' " );
			}
			
			if( $teacher == '1' )
			{
				$query -> where('type', 'teacher');
			}
			if( $parent == '1' )
			{
				$query -> where('type', 'parent');
				
			}
			else
			{
				if( $school != '' )
				{
					$school  =  addslashes( $school);
					$query ->  whereRaw( "recent_school LIKE '%$school%'" );
				}	
			}
			if( $tutor == '1' )
			{
				$query -> where('tutor', '1');
			}
			
			if( $page > 0 ) { $page = $page * 200  ; }
			$query -> offset( $page );
            $query -> limit( 200 );
			$users = $query -> select('first_name','last_name','username','profile_photo','followers','type','city','recent_school','recent_job','tutor','profile_photo_custom','about','id' )  -> get();
			
			$school_profile = array();
			/*if( isset( $_POST['school'] )  )
			{
				$result['users'] 	= array();
				$school	= $_POST['school'];	
				$search_text = $_POST['search_text'];	
				if( $school != '' )
				{
					$query =  DB::table('school_profile');
					if( $search_text != '' )
					{
						$query -> whereRaw( "name LIKE '%$search_text%'" );
						
					}
					$school_profile = $query -> select('name','rating','followers','logo','description','id','address','url' )  -> get();
				}
			}*/
			
			
			
			$query =  DB::table('school_profile');
			if( $search_txt != '' )
			{
				$query -> whereRaw( "name LIKE '%$search_txt%' " );
			}
            if( $page > 0 ) { $page = $page * 200  ; }
			$query -> offset( $page );
            $query -> limit( 200 );
			$school_profile = $query -> select('name','rating','followers','logo','description','id','address','url' )  -> get();
			
			
			
			$query =  DB::table('jobs');
			if( $search_txt != '' )
			{
				$query -> whereRaw( "jobs.title LIKE '%$search_txt%' OR  jobs.description LIKE '%$search_txt%' " );
			}
            if( $page > 0 ) { $page = $page * 200  ; }
			$query -> offset( $page );
            $query -> limit( 200 );
			$query	->	join('school_profile', 'school_profile.id','=','jobs.school_id');			
			$query  ->   select('jobs.*','school_profile.longitude', 'school_profile.latitude',  'school_profile.logo' ,'school_profile.longitude','school_profile.latitude', 'school_profile.id', 'school_profile.url as school_url', 'school_profile.name as school_name', 'school_profile.url as school_url');
			$jobs = $query  -> get();
			
			
			$result['jobs']  	= $jobs;
			$result['schools']  = $school_profile;
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
	 
	 //applicant_profile_link
	 //job_link
	 
	 public function filter_school()
	 {
		 
		if( isset( $_POST['load_data'] ) )
		{
			$curriculums 		= $_POST['curriculums'];
			$school_type 		= $_POST['school_type'];
			$ages_taught 		= $_POST['ages_taught'];
			$search_txt	   		= $_POST['search_text'];
			$area		   		= $_POST['area'];
			$provide_food		= $_POST['provide_food'];
			$boarding		   	= $_POST['boarding'];
			$city 				= $_POST['city'];
			$page 				= $_POST['page'];
			
			DB::enableQueryLog();

			
			$query =  DB::table('school_profile');
			/*if( $search_text != '' )
			{
				
				$query -> where( 'name', 'like', '%' . $search_text . '%' );
			}*/
			
			
			if( $curriculums != '' )
			{
				$curriculums = explode( ',', trim( $curriculums, ',' ) );
				/*foreach( $curriculums as $o )
				{
					$query ->  whereRaw( "curriculums LIKE '%$o%'" );
				}*/
				foreach($curriculums as $key => $element) 
				{
					if($key == 0) 
					{
						$query->where('curriculums', 'like', '%'.$element.'%');
					}
					else
					{
						$query->orWhere('curriculums', 'like', '%'.$element.'%');
					}
				 }
			}
			
			if( $boarding != '' )
			{
				$boarding = explode( ',', trim( $boarding, ',' ) );
				foreach( $boarding as $o )
				{
					$query ->  whereRaw( "day_boarding LIKE '%$o%'" );
				}
			}
			if( $provide_food != '' )
			{
				$query ->  whereRaw( "provide_food LIKE '%$provide_food%'" );
			}
			if( isset( $_POST['featured']) )
			{
				if(  $_POST['featured'] ==  1 )
				{
					$query ->  where( "popular", '=', 1 );
				}
			}
			
			
			
			
			if( $ages_taught != '' )
			{
				$ages_taught = explode( ',', trim( $ages_taught, ',' ) );
				//$query -> whereIn('ages_taught', $ages_taught );
				/*foreach( $ages_taught as $o )
				{
					
					$query ->  whereRaw( "ages_taught LIKE '%$o%'" );
				}*/
				foreach($ages_taught as $key => $element) 
				{
					if($key == 0) 
					{
						$query->where('ages_taught', 'like', '%'.$element.'%');
					}
					else
					{
						$query->orWhere('ages_taught', 'like', '%'.$element.'%');
					}
				 }
			}
			if( $school_type != '' )
			{
				$school_type = explode( ',', trim( $school_type, ',' ) );
				foreach($school_type as $key => $element) 
				{
					
					if($key == 0) 
					{
						if(  $element  ==  'Nursery' )
						{
							$query ->  where( 'nursery','=', '1' );
						}
						else
						{
							$query->where('school_type', 'like', '%'.$element.'%');
						}
					}
					else
					{
						if(  $element  ==  'Nursery' )
						{
							$query ->  orWhere( 'nursery','=', '1' );
						}
						else
						{
							$query->orWhere('school_type', 'like', '%'.$element.'%');
						}
					}
					//$query->orWhere('school_type', 'like', '%'.$element.'%');
				 }
				/*foreach( $school_type as $o )
				{
					if( $o  ==  'Nursery' )
					{
						$query ->  where( 'nursery','=', '1' );
					}
					else
					{
						$query ->  whereRaw( "school_type LIKE '%$o%'" );
					}
				}*/
			}
			
		
			if( $search_txt != '' &&  $search_txt != 'undefined' )
			{
				//$search_txt = DB::connection()->getPdo()->quote($search_txt);
				//$query -> whereRaw( "name LIKE '%$search_txt%'" );
				$query -> where('name', 'like', '%'. $search_txt .'%');
			}
			if( $city != '' &&  $city != 'undefined' )
			{
				//$search_txt = DB::connection()->getPdo()->quote($search_txt);
				//$query -> whereRaw( "name LIKE '%$search_txt%'" );
				$query -> where('city', 'like', '%'. $city .'%');
			}
			
			
			if( $area != '' && $area != 'all' )
			{
				$query -> whereRaw( "area LIKE '%$area%'" );
			}
			
				$query -> orderBy( "popular",  'DESC');
			
			
			
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
			$respone_to_app['q'] 	=  $lcWhatYouWant;
			return response()->json( $respone_to_app );
		}
	 }
	 
   	
	
	 public function filter_school_pins()
	 {
		 
		if( isset( $_POST['load_data'] ) )
		{
			$curriculums 		= $_POST['curriculums'];
			$school_type 		= $_POST['school_type'];
			$ages_taught 		= $_POST['ages_taught'];
			$search_txt	   		= $_POST['search_text'];
			$area		   		= $_POST['area'];
			$provide_food		= $_POST['provide_food'];
			$boarding		   	= $_POST['boarding'];
			
			$page 				= $_POST['page'];
			
			DB::enableQueryLog();

			
			$query =  DB::table('school_profile');
			/*if( $search_text != '' )
			{
				
				$query -> where( 'name', 'like', '%' . $search_text . '%' );
			}*/
			
			
			if( $curriculums != '' )
			{
				$curriculums = explode( ',', trim( $curriculums, ',' ) );
				/*foreach( $curriculums as $o )
				{
					$query ->  whereRaw( "curriculums LIKE '%$o%'" );
				}*/
				foreach($curriculums as $key => $element) 
				{
					if($key == 0) {
						$query->where('curriculums', 'like', '%'.$element.'%');
					}
					$query->orWhere('curriculums', 'like', '%'.$element.'%');
				 }
			}
			
			if( $boarding != '' )
			{
				$boarding = explode( ',', trim( $boarding, ',' ) );
				foreach( $boarding as $o )
				{
					$query ->  whereRaw( "day_boarding LIKE '%$o%'" );
				}
			}
			if( $provide_food != '' )
			{
				$query ->  whereRaw( "provide_food LIKE '%$provide_food%'" );
			}
			if( isset( $_POST['featured']) )
			{
				if(  $_POST['featured'] ==  1 )
				{
					$query ->  where( "popular", '=', 1 );
				}
			}
			
			
			
			
			if( $ages_taught != '' )
			{
				$ages_taught = explode( ',', trim( $ages_taught, ',' ) );
				//$query -> whereIn('ages_taught', $ages_taught );
				/*foreach( $ages_taught as $o )
				{
					
					$query ->  whereRaw( "ages_taught LIKE '%$o%'" );
				}*/
				foreach($ages_taught as $key => $element) 
				{
					if($key == 0) {
						$query->where('ages_taught', 'like', '%'.$element.'%');
					}
					$query->orWhere('ages_taught', 'like', '%'.$element.'%');
				 }
			}
			if( $school_type != '' )
			{
				$school_type = explode( ',', trim( $school_type, ',' ) );
				foreach( $school_type as $o )
				{
					if( $o  ==  'Nursery' )
					{
						$query ->  where( 'nursery','=', '1' );
					}
					else
					{
						$query ->  whereRaw( "school_type LIKE '%$o%'" );
					}
				}
			}
			
		
			if( $search_txt != '' &&  $search_txt != 'undefined' )
			{
				//$search_txt = DB::connection()->getPdo()->quote($search_txt);
				//$query -> whereRaw( "name LIKE '%$search_txt%'" );
				$query -> where('name', 'like', '%'. $search_txt .'%');
			}
			
			if( $area != '' && $area != 'all' )
			{
				$query -> whereRaw( "area LIKE '%$area%'" );
			}
			
			$query -> orderBy( "popular",  'DESC');
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
			$respone_to_app['q'] 	=  $lcWhatYouWant;
			return response()->json( $respone_to_app );
		}
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
	 
	 
	 
 	 public function filter_jobs()
	 {
		/*
		
		benefits: ""contract_type: "Local"gender: ""load_data: 1page: 0position: ""salary_band: ""search_text: ""_token: "9ztVjwIA9MxCFmDEGR5QeUA6O9ToIxbKj1bUfY7S"__proto__: Object

		*/
		if( isset( $_POST['load_data'] ) )
		{
			$benefits 			= $_POST['benefits'];
			$contract_type 		= $_POST['contract_type'];
			$position 			= $_POST['position'];
			$salary_band	   	= $_POST['salary_band'];
			$search_text		= $_POST['search_text'];
			
			//$experience			= $_POST['experience'];
			$gender				= $_POST['gender'];
			$department			= $_POST['department'];
			$page 				= $_POST['page'];
			
			
			DB::enableQueryLog();

			
			$query =  DB::table('jobs');
			
			/*if( $search_text != '' )
			{
				
				$query -> where( 'name', 'like', '%' . $search_text . '%' );
			}*/
			
			
			
			/*if( $position != '' )
			{
				$position = explode( ',', trim( $position, ',' ) );
				foreach( $position as $o )
				{
					$o  =  addslashes( $o);
					$query ->  whereRaw( "position LIKE '%$o%'" );
				}
			}
			*/
			
			if( isset( $_POST['benefits'] ) )
			{
				$benefits =  explode(',', $_POST['benefits'] );
				if(  $benefits[0] != ''  )
				{
					$sub_query = '';
					$sub_q_count = 0;
					foreach( $benefits as $o )
					{
						$o  =  addslashes( $o);
						if( $sub_q_count > 0 )
						{
							$sub_query   .=  " OR benefits like '%$o%'";
						}
						else
						{
							$sub_query   =  "benefits like '%$o%'";
						}
						$sub_q_count ++;
					}
					
					$query ->  whereRaw( $sub_query   );
				}
			}
			
			
			if( isset( $_POST['contract_type'] ) )
			{
				$contract_type =  explode(',', $_POST['contract_type'] );
				if(  $contract_type[0] != ''  )
				{
					$sub_query = '';
					$sub_q_count = 0;
					foreach( $contract_type as $o )
					{
						$o  =  addslashes( $o);
						if( $sub_q_count > 0 )
						{
							$sub_query   .=  " OR contract_type like '%$o%'";
						}
						else
						{
							$sub_query   =  "contract_type like '%$o%'";
						}
						$sub_q_count ++;
					}
					
					$query ->  whereRaw( $sub_query   );
				}
			}
			
			
			
			
			if( isset( $_POST['position'] ) )
			{
				$position =  explode(',', $_POST['position'] );
				if(  $position[0] != ''  )
				{
					$sub_query = '';
					$sub_q_count = 0;
					foreach( $position as $o )
					{
						$o  =  addslashes( $o);
						if( $sub_q_count > 0 )
						{
							$sub_query   .=  " OR position like '%$o%'";
						}
						else
						{
							$sub_query   =  "position like '%$o%'";
						}
						$sub_q_count ++;
					}
					
					$query ->  whereRaw( $sub_query   );
				}
			}
			
			
			
			
			
			
			
			
			
			
			
			if( $search_text != '' )
			{
				$search_text  =  addslashes( $search_text);
				$query -> whereRaw( "title LIKE '%$search_text%'" );
				$query -> orWhere( "school_profile.name", 'LIKE', "%$search_text%" );
				
			}
			if( $gender != '' &&  $gender != 'Either' )
			{
				$query -> whereRaw( "gender LIKE '%$gender%'" );
			}
			
			/*if( $experience != ''  &&  $experience != 'any'  )
			{
				$query -> where( 'experience', 'like', '%' . $experience . '%' );
			}*/
			
			if(  $_POST['school'] != '' )
			{
				$query ->  where( "school_id", '=', $_POST['school'] );
			}
			
			if( isset( $_POST['department'] ) )
			{
				$department =  $_POST['department'];
				if( is_array( $department ) )
				{
					$sub_query = '';
					$sub_q_count = 0;
					
					foreach( $department as $o )
					{
						$o  =  addslashes( $o);
						//$query ->  whereRaw( "department LIKE '%$o%'" );
						if( $sub_q_count > 0 )
						{
							$sub_query   .=  " OR department like '%$o%'";
						}
						else
						{
							$sub_query   =  "department like '%$o%'";
						}
						$sub_q_count ++;
						
						
					}
					
					$query ->  whereRaw( $sub_query   );
				}
			}
			
			if( isset( $_POST['location_type'] ) )
			{
				$location_type =  explode(',', $_POST['location_type'] );
				$respone_to_app['location_type'] 	= count( $location_type );
				if(  $location_type[0] != ''  )
				{
					$sub_query = '';
					$sub_q_count = 0;
					
					foreach( $location_type as $o )
					{
						$o  =  addslashes( $o);
						//$query ->  whereRaw( "department LIKE '%$o%'" );
						if( $sub_q_count > 0 )
						{
							$sub_query   .=  " OR location like '%$o%'";
						}
						else
						{
							$sub_query   =  "location like '%$o%'";
						}
						$sub_q_count ++;
					}
					
					$query ->  whereRaw( $sub_query   );
				}
			}
			
			
			
			
			
			$query ->  whereRaw( 'apply_before >= CURRENT_DATE');
			if( $salary_band != '' &&  $salary_band != 'any'  )
			{
				$query -> where( 'benefits', 'like', '%' . $benefits . '%' );
			}
			
			$query	->	join('school_profile', 'school_profile.id','=','jobs.school_id');			
			$query  ->   select('jobs.*','school_profile.longitude', 'school_profile.latitude',  'school_profile.logo' ,'school_profile.longitude','school_profile.latitude', 'school_profile.id', 'school_profile.url as school_url', 'school_profile.name as school_name', 'school_profile.url as school_url');

			
			if( $page > 0 ) { $page = $page * 10  ; }
			$query -> offset( $page );
            $query -> limit( 10 );
			
			$result = $query -> get();
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
	 
	 public function classified_detail( $url  = '')
	 {
		 
		$query =  DB::table('classifieds') ->  where( 'url', '=', $url );
		$query	->	join('classified_category', 'classified_category.id','=','classifieds.category');
		$query	->	join('user', 'user.id','=','classifieds.uid');
		$query  ->   select('classifieds.*','classified_category.text','user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username','user.email' );
		$result = $query -> get();
		
		$id = $result[0] -> id;		
		$this -> data['classifieds_images']  		=  DB::table('classifieds_images') -> where( 'cid', '=', $id ) -> get() ;
		$this -> data['result']  					= $result[0];
		
		
		
		$this -> data['og_desc'] 	= substr( strip_tags( $result[0] -> description), 0, 100 );
		$this -> data['og_title']   = $result[0] -> title ;
		//$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expatsschoolslogo_square.jpg' ;
		//$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expatsschoolslogo_square.jpg' ;
		$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expat_social-01-sig.jpg';
		$this -> data['og_url'] 	= url('classifieds/detail/' .  $result[0] -> url) ;
		

		$this -> data['page'] = 'classified/detail';
		$this -> data['title'] = 'Expats School -  '. $result[0] -> title;
		$this -> data['page_on'] = 'classified';
        return view("template") -> with( $this -> data );
	 }
	 
	 
	 public function makelive( $url  = '')
	 {
		 
		$query =  DB::table('classifieds') ->  where( 'url', '=', $url );
		$query	->	join('classified_category', 'classified_category.id','=','classifieds.category');
		$query	->	join('user', 'user.id','=','classifieds.uid');
		$query  ->   select('classifieds.*','classified_category.text','user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username','user.email' );
		$result = $query -> get();
		
		$id = $result[0] -> id;		
		$this -> data['classifieds_images']  		=  DB::table('classifieds_images') -> where( 'cid', '=', $id ) -> get() ;
		$this -> data['result']  					= $result[0];
		
		
		
		$this -> data['og_desc'] 	= substr( strip_tags( $result[0] -> description), 0, 100 );
		$this -> data['og_title']   = $result[0] -> title ;
		//$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/400-400_logo_200.png' ;
		//$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expatsschoolslogo_square.jpg' ;
		
		$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expat_social-01-sig.jpg';
		
		
		$this -> data['og_url'] 	= url('classifieds/detail/' .  $result[0] -> url) ;
		

		$this -> data['page'] = 'classified/detail';
		$this -> data['title'] = 'Expats School -  '. $result[0] -> title;
		$this -> data['page_on'] = 'classified';
        return view("template") -> with( $this -> data );
	 }
	 
	 
	 public function flag_item( Request $request )
	 {
		if( isset( $_POST['report'] ) )
		{
			$uid = 0;
			if ( ! $request->session()->has('user') ) 
			{	
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'expire';
				$respone_to_app['data'] 	=  '';
				$respone_to_app['result'] 	=  '2';
				return response()->json( $respone_to_app );
			}
			
			$user = $request -> session() -> get('user');
			
			$d['item_id'] 		= $_POST['cid'];
			$d['report'] 		= $_POST['reason'];
			$d['uid'] 			= $user -> id ;
			$d['type'] 		    = 'ads';	
			
			DB::table('flag_items') -> insert( $d );
			
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  $d ;
			$respone_to_app['result'] 	=  '1';
			
			return response()->json( $respone_to_app );
		}
		 
	 }
	 
	 
	 
	 public function add_to_fav( Request $request )
	 {
		if( isset( $_POST['add_fav'] ) )
		{
			$uid = 0;
			if ( ! $request->session()->has('user') ) 
			{	
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'expire';
				$respone_to_app['data'] 	=  '';
				$respone_to_app['result'] 	=  '2';
				return response()->json( $response );
			}
			
			$user = $request -> session() -> get('user');
			
			DB::enableQueryLog();
			if( $_POST['action'] == 'add')
			{
				$d['item_id'] 		= $_POST['id'];
				$d['uid'] 			= $user -> id ;
				if( isset ( $_POST['type'] ) )
				{
					$d['type'] 		    =  $_POST['type'] ;
				}
				else
				{
					$d['type'] 		    = 'ads';
				}
					
				DB::table('user_fav') -> insert( $d );
				$respone_to_app['result'] 	=  '1';
			}
			else
			{
				$d['item_id'] 		= $_POST['id'];
				$d['uid'] 			= $user -> id ;
				if( isset ( $_POST['type'] ) )
				{
					$d['type'] 		    =  $_POST['type'] ;
				}
				else
				{
					$d['type'] 		    = 'ads';
				}	
				DB::table('user_fav')-> where('item_id', $d['item_id'] ) -> where('type', $d['type'] 	 )  -> where('uid', $d['uid'] )   -> delete(  );
				$respone_to_app['result'] 	=  '4';
			}
			
			$laQuery = DB::getQueryLog();
			$lcWhatYouWant = $laQuery[0]['query']; 
			DB::disableQueryLog();
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  $d ;
			$respone_to_app['q'] 	=  $lcWhatYouWant ;
			
			
			return response()->json( $respone_to_app );
		}
		 
	 }
	 
	 public function job_apply_form( Request $request )
	 {
		 
		if( isset( $_POST['job_application'] ) )
		{
			$uid = 0;
			if ( !$request->session()->has('user')) 
			{	
					$respone_to_app['status'] 	= '200';
					$respone_to_app['message']  = 'error';
					$respone_to_app['data'] 	=  'Your session is expired.';
					$respone_to_app['result'] 	=  '2';
					return response()->json( $respone_to_app );
			}
			
			$sess = $request->session()->get('user');
			$uid = $sess -> id;
			$d['job_id'] 			= $_POST['jid'];
			$d['cover_letter'] 		= $_POST['cover_letter'];
			$d['uid'] 				= $uid;
			
			$query =  DB::table('jobs') -> where ('id', $d['job_id']  )  -> increment('applicants');
			DB::table('job_applications') -> insert( $d );
		
			$d['profile_link']		= url('/user/profile_view?u=' .$sess -> username . '&env=exp'  );
			$d['job_link']			= $_POST['job_url'];
			$school_url				= $_POST['school_url'];
			
			
			
			$scool_profile 		=  DB::table('school_profile') -> where( 'url', '=', $school_url ) -> get() ;
			
		
			$d['email'] = $scool_profile[0] -> email;
	
			$d['school_url'] = $school_url;
			
			$d['email'] = 'bilal@godesto.com';
			
			Mail::send('email_template/job_apply_from_user', $d  , function($message) use ($d)
			{
				$message->to( $d['email'] ) -> subject( 'Your have got an application for a job' ); //->cc('bar@example.com');
			});
			
			Mail::send('email_template/job_apply_from_user', $d  , function($message) use ($d)
			{
				$message->to( 'handsup@expatsschools.com' ) -> subject( 'Your have got an application for a job' ); //->cc('bar@example.com');
			});
			
			
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Your message is sent successfully. Please wait for response';
			$respone_to_app['result'] 	=  '1';
			
			return response()->json( $respone_to_app );
		}
		
		
	 }
	 public function reply_to( Request $request )
	 {
		if( isset( $_POST['reply_ad'] ) )
		{
			$uid = 0;
			if ($request->session()->has('user')) 
			{	
				$sess = $request->session()->get('user');
				$uid = $sess -> id;
			}
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
	 
 	 public function filter_classifieds( Request $request )
	 {
		/*
		
		benefits: ""contract_type: "Local"gender: ""load_data: 1page: 0position: ""salary_band: ""search_text: ""_token: "9ztVjwIA9MxCFmDEGR5QeUA6O9ToIxbKj1bUfY7S"__proto__: Object

		*/
			$user = $request->session()->get('user');
			$uid  = $user -> id;
		
		
		if( isset( $_POST['load_data'] ) )
		{
			
			$page 				= $_POST['page'];
			$favourites 		= $_POST['favourites'];
			
			DB::enableQueryLog();
			$query =  DB::table('classifieds');
			
			
			if( isset ( $_POST['condition'] ) )
			{
				 $condition	= $_POST['condition'];
				 $query ->  whereRaw( "conditions LIKE '%$condition%'" );
			}
			if( isset ( $_POST['usage'] ) )
			{
				 $usage	= $_POST['usage'];
				 $query ->  whereRaw( "usage LIKE '%$usage%'" );
			}
			if( isset ( $_POST['age'] ) )
			{
				 $age	= $_POST['age'];
				 $query ->  whereRaw( "ages LIKE '%$age%'" );
			}
			if( isset ( $_POST['warranty'] ) )
			{
				 $warranty	= $_POST['warranty'];
				 $query ->  whereRaw( "warranty LIKE '%$warranty%'" );
			}
			if( isset ( $_POST['category'] ) )
			{
				 $category	= $_POST['category'];
				 $query ->  where( "category", $category );
			}
			if( isset ( $_POST['sub_category'] ) )
			{
				 $sub_category	= $_POST['sub_category'];
				 $query ->  where( "sub_category", $sub_category );
			}
			
			if( isset ( $_POST['mileage'] ) )
			{
				 $mileage	= $_POST['mileage'];
				 $query ->  whereRaw( "mileage <= '%$mileage%'" );
			}
			
			if( isset ( $_POST['year'] ) )
			{
				 $year	= $_POST['year'];
				 $query ->  where( "year", $year );
			}
			
			
			$query ->  where( "classifieds.is_live", 1 );
			if( isset ( $_POST['level_3'] ) )
			{
				 $level_3	= $_POST['level_3'];
				 $query ->  where( "level_3", $level_3 );
			}
			if( isset ( $_POST['level_4'] ) )
			{
				 $level_4	= $_POST['level_4'];
				 $query ->  where( "level_4", $level_4 );
			}
			
			
			if( isset ( $_POST['search_text'] ) )
			{
				$search_text	=	$_POST['search_text'];
				$query -> where( 'classifieds.title', 'like', '%' . $search_text . '%' );
				$query -> orWhere('classifieds.description', 'like', '%'.$search_text.'%');
			}
			
			if ( $favourites ==  1 )
			{
				$favourites_result = DB::table('user_fav') ->  select( DB::raw( 'GROUP_CONCAT( item_id )' ) )->  where( 'uid', '=', $uid )  ->  where( 'type', '=', 'ads' ) -> get();
				if( $favourites_result -> count() > 0 )
				{
					$prop		 = 'GROUP_CONCAT( item_id )';
					$ids		 = $favourites_result[0] -> $prop;
					$ids_arr	 = explode( ',', $ids );
					
					$query  ->  whereIn('classifieds.id', $ids_arr);
				}
			}
			
		
			
			
			$query	->	join('classified_category', 'classified_category.id','=','classifieds.category');
			$query	->	join('user', 'user.id','=','classifieds.uid');
			//select jobs.*, school_profile.id,school_profile.url as school_url, school_profile.name from jobs INNER JOIN school_profile on jobs.school_id=school_profile.id
			
			$query  ->   select('classifieds.*','classified_category.text','user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username' );

			$query  ->  orderBy('id', 'DESC');
			if( $page > 0 ) { $page = $page * 10  ; }
			$query -> offset( $page );
            $query -> limit( 10 );
			
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
			
			
			//exit;
			return response()->json( $respone_to_app );
		}
	 }
	 
	 
	public function create_album(  Request $request  )
	{
		
		//album_location:album_location, album_description:album_description, album_name:album_name, add_album:1
		if( isset( $_POST['add_album'] ) )
		{
			if (! $request->session()->has('user')) 
			{
			    $respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'error';
				$respone_to_app['data'] 	=  'logout'	;
				$respone_to_app['result'] 	=  '0';
				return response()->json( $respone_to_app );
			}
			
			$user  = $request    ->  session()   ->  get('user');
			
			$d['location'] 		= $_POST['album_location'];
			$d['description'] 	= $_POST['album_description'];
			$d['name'] 			= $_POST['album_name'];
			$d['public'] 		= $_POST['public'];
			$d['uid']		    = $user -> id;
			
			
			$images		= $_POST['images'];
			$id = DB::table	('user_albums')	->	insertGetId( $d );
			$images = explode('##', trim( $images, '##' ) );
			foreach ( $images as $ojb )
			{
				$d = array();
				$d['image'] = $ojb;
				$d['album_id'] = $id ;
				DB::table	('user_albums_photos')	->	insert( $d );
			}
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Album is uploaded successfully'	;
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
			
		}
		
	}
	 
	public function upload_album()
	{
		$uploads = '';
		if( isset( $_FILES ) )
		{
			$uploads = '';
			$count = count( $_FILES['file']['name'] );
			for( $i = 0; $i < $count; $i ++ )
			{
				
				$schemin	= getcwd();
				$tempFile 	= $_FILES['file']['tmp_name'][$i];
				$targetPath = $schemin.'/public/user_albums/';
				
				$filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['file']['name'][$i] ) ) );
				$targetFile = rtrim($targetPath,'/') . '/' . $filename;
				
				
				$fileTypes 	= array('jpg','jpeg','gif','png', 'JPG'); 
				$fileParts = pathinfo($_FILES['file']['name'][$i]);
				if (in_array($fileParts['extension'], $fileTypes)) 
				{
					move_uploaded_file($tempFile, $targetFile);
					$uploads .= '##'. $filename;
					
					/*$auto_id = time().'_';
					$params['SourceFile'] =  $_SERVER['DOCUMENT_ROOT'] .'/media/'.  $_FILES['file']['name'][$i];
					$params['Key'] = 'godesto-iten';
					$url = $this -> aws_sdk -> saveObjectBucket( $params, $auto_id );
					unlink(   $_SERVER['DOCUMENT_ROOT'] .'/media/'.  $_FILES['file']['name'][$i]  );
					$url = str_replace('https://s3-us-west-2.amazonaws.com/bookinghotels/golf_holidays/','', $url );
					$uploads .= '##'. $url;
					if( !isset(	$_POST['hub_id'] ))
					{
						echo $uploads;exit;
					}*/
				
				}
				else 
				{
					//echo '0';
				}
				
				
			}
			echo $uploads ;
			exit;
		}
	}
	
	
	
	public function delete_ad_image(  Request $request  )
	{
		
		
	}
	
	 public function save_ad(  Request $request  )
	 {
		if ( ! $request->session()->has('user') ) 
		{
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'session expire';
			$respone_to_app['result'] 	=  '2';
			return response()->json( $respone_to_app );
		} 
		$user = $request->session()->get('user');
		$uid = $user -> id;
		if( isset( $_POST['save_ad'] ) )
		{
			$d['title'] 				 =  $_POST['title'] ;
			$d['phone_number'] 			 =  $_POST['phone_number'] ;
			$d['price'] 				 =  $_POST['price'] ;
			$d['description'] 			 =  $_POST['description'] ;
			$d['warranty'] 				 =  $_POST['warranty'] ;
			$d['category'] 				 =  $_POST['category'] ;
			
			$d['address'] 				 =  $_POST['address'] ;
			$d['latitude'] 				 =  $_POST['latitude'] ;
			$d['longitude'] 			 =  $_POST['longitude'] ;
			
			$d['mileage']				 =  $_POST['mileage'];
			$d['year']					 =  $_POST['year'];
			$d['service_history']					 =  $_POST['service_history'];
			
			
			
			$d['sub_category'] 			 =  $_POST['sub_category'] ;
			if( $_POST['sub_category'] ==  '' )
			{
					$d['sub_category'] 	= 0;
			}
			
			$d['level_3'] 			 =  $_POST['level_3'] ;
			if( $_POST['level_3'] ==  '' )
			{
					$d['level_3'] 	= 0;
			}
			
			$d['level_4'] 			 =  $_POST['level_4'] ;
			if( $_POST['level_4'] ==  '' )
			{
					$d['level_4'] 	= 0;
			}
			
			
			
			$d['conditions'] 			 =  $_POST['condition'] ;
			$d['usage'] 				 =  $_POST['usage'] ;
			$d['ages'] 					 =  $_POST['age'] ;
			$d['uid'] 					 =  $uid;
			
			$page_url =  strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($d['title'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
			$page_url = $page_url .'_'.time();

			$d['url'] 					 =  $page_url;
			$d['dated'] 				 = date('Y-m-d');
			
			$d['is_live'] 				 = 0;
			
			if( isset ( $_POST['edit']  ) )
			{
				$id  = $_POST['edit_id'];
				DB::table	('classifieds' )	-> where('id', $id ) -> update( $d   );
			}
			else
			{
				$id = DB::table	('classifieds' ) -> insertGetId( $d   );
			}
			
			
			
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  =  $id;
			$respone_to_app['data'] 	=  'Ad is saved successfully';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
			
		}
		
		if( isset( $_POST['update_ad'] ) )
		{
			$ad_id 				 =  $_POST['ad_id'] ;
			$ad_photos			 = explode('##', trim($_POST['ad_photos'], '##') );
			
			
			$del_photos = array();
			if( isset ( $_POST['del_photos'] ) )
			{
				$del_photos			 = explode('##', trim($_POST['del_photos'], '##') );
				foreach( $del_photos as $image )
				{
				
					DB::table	('classifieds_images' ) -> where ('image', $image ) -> delete( );
				}
			}
			foreach( $ad_photos as $image )
			{
				
					$d['image'] = $image;
					$d['cid']	= $ad_id;
					DB::table	('classifieds_images' ) -> insert( $d   );
			}
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  =  'success';
			$respone_to_app['data'] 	=  'Ad is saved successfully';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
		}
		
		
	 }
	 
	 public function cover_image_upload( Request $request )
	 {
		$d = array();
		if( isset( $_FILES['cover_image']['name'] ) && !empty( $_FILES['cover_image']['name'] ))
		{
			$user  = $request    ->  session()   ->  get('user');
			$uid   = $user -> id;
			
			$ad_id = $_POST['ad_id'];
			
			
			$schemin	= getcwd();
			$tempFile 	= $_FILES['cover_image']['tmp_name'];
			$targetPath = $schemin.'/public/classifieds/';
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
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  =  'error';
				$respone_to_app['data'] 	=  'Invalid formate';
				$respone_to_app['result'] 	=  '4';
			
				return response()->json( $response );
				exit;
			}
		
			DB::table	('classifieds' ) -> where( 'id', $ad_id ) ->	update( $d );
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  =  $filename;
			$respone_to_app['data'] 	=  'Cover Image is saved successfully';
			$respone_to_app['result'] 	=  '1';
			
			return response()->json( $respone_to_app );
	 }
	}
	
	
	 public function upload_ad_photo()
	 {
		
		$uploads = '';
		if( isset( $_FILES ) )
		{
			$uploads = '';
			$count = count( $_FILES['file']['name'] );
			for( $i = 0; $i < $count; $i ++ )
			{
				
				$schemin	= getcwd();
				$tempFile 	= $_FILES['file']['tmp_name'][$i];
				$targetPath = $schemin.'/public/classifieds/';
				
				$filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['file']['name'][$i] ) ) );
				$filename   = time().'_'.$filename;
				$targetFile = rtrim($targetPath,'/') . '/' . $filename;
				
				
				$fileTypes 	= array('jpg','jpeg','gif','png', 'JPG'); 
				$fileParts = pathinfo($_FILES['file']['name'][$i]);
				if (in_array($fileParts['extension'], $fileTypes)) 
				{
					move_uploaded_file($tempFile, $targetFile);
					$uploads .= '##'. $filename;
					
					/*$auto_id = time().'_';
					$params['SourceFile'] =  $_SERVER['DOCUMENT_ROOT'] .'/media/'.  $_FILES['file']['name'][$i];
					$params['Key'] = 'godesto-iten';
					$url = $this -> aws_sdk -> saveObjectBucket( $params, $auto_id );
					unlink(   $_SERVER['DOCUMENT_ROOT'] .'/media/'.  $_FILES['file']['name'][$i]  );
					$url = str_replace('https://s3-us-west-2.amazonaws.com/bookinghotels/golf_holidays/','', $url );
					$uploads .= '##'. $url;
					if( !isset(	$_POST['hub_id'] ))
					{
						echo $uploads;exit;
					}*/
				
				}
				else 
				{
					//echo '0';
				}
				
				
			}
		}
			echo $uploads ;
			exit;
	}
	
	 public function place_ad( Request  $request )
	 {
		
		if ( ! $request->session()->has('user') ) 
		{
			return  redirect()->action('AuthController@login');
		}
		$this -> data['page'] = 'classified/place_ad';
		$this -> data['title'] = 'Expats\' School - Classified Page';
		$this -> data['page_on'] = 'classified';
        return view("template" ) -> with( $this -> data );
	 }
	 
	 public function edit_place_ad($id= '', Request  $request )
	 {
		if( $id == '')
		{
			return  redirect()->action('HomeController@post_ad');
		}
		if ( ! $request->session()->has('user') ) 
		{
			return  redirect()->action('AuthController@login');
		}
		
		$query =  DB::table('classifieds') -> where('classifieds.id', $id ); 
		$query	->	join('classified_category', 'classified_category.id','=','classifieds.category');
		$query  ->   select('classifieds.*','classified_category.text' );
		$result = $query -> get();
		
		$result =  $result[0];
		
		$classifieds_images =  DB::table('classifieds_images') -> where('cid', $result -> id ) -> get(); 
		
		if( $classifieds_images -> count() == 0 ) { $classifieds_images = array(); }
		
		$this -> data['page'] 		= 'classified/edit_place_ad';
		$this -> data['title'] 	 	= 'Expats\' School - Classified Page';
		$this -> data['page_on'] 	= 'classified';
		$this -> data['result'] 	= $result;
		$this -> data['classifieds_images'] 	= $classifieds_images;
        return view("template" ) -> with( $this -> data );
	 }
	 
	 public function get_cats( Request  $request )
	 {
	    
		
		if( isset( $_POST['child'] ))
		{
			$classifieds_images = DB::table	('classified_category' ) -> orderBy('text', 'ASC') -> where('parent_id', $_POST['id'] ) -> get(  );
			
			if( $classifieds_images -> count() == 0 )
			{
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  =  'success';
				$respone_to_app['data'] 	=  $classifieds_images;
				$respone_to_app['result'] 	=  '0';
			}
			else
			{
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  =  'success';
				$respone_to_app['data'] 	=  $classifieds_images;
				$respone_to_app['result'] 	=  '1';	
			}
			
			return response()->json( $respone_to_app );
		}
		else
		{
			$classifieds_images = DB::table	('classified_category' ) -> orderBy('text', 'ASC') -> where('parent_id', 0 ) -> get(  );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  =  'success';
			$respone_to_app['data'] 	=  $classifieds_images;
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
		}
		
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
	 
	 
	 
	 
	 
	 
	  public function schools_map()
	 {
		$this -> data['page'] = 'intereactive_map';
		$this -> data['title'] = 'Expats School -  Schools Map';
		$this -> data['page_on'] = 'schools';
        return view("template") -> with( $this -> data );
	 }
	 
	 public function load_schools_pins()
	 {
		 
		if( isset( $_POST['load_data'] ) )
		{
			
			DB::enableQueryLog();
			$result =  DB::table('school_profile')-> select('id','name','latitude','longitude','address','rating','followers','url','logo') -> orderBy( "popular",  'DESC') -> get();
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
			//echo $lcWhatYouWant = $laQuery[0]['query']; 
			DB::disableQueryLog();
			//exit;
			return response()->json( $respone_to_app );
		}
	 }
	  public function load_school_staff()
	 {
		 
		if( isset( $_POST['load_data'] ) )
		{
			$domain_email = trim($_POST['domain_email']);
			//DB::enableQueryLog();
			$school_name = trim($_POST['school_name']);
			
			if( $domain_email == '' )
			{
				$result = json_encode( (object) null );
					$respone_to_app['status'] 	= '200';
					$respone_to_app['message']  = 'success';
					$respone_to_app['data'] 	=  array();
					$respone_to_app['result'] 	=  '0';
				
			}
			else
			{
				$result =  DB::table('user')-> select('id','first_name', 'username','last_name','recent_school','recent_job','profile_photo_custom','profile_photo','about')
                    -> where( 'recent_school', 'LIKE',  '%' . $school_name .'%' )
                    -> where( 'school_email', 'LIKE',  DB::raw("'%$domain_email%'") )
                    -> where( [ ['close_account','=', '0'], ['verified_school','=', '1' ], ['verified','=', '1' ]  ] )
                    -> get();
				//$laQuery = DB::getQueryLog();
				//$lcWhatYouWant = $laQuery[0]['query']; 
				if( $result -> count() ==  0 )
				{
					$result = json_encode( (object) null );
					$respone_to_app['status'] 	= '200';
					$respone_to_app['message']  = 'success';
					$respone_to_app['data'] 	=  array();
					$respone_to_app['result'] 	=  '0';
				}
				else
				{
					
					$respone_to_app['status'] 	= '200';
					$respone_to_app['message']  = 'success';
					$respone_to_app['data'] 	=  $result	;
					$respone_to_app['result'] 	=  '1';
				}
			}
			//DB::disableQueryLog();
			return response()->json( $respone_to_app );
		}
	 }
	 
	 
	 
	 
	 public function enquiry_school()
	 {
		 
		if( isset( $_POST['enquiry'] ) )
		{
			
			$d['message'] 	 		 = $_POST['message'];
			$d['child_name'] 		 = $_POST['child_name'];
			$d['parent_name'] 		 = $_POST['name'];
			$d['parent_email'] 		 = $_POST['email'];
			$d['school_id']			 = $_POST['school_id'];
			
			
			
			$result =  DB::table('school_enquiry')-> insert( $d );
			$d['email_sent']		 = $_POST['email_sent'];
		   Mail::to( $d['email_sent'] )->send(new ExpatsMail($d));

			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Your message is sent successfully'	;
			$respone_to_app['result'] 	=  '1';
			
			return response()->json( $respone_to_app );
		}
	 }
	 
	 public function send_enquiry( $d )
    {
		
		Mail::send('email_template/enquiry', $d , function($message) use ($d)
		{
			$message->to( 'bilal@godesto.com' ) -> subject('Enquiry from Expats\' School' ); //->cc('bar@example.com');
			return true;
		});
		
		return true;
    }
	 
	 
	 
	 
	 public function send_user_invite( Request $request )
	 {
		if ( ! $request->session()->has('user') ) 
		{
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'session expire';
			$respone_to_app['result'] 	=  '2';
			return response()->json( $respone_to_app );
		} 
		
		$user = $request->session()->get('user');
		$uid = $user -> id;
		
		if( isset( $_POST['invite_friend'] ) )
		{
			
			$email 		=  explode(',', trim( $_POST['email'] , ','));
			$u_emaail   = $user -> email;
			if( $email[0] == $u_emaail )
			{
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'success';
				$respone_to_app['data'] 	=  'Your message is sent successfully.';
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
				
				$d['name'] = $user ->  first_name.' '. $user ->  last_name;
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
	 
	 public function send_user_recommendation( Request $request )
	 {
		if ( ! $request->session()->has('user') ) 
		{
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'session expire';
			$respone_to_app['result'] 	=  '2';
			return response()->json( $respone_to_app );
		} 
		
		$user = $request->session()->get('user');
		$uid = $user -> id;
		
		if( isset( $_POST['send_r'] ) )
		{
			
			$d['object_id']    =  $_POST['friend_id'] ;
			$d['uid']          =  $uid;
			$d['text']		   =  $_POST['recomm'];
			DB::table('user_recommendation') -> insert( $d );
			
			/*foreach( $email as $mail_ob)
			{
				$d['friend_email'] = $mail_ob;
				$d['uid']          = $uid;
				$d['code']		   =   substr(str_shuffle("0123456789"), 0, 5);
				$query =  DB::table('user_invitation') -> insert( $d );
				
				$d['name'] = $user ->  first_name.' '. $user ->  last_name;
				Mail::send('email_template/send_invite', $d  , function($message) use ($d)
				{
					$message->to( $d['friend_email'] ) -> subject( $d['name'] . ' sent you an invitation' ); //->cc('bar@example.com');
				});
			}
			*/
			
			
			
			
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Your message is sent successfully.';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
		}
		
		
		 
	 }
	public function privacy()
    {
		
		$this -> data['page']		 = 'static/privacy';
		$this -> data['title'] 		 = 'Expats School - privacy policy';
		$this -> data['page_on']	 = '';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	
	public function terms()
    {
		
		$this -> data['page']		 = 'static/terms';
		$this -> data['title'] 		 = 'Expats School - Terms and Conditions';
		$this -> data['page_on']	 = '';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	
	
	public function help()
    {
		
		$this -> data['page']		 = 'static/help';
		$this -> data['title'] 		 = 'Expats School - Help';
		$this -> data['page_on']	 = '';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	public function about()
    {
		
		$this -> data['page']		 = 'static/about';
		$this -> data['title'] 		 = 'Expats School - About';
		$this -> data['page_on']	 = '';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
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
