<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use AWS;

use Mail;
use App\Mail\ExpatsMail;


class JobsController extends Controller
{
    protected $data = array('no_header' => 0 );


    public function index( Request  $request )
    {

        if ( ! $request->session()->has('user') )
        {
            return  redirect()->action('AuthController@login');
        }

        $this -> data['page']    = 'jobs/joblist';

        $this -> data['title']   = 'Expats\' School - Jobs Page';

        $this -> data['page_on'] = 'classified';

        return view("template" ) -> with( $this -> data );
    }

    public function detail( $school_url, $job_url,  Request  $request )
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

        $this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expat_social-01-sig.jpg';

        $this -> data['og_url'] 	=  url('/jobs/'. $result[0]  -> url  );

        $this -> data['page'] = 'jobs/job_detail';

        $this -> data['title'] = 'Expats School -  School Job Page';

        $this -> data['page_on'] = 'jobs';

        return view("template") -> with( $this -> data );
    }

    public function list_jobs( Request $request )
    {



        if(  $request -> has('page')  )
        {

            $page 				= $request -> get('page');

            $benefits 			= $request -> get('benefits');

            $contract_type 		= $request -> get('contract_type');

            $position 			= $request -> get('position');

            $salary_band	   	= '';//$request -> get('salary_band');

            $search_text		= $request -> get('search_text');

            $gender				= '';//$request -> get('gender');

            $department			= $request -> get('department');

            $page 				= $request -> get('page');


            DB::enableQueryLog();


            $query    =  DB::table('jobs');

            $response =  array();

            if( $benefits != '' &&  $benefits != 'undefined'  )
            {

                $query -> where( 'benefits', 'like', '%' . $benefits . '%' );

            }

           /* if( $request -> has('benefits' ) )
            {

                    $benefits = $request -> get('benefits');

                    $benefits =  explode(',', $benefits  );

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
           */


            if(  $request -> has('contract_type') )
            {

                $contract_type =  explode(',', $request -> get('contract_type') );

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


            $query ->  whereRaw( 'apply_before >= CURRENT_DATE');

            if( $salary_band != '' &&  $salary_band != 'any'  )
            {

                $query -> where( 'benefits', 'like', '%' . $benefits . '%' );

            }
            if( $position != '' &&  $position != 'undefined'  )
            {

                $query -> where( 'position', 'like', '%' . $position . '%' );

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

            if(  $request -> get('school') != '' )
            {

                $school_id = School::where('name', '=', $request -> get('school') ) -> first();

                $school_id = $school_id -> id;

                $query ->  where( "school_id", '=', $school_id  );
            }

            if( $request -> has('department') )
            {
                $department =  $request -> get('department');

                if( is_array( $department ) )
                {
                    $sub_query = '';

                    $sub_q_count = 0;

                    foreach( $department as $o )
                    {
                        $o  =  addslashes( $o);

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

            if(  $request -> has('location_type') )
            {
                $location_type =  explode(',', $request -> get('location_type') );

                $response['location_type'] 	= count( $location_type );

                if(  $location_type[0] != ''  )
                {

                    $sub_query = '';

                    $sub_q_count = 0;

                    foreach( $location_type as $o )
                    {
                        $o  =  addslashes( $o);

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

                $response['status'] 	= '200';

                $response['message']  = 'success';

                $response['data'] 	=  $result;

                $response['result']	=  '0';

            }
            else
            {

                $response['status']	= '200';

                $response['message']  = 'success';

                $response['data'] 	=  $result	;

                $response['result'] 	=  '1';

            }
            $response['q'] 	=  $lcWhatYouWant;




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

                $targetPath = getcwd().'/public/classifieds/';

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

            $targetPath = getcwd().'/public/classifieds/';

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


    public function job_apply_form( Request $request )
    {

        if( $request -> has('job_application') )
        {
            $uid = 0;

            if ( !$request->session()->has('user'))
            {

                $response['status'] 	= '200';

                $response['message']  = 'error';

                $response['data'] 	=  'Your session is expired.';

                $response['result'] 	=  '2';

                return response()->json( $response );
            }


            $sess = $request->session()->get('user');

            $uid = $sess -> id;

            $d['job_id'] 			= $request -> get('jid');

            $d['cover_letter'] 		= $request -> get('cover_letter');

            $d['uid'] 				= $uid;

            $query =  DB::table('jobs') -> where ('id', $d['job_id']  )  -> increment('applicants');

            DB::table('job_applications') -> insert( $d );


            $d['profile_link']		= url('/user/profile_view?u=' .$sess -> username . '&env=exp'  );

            $d['job_link']			= $request -> get('job_url');

            $school_url				= $request -> get('school_url');

            $scool_profile 		=  DB::table('school_profile') -> where( 'url', '=', $school_url ) -> get() ;


            $d['email']         = $scool_profile[0] -> email;

            $d['school_url']    = $school_url;

            $d['email']         = 'bilal@godesto.com';

            /*Mail::send('email_template/job_apply_from_user', $d  , function($message) use ($d)
            {
                $message->to( $d['email'] ) -> subject( 'Your have got an application for a job' ); //->cc('bar@example.com');
            });

            Mail::send('email_template/job_apply_from_user', $d  , function($message) use ($d)
            {
                $message->to( 'handsup@expatsschools.com' ) -> subject( 'Your have got an application for a job' ); //->cc('bar@example.com');
            });*/



            $res['status'] 	= '200';

            $response['message']  = 'success';

            $response['data'] 	=  'Your message is sent successfully. Please wait for response';

            $response['result'] 	=  '1';

            return response()->json( $response );
        }


    }


    public function job_detail( Request  $request )
    {

        $school_url = $request -> get('school_url');

        $job_url    = $request -> get('job_url');

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

        $this -> data['og_logo']	= 'https://www.expatsschools.com/public/css/img/expat_social-01-sig.jpg';

        $this -> data['og_url'] 	=  url('/jobs/'. $result[0]  -> url  );

        $this -> data['page'] = 'jobs/job_detail';

        $this -> data['title'] = 'Expats School -  School Job Page';

        $this -> data['page_on'] = 'jobs';


        $response_to_app['status'] 	 = '200';

        $response_to_app['message']  =  'success';

        $response_to_app['data'] 	 =  $this -> data;

        $response_to_app['result'] 	 =  '1';

        return response()->json( $response_to_app );
    }




}
