<div id="app">

<?php

  $jobs = $jobs[0];

  $school_profile = $school_profile[0];

  $logo = '';

  if( $school_profile -> logo != '' )
  {

      $logo = 'https://d2heijv3bffmsx.cloudfront.net/'. $school_profile -> logo;

  }
  else
  {

    $logo = url('/'. 'css/img/nologo.png' );

  }

?>



<header class="page-title bg-job">

  <div class="container">

    <div class="row">

      <div class="col-12 job-title"> <a href="<?php echo url('/school/'.$school_profile -> url);?>" class="logo-company"><img src="<?php echo $logo;?>" alt="<?php echo $school_profile -> name;?>"></a>

        <h1><?php echo $jobs -> title;?></h1>

        <span>Published: <?php echo $jobs -> title;?></span> <em>by <a href="<?php echo url('/school/'.$school_profile -> url);?>"><?php echo $school_profile -> name;?></a></em> </div>

    </div>

  </div>

</header>

<div id="myCanvasNav" class="overlay" onclick="closeNav()"></div>

    <?php

        $user = array();

        if (Session::has('user'))
        {

             $user =  Session::get('user');

        }

     ?>
<jobdetail-component


        :full-path="fullPath"

        :job-item="<?php echo e(json_encode( $jobs )); ?>"

        :school-profile="<?php echo e(json_encode( $school_profile )); ?>"

        :user="<?php echo e(json_encode( $user )); ?>"


>

</jobdetail-component>


</div><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/es/resources/views/jobs/job_detail.blade.php ENDPATH**/ ?>