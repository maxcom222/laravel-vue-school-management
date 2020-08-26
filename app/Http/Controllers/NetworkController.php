<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class NetworkController extends Controller
{
    //

    protected $data = array('no_header' => 0 );


    public function index( Request $request )
    {

        if (! $request->session()->has('user'))
        {

            return  redirect()->action('AuthController@login');

        }


        $this -> data['page']		 = 'user/network';

        $this -> data['title'] 		 = 'Grow your network through Expats School';

        $this -> data['page_on']	 = 'staff-room';

        $this -> data['no_header'] 	 = '0';

        return view( "template" ) -> with( $this -> data ) ;
    }

    public function load_specialization()
    {

        $faq =  DB::table('specialization')   ->select('title' ) -> get() ;

        $result = json_encode( (object) null );

        $response_to_app['status'] 	= '200';

        $response_to_app['message']  = 'success';

        $response_to_app['data'] 	=  $faq;

        $response_to_app['result'] 	=  '1';

        return response()->json( $response_to_app );
    }

    public function filter_staff( Request $request )
    {

        if (! $request->session()->has('user'))
        {
            $result = json_encode( (object) null );

            $response['status'] 	= '200';

            $response['message']  = 'success';

            $response['data'] 	=  'session is expired';

            $response['result'] 	=  '2';

            return response()->json( $response );
        }

        $user = $request->session()->get('user');

        $uid  = $user -> id;

        if( $request -> has('load_data') )
		{

            $spec		 		= '';

            $school 			= '';

            $city		 		= '';

            $search_text	   	= '';

            $teacher		   	= '';

            $tutor				= '';

            $parent			   	= '';

            if( $request -> get('spec') != ''   )
            {
                $spec		 		=	$request -> get('spec');
            }
            if( $request -> get('school')  != ''   )
            {
                $school		 		=	$request -> get('school');
            }
            if( $request -> get('city')  != ''   )
            {
                $city		 		=	$request -> get('city');
            }
            if( $request -> get('search_text')  != ''  )
            {
                $search_text	=	$request -> get('search_text');
            }



            $teacher		   	=$request -> get('teacher');

            $tutor				=$request -> get('tutor');

            $parent			   	=$request -> get('parent');

            $page 				=$request -> get('page');

            DB::enableQueryLog();


            $query =  DB::table('user');

            $query ->  where( "user.id", '<>', $uid );

            $query ->  where( "user.verified", '=', '1' );


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

                if($request -> get('school_id') !=  '' )
				{

                    $school_id =	$request -> get('school_id');

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

                $response['status'] 	= '200';

                $response['message']  = 'success';

                $response['data'] 	=  $result;

                $response['result'] 	=  '0';

                $response['lcWhatYouWant'] = $lcWhatYouWant;
            }
            else
            {

                $response['status'] 	= '200';

                $response['message']  = 'success';

                $response['data'] 	=  $result	;

                $response['result'] 	=  '1';

                $response['lcWhatYouWant'] = $lcWhatYouWant;
            }

            $response['search_txt'] = $search_text;

            DB::disableQueryLog();


            return response()->json( $response );
        }


	 }

}
