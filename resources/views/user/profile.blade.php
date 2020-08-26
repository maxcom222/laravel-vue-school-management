

    <?php

    $profile_photo = url( '/css/img/user-img.png' );

    $width = 30;

    $self_view_info = array();

    $self_view_info[0] = $self_view;


    if( $self_view == 1 )
    {


        $user = Session::get('user');
    }
    else
    {


        $user = $user_data;


    }


    if( $user -> profile_photo != '' )
    {

        $width = $width + 5;

        ?>

        <input type="hidden" id="dp-flag" value="1" />

        <?php

        if( $user -> profile_photo_custom == 1 )
        {

            $profile_photo = url('/user_profiles/'. $user -> profile_photo ) ;

        }
        else
        {

            $profile_photo =  $user -> profile_photo;

        }
    }
    else
    {
        ?>

        <input type="hidden" id="dp-flag" value="0" />

        <?php
    }


    $position = '0px';

    if( $user -> cover_position != '0')
    {

        $position =  $user -> cover_position;

    }

    $sid_1 = ''; $sid_2 = ''; $sid_3 = '';

    if( $user -> school_one != NULL &&   $user -> school_one  != '' )
    {

        $sid_1 = $user -> school_one;

    }
    if( $user -> school_two != NULL &&   $user -> school_two  != '' )
    {

        $sid_2 = $user -> school_two;

    }

    if( $user -> school_three != NULL &&   $user -> school_three  != '' )
    {


        $sid_3 = $user -> school_three;

    }

    ?>
    <input type="hidden" id="uid" value="<?php echo $user -> id ;?>"  />

    <input type="hidden" id="user_type" value="<?php echo $user -> type ;?>"  />

    <input type="hidden" id="sid_1" value="<?php echo $sid_1 ;?>"  />

    <input type="hidden" id="sid_2" value="<?php echo $sid_2 ;?>"  />

    <input type="hidden" id="sid_3" value="<?php echo $sid_3 ;?>"  />

    <input type="hidden" id="membership_status" value="<?php echo $membership_status ;?>"  />



    <profile

            :full-path="fullPath"

            :user="{{ json_encode( $user  ) }}"

            :self-view="{{  json_encode( $self_view ) }}"

            :membership-status="{{  json_encode( $membership_status ) }}"

            :twitter-name="{{ json_encode($twitter_name) }}"



    >

    </profile>




