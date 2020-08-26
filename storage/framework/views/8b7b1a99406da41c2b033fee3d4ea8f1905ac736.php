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

        :user="<?php echo e(json_encode( $user )); ?>"

        :self-view="<?php echo e(json_encode( $self_view )); ?>"

        :membership-status="<?php echo e(json_encode( $membership_status )); ?>"

        :expats-friends="<?php echo e(json_encode( $expats_friends )); ?>"

        :twitter-name="<?php echo e(json_encode( $twitter_name )); ?>"

        :no-header="<?php echo e(json_encode( $no_header )); ?>"

        :user-datastandard="<?php echo e(json_encode( $user_data_standard )); ?>"

        :v="<?php echo e(json_encode( $v )); ?>"



>

</major-component>


<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/es/resources/views/single_main.blade.php ENDPATH**/ ?>