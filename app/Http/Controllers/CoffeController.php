<?php

namespace App\Http\Controllers;

use App\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

use Memcached;

class CoffeController extends Controller
{
    protected $data = array('no_header' => 0 );
	
	public function club(Request $request )
    {
		if (! $request->session()->has('user')) { return  redirect()->action('AuthController@login'); }
		$this -> data['page']		 = 'coffe_club/club';
		$this -> data['title'] 		 = 'Expats School - coffee club';
		$this -> data['page_on']	 = 'coffee-club';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	public function staff_room( Request $request )
    {
		
		if (! $request->session()->has('user')) 
		{
			return  redirect()->action('AuthController@login');
		}
		
		
		$this -> data['page']		 = 'coffe_club/staff_room';
		$this -> data['title'] 		 = 'Staff Room - Expats School';
		$this -> data['page_on']	 = 'staff-room';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	public function connections_suggestion ( Request $request )
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
		
		$schools = '';
		$list = json_decode(  $_POST['list'] );
		foreach( $list as $obj )
		{
			if( $obj -> type == 'school' )
			{
				$schools .= ','. $obj -> object_id; 
			}
		}
		$schools  = trim( $schools, ',' );
		$schools  = explode(',', $schools );
		
		$query =  DB::table('user_following') -> whereIn('user_following.object_id', $schools  ) -> where ('user_following.uid', '<>', $uid ); 
		$query	->	join('user', 'user.id','=','user_following.uid');
		$query  ->   select('user_following.*','user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username','recent_job' );
		$result = $query -> get();
		
		
		if( $result -> count() ==  0 )
		{
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=   array();
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
	
	
	
	
	
	
	public function forum_detail( $id, $url )
    {
		
		/*$query =  DB::table('post') ->  where( 'post.id', '=', $id );
		$query	->	join('user', 'user.id','=','post.uid');
		$query	->	join('school_profile', 'user.id','=','post.uid');
		$query  ->   select('post.*','user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username' );
		*/
		$result  = DB :: select("SELECT post.*,user.*, school_profile.*, post.description as body_copy FROM post 
		 LEFT JOIN `user` ON (user.id = post.uid AND post.uid <> '0' )   
		 LEFT JOIN school_profile  ON (school_profile.id = post.school_id AND post.uid  = '0' )  where post.id = $id  ");

	
		$this -> data['og_desc'] 	= substr( strip_tags( $result[0] -> description), 0, 100 );
		$this -> data['og_title']   = $result[0] -> title ;
		$this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expatsschoolslogo_square.jpg' ;

		$this -> data['og_url'] 	= url('forum/' .$result[0] -> id. '/'.  $result[0] -> url) ;
		
		
		
		
		$this -> data['page']		 = 'coffe_club/forum_detail';
		$this -> data['title'] 		 = 'Staff Room - Expats School';
		$this -> data['page_on']	 = 'coffee-club';
		$this -> data['no_header'] 	 = '0';
		$this -> data['result'] 	 = $result ;
        return view( "template" ) -> with( $this -> data ) ;
    }
	
	
	
	
	
	
	
	
	
    public function load_specialization()
	 {
		$faq =  DB::table('specialization')   ->select('title' ) -> get() ; 
		$result = json_encode( (object) null );
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  $faq;
		$respone_to_app['result'] 	=  '1';
		return response()->json( $respone_to_app );
	 }
	 public function top_faqs()
	 {
		$faq =  DB::table('faqs')   ->select('category', 'category_url' ) ->distinct() -> get() ; 
		$result = json_encode( (object) null );
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  $faq;
		$respone_to_app['result'] 	=  '1';
		return response()->json( $respone_to_app );
	 }
	 public function faqs_by_category(  )
	 {
		 
			$category = $_POST['category'];
			$faq =  DB::table('faqs') -> where ('category','=', $category  ) ->  get( );
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  $faq;
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
	 }
	 
	 
	 public function top_data(Request $request )
	 {
		/*$query =  DB::table('post');
		$query	->	join('user', 'user.id','=','post.uid') -> orderBy('post.id', 'DESC');			
		$post = $query  ->   select('post.*','user.profile_photo_custom', 'user.profile_photo', 'user.first_name', 'user.last_name', 'user.username' ) -> get();
		*/
		DB::enableQueryLog();
		
		if( isset( $_POST['load_data'] ) )
		{
			$city 	 = ''; $topic = '';   $event = '';
			$article = ''; $faq = ''; 
			if( isset ( $_POST['topic'] ) )
			{
				$topic 		= $_POST['topic'];
			}
			if( isset ( $_POST['events'] ) )
			{
				$event		= $_POST['events'];
			}
			if( isset ( $_POST['article'] ) )
			{
				$article	= $_POST['article'];
			}
			if( isset ( $_POST['faq'] ) )
			{
				$faq	   	= $_POST['faq'];
			}
			if( isset ( $_POST['city'] ) )
			{
				$city 		= $_POST['city'];
			}
			
			
			$user = $request->session()->get('user');
			$uid  = $user -> id;
		
			
			
			$page 		= $_POST['page'];
			$topic		= $_POST['topic'];
			//DB::enableQueryLog();
			$favourites = $_POST['favourites'];
			
			$query =  DB::table('post');
			
			/*if( $city != '' )
			{
				$query ->  whereRaw( "post.city LIKE '%$city%'" );
			}*/
			if( $article == '1' )
			{
				$query ->  where( 'post.post_type', 'article' );
			}
			if( $faq == '1' )
			{
				$query ->  where( 'post.post_type', 'question' );
			}
			if( $event == '1' )
			{
				$query ->  where( 'post.post_type', 'event' );
			}
			
			if( isset( $_POST['school_id'] ) )
			{
				$school_id	=	 $_POST['school_id'];
				if( $school_id !=  '' )
				{
					$query ->  where( 'post.school_id',  $school_id );
				}
			}
			
			if( $topic != '' )
			{
				$topic  =  addslashes( $topic);
				$query -> whereRaw( "post.title LIKE '%$topic%'" );
				$query -> orWhere( "post.description", 'LIKE', "%$topic%" );
				$query -> orWhere( "post.short_desc", 'LIKE', "%$topic%" );
				$query -> orWhere( "post.job_details", 'LIKE', "%$topic%" );
				
			}
			if ( $favourites ==  1 )
			{
				$favourites_result = DB::table('user_fav') ->  select( DB::raw( 'GROUP_CONCAT( item_id )' ) )->  where( 'uid', '=', $uid )  ->  where( 'type', '=', 'post' ) -> get();
				if( $favourites_result -> count() > 0 )
				{
					$prop		 = 'GROUP_CONCAT( item_id )';
					$ids		 = $favourites_result[0] -> $prop;
					$ids_arr	 = explode( ',', $ids );
					$query  ->  whereIn('post.id', $ids_arr);
				}
				
				
			}
			$query ->  where( [['post_type', '<>', 'classified'],['post_type', '<>', 'job'] ] );
			$query	->	join('user', 'user.id','=','post.uid') -> orderBy('post.id', 'DESC');		
			$query  ->   select('post.*', 'post.id' ,'user.profile_photo_custom', 'user.profile_photo', 'user.first_name', 'user.last_name', 'user.username','user.close_account' ) ;
			
			
			if( $page > 0 ) { $page = $page * 10  ; }
			$query -> offset( $page );
            $query -> limit( 10 );
			
			$post = $query -> get();
			
			$laQuery = DB::getQueryLog();
			$lcWhatYouWant = $laQuery[0]['query']; 
			DB::disableQueryLog();
			
			$result['post'] = $post;
			$respone_to_app['status'] 	= '200';
			$respone_to_app['query'] 	= $lcWhatYouWant ;
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  $result;
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
			
		}
		
		
		
	 }
	 
	 
	 
	public function question_detail( $id = '', $url = '' )
    {
		
		$query =  DB::table('faqs') -> where( 'id', $id ) -> get();
			
		
		$this -> data['page']		 = 'coffe_club/faq';
		$this -> data['faq']		 = $query[0];
		$this -> data['title'] 		 = 'expatsschools faq :'.  $query[0] -> question;
		$this -> data['page_on']	 = 'coffee-club';
		$this -> data['no_header'] 	 = '0';
		
        return view( "template" ) -> with( $this -> data ) ;
		
		
		
    }
	public function faqs( $id = '', $url = '' )
    {
		
		$query =  DB::table('faqs') -> get();
		$this -> data['page']		 = 'coffe_club/faqs_from_admin';
		$this -> data['faq']		 = $query;
		$this -> data['title'] 		 = 'expatsschools faqs ';
		$this -> data['page_on']	 = 'coffee-club';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	public function category_faq( $url = '' )
    {
		
		$query =  DB::table('faqs') -> where('category_url', $url ) -> get();
		$this -> data['page']		 = 'coffe_club/faqs_by_category';
		$this -> data['faq']		 = $query;
		$this -> data['title'] 		 = 'expatsschools faqs ';
		$this -> data['page_on']	 = 'coffee-club';
		$this -> data['no_header'] 	 = '0';
        return view( "template" ) -> with( $this -> data ) ;
    }
	
	
	
	 public function post_faq( Request $request)
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
		
		$user 		= $request -> session() -> get('user');
		$uid		= $user -> id ;
		 //faq_school:faq_school, save_faq:1,faq_question:faq_question, school_id:school_id,
		if( isset( $_POST['save_faq'] ) )
		{
			$school_id  = '0';
			$faq_school 		= $_POST['faq_school'];
			$faq_question 		= $_POST['faq_question'];
			$school_id_info = array();
			if( isset( $_POST['school_id'] ) )
			{
				$school_id	 	= $_POST['school_id'];
				$school_id_info = DB::table('school_profile')  -> where( 'id', $school_id ) -> select( 'id','url','name' ) -> get();
				//$school_id_info = json_encode( $school_id_info ) ;
			}
			$d['job_details'] 	 = json_encode( $school_id_info );
			$faq_title	 		= $_POST['faq_title'];
			
			
			$d['description'] 	     = $faq_question;
			$d['title'] 	 		 = $faq_title;
			$d['school_id'] 		 = $school_id;
			$d['uid'] 		   		 = $uid;
			//$d['city']	 	   		 = 'dubai';
			
			$page_url =  strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($d['title'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
			$d['url']	= trim($page_url, '-');
		
			$d['post_type'] 	 = 'question';
			$edit_post = 0;
			if( $_POST['post_id'] > 0 )
			{
				 $edit_post = 1;
				 DB::table('post') -> where ('id', $_POST['post_id'] ) -> update( $d );
				 $news_id = $_POST['post_id'] ;
			}
			else
			{
				$news_id =  DB::table('post') -> insertGetId( $d );
			}
			
			
			if( isset( $_POST['school_id'] ) )
			{
				$this	->	save_for_followers( $_POST['school_id'], $news_id,  'mention',  $edit_post  );
				$this	->	save_for_followers( $uid, $news_id,  'question',  $edit_post, 'school' );
			}
			else
			{
				$this	->	save_for_followers( $uid, $news_id,  'question',  $edit_post,  'school' );
			}
			
			
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Your question is posted successfully';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
			
		}
		
		if( isset( $_POST['save_event'] ) )
		{
			$event_title 		= $_POST['event_title'];
			$event_description 	= $_POST['event_description'];
			$event_date	 		= $_POST['event_date'];
			$event_time	 		= $_POST['event_time'];
			$event_address		= $_POST['event_address'];
			
			
			$school_id  = '0';
			$school_id_info = array();
			if( isset( $_POST['school_id'] ) )
			{
				$school_id	 		= $_POST['school_id'];
				$school_id_info = DB::table('school_profile')  -> where( 'id', $school_id ) -> select( 'id','url','name' ) -> get();
				
			}
			$d['job_details'] 	 = json_encode( $school_id_info );
			$d['title'] 	 	 = $event_title;
			$d['description'] 	 = $event_description;
			$d['dated'] 		 = $event_date;
			$d['timed'] 		 = date('H:i:s', strtotime($event_time) );
			$d['uid'] 		   	 = $uid;
			$d['school_id'] 		   	 = $school_id;
			$d['address']		= $event_address;
			
			$d['latitude']		= $_POST['latitude'];
			$d['longitude']		= $_POST['longitude'];
			
			
			
			
			$d['post_type'] 	 = 'event';
			$page_url =  strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($d['title'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
			//$area_url =  strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($d['city'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
			$d['url']	= trim($page_url, '-');
		
			 $edit_post = 0;
			if( $_POST['post_id'] > 0 )
			{
				 $edit_post = 1;
				 DB::table('post') -> where ('id', $_POST['post_id'] ) -> update( $d );
				 $news_id = $_POST['post_id'] ;
			}
			else
			{
				$news_id =  DB::table('post') -> insertGetId( $d );
			}
			
			
			if( isset( $_POST['school_id'] ) )
			{
				$this	->	save_for_followers( $_POST['school_id'], $news_id,  'mention',  $edit_post  );
				$this	->	save_for_followers( $uid, $news_id, 'event',  $edit_post, 'school' );
			}
			else
			{
				$this	->	save_for_followers( $uid, $news_id, 'event',  $edit_post, 'school' );	
			}
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Your event is posted successfully';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
			
		}
		
		
		
		if( isset( $_POST['save_article'] ) )
		{
			$article_title 		= $_POST['article_title'];
			$description 		= $_POST['description'];
			$short_desc 		= $_POST['short_desc'];
			$photo	 		    = trim( $_POST['ad_article_photos'], '##');
			
			
			$d['title'] 	 	 = $article_title;
			$d['description'] 	 = $description;
			$d['photo'] 		 = $photo;
			$d['short_desc']	 = $short_desc;
			$d['uid'] 		   	 = $uid;
			$d['post_type'] 	 = 'article';
			$school_id_info = array();
			if( isset( $_POST['article_school'] ) )
			{
				$d['school_id'] 	=  $_POST['article_school'];
				$school_id_info = DB::table('school_profile')  -> where( 'id', $d['school_id'] ) -> select( 'id','url','name' ) -> get();
				//$school_id_info = json_encode( $school_id_info ) ;
			}
			$d['job_details'] 	 = json_encode( $school_id_info );
			
			$page_url =  strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($d['title'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
			//$area_url =  strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($d['city'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
			$d['url']	= trim($page_url, '-');
			$edit_post = 0;
			if( $_POST['post_id'] > 0 )
			{
				 $edit_post = 1;
				 DB::table('post') -> where ('id', $_POST['post_id'] ) -> update( $d );
				 $news_id = $_POST['post_id'] ;
			}
			else
			{
				$news_id =  DB::table('post') -> insertGetId( $d );
			}
			
			
			if( isset( $_POST['article_school'] ) )
			{
				$this	->	save_for_followers( $_POST['article_school'], $news_id, 'mention', $edit_post );
				$this	->	save_for_followers( $uid, $news_id, 'article', $edit_post, 'school' );
			}
			else
			{
				$this	->	save_for_followers( $uid, $news_id, 'article', $edit_post, 'school' );	
			}
			
			
			
			
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Your article is posted successfully';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
		
		}
		
		
	 }
	 
	 
	 public function save_for_followers( $object_id, $news_id, $text, $edit, $user_text = 'user' )
	 {
		if(  $edit  ==  1 )
		{
			 DB::table('feed') -> where([  ['post_id', '=', $news_id ] ]) -> delete();	
		}
		$user_following = DB::table('user_following')	-> where( [['object_id','=', $object_id]] )  -> get( );
		foreach( $user_following as $eachfollower)
		{
			$uid	 = $eachfollower -> uid;
			
			
			$da_feed['uid']					= $uid;
			$da_feed['notification_status']	= '0';
			$da_feed['story_type']			= $text;
			$da_feed['object_type']			= $user_text;
			$da_feed['object_id']			= $object_id;
			$da_feed['post_id']				= $news_id;
			
		    $chk  = DB::table('feed')	-> where( [['uid','=', $uid], ['post_id','=', $news_id ]  ] )   -> get();
			if( $chk -> count() == 0 )
			{
				DB::table('feed') -> insert( $da_feed );
			}
		}
	 }
	 
	 public function filter_staff( Request $request )
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
			
			$spec		 		= '';
			$school 			= '';
			$city		 		= '';
			$search_text	   		= '';
			$teacher		   	= '';
			$tutor				= '';
			$parent			   	= '';
			if( isset( $_POST['spec'] ) )
			{
				$spec		 		= $_POST['spec'];	
			}
			if( isset( $_POST['school'] ) )
			{
				$school		 		= $_POST['school'];	
			}
			if( isset( $_POST['city'] ) )
			{
				$city		 		= $_POST['city'];	
			}
			if( isset( $_POST['search_text'] ) )
			{
				$search_text	= $_POST['search_text'];	
			}
			
			
			
			$teacher		   	= $_POST['teacher'];
			$tutor				= $_POST['tutor'];
			$parent			   	= $_POST['parent'];
			
			$page 				= $_POST['page'];
			
			DB::enableQueryLog();

			
			$query =  DB::table('user');
			$query ->  where( "user.id", '<>', $uid );
			$query ->  where( "user.verified", '=', '1' );
			
			/*if( $search_text != '' )
			{
				
				$query -> where( 'name', 'like', '%' . $search_text . '%' );
			}*/
			
			
			if( $spec != '' )
			{
				//$spec = explode( ',',  $spec  );
				foreach( $spec as $o )
				{
					$query ->  whereRaw( "spec LIKE '%$o%'" );
				}
			}
			
			
			
			
			if( $search_text != '' )
			{
				$query -> whereRaw( "name LIKE '%$search_text%'" );
			}
			
			if( $teacher == '1' )
			{
				$query -> where('type', 'teacher');
			}
			if( $parent == '1' )
			{
				$query -> where('type', 'parent');
				if( $_POST['school_id'] !=  '' )
				{
					$school_id = $_POST['school_id'];
					$query -> whereRaw("( school_one = $school_id OR  school_two = $school_id OR school_three = $school_id) "   );
				}
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
			
			//$query -> orderBy( "popular",  'DESC');
			
			
			
			if( $page > 0 ) { $page = $page * 10  ; }
			$query -> offset( $page );
            $query -> limit( 10 );
			
			$result = $query -> select('first_name','last_name','username','profile_photo','followers','type','city','recent_school','recent_job','tutor','profile_photo_custom','about','id','current_emp_status' )  -> get();
			
			$laQuery = DB::getQueryLog();
			$lcWhatYouWant = $laQuery[0]['query']; 
			if( $result -> count() ==  0 )
			{
				$result = json_encode( (object) null );
				$respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'success';
				$respone_to_app['data'] 	=  $result;
				$respone_to_app['result'] 	=  '0';
				$respone_to_app['lcWhatYouWant'] = $lcWhatYouWant;
			}
			else
			{
				
                $respone_to_app['status'] 	= '200';
				$respone_to_app['message']  = 'success';
				$respone_to_app['data'] 	=  $result	;
				$respone_to_app['result'] 	=  '1';
				$respone_to_app['lcWhatYouWant'] = $lcWhatYouWant;
			}
			
			$respone_to_app['search_txt'] = $search_text;
			DB::disableQueryLog();
			//exit;
			return response()->json( $respone_to_app );
		}
	 
		 
	 }
   
   
   
   /*
   if user follow school
   enter all feed for this user  for all post and mention for this user
   if user follow user
   enter all feed for this user  for all post
   */
   	
	
	
	 public function upload_article_photo()
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
				$targetPath = $schemin.'/articles/';
				
				$filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['file']['name'][$i] ) ) );
				$filename   = time().'_'.$filename;
				$targetFile = rtrim($targetPath,'/') . '/' . $filename;
				
				
				$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
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
	 
	 
	 
	 
	public function user_action_save ( Request $request )
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
		
		$d['uid']		=	 $uid;
		$d['object_id']	=	 $_POST['object_id'];
		$d['type']		=	 $_POST['action'];
		
		
		if( $d['type'] == 'like')
		{
			 DB::table('user_activity') -> insert( $d );
			 DB::table('post') ->where('id', $d['object_id']  ) -> increment( 'like_counter' );
		}
		if( $d['type'] == 'unlike')
		{
			 DB::table('user_activity') -> where( 'uid', $uid ) -> where('object_id', $d['object_id'] ) -> delete();
			 DB::table('post') ->where('id', $d['object_id']  ) -> decrement( 'like_counter' );
		}
		if( $d['type'] == 'comment')
		{
			 $d['text'] = $_POST['text'];
			 if( isset( $_POST['id'] )  && $_POST['id'] > 0 )
			 {
				  DB::table('user_activity') -> where('id', $_POST['id'] ) ->  update( $d );
			 }
			 else
			 {
			  	DB::table('user_activity') ->  insert( $d );
				DB::table('post') ->where('id', $d['object_id']  ) -> increment( 'comment_counter' );
			 }
		}
		
		$user_activity = DB::table('user_activity') 	-> select('object_id')  ->  where('uid', $uid ) -> where('type', 'like') -> get();
		
		
		if( $user_activity -> count() ==  0 )
		{
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=   array();
			$respone_to_app['result'] 	=  '0';
		}
		else
		{
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  $user_activity	;
			$respone_to_app['result'] 	=  '1';
		}
		
		return response()->json( $respone_to_app );
	}
	
	
	
	 
	public function post_comments ( Request $request )
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
		$object_id   = $_POST['object_id'];
		
		$query = DB::table('user_activity') -> orderBy('user_activity.dated', 'DESC' ) -> join('user', 'user.id','=','user_activity.uid');
		$user_activity = $query -> select('user_activity.text', 'user_activity.id as id'  ,'user_activity.dated','user_activity.id','user.id as uid', 'user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.recent_job', 'user.username') ->  where('user_activity.object_id', $object_id )  -> where('user_activity.type', 'comment') -> get();		
		if( $user_activity -> count() ==  0 )
		{
			$result = json_encode( (object) null );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=   array();
			$respone_to_app['result'] 	=  '0';
		}
		else
		{
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  $user_activity	;
			$respone_to_app['result'] 	=  '1';
		}
		return response()->json( $respone_to_app );
	}
	
	public function send_message ( Request $request )
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
		
		DB::enableQueryLog();
		
		$d['uid']	 				 = $uid;
		$d['message']				 = $_POST['message'];
		$d['rec_id']  				 = $_POST['rec_id'];
		
		$rec_id 					 = $d['rec_id'];
		$chat_room_arr['user_one']   = $uid;
		$chat_room_arr['user_two']   = $d['rec_id'];
		$chat_room_arr['updated_by'] = $uid;
		
		$now = DB::raw('NOW()');
		
		
		
		if ( isset( $_POST['message_type'] )) 
		{
			$message_type = $_POST['message_type'];
		}
		else
		{
			$message_type = 'user';
		}
		
		$chat_room_arr['updated_date'] = $now;
		$chat_room = DB::table('chat_room') -> whereRaw( "(user_one=$uid and user_two= $rec_id)  or (user_two=$uid and user_one= $rec_id) " ) -> get();
		if( $chat_room  -> count() == 0 )
		{
			$chat_room_arr['message_type'] = $message_type;
			DB::table('chat_room') -> insert (  $chat_room_arr  );	
		}
		else
		{
			$user_one						 = $chat_room[0] -> user_one;
			$user_two						 = $chat_room[0] -> user_two;
			$chat_room_arr['message_type'] 	 = $message_type;
			$chat_room_arr['updated_status'] = 0;
			
			DB::table('chat_room') -> where(	[[ 'user_one', '=',  $user_one],['user_two', '=', $user_two  ]]	)  -> update(  $chat_room_arr  );			
		}
		
		/*$laQuery = DB::getQueryLog();
		$lcWhatYouWant = $laQuery[0]['query']; 
		DB::disableQueryLog();
		*/
		$d['message_type']   =  $message_type;
		$data_id			 =  DB::table('messages') -> insertGetId( $d  );
		
		$dd['uid'] 			 =   $uid;
		$dd['activity_type'] =  'message';
		$dd['object_id'] 	 =  $d['rec_id'];
		$dd['object_type'] 	 =  'user';
		$dd['data_id']		 = $data_id;
		DB::table('notifications') -> insert( $dd  );
		
		$email_info['name']		 = $user -> first_name.' '.$user ->last_name;
		
		
		if( $d['message_type'] == 'school' ) 
		{
			
			$em = DB::table('school_profile') -> select('name', 'email') -> where( 'id', $_POST['rec_id'] ) -> get();
			
			$email_info['link']		 = 'https://www.expatsschools.com/secure_admin/admin' ;
			$email_info['receiver']  = $em[0] -> email;
			
		}
		else
		{
			$em = DB::table('user') -> select('name', 'email') -> where( 'id', $_POST['rec_id'] ) -> get();
			
			$email_info['link']		 = 'https://www.expatsschools.com/messages' ;
			$email_info['receiver']  = $em[0] -> email;
		}
		
		
		
		Mail::send('email_template/send_message', $email_info , function($message) use ( $email_info )
		{
			$message->to( $email_info['receiver'] ) -> subject('You have a new message' ); //->cc('bar@example.com');
			return true;
		});
		
		
		$respone_to_app['query'] 	= '';
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  'Your message is sent successfully'	;
		$respone_to_app['result'] 	=  '1';
		$respone_to_app['data_id'] 	=  $data_id;
		
		return response()->json( $respone_to_app );
	}
	
	
	
	public function get_chat_rooms ( Request $request )
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
		DB::enableQueryLog();
		
		/*$query =  DB::table('messages') -> where( 'messages.rec_id', '=', $uid ) ->  orWhere( 'messages.uid', '=', $uid ) -> orderBy('messages.dated','DESC') -> groupBy('messages.uid') ;
		
		$query	->	join('user', 'user.id','=','messages.uid');
		//query	->	join('user', 'user.id','=','messages.rec_id');
		$query  ->   select('messages.dated','messages.id','messages.uid','messages.rec_id', 'messages.message','user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username' ) ;
		$result = $query  -> get();*/
		
	
		//$result = DB::select('SELECT messages.*,user.id,user.first_name,user.last_name,user.profile_photo,user.profile_photo_custom,recent_job  FROM messages INNER JOIN user WHERE  messages.uid = user.id AND messages.rec_id = '. $uid .'  GROUP BY messages.uid   UNION  SELECT messages.*,user.id,user.first_name,user.last_name,user.profile_photo,user.profile_photo_custom,recent_job  FROM messages INNER JOIN user WHERE  messages.rec_id = user.id AND messages.uid = '. $uid .' GROUP BY messages.uid');
		
		if( $_POST['message_type']  == 'user' )
		{
			$query = DB::table('chat_room') -> whereRaw( "chat_room.user_one=$uid OR chat_room.user_two = $uid") ;
			$query	->	join('user', 'user.id','=','chat_room.user_one');
			$query	->	join('user as u', 'u.id','=','chat_room.user_two');
			$query -> where( "chat_room.message_type", '=', 'user' ) ;
			$query  ->   select(  'chat_room.id','chat_room.user_two', 'chat_room.updated_by', 'chat_room.user_one', 'chat_room.updated_date', 'user.id as uid',   'user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username',  'u.id as u_uid',   'u.first_name as u_first_name', 'u.last_name as u_last_name', 'u.profile_photo as u_profile_photo', 'u.profile_photo_custom as u_profile_photo_custom', 'u.username as u_username' ) ;
			$result = $query  -> get();
		}
		/*in case of school user_one will be always user and user_two will be school*/
		if( $_POST['message_type']  == 'school' )
		{
			$query = DB::table('chat_room') -> whereRaw( "chat_room.user_one=$uid") ;
			$query	->	join('user', 'user.id','=','chat_room.user_one');
			$query	->	join('school_profile as u', 'u.id','=','chat_room.user_two');
			$query -> where( "chat_room.message_type", '=', 'school' ) ;
			$query  ->   select(  'chat_room.id','chat_room.user_two', 'chat_room.updated_by', 'chat_room.user_one', 'chat_room.updated_date', 'user.id as uid',   'user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username',  'u.id as u_uid',   'u.name as u_name',  'u.logo as u_logo',  'u.url as u_url' ) ;
			$result = $query  -> get();
		}
		
		
		$laQuery = DB::getQueryLog();
		$lcWhatYouWant = $laQuery[0]['query']; 
		DB::disableQueryLog();
		
		$respone_to_app['query']  = $lcWhatYouWant;
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  $result;
		$respone_to_app['result'] 	=  '1';
		return response()->json( $respone_to_app );
	}
	
	public function get_user_inbox ( Request $request )
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
		$friend_id   = $_POST['friend_id'];
		DB::enableQueryLog();
		
		if( $_POST['message_type'] == 'user' )
		{
			$result =  DB::select('SELECT messages.*, messages.id as message_id,user.id,user.first_name,user.last_name,user.profile_photo,user.profile_photo_custom,user.recent_job,user.username  FROM messages INNER JOIN user WHERE messages.message_type = "user" AND  messages.uid = user.id AND messages.uid = '.  $uid .' and messages.rec_id = '. $friend_id .'  UNION SELECT messages.*, messages.id as message_id, user.id,user.first_name,user.last_name,user.profile_photo,user.profile_photo_custom,user.recent_job,user.username  FROM messages  INNER JOIN  user WHERE messages.uid = user.id   AND messages.message_type = "user" AND messages.rec_id = '. $uid .' and messages.uid = '. $friend_id.' order by dated ASC');
		}
		else
		{
			$result =  DB::select('SELECT messages.*, messages.id as message_id,user.id, CONCAT(user.first_name, " ", user.last_name ) as name,user.profile_photo,user.username  FROM messages INNER JOIN user WHERE messages.message_type = "school" AND  messages.uid = user.id AND messages.uid = '.  $uid .' and messages.rec_id = '. $friend_id .'    UNION SELECT messages.*, messages.id as message_id, school_profile.id,school_profile.name, school_profile.logo as profile_photo,school_profile.url as username FROM messages  INNER JOIN  school_profile WHERE messages.uid = school_profile.id   AND messages.message_type = "school"   AND messages.rec_id = '. $uid .' and messages.uid = '. $friend_id.'   order by dated ASC');
		}
		//DB::table('notifications') -> where ( [  ['object_id', '=',  $uid ],['get_status','=', '0'] ] )  -> update( array('get_status' =>  '1' ) );
		
		$laQuery = DB::getQueryLog();
		$lcWhatYouWant = $laQuery[0]['query']; 
		DB::disableQueryLog();
		
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['query']  = $lcWhatYouWant;
		$respone_to_app['data'] 	=  $result;
		$respone_to_app['result'] 	=  '1';
		return response()->json( $respone_to_app );
	}
	
	
	
		
	public function get_latest_msg ( Request $request )
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
		$friend_id 	 = $_POST['friend_id'];
		DB::enableQueryLog();
		
		$notifications = DB::table('notifications')-> select( DB::raw('group_concat(data_id) as data_id') ) -> where ( [  ['object_id', '=',  $uid ], ['uid', '=',  $friend_id ] ,['get_status','=', '0'] ] )  -> get(  );
		DB::table('notifications') -> where ( [  ['object_id', '=',  $uid ],['get_status','=', '0'] ] )  -> update( array('get_status' =>  '1' ) );
		
		$laQuery = DB::getQueryLog();
		$lcWhatYouWant = $laQuery[0]['query']; 
		DB::disableQueryLog();
		
		///p($notifications);exit;
		
		if( $_POST['message_type'] == 'user' )
		{
			
			$result =  DB::select('SELECT messages.*,messages.id as message_id,user.id,user.first_name,user.last_name,user.profile_photo,user.profile_photo_custom,user.recent_job,user.username  FROM messages INNER JOIN user WHERE  messages.uid = user.id AND messages.message_type = "user" AND  messages.uid = '.  $uid .' and messages.rec_id = '. $friend_id .'  UNION SELECT messages.*,messages.id as message_id, user.id,user.first_name,user.last_name,user.profile_photo,user.profile_photo_custom,user.recent_job,user.username  FROM messages  INNER JOIN  user WHERE messages.uid = user.id   AND messages.message_type = "user"     AND messages.rec_id = '. $uid .' and messages.uid = '. $friend_id.' order by dated DESC');
		}
		else
		{
			
			$result =  DB::select('SELECT messages.*, messages.id as message_id,user.id, CONCAT(user.first_name, " ", user.last_name ) as name,user.profile_photo,user.username  FROM messages INNER JOIN user WHERE messages.message_type = "school" AND  messages.uid = user.id AND messages.uid = '.  $uid .' and messages.rec_id = '. $friend_id .'    UNION SELECT messages.*, messages.id as message_id, school_profile.id,school_profile.name, school_profile.logo as profile_photo,school_profile.url as username FROM messages  INNER JOIN  school_profile WHERE messages.uid = school_profile.id   AND messages.message_type = "school"   AND messages.rec_id = '. $uid .' and messages.uid = '. $friend_id.'   order by dated ASC');
		}
		//exit;
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['query']  = $lcWhatYouWant;
		$respone_to_app['data'] 	=  $result;
		$respone_to_app['result'] 	=  '1';
		return response()->json( $respone_to_app );

		
		return response()->json( $respone_to_app );
	}

	
	
