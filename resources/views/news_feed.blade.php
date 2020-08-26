    <header class="page-title bg-feed">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>News Feed</h1>
                </div>
            </div>
        </div>
    </header>

    <main class="two-cloumn  coffe-club nsfeed">
                <div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

        <div class="container">
<?php
            $last_name = ''; $first_name = ''; $recent_job = ''; $recent_school = '';
			$profile_photo = url( '/css/img/user-img.png' );
            if ( Session::has('user')  )
            {
				$user = Session::get('user');
				if( $user -> first_name != '' )
				{
					$first_name = $user -> first_name;
				}
				if( $user -> first_name != '' )
				{
					$last_name = $user -> last_name;
				}
				$recent_job = 'Add your recent job in profile section';
				if( $user -> recent_job != '' )
				{
					$recent_job = $user -> recent_job;
				}	
				if( $user -> recent_school != '' )
				{
					$recent_school = $user -> recent_school;
				}		
				
				
					
				if( $user -> profile_photo != '' )
				{
					
					if( $user -> profile_photo_custom == 1 )
					{
						$profile_photo = url('/user_profiles/'. $user -> profile_photo ) ;
					}
					else
					{
						$profile_photo =  $user -> profile_photo;
					}
				}		
            }
			else
			{
				$first_name = '<a href="https://www.expatsschools.com/login">Login</a> to '; $last_name = ' Expats School';
			}
?>
            <div class="row">
                <div class="col-12 col-md-3 col-left">
                    <div class="frame pro-widget" id="contact">
                        <div class="pro-img"><a href=""><img src="<?php echo $profile_photo;?>" alt="<?php echo $first_name.' '.$last_name;?>" ></a></div>
                        <h3><?php echo $first_name.' '.$last_name;?></h3>
                        <span class="text-muted"><?php echo $recent_job;?> </span>
                        <p><?php echo $recent_school;?></p>
                        
                    </div>
                </div>
                <div class="col-12 col-md-6 ajaxify-nf"> </div>
                
                
                
                
                
                <div class="col-12 col-md-3 col-right">
                    <div class="frame recommendations">
                        <h5>Recommended Schools</h5>
                        
                        <?php
						foreach ( $top_schools as $sch_obj )
						{
							
							
								if( $sch_obj -> logo == ''  || $sch_obj -> logo == null ){ $logo = url('/css/img/nologo.png') ;  }
								else{  $logo =  'https://www.expatsschools.com/secure_admin/media/images/logos/' .  $sch_obj -> logo ;  }
		
						?>
                        
                        
                        
                        <div class="follow-it">
                            <a href="<?php echo url('/school/'.  $sch_obj -> url ) ;  ?>" class="logo-thumb"><img src="<?php echo $logo;?>" alt="<?php echo $sch_obj -> name;?>"><h4><?php echo $sch_obj -> name;?></h4></a>
                        </div>
                        <?php
						
							}
						?>
                        <h5 class="d-none">Recommended Teachers</h5>
                        <div class="follow-it teacher d-none">
                            <a href="" class="logo-thumb"><img src="{{ asset('css/img/teacher-03.jpg') }}" alt=""><h4>Rubie Rueda</h4></a>
                            <a href="" class="btn btn-sm btn-outline-primary">Follow</a>
                        </div>
                        <div class="follow-it teacher d-none">
                            <a href="" class="logo-thumb"><img src="{{ asset('css/img/teacher-02.jpg') }}" alt=""><h4>Terry Stever</h4></a>
                            <a href="" class="btn btn-sm btn-outline-primary">Follow</a>
                        </div>
                        <div class="footer">
                            <a href="{{ url('/about') }}">About</a> <span>·</span>
                            <a href="{{ url('/help') }}">Help Center</a> <span>·</span>
                            <a href="{{ url('/privacy') }}">Privacy Policy</a> <span>·</span>
                            <a href="{{ url('/terms') }}">Term &amp; Conditions</a> <span>·</span>
                            <a href="{{ url('/about') }}">More</a>
                            <small>© <?php echo date('Y');?>. All Rights Reserved.</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row d-none">
                <div class="col-12 text-center">
                    <a href="" class="btn btn-sm btn-secondary">Load more...</a>
                </div>
            </div>
        </div>
    </main>
    
    <div class="modal fade" id="uiLikeDailog2" tabindex="-1" role="dialog" aria-labelledby="uiContactLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uiMesssageLabel">Newsfeed will be live soon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
      <h2>Coming Soon. Hold on...</h2>
      </div>
      <div class="modal-footer">
        <button type="button"  data-dismiss="modal" aria-label="Close" class="btn btn-primary modal-btn modal-btn-action   go  ">Close</button>
      </div>
    </div>
  </div>
</div>
    
    <div class="modal fade" id="uiLikeDailog" tabindex="-1" role="dialog" aria-labelledby="uiContactLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uiMesssageLabel">See who liked this post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
      <div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>
       <ul class="like_items"></ul>
      </div>
      <div class="modal-footer">
        <button type="button"  data-dismiss="modal" aria-label="Close" class="btn btn-primary modal-btn modal-btn-action   go  ">Close</button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="uiDeleteDailog" tabindex="-1" role="dialog" aria-labelledby="uiContactLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
      <p>Are you sure to delete this comment?</p>
      </div>
      <div class="modal-footer">
        <button type="button"   class="btn btn-primary js_delete_action_comment modal-btn modal-btn-action   go  ">Delete</button>
        <button type="button"  data-dismiss="modal" aria-label="Close" class="btn btn-primary modal-btn modal-btn-action   go ">Close</button>

      </div>
    </div>
  </div>
</div>

