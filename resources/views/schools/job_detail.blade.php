<?php
	$jobs = $jobs[0];
	$school_profile = $school_profile[0];
	 $logo = '';
	 if( $school_profile -> logo != '' )
	 {
		  $logo = 'https://www.expatsschools.com/secure_admin/media/images/logos/'. $school_profile -> logo;
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
<main class="two-cloumn">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-4 col-left">
        <div class="frame share job-info">
          <ul class="job-stats">
            <li> <strong>Apply before:</strong><p><?php echo date('M d, Y', strtotime( $jobs -> apply_before) );?>  <input type="hidden" id="school_url" value="<?php echo $school_profile -> url;?>" />   <input type="hidden" id="job_url" value="<?php echo $jobs -> url;?>" />  <input type="hidden" id="jid" value="<?php echo $jobs -> id;?>" /></p>
            </li>
            <li> <strong>Contract Type:</strong><p><?php echo $jobs -> contract_type;?></p>
            </li>
            <li> <strong>Total Positions:</strong><p><?php echo $jobs -> total_position;?></p>
            </li>
            <li> <strong>Experience:</strong><p><?php echo $jobs -> experience;?></p>
            </li>
            <li> <strong>Gender:</strong><p><?php echo $jobs -> gender;?></p>
            </li>
            <li> <strong>Salary:</strong><p><?php echo $jobs -> salary_band;?></p>
            </li>
          </ul>
          <?php
			if (Session::has('user'))
			{
					$user = Session::get('user');
					?>
                    <button class="btn btn-primary js_apply_m">Apply for this Job</button>
                    <?php
			}
			else
			{
				?>
                <p class="login-j-content">Login <a class="login" href="{{ url('/login') }}">here </a> to apply</p>
                <?php
				
			}
		 ?>
          <p class=" text-center al-app d-none alert alert-success"></p>
          <strong>Share</strong>
          <div class="sharethis-inline-share-buttons"   data-url="<?php echo url('/jobs/'.$school_profile -> url.'/'. $jobs -> url  );  ?>" data-title="<?php echo $jobs -> title;?>"></div>
        </div>
      </div>
      <div class="col-12 col-md-8 col-right">
        <div class="frame news-article">
          <h2>Job Summary</h2>
          <p>
          <?php echo $jobs -> description;?>
          </p>
          <h2>Benefits</h2>
          <ul class="benefits">
           <?php 
		   
		  		$benefits = explode(',',  $jobs -> benefits); 
				foreach( $benefits as $obj )
				{
					
					?>
                    <li><svg class="icon icon-check"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-check"></use></svg> <?php echo $obj;?></li>
                    <?php
					
				}
			?>
          
            
           
          </ul>
          <h2>About <?php echo $school_profile -> name;?></h2>
          <?php echo $school_profile -> description;?>
        </div>
      </div>
    </div>
    
     <?php
			if( count( $similar_jobs ) != 0 )
			{
	?>
    <div class="row">
      <div class="col-12">
        <div class="more-news">
          <h2 class="text-center">Similar Jobs</h2>
          <div class="owl-carousel owl-theme owl-jobs">
           <?php
				foreach( $similar_jobs as $obj )
				{
				
					 $school_profile		=  DB::table('school_profile') -> where( 'id', '=', $obj -> school_id ) -> get() ;
					 $school_profile = $school_profile[0];
					 if( $school_profile -> logo != '' )
					 {
						  $logo = 'https://www.expatsschools.com/secure_admin/media/images/logos/'. $school_profile -> logo;
					 }
					 else
					 {
						$logo = url('/'. 'css/img/nologo.png' );
					 }
					
					
					$link_sc =  url('/jobs/'.$school_profile -> url.'/'. $obj -> url  ); 
					

		?>
            <div class="item"> <a href="<?php echo $link_sc;?>" target="_blank"><img src="<?php echo $logo;?>" alt="<?php echo $school_profile -> name;?>"></a>
              <h3><?php echo  substr($obj -> position, 0, 38 );?></h3>
              <small><?php echo date('M d, Y', strtotime( $obj -> apply_before) );?></small>
            </div>
            
            
            <?php }  ?>
            
            
            
            
            
          </div>
        </div>
      </div>
    </div>
    
    <?php
		
		}
	?>
  </div>
</main>





<div class="modal fade" id="coverUiDialog" tabindex="-1" role="dialog" aria-labelledby="coverUiLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="coverUiLabel">Job Application</h5>
      </div>
      <div class="modal-body">
		 <p class="lead">Your public profile link will be shared with the employer.</p>
         <div class="form-group  row">
            <label for="" class="col-12 col-form-label">Cover letter *</label>
            <div class="col-12">
                <textarea class="form-control" id="cover_letter" style="height:200px;" ><?php echo $user_about;?></textarea>
            </div>
        </div>
        
        <div class="form-group  row">
         <label for="" class="col-12 col-form-label"><input type="checkbox" id="cgbr1"  /> I confirm that the information provided in my profile and cover letter is accurate and true.</label>
            
        </div>
        
       
        <div class="form-group  row">
         <label for="" class="col-12 col-form-label"><input type="checkbox" id="cgbr2"   /> I understand that only shortlisted candidates may be contacted.</label>
            
        </div>
        
        
        
         <div class="form-group  row">
            <label for="" class="col-12 col-form-label"></label>
            <div class="col-12 text-center">
            	<button class="btn btn-primary js_apply">Submit Application</button>
             </div>
        </div>

      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

