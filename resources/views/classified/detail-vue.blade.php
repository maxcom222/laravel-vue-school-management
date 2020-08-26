


<?php
    $profile_photo = url( '/css/img/user-img.png' );

	if( $result -> profile_photo != '' )
	{
		
		if( $result -> profile_photo_custom == 1 )
		{
			$profile_photo = 'https://d2heijv3bffmsx.cloudfront.net/'.  $result -> profile_photo  ;
		}
		else
		{
			$profile_photo =  $result -> profile_photo;
		}
	}
	
	$cover_image			 = url('/classifieds/'.  $result -> cover_image );

$ages_arr = array();
$ages_arr[1] = 'Brand New';
$ages_arr[2] = '0-1 month';
$ages_arr[3] = '1-6 months';
$ages_arr[4] = '6-12 months';
$ages_arr[5] = '1-2 years';
$ages_arr[6] = '2-5 years';
$ages_arr[7] = '5-10 years';
$ages_arr[8] = '10+ years';




//echo  array_search('0-1 month', $ages_arr);

//exit;




$condition_arr =array();
$condition_arr[1] = '';
$condition_arr[5] = 'Perfect inside and out</option>';
$condition_arr[4] = 'Almost no noticeable problems or flaws</option>';
$condition_arr[3] = 'A bit of wear and tear, but in good working condition</option>';
$condition_arr[2] = 'Normal wear and tear for the age of the item, a few problems here and there</option>';
$condition_arr[1] = 'Above average wear and tear.  The item may need a bit of repair to work properly</option>';



$usage_arr = array();
$usage_arr[1] = 'Still in original packaging';
$usage_arr[2] = 'Out of original packaging, but only used once';
$usage_arr[3] = 'Used only a few times';
$usage_arr[4] = 'Used an average amount, as frequently as would be expected';
$usage_arr[5] = 'Used an above average amount since purchased';
$icon = url('/css/img/12mpicon.png');


$map_url = 'http://maps.googleapis.com/maps/api/staticmap?zoom=15&size=637x440&maptype=roadmap&markers=icon:'. $icon.'|'. $result -> latitude.','. $result -> longitude.'&key=AIzaSyB_O3eana1MbjibnAWKwIg7cPCHXQ-8fN4';



?>


    <main class="two-cloumn">

        <div class="container">

            <div class="row">

                <div class="col-12 col-md-3 col-left">
                    
                         <div class="map">

                            <img src="<?php echo $map_url;?>" class="img-fluid" alt="google map">

                            <p><strong>Location</strong> <?php echo $result -> address;?></p>

                            <p><a href="https://www.google.com/maps/dir/?api=1&origin=<?php echo str_replace(' ','+', $result -> address  );?>" target="_blank">Get Directions</a></p>

                         </div>
                    
                </div>
                
                <div class="col-12 col-md-6">

                    <div class="feed ad">

                        <a href="" class="dp"><img src="<?php echo $profile_photo;?>" alt="<?php echo $result -> first_name.' '. $result -> last_name;?>"></a>

                        <div>

                            <a href="" class="publisher"><?php echo $result -> first_name.' '. $result -> last_name;?></a>

                            <span class="text-muted"> posted</span>

                            <h2><a href=""><?php echo $result -> title ;?></a></h2>

                            <span class="text-muted">in</span> <span class="posted-in"><?php echo $result -> text ;?></span>

                            <small class="text-muted"><?php echo date('M d, Y', strtotime ( $result -> dated ));?></small>

                        </div>

                        <p><?php echo $result -> description;?></p>

                        <div class="item-detail">

                            <p><strong>Age</strong> <span><?php echo $result -> ages ;?></span></p>

                            <p><strong>Usage</strong> <span><?php echo $result -> usage  ;?></span></p>

                            <p><strong>Condition</strong> <span><?php echo $result -> conditions;?></span></p>

                            <p><strong>Warranty</strong> <span><?php echo $result -> warranty;?></span></p>

                        </div>

                        <a href="" class="featured"><img src="<?php echo $cover_image;?>" alt="" class="img-fluid"></a>

                    </div>



                    <adreply-component

                            :ad-item="{{ json_encode($result) }}"

                            :full-path="fullPath">

                    </adreply-component>


                    
                </div>


                <div class="col-12 col-md-3 col-right">

                    <detailside-component

                            :ad-item="{{ json_encode($result) }}"

                            :full-path="fullPath">

                        >
                    </detailside-component>



                </div>
            </div>
            
        </div>
    </main>






