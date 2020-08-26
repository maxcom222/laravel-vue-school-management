



    <?php


    $first_name  = '';

    $last_name = '';

    $email = '';

    $contact_number = '';

	if (Session::has('user'))
	{

	        $user = Session::get('user');

	}
	?>
<header style="opacity:0;">

</header>


    <setting-component

        :full-path="fullPath"

        :user="{{ json_encode( $user ) }}"


    >


    </setting-component>


