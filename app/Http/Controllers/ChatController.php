<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Events\MsgReadEvent;
use App\Events\OnlineEvent;
use App\Events\PrivateChatEvent;
use App\Http\Resources\ChatResource;
use App\Http\Resources\UserResource;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use AWS;

class ChatController extends Controller
{


    public function messages2( Request $request )
    {
       // if (! $request->session()->has('user')) { return  redirect()->action('AuthController@login'); }
        $this -> data['page']		 = 'messages2';

        $this -> data['title'] 		 = 'Expats School - Your inbox';

        $this -> data['page_on']	 = 'messages';

        $this -> data['no_header'] 	 = '0';

        $user		 = $request->session()->get('user');


        broadcast( new  OnlineEvent( $user ) );



        return view( "template" ) -> with( $this -> data ) ;
    }



    public function send( Request $request )
    {


        ini_set('memory_limit', '-1');

        $msg  = $request -> msg;
        $user = $request -> user;
        //return response()->json([$request->all()]);
        event( new \App\Events\ChatEvent($msg, $user ) );

        return response()->json([$request->all()]);
    }

    public function send_message( Session $session ,Request $request )
    {

        $user		 = $request->session()->get('user');

        $uid 	 	 = $user -> id;

        $attachmentArray = $request -> get('attachment') ;

        $content         = $request  -> get('content');

        if( count($request -> get('attachment') ) > 0 )
        {

            if( $content === null  ){

                $content = '';
            }

            $attachment =  $attachmentArray[0]['upload_path'];

            $message =  $session -> messages()  -> create(  ['content' => $content , 'attachment' => $attachment ]  );
        }
        else
        {
            $attachment = '';

            $message =  $session -> messages()  -> create(['content' => $content ]);
        }


        $chat = $message -> createForSend( $session -> id, $uid  );

        $message -> createForReceive( $session -> id, $request -> to_user  );

        broadcast( new PrivateChatEvent( $request  -> get('content') , $chat, $attachment ));

        return response( $chat -> id, 200 );

        /*Chat() -> create([

            'session_id'  => $session -> id,
            'type' =>  0,
            'user_id'=> $uid,

        ]);*/

       /** $message -> Chat() -> create([

            'session_id'  => $session -> id,
            'type' =>  1,
            'user_id'=> $request -> to_user,

        ]);**/






        return $message;




        //$content = $request ->

        //event( new \App\Events\ChatEvent($msg, $user ) );

        //return response()->json([$request->all()]);
    }

    public function read( Session $session ,Request $request )
    {

        $user		 = $request->session()->get('user');
        $uid 	 	 = $user -> id;


        $chats =  $session -> chats  ->  where('read_at',  null ) -> where('type', 0) -> where('user_id','<>', $uid  );

        foreach( $chats as $chat )
        {

             $chat -> update(  ['read_at' =>   \Carbon\Carbon::now()  ] );

             broadcast( new  MsgReadEvent( new ChatResource($chat),  $chat -> session_id ));
        }
    }

    public function clear( Session $session ,Request $request )
    {

        $user		 = $request->session()->get('user');

        $uid 	 	 = $user -> id;

        $session -> clearMessages( $uid  );

        if( $session -> chats() -> count() == 0 )
        {
            $session -> deleteMessages(  $uid  );
        }


    }


    public function auth( Request $request )
    {

        ini_set('memory_limit', '-1');

        /*
         *
         * Auth info required to subscribe to private-chat
         * socket_id: 4105.13201961
channel_name: private-chat
         * */
        $user['socket_id']    = $_POST['socket_id'];

        $user['channel_name'] = $_POST['channel_name'];

        $auth= hash_hmac('SHA256', $user['socket_id'].':'.$user['channel_name'], '8455cb5066eb001d5e56');

        $auth = '91763ace9c34a06f535b:'.$auth;



        $user_return_object = array();

        $user_return_object['auth'] = $auth;

        $user		 = $request->session()->get('user');


        if( $_POST['channel_name']   === 'presence-online' )
        {
            $user_info  = $this  -> UserResource( $user  );

            $arr['user_id']   =  $user_info['id'] ;

            $arr['user_info'] =  $user_info ;

           //p( $_POST );exit;

            $user_return_object['channel_data'] =   json_encode( $arr );
        }



       /* $user_information = array(
                                'id' =>  '5025',
                                'name' => 'bilal'
                            );

        $user['channel_data'] = json_encode( $user_information );
      */
        return response()->json( $user_return_object );
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



    public  function  get_messages( Session $session,   Request $request  )
    {
        $user		 = $request->session()->get('user');
        $uid 	 	 = $user -> id;

        //return   $session -> chats -> where( 'user_id', $uid );

        return  ChatResource::collection(  $session -> chats -> where( 'user_id', $uid  ) );
    }




    public function get_friends( Request $request ) {


        if (! $request->session()->has('user'))
        {
            $result = json_encode( (object) null );

            $response_to_app['status'] 	= '200';

            $response_to_app['message']  = 'success';

            $response_to_app['data'] 	=  $result;

            $response_to_app['result'] 	=  '2';

            return response()->json( $response_to_app );
        }

        $user		 = $request->session()->get('user');

        $uid 	 	 = $user -> id;


        $result = DB::table('tbl_sessions') -> where( 'user1_id', $uid )

            -> orWhere('user2_id', $uid ) -> get();

        $ids = [];

        foreach ($result as $obj )
        {
            if( $uid === $obj -> user1_id  )
            {
                $ids[]  = $obj  -> user2_id;
            }
            else
            {
                $ids[]  = $obj  -> user1_id;
            }
        }



        //return  UserResource::collection(  User::where( [ ['id', '<>', $uid],['verified', '=', '1'] ]   -> limit(10) -> get() );

        return  UserResource::collection(  User::whereIn( 'id', $ids )  -> get() );

        /*
        email:"taraleoncameron@gmail.com"
        id:5198
        name:"TARA CAMERON"
        online:false
        profile_photo:"/profile_1547978722_tara.jpg"
        session:null
        username:"taraleoncameron51981547978480"
*/


        //return response()->json([$request->all()]);
    }


    public  function upload_image( Request $request )
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

                $s3 = AWS::createClient('s3');

                $window = $request -> get('window');

                $file_key  = $window. '/' . $filename;

                $t = $s3->putObject(array(

                    'Bucket'     => 'expatsschools',

                    'Key'        => $file_key,

                    'SourceFile' => $targetPath.  $filename,

                )) -> toArray();


                $url = $t['ObjectURL'];

                unlink(  $targetPath.  $filename  );

                $url = str_replace('https://expatsschools.s3.ap-south-1.amazonaws.com/','', $url );

                $response['status'] 	= '200';

                $response['message']    =  'success';

                $response['data'] 	    =  $filename;

                $response['url'] 	    =  $file_key;

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



    public function open_window( Request $request ) {

        $user		 = $request->session()->get('user');

        $uid 	 	 = $user -> id;



        $param_id		 = $request ->  get('friend_id');

        return  UserResource::collection(  User::where( [ ['id', '=', $param_id ],['id', '<>', $uid ],['verified', '=', '1'] ] ) -> get() );

        //return  UserResource::collection(  User::whereIn( 'id', $ids )  -> get() );

    }


}
