<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SchoolsController extends Controller
{

    protected $data = array('no_header' => 0 );

    public function list_school()
    {
        $this -> data['page']    = 'schools/list_school';

        $this -> data['title']   = 'Expats School - Listing Page';

        $this -> data['page_on'] = 'school';


        $school_profile = School::count();

        $this -> data['school_count'] = $school_profile;

        return view("template" ) -> with( $this -> data );
    }

    public function school_type_ahead(Request $request )
    {
        $query = $request -> get('query');

        $school_profile =  DB::table('school_profile') -> where('name', 'LIKE',  $query .'%') -> select('name as code', 'name as label')-> get() ;

        //return $school_profile;
        return response()->json( $school_profile );
    }

    public function school_type_ahead_original()
    {
        $school_profile =  DB::table('school_profile') -> select('name')-> get() ;

        $response_to_app['status'] 	= '200';
        $response_to_app['message']  = 'success';
        $response_to_app['data'] 	=  $school_profile	;
        $response_to_app['result'] 	=  '1';

        return response()->json( $response_to_app );
    }

    public function get_schools(Request $request )
    {

        ini_set('memory_limit', '-1');

        DB::enableQueryLog();

        $query =  DB::table('school_profile');



        $school_type  = 0;

        $ages_taught  = 0;

        $curriculums  = 0;

        if($request->has('param'))
        {
            $request_param =  $request -> get('param')  ;

            foreach( $request_param as  $obj  )
            {
                if( $obj['type'] == 'school_type' )
                {
                    foreach ( $obj['data'] as $filter_item )
                    {
                        if( $filter_item['status'] == 1 )
                        {
                            $element = $filter_item['key'];

                            if( $school_type == 0)
                            {
                                if(  $element  ==  'Nursery' )
                                {
                                    $query ->  where( 'nursery','=', '1' );
                                }
                                else
                                {
                                    $query->where('school_type', 'like', '%'.$element.'%');
                                }

                                $school_type = 1;
                            }
                            else
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
                        }
                    }

                }


                if( $obj['type'] == 'ages_taught' )
                {
                    foreach ( $obj['data'] as $filter_item )
                    {
                        if( $filter_item['status'] == 1 )
                        {
                            $element = $filter_item['key'];

                            if( $ages_taught == 0)
                            {
                                $query->where('ages_taught', 'like', '%'.$element.'%');

                                $school_type = 1;
                            }
                            else
                            {
                                $query->orWhere('ages_taught', 'like', '%'.$element.'%');
                            }
                        }
                    }

                }

                if( $obj['type'] == 'boarding' )
                {
                    foreach ($obj['data'] as $filter_item)
                    {
                        if ($filter_item['status'] == 1)
                        {
                            $query ->  whereRaw( "day_boarding LIKE '%$o%'" );
                        }
                    }
                }

                if( $obj['type'] == 'curriculums' )
                {
                    foreach ( $obj['data'] as $filter_item )
                    {
                        if( $filter_item['status'] == 1 )
                        {
                            $element = $filter_item['key'];

                            if( $curriculums == 0)
                            {

                                $query->where('curriculums', 'like', '%'.$element.'%');

                                $curriculums = 1;
                            }
                            else
                            {

                                $query->orWhere('curriculums', 'like', '%'.$element.'%');

                            }
                        }
                    }

                }

                if( $obj['type'] == 'featured' )
                {
                    foreach ($obj['data'] as $filter_item)
                    {
                        if ($filter_item['status'] == 1)
                        {
                            $query ->  where( "popular", '=', 1 );
                        }
                    }
                }


                if( $obj['type'] == 'provide_food' )
                {
                    foreach ($obj['data'] as $filter_item)
                    {
                        if ($filter_item['status'] == 1)
                        {
                            $query ->  where( "provide_food", '=', 1 );
                        }
                    }
                }

            }

        }



        if( $request->has('city')  )
        {

            $city  = $request->get('city');

            $query -> where('city', 'like', '%'. $city   .'%');
        }


        if( $request->has('area') )
        {
            $selected_area = $request->get('area');

            if( $selected_area != '' )
            {
                $query -> whereRaw( "area LIKE '%$selected_area%'" );
            }


        }

        if( $request->has('school') )
        {
            $search_text = $request->get('school');

            if( $search_text != '' )
            {
                $query -> where('name', 'like', '%'. $search_text .'%');
            }


        }


        $page = $request -> get('page');

        if( $page > 0 ) { $page = $page * 10  ; }
        $query -> offset( $page );
        $query -> limit( 10 );

        $result = $query -> get();

        $response_to_app = array();

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

        $laQuery = DB::getQueryLog();
        $lcWhatYouWant = $laQuery[0]['query'];
        DB::disableQueryLog();
        //exit;
        $response_to_app['q'] 	=  $lcWhatYouWant;

        return response()->json( $response_to_app );




    }

    public function load_areas()
    {
        $respone_to_app = array();

        $area =  School:: select('area') -> distinct('area')-> get() ;

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

    public function follow_school(  Request $request )
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

        if(  $request -> has ('school_id') )
        {

            $user		 = $request->session()->get('user');

            $uid 	 	 = $user -> id;

            $d['object_id'] 		= $request -> get('school_id');

            $d['type'] 				= $request -> get('type');

            $d['uid'] 				= $uid;

            if( $request -> get('status') ==  'Follow' )
            {

                $chk = DB::table('user_following')->where(  [  ['uid','=', $d['uid'] ],  ['type', '=', $d['type'] ],  [ 'object_id', '=', $d['object_id'] ]]  )->get() ;

                if( $chk -> count() == 0 )
                {

                    $id = DB::table	('user_following')	->	insertGetId( $d );

                    $user_following =  DB::table('user_following')->where('uid', $d['uid']  )->get() ;

                    if( $id > 0 )
                    {

                        if( $d['type']  == 'school')
                        {
                            DB::table('school_profile') ->   whereId( $d['object_id'] )->increment('followers');
                        }
                        else
                        {
                            DB::table('user') ->   whereId( $d['object_id'] )->increment('followers');
                        }



                        $this -> create_news_feed_data_for_new();

                        $response_to_app['status'] 	= '200';

                        $response_to_app['message']  = 'You have successfully followed this school.s';

                        $response_to_app['data'] 	=  $user_following;

                        $response_to_app['result'] 	=  '1';
                    }
                    else
                    {

                        $response_to_app['status'] 	= '200';

                        $response_to_app['message']  = 'error';

                        $response_to_app['data'] 	=  'not added'	;

                        $response_to_app['result'] 	=  '0';
                    }

                }
                else
                {
                    $user_following =  DB::table('user_following')->where('uid', $d['uid']  )->get() ;

                    $response_to_app['status'] 	= '200';

                    $response_to_app['message']  = 'You have successfully followed this school';

                    $response_to_app['data'] 	=  $user_following;

                    $response_to_app['result'] 	=  '1';
                }

            }
            else
            {

                $d['object_id'] 		= $request -> get('school_id');

                $d['type'] 				= $request -> get('type');

                $d['uid'] 				= $uid;

                DB::table('user_following') -> where( $d ) -> delete (  );

                if( $d['type']  == 'school')
                {
                    DB::table('school_profile') ->   whereId( $d['object_id'] )->decrement('followers');
                }
                else
                {
                    DB::table('user') ->   whereId( $d['object_id'] )->decrement('followers');
                }

                $result = DB::table('user_following') -> where( 'uid', $uid ) -> get (  );



                $response_to_app['status'] 	= '200';

                $response_to_app['message']  = 'success';

                $response_to_app['data'] 	=  $result;

                $response_to_app['result'] 	=  '1';

            }


            return response()->json( $response_to_app );
        }
    }

    public function detail( $url )
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



        $this -> data['page'] = 'schools/school_detail';

        $this -> data['title'] = 'Expats School - Profile Page';

        $this -> data['page_on'] = 'school';



        return view("template") -> with( $this -> data );
    }


    public function enquiry_school(Request $request )
    {

        if(  $request -> has('enquiry')  )
        {

            $d['message'] 	 		 =  $request -> get ('message');

            $d['child_name'] 		 = $request -> get ('child_name');

            $d['parent_name'] 		 = $request -> get ('name');

            $d['parent_email'] 		 = $request -> get ('email');

            $d['school_id']			 = $request -> get ('school_id');

            $result =  DB::table('school_enquiry')-> insert( $d );

            $d['email_sent']		 = $request -> get ('email_sent');

           // Mail::to( $d['email_sent'] )->send(new ExpatsMail($d));



            $response['status'] 	= '200';

            $response['message']  = 'success';

            $response['data'] 	=  'Your message is sent successfully'	;

            $response['result'] 	=  '1';

            return response()->json( $response );
        }
    }

    public function load_school_staff(Request $request )
    {

        if( $request -> has('name') )
        {

            $domain_email = trim(   $request -> get ('domain') );


            $school_name   = trim(     $request -> get ('name')  );

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

                    $response_to_app['status'] 	= '200';

                    $response_to_app['message']  = 'success';

                    $response_to_app['data'] 	=  array();

                    $response_to_app['result'] 	=  '0';
                }
                else
                {


                    $response_to_app['status'] 	= '200';

                    $response_to_app['message']  = 'success';

                    $response_to_app['data'] 	=  $result	;

                    $response_to_app['result'] 	=  '1';
                }
            }
            //DB::disableQueryLog();

            return response()->json( $response_to_app );

        }

    }





    public function school_detail( Request $request )
    {

        $url = $request -> get('url');

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

        $response_to_app['status'] 	= '200';

        $response_to_app['message']  = 'success';

        $response_to_app['data'] 	=  $data;

        $response_to_app['result'] 	=  '2';

        return response()->json( $response_to_app );
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

}
