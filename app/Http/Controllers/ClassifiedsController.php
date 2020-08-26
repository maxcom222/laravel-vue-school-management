<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use AWS;

use Mail;

use App\Mail\ExpatsMail;



class ClassifiedsController extends Controller
{
    protected $data = array('no_header' => 0 );


    public function index( Request  $request )
    {

        if ( ! $request->session()->has('user') )
        {
            return  redirect()->action('AuthController@login');
        }

        $this -> data['page']    = 'classified/index';

        $this -> data['title']   = 'Expats\' School - Classified Page';

        $this -> data['page_on'] = 'classified';

        return view("template" ) -> with( $this -> data );
    }

    public function detail( $url, Request  $request )
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

        $this -> data['og_logo']	= 'https://www.expatsschools.com/css/img/expat_social-01-sig.jpg';

        $this -> data['og_url'] 	= url('classifieds/detail/' .  $result[0] -> url) ;



        $this -> data['page'] = 'classified/detail-vue';

        $this -> data['title'] = 'Expats School -  '. $result[0] -> title;

        $this -> data['page_on'] = 'classified';

        return view("template") -> with( $this -> data );
    }


    public function ad_detail( Request  $request )
    {

        $url = $request ->  get('url');

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

        $this -> data['og_logo']	= 'https://www.expatsschools.com/css/img/expat_social-01-sig.jpg';

        $this -> data['og_url'] 	= url('classifieds/detail/' .  $result[0] -> url) ;

        $this -> data['page'] = 'classified/detail-vue';

        $this -> data['title'] = 'Expats School -  '. $result[0] -> title;

        $this -> data['page_on'] = 'classified';

        $response['status'] 	= '200';

        $response['message']    = 'success';

        $response['data'] 	    =  $this -> data;

        $response['result'] 	=  '1';

        return response()->json( $response );

    }




    public function listing( Request $request )
    {

        $user = $request->session()->get('user');

        $uid  = $user -> id;


        if(  $request -> has('page')  )
        {

            $page 				= $request -> get('page');

            $favourites 		= $request -> get('favourites');

            DB::enableQueryLog();

            $query =  DB::table('classifieds');

            $query ->  where( "classifieds.is_live", 1 );


            if(  $request -> get('condition') != ''   &&  $request -> get('usage') != 'Any'  )
            {
                $condition	= $request -> get('condition');

                $query ->  whereRaw( "classifieds.conditions LIKE '%$condition%'" );
            }
            if(  $request -> get('usage') != '' &&  $request -> get('usage') != 'Any'  )
            {
                $usage	= $request -> get('usage');

                $query ->  whereRaw( "classifieds.usage LIKE '%$usage%'" );
            }
            if( $request -> get('age') != ''  &&  $request -> get('usage') != 'Any' )
            {
                $age	= $request -> get('age');

                $query ->  whereRaw( "classifieds.ages LIKE '%$age%'" );

            }
            if(  $request -> get('warranty') != '' &&  $request -> get('usage') != 'Any'  )
            {

                $warranty	= $request -> get('warranty');

                $query ->  whereRaw( "classifieds.warranty LIKE '%$warranty%'" );
            }
            if(  $request -> get('category' ) != '' )
            {
                $category	= $request -> get('category');

                $query ->  where( "category", $category );
            }
            if(  $request -> get('sub_category') != '' )
            {
                $sub_category	= $request -> get('sub_category');

                $query ->  where( "sub_category", $sub_category );
            }

            if( $request -> has('mileage') )
            {
                $mileage	= $request -> get('mileage');

                $query ->  whereRaw( "mileage <= '%$mileage%'" );
            }

            if(  $request -> get('year') != '')
            {
                $year	= $request -> get('year');

                $query ->  where( "year", $year );
            }




            if(  $request -> get('level_3')  != '' )
            {
                $level_3	= $request -> get('level_3');

                $query ->  where( "level_3", $level_3 );

            }
            if( $request -> get('level_4' ) != '' )
            {
                $level_4	= $request -> get('level_4');

                $query ->  where( "level_4", $level_4 );
            }


            if(  $request -> get('search_text') != '' )
            {
                $search_text	=	$request -> get('search_text');

                $query -> where( 'classifieds.title', 'like', '%' . $search_text . '%' );

                $query -> orWhere('classifieds.description', 'like', '%'.$search_text.'%');
            }

            if ( $favourites ==  1 )
            {
                $favourites_result = DB::table('user_fav')

                    ->  select( DB::raw( 'GROUP_CONCAT( item_id )' ) )

                    ->  where( 'uid', '=', $uid )

                    ->  where( 'type', '=', 'ads' ) -> get();


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

            $query  ->   select('classifieds.*','classified_category.text','user.first_name', 'user.last_name', 'user.profile_photo', 'user.profile_photo_custom', 'user.username' );

            $query  ->  orderBy('id', 'DESC');

            if( $page > 0 ) { $page = $page * 10  ; }

            $query -> offset( $page );

            $query -> limit( 10 );

            $result = $query -> get();


            $laQuery = DB::getQueryLog();

            $lcWhatYouWant = $laQuery[0]['query'];

            DB::disableQueryLog();

            $response['query'] 	=  $lcWhatYouWant;

            if( $result -> count() ==  0 )
            {
                $result = json_encode( (object) null );

                $response['status'] 	= '200';

                $response['message']    = 'success';

                $response['data'] 	    =  $result;

                $response['result'] 	=  '0';
            }
            else
            {

                $response['status'] 	= '200';

                $response['message']    = 'success';

                $response['data'] 	    =  $result	;

                $response['result'] 	=  '1';
            }


            return response()->json( $response );
        }
    }






    public function post( Request  $request )
    {

        if ( ! $request->session()->has('user') )
        {

            return  redirect()->action('AuthController@login');

        }

        $this -> data['page'] = 'classified/post_edit';

        $this -> data['title'] = 'Expats\' School - Classified Page';

        $this -> data['page_on'] = 'classified';

        return view("template" ) -> with( $this -> data );
    }

    public function get_cats( Request  $request )
    {


        if(  $request  -> has('child') )
        {
            $classifieds_images = DB::table	('classified_category' ) -> orderBy('text', 'ASC') -> where('parent_id',  $request  -> get('id') ) -> get(  );

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


    public  function upload_cover_photo()
    {


        if( isset( $_FILES ) )
        {
                $uploads = '';



                $tempFile 	= $_FILES['file']['tmp_name'];

                $targetPath = getcwd().'/classified/';

                $filename 	= trim(addslashes(	str_replace( ' ', '', $_FILES['file']['name'] ) ) );

                $filename   = time().'_'.$filename;

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

                    $file_key  = 'classifieds/'.$filename;

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


    public function upload_album()
    {

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

                $file_key  = 'classifieds/'.$filename;

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


    public function save_ad(  Request $request )
    {

        if ( ! $request->session()->has('user') )
        {
            return  redirect()->action('AuthController@login');
        }

        $user  = $request  ->  session() -> get('user');
        $uid   = $user -> id;

        if(  $request -> has('title') )
        {
            $d['title'] 				 =  $request -> get('title') ;

            $d['phone_number'] 			 =  $request -> get('phone_number') ;

            $d['price'] 				 =  $request -> get('price') ;

            $d['description'] 			 =  $request -> get('description') ;

            $d['warranty'] 				 =  $request -> get('warranty') ;

            $d['category'] 				 =  $request -> get('category') ;

            $d['address'] 				 =  $request -> get('address');

            $d['latitude'] 				 =  $request -> get('latitude') ;

            $d['longitude'] 			 =  $request -> get('longitude') ;

            $d['mileage']				 =  $request -> get('mileage');

            $d['year']					 =  $request -> get('year');

            $d['service_history']		  =  $request -> get('service_history');



            $d['sub_category'] 			 = $request -> get('sub_category') ;

            if( $request -> get('sub_category') ==  '' )
            {
                $d['sub_category'] 	= 0;
            }

            $d['level_3'] 			 =  $request -> get('level_3') ;

            if( $request -> get('level_3') ==  '' )
            {
                $d['level_3'] 	= 0;
            }

            $d['level_4'] 			 =  $request -> get('level_4') ;

            if( $request -> get('level_4') ==  '' )
            {
                $d['level_4'] 	= 0;
            }



            $d['conditions'] 			 =  $request -> get('condition') ;

            $d['usage'] 				 =  $request -> get('usage') ;

            $d['ages'] 					 =  $request -> get('ages') ;

            $d['cover_image']            =  $request -> get('cover_photo');

            $d['uid'] 					 =  $uid;

            $page_url =  strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($d['title'], ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));

            $page_url = $page_url .'_'.time();

            $d['url'] 					 =  $page_url;

            $d['dated'] 				 = date('Y-m-d');

            $d['is_live'] 				 = 0;

            if(  $request -> has('edit')  )
            {
                $id  = $request -> get('edit_id');

                DB::table	('classifieds' )	-> where('id', $id ) -> update( $d   );
            }
            else
            {
                $id = DB::table	('classifieds' ) -> insertGetId( $d   );

                $images = $request -> get('images');

                $images = explode('##', $images );

                $d = array();

                $d['cid'] = $id;

                foreach(  $images as $img )
                {

                    $d['image'] = $img;

                    DB::table	('classifieds_images' )	-> insertGetId( $d   );
                }
            }




            $response['status'] 	= '200';
            $response['message']    =  $id;
            $response['data'] 	    =  'Ad is saved successfully';
            $response['result'] 	=  '1';
            return response()->json( $response );

        }
    }


    public function add_to_fav( Request $request )
    {

            $uid = 0;

            if ( ! $request->session()->has('user') )
            {
                $response['status'] 	= '200';

                $response['message']  = 'expire';

                $response['data'] 	=  '';

                $response['result'] 	=  '2';

                return response()->json( $response );
            }

            $user = $request -> session() -> get('user');

            DB::enableQueryLog();

            if( $request -> has ('type') )
            {
                $d['type'] 		    =  $request -> get ('type') ;
            }
            else
            {
                $d['type'] 		    = 'ads';
            }

            if( $request -> get('action') == 'add' )
            {

                $d['item_id'] 		= $request -> get ('id');

                $d['uid'] 			= $user -> id ;



                DB::table('user_fav') -> insert( $d );

                $response['result'] 	=  '1';
            }
            else
            {
                $d['item_id'] 		= $request -> get ('id');

                $d['uid'] 			= $user -> id ;


                DB::table('user_fav')

                    -> where('item_id', $d['item_id'] )

                    -> where('type', $d['type'] 	 )

                    -> where('uid', $d['uid'] )   -> delete(  );

                $response['result'] 	=  '4';
            }

            $laQuery = DB::getQueryLog();

            $lcWhatYouWant = $laQuery[0]['query'];

            DB::disableQueryLog();

            $response['status'] 	= '200';

            $response['message']    = 'success';

            $response['data'] 	    =  $d ;

            $response['action'] 	=  $request -> get('action');


            return response()->json( $response );

    }


    public function flag_item( Request $request )
    {
        if(   $request  -> has('report')   )
        {
            $uid = 0;

            if ( ! $request->session()->has('user') )
            {

                $response['status'] 	= '200';

                $response['message']  = 'expire';

                $response['data'] 	=  '';

                $response['result'] 	=  '2';

                return response()->json( $response );
            }

            $user = $request -> session() -> get('user');

            $d['item_id'] 		= $request  ->  get('cid');

            $d['report'] 		= $request  ->  get('report_reason');

            $d['uid'] 			= $user -> id ;

            $d['type'] 		    = 'ads';

            DB::table('flag_items') -> insert( $d );



            $response['status'] 	= '200';

            $response['message']    = 'success';

            $response['data'] 	    =  $d ;

            $response['result'] 	=  '1';

            return response()->json( $response );
        }

    }

    public function contact_info(Request $request )
    {

        if( $request -> has('save_basic_info') )
        {

            $d['name'] 				= $request  -> get('name');

            $d['message'] 		    = $request  -> get('message');

            $d['phone'] 			= $request  -> get('phone');

            $d['subject'] 			= $request  -> get('subject');

            DB::table('tbl_contact') -> insert( $d );

            $d['msg'] =  $request  -> get('message');

            $d['email'] = 'bilal@godesto.com' ;

            $d['type']  = '';

            if( $request  -> has('type') )
            {
                $d['type']  = $request -> get('type');
            }


            Mail::send('email_template/contact_info', $d  , function($message) use ($d)
            {

                if(  $d['type'] == 'register')
                {
                    $message->to( $d['email'] ) -> subject( "Registration request from Expats' Schools" );
                }
                else
                {
                    $message->to( $d['email'] ) -> subject( "Contact from Expats' Schools" );
                }

            });

            $response['status'] 	= '200';

            $response['message']  = 'success';

            $response['data'] 	=  'Your message is sent successfully. Please wait for response from buyer';

            $response['result'] 	=  '1';

            return response()->json( $response );


        }

    }

    public function reply_ad( Request $request )
    {
        if( $request  -> has('reply_ad') )
        {
            $uid = 0;

            if ( $request->session()->has('user') )
            {
                $session_request = $request->session()->get('user');

                $uid = $session_request -> id;
            }

            $d['name'] 				= $request  -> get('name');

            $d['phone_number'] 		= $request  -> get('phone_number');

            $d['email'] 			= $request  -> get('email');

            $d['message'] 			= $request  -> get('message');

            $d['cid'] 				= $request  -> get('cid');

            $d['uid'] 				= $uid;

            $query =  DB::table('classifieds_response') -> insert( $d );

            $d['ad_link']		    = $request  -> get('ad_link') ;

            unset($d['message'] );

            $d['msg'] =  $request  -> get('message');

            $d['email'] = 'bilal@godesto.com' ; //$request  -> get('js_rec_email');

          /*  Mail::send('email_template/ads_response', $d  , function($message) use ($d)
            {

                $message->to( $d['email'] ) -> subject( 'Your ad got a response' );


            });
*/


            $response['status'] 	= '200';

            $response['message']  = 'success';

            $response['data'] 	=  'Your message is sent successfully. Please wait for response from buyer';

            $response['result'] 	=  '1';

            return response()->json( $response );
        }



    }
    public  function get_friends(Request $request  )
    {

        $url = $request ->  get('url');

        $expats_friends =  DB::table('expats_friends') -> where( 'url', $url )  -> get();

        $response['status'] 	= '200';

        $response['message']  = 'success';

        $response['data'] 	=  $expats_friends;

        $response['result'] 	=  '1';

        return response()->json( $response );
    }






}
