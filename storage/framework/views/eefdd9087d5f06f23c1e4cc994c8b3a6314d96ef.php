

<?php

        if( isset ($_GET['v'])  ) {



         ?>


            <profile-wizard

                    :v="<?php echo e(json_encode( $_GET['v'] )); ?>"

                    :user_data_standard="<?php echo e(json_encode( $response['user_data'] )); ?>"

                    :full-path="fullPath">


            </profile-wizard>

        <?php

        } else {

            ?>

            <profile-wizard

                    :v="0"

                    :user_data_standard="0"

                    :full-path="fullPath">


            </profile-wizard>
<?php
        }

?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/es/resources/views/user/profile_wizard.blade.php ENDPATH**/ ?>