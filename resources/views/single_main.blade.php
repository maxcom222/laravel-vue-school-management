<?php

$first_name  = '';

$last_name = '';

$email = '';

$contact_number = '';

$user = array();

if (Session::has('user'))
{

    $user = Session::get('user');

}
?>
<div v-if="showMainComponentLoader" class="loader" style="position: relative;height: 700px;"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

<major-component

        :full-path="fullPath"

        :user="{{ json_encode( $user ) }}"

        :self-view="{{ json_encode( $self_view ) }}"

        :membership-status="{{ json_encode( $membership_status ) }}"

        :expats-friends="{{ json_encode( $expats_friends ) }}"

        :twitter-name="{{ json_encode( $twitter_name ) }}"

        :no-header="{{ json_encode( $no_header ) }}"

        :user-datastandard="{{ json_encode( $user_data_standard ) }}"

        :v="{{ json_encode( $v ) }}"



>

</major-component>