	public function notifications ( Request $request )
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
		
		
		$query = DB::table('chat_room') -> whereRaw( "(chat_room.user_one=$uid OR chat_room.user_two = $uid)   AND  chat_room.updated_status = 0 and updated_by <>  $uid  ") ;
		$query	->	join('user', 'user.id','=','chat_room.user_one');
		$query	->	join('user as u', 'u.id','=','chat_room.user_two');
		$query  ->   select(  'chat_room.id','chat_room.user_two', 'chat_room.updated_by', 'chat_room.user_one', 'chat_room.updated_status', 'chat_room.updated_date', 'user.id as uid',   'user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username',  'u.id as u_uid',   'u.first_name as u_first_name', 'u.last_name as u_last_name', 'u.profile_photo as u_profile_photo', 'u.profile_photo_custom as u_profile_photo_custom', 'u.username as u_username' ) ;

		$result = $query  -> get();
		DB::enableQueryLog();
		$affected  = DB::table('chat_room') -> whereRaw( "(chat_room.user_one=$uid OR chat_room.user_two = $uid) and updated_by <>  $uid ") -> update( array('chat_room.updated_status' => 1) ) ;
	
		$laQuery = DB::getQueryLog();
		$lcWhatYouWant = $laQuery[0]['query']; 
		DB::disableQueryLog();
		$respone_to_app['status'] 	= '200';
		$respone_to_app['message']  = 'success';
		$respone_to_app['data'] 	=  $result ;
		$respone_to_app['result'] 	=  '1';
		$respone_to_app['query'] 	=  $lcWhatYouWant;
		
