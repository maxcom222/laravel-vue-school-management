
 <?php


 $school_profile  = $data['school_profile'];

 $school_uniform  = $data['school_uniform'];

 $jobs = $data['jobs'];

 $school_reviews = $data['school_reviews'];

 $year1 = $data['year1'];

 $year2 = $data['year2'];

 $year3 = $data['year3'];

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


 //ranches-primary-school-1538734489

 ?>


    <schooldetail-header

            :full-path="fullPath"

            :school-profile="{{ json_encode( $school_profile ) }}"
    >


    </schooldetail-header>



<input type="hidden" id="latitude" value="<?php echo $school_profile -> latitude;?>"  />

<input type="hidden" id="longitude" value="<?php echo $school_profile -> longitude;?>"  />

<detail-nav :url="'{{ json_encode($school_profile -> url)  }}'"  :full-path="fullPath">

</detail-nav>

<div id="canvas_nav" class="overlay" ></div>
<main class="school_profile">
  <div class="container">

    <div class="row">

      <div class="col-12 col-md-3 col-left">

           
           <?php
				
				if(  $school_profile -> admission_email != '' &&  $school_profile -> admission_email != null  )
				{	   
		   ?>


            <schooladmission-component

                :full-path="fullPath"

                :school-profile="{{ json_encode( $school_profile ) }}"
                >


            </schooladmission-component>
	      
     	<?php
				}
		?>
      </div>


      <div class="col-12 col-md-9 col-right ">

          <h2>Leadership: <span style="color:rgba(0, 0, 0, 0.7)"><?php echo $school_profile -> principal_name;?></span></h2>


          <school-welcome

                  :full-path="fullPath"

                  :school-profile="{{ json_encode( $school_profile ) }}"
          >


          </school-welcome>



            
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

            <li>
                <strong>Ages taught</strong>

                <span>

                    <ul>

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

            <div class="requests row">




            <?php


                foreach( $jobs as $obj ){
            ?>

            <div class="item col-md-6 col-sm-6 col-xs-12">


                <div class="user-card">

                    <a href="<?php echo url('/jobs/'.$school_profile -> url . '/'. $obj -> url  );?>">

                        <?php echo $obj -> title;?>
                    </a>

                    <span>

                    <p>Experience:  <?php echo $obj -> experience;?></p>

                    <p>Apply  Before: <?php echo  date('d-m-Y', strtotime($obj -> apply_before) );?></p>


                 </span>


                    <a
                            href="<?php echo url('/jobs/'.$school_profile -> url . '/'. $obj -> url  );?>"

                            class="btn btn-primary"

                    >
                        View Job

                    </a>


                </div>

            </div>



            <?php } ?>


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
        

        <school-staff  :full-path="fullPath"  :school-profile="{{ json_encode( $school_profile ) }}">


        </school-staff>




          <div class="frame" id="contact-info">


              <h2>Contact</h2>

              <p>

                  <svg class="icon icon-room">

                      <use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-room"></use>
                  </svg>

                  <?php echo $school_profile -> address;?>

              </p>

              <p>

                  <svg class="icon icon-phone">
                      <use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-phone"></use>
                  </svg>

                  <?php echo $school_profile -> phone;?>

              </p>

              <p>

                  <svg class="icon icon-mail_outline">
                      <use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-mail_outline"></use>
                  </svg>

                  <a href="mailto:<?php echo $school_profile -> email;?>">

                      <?php echo $school_profile -> email;?>

                  </a>

              </p>

              <img src="https://maps.googleapis.com/maps/api/staticmap?center=Dubai&zoom=13&size=365x180&maptype=roadmap&markers=color:red%7Clabel:S%7C<?php echo $school_profile -> latitude;?>,<?php echo $school_profile -> longitude;?>&key=AIzaSyB_O3eana1MbjibnAWKwIg7cPCHXQ-8fN4" alt="School Map" class="img-fluid">


              <p class="text-center d-none"><a href="" class="js_large_map">Enlarge Map</a></p>


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



