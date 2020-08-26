
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
 //ranches-primary-school-1538734489

 ?>
 
 <header>
        <div class="container edge">
            <div class="row no-gutters">
                <div class="col-12 col-md-2 align-self-end">
                    <a href="<?php echo url('/'. $school_profile -> url );?>" class="logo"><img src="<?php echo $logo;?>" alt="<?php echo $school_profile -> name;?>"></a>
                </div>
                <div class="col-12 col-md-7 align-self-end">
                    <h1 class="js_school_name"><?php echo $school_profile -> name;?> 
                    
                    <input type="hidden" id="domain_email" value="<?php echo $school_profile -> domain_email;?> " />
                    <input type="hidden" id="js_school_name" value="<?php echo $school_profile -> name;?> " />
                    </h1>
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

<nav class="sticky">
	<span class="menu js_open_nav" ><svg class="icon icon-menu"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-menu"></use></svg>School Navigation</span>
  <ul id="nav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    <li class="current"><a href="#profile">Profile</a> </li>
    <li><a href="#gallery">Galleries</a> </li>

    <?php
	 if( $school_profile  -> url == 'ranches-primary-school-1538734489' )
	 {
		 ?>
         <li><a  class="go_new" href="<?php echo url( 'school/news-events/' .$school_profile  -> url ) ;?>">Social Media</a> </li>
         <?php
	 }
	
 ?>
      <li><a href="#news">News &amp; Event</a> </li>
    <li><a href="#admission">Admission &amp; Fees</a> </li>
    <li><a href="#job">Jobs</a> </li>
    <li><a  class="recommendation"	href="">Recommendation</a> </li>
     <li><a href="#staff">Staff</a> </li>
  </ul>
