<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use AWS;

use Illuminate\Support\Facades\DB;


class BucketController extends Controller
{

    public  function copy()
    {


        $school_profile = DB::table('user') -> where([  ['verified', '=', '1'],['cover_image','<>',''] ]) -> get();

        $tables = DB::select('SHOW TABLES');
        foreach($tables as $table)
        {
           $t =  $table->Tables_in_beta_expa_main;

           //p($table);exit;


            ///DB::statement("ALTER TABLE `$t` CHANGE `id' `id`  BIGINT(20) NOT NULL AUTO_INCREMENT");

            echo "ALTER TABLE `$t` CHANGE `id`  `id`  BIGINT(20) NOT NULL AUTO_INCREMENT";

            echo "<BR><BR>";


            // " CHANGE `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT";


        }

        exit;


        return '';

        $school_profile = DB::table('user') -> where([  ['verified', '=', '1'],['cover_image','<>',''] ]) -> get();

        foreach( $school_profile as $obj )
        {

           // $logo        = $obj -> logo;

            $cover_image = $obj -> cover_image;

          //  echo $_SERVER['DOCUMENT_ROOT'];
            //exit;



            $url = 'https://www.expatsschools.com/public/user_profiles/'. $cover_image ;

            $save_name   = $obj -> cover_image;

            $save_directory = "/home/beta.expatsschools.com/public_html/public/";

            file_put_contents($save_directory . $save_name, file_get_contents($url));

            $s3 = AWS::createClient('s3');

            $file_key  = 'users/' . ''.$obj -> profile_photo;

            $t = $s3->putObject(array(
                'Bucket'     => 'expatsschools',

                'Key'        => $file_key,

                'SourceFile' =>  $save_directory . $save_name,

            )) -> toArray();


            $url = $t['ObjectURL'];

            unlink(  $save_directory . $save_name);


            $url = str_replace('https://expatsschools.s3.ap-south-1.amazonaws.com/','', $url );

            $d['cover_image'] = str_replace('//','/', $url );

            DB::table('user')

                -> where('id',  $obj -> id )

                -> update( $d );


            echo $url;

            echo '<BR><BR>'; //exit;




        }









    }

    public  function copy2()
    {



        $school_profile = DB::table('school_profile') -> where([ ['id', '>', '96'], ['cover_image', '<>', '' ] ]) -> get();

        foreach( $school_profile as $obj )
        {

            $logo        = $obj -> logo;

            $cover_image = $obj -> cover_image;

            $url = 'https://www.expatsschools.com/secure_admin/media/images/covers/'. $cover_image ;

            $save_name   = 'expats_'.  time().'_COVER.jpg';

            $save_directory = "/Applications/XAMPP/xamppfiles/htdocs/expat_front/public/";

            file_put_contents($save_directory . $save_name, file_get_contents($url));

            $s3 = AWS::createClient('s3');

            $file_key  = 'school_covers/' . ''.$save_name;

            $t = $s3->putObject(array(
                'Bucket'     => 'expatsschools',

                'Key'        => $file_key,

                'SourceFile' =>  $save_directory . $save_name,

            )) -> toArray();


            $url = $t['ObjectURL'];

            unlink(  $save_directory . $save_name);


            $url = str_replace('https://expatsschools.s3.ap-south-1.amazonaws.com/','', $url );

            $d['cover_image'] = $url;

            DB::table('school_profile')

                -> where('id',  $obj -> id )

                -> update( $d );


            echo $url;

            echo '<BR><BR>';




        }









    }



}