		return response()->json( $respone_to_app );
	}
	
	
	public function post_likes(  Request $request )
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
			
			$object_id = $_POST['object_id'];
			
			$query	=	DB::table('user_activity') -> where( [['user_activity.object_id', '=', $object_id], ['user_activity.type', '=',  'like'] ] );
			$query	->	join('user', 'user.id','=','user_activity.uid') -> orderBy('user_activity.id', 'DESC');		
			$result =   $query  ->   select('user_activity.*', 'user_activity.id' ,'user.profile_photo_custom', 'user.profile_photo', 'user.first_name', 'user.last_name', 'user.username', 'user.recent_job' ) -> get() ;
		
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  $result ;
			$respone_to_app['result'] 	=  '1';
			$respone_to_app['query'] 	=  '';
			
			return response()->json( $respone_to_app );
	}
	
	
	public function delete_user_post(  Request $request )
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
		if( isset( $_POST['load_data'] ) )
		{
			$user		 = $request->session()->get('user');
			$uid 	 	 = $user -> id;
			$post_id	 = $_POST['id'];
			DB::table('post') -> where ('id', $post_id ) -> delete();
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Deleted successfully';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
			
		}
	}
	
	
	public function close_account(  Request $request )
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
		if( isset( $_POST['load_data'] ) )
		{
			$user		 = $request->session()->get('user');
			$uid 	 	 = $user -> id;
			$d['verified'] = 0;
			$d['profile_photo'] = 'user-img.png';
			$d['close_account'] = 1;
			DB::table('user') -> where ('id', $uid ) -> update( $d );
			//DB::table('post') ->where('uid', $uid  ) -> delete();
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Deleted successfully';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
			
		}
	}
	public function delete_user_comment(  Request $request )
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
		if( isset( $_POST['load_data'] ) )
		{
			$user		 = $request->session()->get('user');
			$uid 	 	 = $user -> id;
			$post_id	 = $_POST['id'];
			$object_id	 = $_POST['object_id'];
			
			DB::table('user_activity') -> where ('id', $post_id ) -> delete();
			DB::table('post') ->where('id', $object_id  ) -> decrement( 'comment_counter' );
			$respone_to_app['status'] 	= '200';
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  'Deleted successfully';
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
			
		}
	}
	public function top_newsfeed_data( Request $request )
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
		
		DB::enableQueryLog();
		if( isset( $_POST['load_data'] ) )
		{
			
			
			
			$user		 = $request->session()->get('user');
			$uid 	 	 = $user -> id;
		
		
			$page 		= $_POST['page'];
			if( $page > 0 ) { $page = $page * 10  ; }
			

			/*$result =  DB::select("SELECT feed.id as f_id, feed.uid as f_uid, feed.object_id as f_object_id,feed.story_type as f_story_type,
feed.notification_status as f_notification_status, feed.object_type as f_object_type, feed.post_id as f_post_id , user.id as u_id, user.profile_photo_custom as u_profile_photo_custom, user.first_name as u_first_name,user.last_name as u_last_name,user.username as u_username, user.profile_photo as u_profile_photo,
school_profile.id as sid, school_profile.url as surl, school_profile.logo as slogo, school_profile.followers, school_profile.name as sname,
post.id as pid, post.url as purl, post.job_details as job, post.comment_counter as pcomment_counter, post.like_counter as plike_counter, post.description as post_desc,post.short_desc as pshort_desc, post.dated as pdated, post.title as ptitle, post.post_type as ptype
FROM feed  
LEFT JOIN `user` ON (user.id = feed.uid AND feed.object_type = 'user' ) 
LEFT JOIN school_profile  ON (school_profile.id = feed.object_id AND feed.object_type  = 'school')
LEFT JOIN post  ON (post.id = feed.post_id)  where feed.uid = $uid order by pdated DESC  limit $page,10 ");
*/
			
			$result =  DB::select("SELECT feed.id as f_id, feed.uid as f_uid, feed.object_id as f_object_id,feed.story_type as f_story_type,
feed.notification_status as f_notification_status, feed.object_type as f_object_type, feed.post_id as f_post_id ,  coalesce(user.id,x.id) as u_id, coalesce(user.close_account,x.close_account) as u_ca, coalesce(user.profile_photo_custom,x.profile_photo_custom) as u_profile_photo_custom, coalesce(user.first_name,x.first_name) as u_first_name,coalesce(user.last_name,x.last_name) as u_last_name,coalesce(user.username,x.username) as u_username, coalesce(user.profile_photo,x.profile_photo) as u_profile_photo,
school_profile.id as sid, school_profile.url as surl, school_profile.logo as slogo, school_profile.followers, school_profile.name as sname,
post.id as pid, post.url as purl, post.school_id as pschoolid, post.job_details as job, post.comment_counter as pcomment_counter, post.like_counter as plike_counter, post.description as post_desc,post.short_desc as pshort_desc, post.dated as pdated, post.title as ptitle, post.post_type as ptype, post.uid as puid
FROM feed
LEFT JOIN `user` ON (user.id = feed.uid AND feed.object_type='user')
LEFT JOIN `user` x ON (x.id = feed.object_id AND feed.object_type='school')
LEFT JOIN school_profile ON (school_profile.id = feed.object_id AND feed.object_type = 'school')
LEFT JOIN post ON (post.id = feed.post_id) where feed.uid = $uid  and feed.object_id <> $uid order by pdated DESC limit $page,10");
		
		/*LEFT JOIN `user` ON (user.id = feed.uid AND feed.object_type='user') 
		LEFT JOIN `user` x ON (x.id = feed.object_id AND feed.object_type='school')

		*/
			$laQuery = DB::getQueryLog();
			$lcWhatYouWant = $laQuery[0]['query']; 
			DB::disableQueryLog();
			
			
			$respone_to_app['status'] 	= '200';
			$respone_to_app['query'] 	= $laQuery;
			$respone_to_app['message']  = 'success';
			$respone_to_app['data'] 	=  $result;
			$respone_to_app['result'] 	=  '1';
			return response()->json( $respone_to_app );
			
		}
	}
	
	
	public function clear_c( Request $request )
	{
		
		$this -> data['page']		 = 'coffe_club/clear_c';
		$this -> data['title'] 		 = 'Staff Room - Expats School';
		$this -> data['page_on']	 = 'coffee-club';
		$this -> data['no_header'] 	 = '0';
		$this -> data['result'] 	 = '' ;
        return view( "template" ) -> with( $this -> data ) ;
	}
	
	
}