</nav>
<div id="canvas_nav" class="overlay" ></div>
<main class="school_profile">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-3 col-left">
        <div class="frame">
        <?php
		if( $school_profile -> principal_name !=  '' ) {?>
         <h2>Leadership</h2>
         <p> <?php echo $school_profile -> principal_name;?></p>
         <?php  } ?>
          <h2>Contact</h2>
          <p><svg class="icon icon-room">
            <use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-room"></use>
            </svg> <?php echo $school_profile -> address;?></p>
          <p><svg class="icon icon-phone">
            <use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-phone"></use>
            </svg>  <?php echo $school_profile -> phone;?></p>
          <p><svg class="icon icon-mail_outline">
            <use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-mail_outline"></use>
            </svg> <a href="mailto:<?php echo $school_profile -> email;?>"><?php echo $school_profile -> email;?></a></p>
          <img src="https://maps.googleapis.com/maps/api/staticmap?center=Dubai&zoom=13&size=365x180&maptype=roadmap&markers=color:red%7Clabel:S%7C<?php echo $school_profile -> latitude;?>,<?php echo $school_profile -> longitude;?>&key=AIzaSyB_O3eana1MbjibnAWKwIg7cPCHXQ-8fN4" alt="School Map" class="img-fluid">
           <p class="text-center"><a href="" class="js_large_map">Enlarge Map</a></p>
          
          
           </div>
           
           
           <?php
				
				if(  $school_profile -> admission_email != '' &&  $school_profile -> admission_email != null  )
				{	   
		   ?>
           
           <div class="frame contact-buyer">
                        <h3>Contact Admissions:</h3>
                        <form>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Parent's Email</label>
                                    <input type="email" class="form-control" id="js_profile_email" placeholder="">
                                    <input id="email_sent" type="hidden" value="<?php echo $school_profile -> admission_email;?>" />
                                </div>
                            </div>
                            
                            
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="">Parent's Full Name</label>
                                    <input type="text" class="form-control" id="js_profile_name" placeholder="">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Child's Name</label>
                                    <input type="email" class="form-control" id="js_profile_child_name" placeholder="">
                                </div>
                            </div>
                            
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Message</label>
                                    <textarea class="form-control" style="height:200px;" id="js_profile_msg"></textarea>
                                </div>
                            </div>
                        </form>
                        <p class="alert alert-primary ">By clicking on 'Send', I agree to the Expats' School <a target="_blank" href="{{ asset('terms')  }}">Terms & Conditions</a> and <a  target="_blank" href="{{ asset('privacy')  }}">Privacy Policy</a></p>
                        <p class="alert alert-success d-none js_status_mssg"></p>
                        <a id="js_enquiry_2" href="" class="btn btn-sm btn-primary">Send</a>
                    </div>
	      
     	<?php
				}
		?>
      </div>
      <div class="col-12 col-md-9 col-right ">
        <div class="frame" id="welcome">
          <h2>Welcome</h2>
          
          <?php
		  
		    $desc = $school_profile -> description;
		    $desc_html = '';
			$short_desc = strip_tags( $desc );
			
			if( strlen($short_desc) > 400 )
			{
				$short_desc = substr( $short_desc, 0, 400);
				$desc_html .= '<div class="short-desc">'.  $short_desc .'</div>';
				$desc_html .= '<div class="long-desc d-none">'.  $desc .'</div>';
				$desc_html .= '<p class="text-center more-text"> <a href="" class="js_more"><span>More </span>   <i class="glyphicon glyphicon-chevron-down"></i></a></p>';
			}
			else
			{
				$desc_html .= '<div class="short-desc">'. $short_desc .'</div>';
			}
	
		  echo $desc_html;
		  ?>
		
            </div>
            
       <?php
		if( $school_profile -> video !=  '' )
		{
			$video =  explode('?v=', $school_profile -> video );
			if( isset ( $video[1] ) )
			{
			$video = $video[1];
		?>      
            
            <div class="frame" id="video">
         	 <h2>School Video</h2>
             <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video;?>?rel=0" allowfullscreen></iframe>
            </div>
       		</div>
            
            
         <?php } } ?>
            
            
            
            
        <div class="frame" id="profile">
          <h2>Profile</h2>
          <ul class="data-type">
            <li><strong>School type</strong><span> <?php echo $school_profile -> school_type;?></span></li>
            <li><strong>Ages taught</strong><span><ul>
			<?php 
			
			$ages_taught =  explode(',', $school_profile -> ages_taught);
			
			foreach( $ages_taught as $ages_taught_o )
			{
			?>
			
            <li><?php echo $ages_taught_o;?></li>
            <?php } ?>
            		
            </ul>
            </span>
            
            </li>
            <li><strong>School Size</strong><span><?php echo $school_profile -> boy_size;?> boys  <?php echo $school_profile -> girl_size;?> girls</span> </li>
            <li><strong>Curriculums</strong><span><?php echo $school_profile -> curriculums;?></span> </li>
            <li><strong>Day and Boarding</strong><span><?php echo $school_profile -> day_boarding;?></span> </li>
           <?php if ( $school_profile -> key_features != '' ) {?> <li><strong>Key features</strong><span><?php echo $school_profile -> key_features;?></span> </li>
			<?php } ?>
          </ul>
          <ul class="d-none">
            <li><strong>School type</strong><span>Co-educational</span> </li>
            <li><strong>Ages taught</strong><span>3 - 18</span> </li>
            <li><strong>School Size</strong><span>1,222 boys 1,145 girls</span> </li>
            <li><strong>Curriculums</strong><span>English National Curriculum<br>
              International Primary Curriculum</span> </li>
            <li><strong>Day\Boarding</strong><span>Day<br>
              Full Boarding<br>
              Flexi Boarding</span> </li>
          </ul>
        </div>
        
          <?php  if( $school_albums -> count() > 0 ) { ?>
        <div class="frame" id="gallery">
                        <h2>Galleries</h2>
                        <div class="owl-carousel owl-theme owl-gallery">
			<input type="hidden" id="gallery_count" value="<?php echo $school_albums -> count(); ?>"  />

                            <?php
								
								foreach( $school_albums as $album_o )
								{
									
									$cover_image = 'https://www.expatsschools.com/secure_admin/media/images/school_albums/'. $album_o -> cover_image;
								
							?>
                            <div class="item">
                                <a href="<?php echo url('/albums/'.$school_profile -> url . '/'. $album_o -> url  );?>"><img src="<?php echo $cover_image;?>" alt="<?php echo $album_o -> headline;?>"></a>
                                 <h3><a href="<?php echo url('/albums/'.$school_profile -> url . '/'. $album_o -> url  );?>"><?php echo $album_o -> headline;?></a></h3>
                                 <small><?php echo date('M d,Y', strtotime( $album_o -> dated) );?></small>
                            </div>
                            
                            
                            <?php } ?>
                           
                        </div>
                    </div>
         <?php  } ?>
         
         <?php  if( $school_news -> count() > 0 ) { ?>
         <div class="frame" id="news">
                        <h2>News &amp; Events</h2>
                        <div class="owl-carousel owl-theme owl-news">
                        <input type="hidden" id="news_count" value="<?php echo $school_news -> count(); ?>"  />
                            <?php
								
								foreach( $school_news as $news_o ){
									if( $news_o -> photo  == '' )
									{
										$image = url('/css/img/image-01.jpg');
									}
									else
									{
										$image = url('/articles/'. $news_o -> photo  );
									}
									
							?>
                           
                            <div class="item">
                                <a href="<?php echo url('/post/'.$news_o -> id . '/'. $news_o -> url  );?>"><img src="<?php echo $image;?>" alt=""></a>
                                <h3><a href="<?php echo url('/post/'.$news_o -> id . '/'. $news_o -> url  );?>"><?php echo $news_o -> title;?></a></h3>
                                <small><?php echo date('M d,Y', strtotime( $news_o -> dated) );?></small>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
        
        <?php } ?>
        
        
        
        
        
        
        
        
        
        
        
        <div class="frame" id="admission">
          <h2>Admission &amp; Fees</h2>
          <h2 class="title">Year 2018-2019</h2>
          <div class="table-responsive">
            <table class="table  table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">Stage</th>
                  <th scope="col">Fee (Annual)</th>
                  <th scope="col">Enrolled Students</th>
                  <th   scope="col">Open/Waiting List</th>
                   <th   scope="col">Classes</th>
                </tr>
              </thead>
              <tbody>
               
               <?php
			   foreach( $year1 as $obj ){
			   ?>
               
                <tr>
                  <th scope="row"><?php echo $obj -> stage;?></th>
                  <td><?php echo $obj -> fee;?></td>
                  <td><?php echo $obj -> students;?></td>
                    <td><?php echo $obj -> availability;?></td>
                     <td><?php echo $obj -> classes;?></td>
                   
                </tr>
                <?php  } ?>
              </tbody>
            </table>
          </div>
          
          <div class="next_year">
          <h2 class="title">Year 2019-2020</h2>
          <?php
		  	
			if( $year2 -> count() == 0 )
			{
				?>
                <h2>No information found.</h2>
                <?php
			}
			else
			{
		  ?>
          <div class="table-responsive">
            <table class="table  table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">Stage</th>
                  <th scope="col">Fee (Annual)</th>
                  <th scope="col">Enrolled Students</th>
                  <th   scope="col">Open/Waiting List</th>
                   <th   scope="col">Classes</th>
                </tr>
              </thead>
              <tbody>
               
               <?php
			   foreach( $year2 as $obj ){
			   ?>
               
                <tr>
                  <th scope="row"><?php echo $obj -> stage;?></th>
                  <td><?php echo $obj -> fee;?></td>
                   <td><?php echo $obj -> students;?></td>
                    <td><?php echo $obj -> availability;?></td>
                     <td><?php echo $obj -> classes;?></td>
                 
                </tr>
                <?php  } ?>
              </tbody>
            </table>
          </div>
          
          <?php } ?>
          
        </div>
        
        
        <div class="next_year">
          <h2 class="title">Year 2020-2021</h2>
          <?php
		  	
			if( $year3 -> count() == 0 )
			{
				?>
                <h2>No information found.</h2>
                <?php
			}
			else
			{
		  ?>
          <div class="table-responsive">
            <table class="table  table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">Stage</th>
                  <th scope="col">Fee (Annual)</th>
                  <th scope="col">Enrolled Students</th>
                  <th   scope="col">Open/Waiting List</th>
                   <th   scope="col">Classes</th>
                </tr>
              </thead>
              <tbody>
               
               <?php
			   foreach( $year3 as $obj ){
			   ?>
               
                <tr>
                  <th scope="row"><?php echo $obj -> stage;?></th>
                  <td><?php echo $obj -> fee;?></td>
                   <td><?php echo $obj -> students;?></td>
                    <td><?php echo $obj -> availability;?></td>
                 <td><?php echo $obj -> classes;?></td>
                </tr>
                <?php  } ?>
              </tbody>
            </table>
          </div>
          
          <?php } ?>
          
        </div>
        
        
        
        </div>
        
        
         <?php
		if( $school_uniform -> count() > 0 ) { ?>
        <div class="frame" id="job">
          <h2>Uniform</h2>
          <div class="table-responsive">
            <table class="table  table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">Link</th>
                  <th scope="col">Price</th>
                
                </tr>
              </thead>
              <tbody>
              
              <?php
			  
					foreach( $school_uniform as $obj )
					{		  
			  ?>
                <tr>
                 
                  <td><a target="_blank" href="<?php echo  $obj -> link_to ;?>">View Detail</a></td>
               <td scope="row">AED<?php echo $obj -> cost;?></td>
              
                </tr>
              
              
              <?php
					}
				?>
              </tbody>
            </table>
          </div>
        </div>
        
        <?php } ?>
        
        
       <?php
		if( $jobs -> count() > 0 ) { ?>
        <div class="frame" id="job">
          <h2>Jobs</h2>
          <div class="table-responsive">
            <table class="table  table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">Position</th>
                  <th scope="col">Experience</th>
                  <th scope="col">Last Date</th>
                  <th scope="col">Details</th>
                </tr>
              </thead>
              <tbody>
              
              <?php
			  
					foreach( $jobs as $obj )
					{		  
			  ?>
                <tr>
                  <td scope="row"><?php echo $obj -> title;?></th>
                  <td><?php echo $obj -> experience;?></td>
                  <td><?php echo  date('d-m-Y', strtotime($obj -> apply_before) );?></td>
                  <td><a href="<?php echo url('/jobs/'.$school_profile -> url . '/'. $obj -> url  );?>">View Detail</a></td>
                </tr>
              
              
              <?php
					}
				?>
              </tbody>
            </table>
          </div>
        </div>
        
        <?php } ?>
        
        <?php
		if( $school_reviews -> count() > 0 ) { ?>
		
        <div class="frame" id="recommend">
          <h2>Recommendation</h2>
          <div class="owl-carousel owl-theme owl-recommend">
           
           
            <?php
			  		//p( $school_reviews ); 
					foreach( $school_reviews as $obj )
					{		  
			  ?>
            <div class="item">
              <div class="recommend"> <img src="{{ asset('css/img/user-05.png') }}" alt=""> <strong>Jennifer Rappoport</strong> <small><?php echo date('M d, Y', strtotime( $obj -> date_added ) );?></small>
                <p><?php echo $obj -> text;?></p>
              </div>
            </div>
            
            <?php } ?>
            
            
            
            
          </div>
        </div>
        <?php } ?>
        <input type="hidden" id="rec_cnt" value="<?php echo  $school_reviews -> count()  ;?>"  />
        
        
        <div class="frame" id="staff">
        
             <div class="requested js_staff_container">
                <h3>Staff</h3>
                <div class="requests row"></div>
             </div>
        
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

