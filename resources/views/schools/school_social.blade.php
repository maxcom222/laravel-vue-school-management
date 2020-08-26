<input type="hidden" id="school_id" value="<?php echo $school_profile[0] -> id;?>" />

 <?php
 
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
 
 <header>
        <div class="container edge">
            <div class="row no-gutters">
                <div class="col-12 col-md-2 align-self-end">
                    <a href="<?php echo url('/'. $school_profile -> url );?>" class="logo"><img src="<?php echo $logo;?>" alt="<?php echo $school_profile -> name;?>"></a>
                </div>
                <div class="col-12 col-md-7 align-self-end">
                    <h1 class="js_school_name"><?php echo $school_profile -> name;?> <input type="hidden" id="domain_email" value="<?php echo $school_profile -> domain_email;?> " /></h1>
                    <em><?php echo $school_profile -> motto;?></em>
                    <em><svg class="icon icon-star"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-star"></use></svg>KHDA Rating: <?php echo $school_profile -> rating;?></em>
                </div>
                <div class="col-12 col-md-3 align-self-end">
                    <button data-f="<?php echo $school_profile -> followers ;?>"  data-id="<?php echo $school_profile -> id ;?>"  class="btn school_profile_page js_follow_school  follow">Follow</button>
                    <small class="followers"><?php echo $school_profile -> followers ;?> followers</small>
                </div>
            </div>
            <div class="cover" <?php if( $school_profile -> cover_image != '' ) { $cover_image = 'https://www.expatsschools.com/secure_admin/media/images/covers/'.  $school_profile -> cover_image;   ?> style="background-image:url('<?php echo $cover_image; ?>');     background-size: 100% 100%;"  <?php } else{ ?>   style="background:none;" <?php } ?>><span></span></div>
        </div>
    </header>
<input type="hidden" id="latitude" value="<?php echo $school_profile -> latitude;?>"  />
<input type="hidden" id="longitude" value="<?php echo $school_profile -> longitude;?>"  />

<input type="hidden" id="school_id" value="<?php echo $school_profile -> id;?>"  />

<nav class="sticky">
	<span class="menu js_open_nav" ><svg class="icon icon-menu"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-menu"></use></svg>School Navigation</span>
  <ul id="nav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    <li ><a href="<?php echo url('/school/'. $school_profile -> url );?>#profile">Profile</a> </li>
    <li><a href="<?php echo url('/school/'. $school_profile -> url );?>#gallery">Galleries</a> </li>
     <?php
	 if( $school_profile  -> url == 'ranches-primary-school-1538734489' )
	 {
		 ?>
         <li class="current"><a  class="go_new" href="<?php echo url( 'school/news-events/' .$school_profile  -> url ) ;?>">Social Media</a> </li>
         <?php
	 }
	
 ?>
    <li ><a href="<?php echo url('/school/'. $school_profile -> url );?>#news">News &amp; Event</a> </li>
    <li><a href="<?php echo url('/school/'. $school_profile -> url );?>#admission">Admission &amp; Fees</a> </li>
    <li><a href="<?php echo url('/school/'. $school_profile -> url );?>#job">Jobs</a> </li>
    <li><a  href="<?php echo url('/school/'. $school_profile -> url );?>#recommendation"	>Recommendation</a> </li>
     <li><a href="<?php echo url('/school/'. $school_profile -> url );?>#staff">Staff</a> </li>
  </ul>
</nav>
<div id="canvas_nav" class="overlay" ></div>
<main class="school_profile school_social">
<!--
<div class="only-mobile">
  	  <div class="text-center mg-bottom-20">
      	<button class="btn btn-sm  js_slide_staffroom_filters btn-primary" type="button"><span class="glyphicon  glyphicon-filter"></span>  Filters</button>
   	</div>
</div>
-->

  <div class="container">
    <div class="row">
      <div class="col-12 col-md-3 col-left">
                    <div class="frame cafe-sort filters barrel_o_filters  desktop-filterss js_staff_room_filter" >
                        
                    </div>
                </div>
      
      <div class="col-12 col-md-6 col-right ">
         <div class="js_ajax_dynamic">
                    
                    </div>
                    
      </div>
    </div>
  </div>
</main>

<div class="modal fade" id="mapUIDailog" tabindex="-1" role="dialog" aria-labelledby="logModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logModalLabel"><?php echo $school_profile -> name;?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

      </div>
      <div class="modal-body">
        <div id="enlarge_map" style="height:400px;">
        
        </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

