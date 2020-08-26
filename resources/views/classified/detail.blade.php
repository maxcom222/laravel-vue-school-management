
<?php
    $profile_photo = url( '/css/img/user-img.png' );
	if( $result -> profile_photo != '' )
	{
		
		if( $result -> profile_photo_custom == 1 )
		{
			$profile_photo = url('/user_profiles/'. $result -> profile_photo ) ;
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
                            <p><strong>Age</strong> <span><?php echo $ages_arr[$result -> ages]  ;?></span></p>
                            <p><strong>Usage</strong> <span><?php echo $usage_arr[$result -> usage] ;?></span></p>
                            <p><strong>Condition</strong> <span><?php echo $condition_arr[$result -> conditions];?></span></p>
                            <p><strong>Warranty</strong> <span><?php echo $result -> warranty;?></span></p>
                        </div>
                        <a href="" class="featured"><img src="<?php echo $cover_image;?>" alt="" class="img-fluid"></a>
                    </div>

                    <div class="frame contact-buyer">
                        <h3>Reply to this Ad:</h3>
                        <form>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" id="js_ad_email" placeholder="">
                                    <input type="hidden" class="form-control" value="<?php echo $result -> email;?>" id="js_rec_email">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" id="js_ad_name" placeholder="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Phone</label>
                                    <input type="text" class="form-control" id="js_ad_phone" placeholder="">
                                    <input type="hidden" id="cid" value="<?php echo $result -> id;?>" />
                                  </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="">Message</label>
                                    <input type="hidden" id="ad_link" value="<?php echo $result -> url;?>" />
                                    <textarea class="form-control" style="height:200px;" id="js_ad_msg"></textarea>
                                </div>
                            </div>
                        </form>
                        <p class="alert alert-primary ">By clicking on 'Send Reply', I agree to the Expats' School Terms & Conditions and Privacy Policy</p>
                        <p class="alert alert-success d-none js_status_mssg"></p>
                        <button class="btn btn-sm btn-primary js_reply">Send Reply</button>
                    </div>
                    
                </div>
                <div class="col-12 col-md-3 col-right">
                    <div class="frame item-opt">
                        <em><?php echo $result -> price;?></em>
                        <p class="d-none ph"><?php echo $result -> phone_number;?></p>
                        <a href="" class="btn btn-sm btn-primary show_phone_number"><svg class="icon icon-phone"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-phone"></use></svg> Show Phone</a>
                        <a href="" class="btn btn-sm btn-outline-primary js_fav  d-none "><svg class="icon icon-favorite"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-favorite"></use></svg> Watchlist</a>
                        <a href="" data-id="<?php echo $result -> id;?>" data-title="<?php echo $result -> title;?>" class="btn btn-sm btn-outline-secondary js_ad_flag  report_ad"><svg class="icon icon-flag"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-flag"></use></svg> Report Ad</a>
                    </div>
                   
                    <div class="frame recommendations">
                        
                        <div class="footer">
                            <a href="{{ asset('about') }}">About</a> <span>·</span>
                            <a href="{{ asset('help') }}">Help Center</a> <span>·</span>
                            <a href="{{ asset('privacy') }}">Privacy Policy</a> <span>·</span>
                            <a href="{{ asset('term') }}">Term &amp; Conditions</a> <span>·</span>
                            <small>© <?php echo date('Y');?>. All Rights Reserved.</small>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </main>


<div class="modal fade" id="uiReportDailog" tabindex="-1" role="dialog" aria-labelledby="uiContactLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uiContactLabel">Flag an item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
       	 <p class="lead">Provide as much information you can.</p>
         <div class="form-group  row">
            <label for="" class="col-12 col-form-label">Ad title</label>
            <div class="col-12">
                <input type="text" value=""  class="form-control" id="report_ad_title" readonly="readonly" >
                <input type="hidden" id="report_ad_id" />
            </div>
        </div>
        
         <div class="form-group  row">
            <label for="" class="col-12 col-form-label">Describe why this ad is inappropriate</label>
            <div class="col-12">
                <textarea style="height:200px;" class="form-control" id="report_reason"></textarea>
            </div>
        </div>
       
        
        
        
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default modal-btn" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary modal-btn modal-btn-action js_submit_report  go ">Submit Report</button>
      </div>
    </div>
  </div>
</div>

