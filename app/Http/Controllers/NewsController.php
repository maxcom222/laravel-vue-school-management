<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\LikeEvent;

use App\Events\CommentEvent;

use App\Events\CoffeepostEvent;

use Illuminate\Support\Facades\DB;

use App\Mail;

use AWS;


class NewsController extends Controller
{
    protected $data = array('no_header' => 0 );

    public function index(Request $request )
    {
        if (  ! $request->session()->has('user') )
        {

            return  redirect()->action('AuthController@login');

        }

        $this -> data['page']		 = 'news/index';

        $this -> data['title'] 		 = 'News and views - Expats School';

        $this -> data['page_on']	 = 'coffee-club';

        $this -> data['no_header'] 	 = '0';

        return view( "template" ) -> with( $this -> data ) ;
    }



    public function post_detail( $username, $post_url, Request $request )
    {
        if (  ! $request->session()->has('user') )
        {

            return  redirect()->action('AuthController@login');

        }

       // echo $username;
       // echo $post_url;

       // exit;


        $result  = DB :: select("SELECT post.id  as post_id, post.*,user.*, school_profile.*, post.description as body_copy FROM post 
		
		 LEFT JOIN `user` ON (user.id = post.uid AND post.uid <> '0' )   
		
		 LEFT JOIN school_profile  ON (school_profile.id = post.school_id AND post.uid  = '0' )  where post.url = '$post_url' ");


        $this -> data['og_desc'] 	= substr( strip_tags( $result[0] -> description), 0, 100 );

        $this -> data['og_title']   = $result[0] -> title ;

        $this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expatsschoolslogo_square.jpg' ;

        $this -> data['og_url'] 	= url('posts/' .$result[0] -> username. '/'.  $result[0] -> url) ;


        $this -> data['result']		 = $result;

        $this -> data['page']		 = 'news/post_detail';

        $this -> data['title'] 		 = 'News and views - Expats School';

        $this -> data['page_on']	 = 'coffee-club';

        $this -> data['no_header'] 	 = '0';




        return view( "template" ) -> with( $this -> data ) ;
    }


    public function post_detail_load(  Request $request )
    {
        if (  ! $request->session()->has('user') )
        {

            return  redirect()->action('AuthController@login');

        }

        $username = $request  -> get('username');

        $post_url = $request  -> get('url');


        $result  = DB :: select("SELECT post.id  as post_id, post.*,user.*, school_profile.*, post.description as body_copy FROM post 
		
		 LEFT JOIN `user` ON (user.id = post.uid AND post.uid <> '0' )   
		
		 LEFT JOIN school_profile  ON (school_profile.id = post.school_id AND post.uid  = '0' )  where post.url = '$post_url' ");




        $response_to_app['status'] 	= '200';

        $response_to_app['message']  = 'success';

        $response_to_app['data'] 	=  $result[0];

        $response_to_app['result'] 	=  '1';

        return response()->json( $response_to_app );
      }




    public function get_post( Request $request )
    {
        /*$query =  DB::table('post');
        $query	->	join('user', 'user.id','=','post.uid') -> orderBy('post.id', 'DESC');
        $post = $query  ->   select('post.*','user.profile_photo_custom', 'user.profile_photo', 'user.first_name', 'user.last_name', 'user.username' ) -> get();
        */
        DB::enableQueryLog();

        if( $request -> has('load_data') )
        {
            $city 	 = ''; $topic = '';   $event = '';

            $article = ''; $faq = '';

            if(  $request -> has('topic') )
            {

                $topic 		= $request -> get('topic');

            }
            if( $request -> get('event') !=   ''   )
            {

                $event		= $request -> get('event');

            }
            if( $request -> get('article')  !=   ''  )
            {

                $article	= $request -> get('article');

            }
            if( $request -> get('faq')  !=   ''  )
            {

                $faq	   	= $request -> get('faq');

            }
            if( $request -> get('city')  !=   ''  )
            {

                $city 		= $request -> get('city');

            }




            $user = $request->session()->get('user');

            $uid  = $user -> id;

            $page 		= $request -> get('page');

            //DB::enableQueryLog();

            $favourites = $request -> get('favourites');

            $sort = $request -> get('sort');

            $query =  DB::table('post');

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

            if( $request -> get('school_id') != '' )
            {
                $school_id	=	 $request -> get('school_id');

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

            $query	->	join('user', 'user.id','=','post.uid');

            if( $sort   ==  'new')
            {
                $query -> orderBy('post.id', 'DESC');

            }
            if( $sort   ==  'old')
            {
                $query -> orderBy('post.id', 'ASC');
            }
            if( $sort   ==  'etc')
            {
                $query -> where('user.verified_school', 1);
            }




            $query  ->   select('post.*',  'post.id' ,'user.profile_photo_custom', 'user.profile_photo', 'user.first_name', 'user.last_name', 'user.username','user.close_account' ) ;


            if( $page > 0 ) { $page = $page * 10  ; }

            $query -> offset( $page );

            $query -> limit( 10 );

            $post = $query -> get();

            $laQuery = DB::getQueryLog();

            $lcWhatYouWant = $laQuery[0]['query'];

            DB::disableQueryLog();

            $result['post'] = $post;

            $response_to_app['status'] 	= '200';

            $response_to_app['query'] 	= $lcWhatYouWant ;

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $result;

            $response_to_app['result'] 	=  '1';

            return response()->json( $response_to_app );

        }



    }

    public  function upload_image()
    {


        if( isset( $_FILES ) )
        {
            $uploads = '';

            $response = [];

            $tempFile 	= $_FILES['file']['tmp_name'];

            $targetPath = getcwd().'/public/classifieds/';

            $filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['file']['name'] ) ) );

            $filename   = 'expats_'.time().'__news'. $filename;   //time().'_'.$filename;

            $targetFile = rtrim($targetPath,'/') . '/' . $filename;

            $fileTypes 	= array('jpg','jpeg','gif','png', 'JPG');

            $fileParts = pathinfo($_FILES['file']['name']);

            if (in_array($fileParts['extension'], $fileTypes))
            {

                move_uploaded_file($tempFile, $targetFile);

                $uploads = $filename;

                $save_name   = 'expats_'.time().'__news-views.jpg';


                $params['SourceFile'] =  $targetPath.  $filename;

                $params['Key'] = 'godesto-golf';

                $s3 = AWS::createClient('s3');

                $file_key  = 'network/'.$filename;

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

    public function publish( Request $request )
    {


        if ( ! $request->session()->has('user') )
        {

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'expire';

            $response_to_app['data'] 	=  '';

            $response_to_app['result'] 	=  '2';

            return response()->json( $response_to_app );
        }

        $user 		= $request -> session() -> get('user');

        $uid		= $user -> id ;

        $userResource = $this -> UserResource( $user );




        if( $request  -> get('save_article') !=  ''  )
        {
            $d['title'] 			= $request  -> get('headline');

            $d['description'] 		= $request  -> get('description');

            $d['short_desc'] 		= $request  -> get('short_desc');

            $d['photo']	 		    = $request  -> get('image');

            $d['uid'] 		   	    = $uid;

            $d['post_type'] 	    = 'article';

            $school_id_info = array();

            if( $request  -> get('school') !=   '' )
            {



                $school_id_info = DB::table('school_profile')

                    -> where( 'name',	$request  -> get('school') )

                    -> select( 'id','url','name' ) -> get();

                $d['school_id'] 	=  $school_id_info[0] -> id;

            }

            $d['job_details'] 	 = json_encode( $school_id_info );

            $page_url =  strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($d['title'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));

            $d['url']	= trim($page_url, '-').'__'. time() .'__'. $user -> id;

            $edit_post = 0;

            if( $request  -> get('post_id') != 0 )
            {
                $edit_post = 1;

                DB::table('post') -> where ('id', $request  -> get('post_id') ) -> update( $d );

                $news_id = $request  -> get('post_id') ;
            }
            else
            {

                $news_id =  DB::table('post') -> insertGetId( $d );

            }


            if(  $request  -> get('school') !=  ''  )
            {

                $this	->	save_for_followers( $request  -> get('school'), $news_id, 'mention', $edit_post );

                $this	->	save_for_followers( $uid, $news_id, 'article', $edit_post, 'school' );
            }
            else
            {

                $this	->	save_for_followers( $uid, $news_id, 'article', $edit_post, 'school' );
            }

            $d['id']    = $news_id;

            broadcast( new CoffeepostEvent( $userResource, $d , 'article' )  );


            $result = json_encode( (object) null );

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  'Your article is posted successfully';

            $response_to_app['result'] 	=  '1';

            return response()->json( $response_to_app );

        }

     }

    public function publish_question( Request $request )
     {

         if ( ! $request->session()->has('user') )
         {

             $response_to_app['status'] 	= '200';

             $response_to_app['message']  = 'expire';

             $response_to_app['data'] 	=  '';

             $response_to_app['result'] 	=  '2';

             return response()->json( $response_to_app );
         }

         $user 		= $request -> session() -> get('user');

         $uid		= $user -> id ;

         $userResource = $this -> UserResource( $user );

         if(  $request -> get ('save_article') !== '' )
		 {

            $school_id_info = array();

             $d['school_id'] 	=  0;

            if( $request  -> get('school') !=   '' )
            {

                $school_id_info = DB::table('school_profile')

                    -> where( 'name',	$request  -> get('school') )

                    -> select( 'id','url','name' ) -> get();

                $d['school_id'] 	=  $school_id_info[0] -> id;

            }

            $d['job_details'] 		 = json_encode( $school_id_info );

            $d['description'] 	     = $request -> get ('description');

            $d['title'] 	 		 = $request -> get('question');

            $d['uid'] 		   		 = $uid;

            $page_url =  strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($d['title'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));



            $d['url']	= trim($page_url, '-').'__'. time() .'__'. $user -> id;



            $d['post_type'] 	 = 'question';

            $edit_post = 0;

            if( $request  -> get('post_id') != 0 )
            {
                $edit_post = 1;

                DB::table('post') -> where ('id', $request  -> get ('post_id') ) -> update( $d );

                $news_id = $request -> get ('post_id') ;
            }
            else
            {
                $news_id =  DB::table('post') -> insertGetId( $d );
            }


            if(  $request   -> get ('school') != '' )
            {
                $this	->	save_for_followers( $request -> get ('school_id'), $news_id,  'mention',  $edit_post  );

                $this	->	save_for_followers( $uid, $news_id,  'question',  $edit_post, 'school' );
            }
            else
            {

                $this	->	save_for_followers( $uid, $news_id,  'question',  $edit_post,  'school' );
            }


             $d['id']    = $news_id;

             broadcast( new CoffeepostEvent( $userResource, $d , 'question' )  );


            $result = json_encode( (object) null );

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  'Your question is posted successfully';

            $response_to_app['result'] 	=  '1';

            return response()->json( $response_to_app );

        }
     }

    public function publish_event( Request $request )
    {


        if ( ! $request->session()->has('user') )
        {

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'expire';

            $response_to_app['data'] 	=  '';

            $response_to_app['result'] 	=  '2';

            return response()->json( $response_to_app );
        }

        $user 		= $request -> session() -> get('user');

        $uid		= $user -> id ;

        $userResource = $this -> UserResource( $user );

        if( $request  -> get('save_article') !=  ''  )
        {
            $d['title'] 			= $request  -> get('headline');

            $d['description'] 		= $request  -> get('description');

            $d['address'] 		    = $request  -> get('location');

            $d['event_date']	 	= $request  -> get('dated');

            $d['timed']	 		    = $request  -> get('time_req');

            $d['latitude']	 		= $request  -> get('latitude');

            $d['longitude']	 	    = $request  -> get('longitude');

            $d['uid'] 		   	    = $uid;

            $d['post_type'] 	    = 'event';

            $school_id_info = array();

            if( $request  -> get('school') !=   '' )
            {



                $school_id_info = DB::table('school_profile')

                    -> where( 'name',	$request  -> get('school') )

                    -> select( 'id','url','name' ) -> get();

                $d['school_id'] 	=  $school_id_info[0] -> id;

            }

            $d['job_details'] 	 = json_encode( $school_id_info );

            $page_url =  strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($d['title'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));

            $d['url']	= trim($page_url, '-').'__'. time() .'__'. $user -> id;

            $edit_post = 0;

            if( $request  -> get('post_id') != 0 )
            {
                $edit_post = 1;

                DB::table('post') -> where ('id', $request  -> get('post_id') ) -> update( $d );

                $news_id = $request  -> get('post_id') ;
            }
            else
            {

                $news_id =  DB::table('post') -> insertGetId( $d );

            }


            if(  $request  -> get('school') !=  ''  )
            {

                $this	->	save_for_followers( $request  -> get('school'), $news_id, 'mention', $edit_post );

                $this	->	save_for_followers( $uid, $news_id, 'article', $edit_post, 'school' );
            }
            else
            {

                $this	->	save_for_followers( $uid, $news_id, 'article', $edit_post, 'school' );
            }


            $d['id']    = $news_id;

            broadcast( new CoffeepostEvent( $userResource, $d , 'article' )  );

            $result = json_encode( (object) null );

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  'Your article is posted successfully';

            $response_to_app['result'] 	=  '1';

            return response()->json( $response_to_app );

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

    public function user_action_save ( Request $request )
    {

        if (!$request->session()->has('user'))
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

        $userResource = [];

        $userResource['first_name'] = $user ->  first_name;

        $userResource['last_name'] = $user ->  last_name;

        $userResource['profile_photo'] = $user ->  profile_photo;

        $userResource['id'] =    $user ->  id;



        $d['uid']		=	 $uid;

        $d['object_id']	=	 $request -> get('object_id');

        $d['type']		=	 $request -> get('action');


        if( $d['type'] == 'list_comment')
        {



            $query = DB::table('user_activity')

                -> where( [ [ 'user_activity.object_id', $request -> get('object_id')], ['user_activity.type', '=', 'comment']  ] )

                -> orderBy('user_activity.dated', 'DESC' ) -> join('user', 'user.id','=','user_activity.uid');

            $user_activity = $query -> select('user_activity.text', 'user_activity.id as id'  ,'user_activity.dated','user_activity.id','user.id as uid', 'user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.recent_job', 'user.username') -> get();



            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $user_activity	;

            $response_to_app['result'] 	=  '1';

            return response()->json( $response_to_app );

        }

        if( $d['type'] == 'like')
        {

            DB::table('user_activity') -> insert( $d );

            DB::table('post') ->where('id', $d['object_id']  ) -> increment( 'like_counter' );

            broadcast( new LikeEvent(    $d['object_id'], $d['type'] ) );


        }

        if( $d['type'] == 'unlike')
        {

            DB::table('user_activity') -> where( 'uid', $uid ) -> where('object_id', $d['object_id'] ) -> delete();

            DB::table('post') ->where('id', $d['object_id']  ) -> decrement( 'like_counter' );

            broadcast( new LikeEvent( $d['object_id'], $d['type'] ) );

        }

        if( $d['type'] == 'comment')
        {



            $d['text'] = $request -> get('comment');

            if(  $request -> get('comment_id') != 0  && $request -> has('editAction')  )
            {

                DB::table('user_activity') -> where('id', $request -> get('comment_id') ) ->  update( $d );

                $d['id']    = $request -> get('comment_id');

                $response_to_app['id']    = $request -> get('comment_id');

                broadcast( new CommentEvent(  $d['object_id'], 'edit_comment', $userResource, $d  ) );

            }
            else if(  $request -> get('comment_id') != 0 && $request -> has('delAction')  )
            {

                DB::table('user_activity') -> where('id', $request -> get('comment_id') ) ->  delete( );

                DB::table('post') ->where('id', $d['object_id']  ) -> decrement( 'comment_counter' );

                $d['id']    = $request -> get('comment_id');

                broadcast( new CommentEvent(  $d['object_id'], 'del_comment', $userResource, $d   ) );

                $response_to_app['id']    = $request -> get('comment_id');


            }
            else
            {

                $id = DB::table('user_activity') -> insertGetId( $d );

                DB::table('post') ->where('id', $d['object_id']  ) -> increment( 'comment_counter' );

                $d['id']    = $id;

                broadcast( new CommentEvent(  $d['object_id'], 'add_comment', $userResource, $d  ) );

                $response_to_app['id'] = $id;

            }


        }

        $user_activity = DB::table('user_activity') 	-> select('object_id')  ->  where('uid', $uid ) -> where('type', 'like') -> get();


        if( $user_activity -> count() ==  0 )
        {
            $result = json_encode( (object) null );

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=   array();

            $response_to_app['result'] 	=  '0';
        }
        else
        {

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $user_activity	;

            $response_to_app['result'] 	=  '1';
        }


        return response()->json( $response_to_app );
    }

    public function user_fav ( Request $request )
    {

        if (!$request->session()->has('user'))
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

        $userResource = [];

        $userResource['first_name'] = $user ->  first_name;

        $userResource['last_name'] = $user ->  last_name;

        $userResource['profile_photo'] = $user ->  profile_photo;

        $userResource['id'] =    $user ->  id;


        $d['uid']		=	 $uid;

        $d['item_id']	=	 $request -> get('object_id');

        $action		=	 $request -> get('action');

        $d['type']		=	 $request -> get('type');


        if( $action == 'fav')
        {

            DB::table('user_fav') -> insert( $d );

           // broadcast( new LikeEvent(    $d['object_id'], $d['type'] ) );

        }

        if( $action == 'unfav')
        {

            DB::table('user_fav') -> where( 'uid', $uid ) -> where('item_id', $d['item_id'] ) -> delete();

            //broadcast( new LikeEvent( $d['object_id'], $d['type'] ) );

        }

        $user_fav = DB::table('user_fav') 	-> select('item_id', 'type')  ->  where('uid', $uid )  -> get();

        if( $user_fav -> count() ==  0 )
        {
            $result = json_encode( (object) null );

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=   array();

            $response_to_app['result'] 	=  '0';
        }
        else
        {

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $user_fav	;

            $response_to_app['result'] 	=  '1';
        }


        return response()->json( $response_to_app );
    }


    private function UserResource( $user )
    {

        $userResource = [];

        $userResource['first_name'] = $user ->  first_name;

        $userResource['last_name'] = $user ->  last_name;

        $userResource['profile_photo'] = $user ->  profile_photo;

        $userResource['id'] =    $user ->  id;

        return  $userResource;

    }



}
