

<input type="hidden" id="post_id" value="<?php echo $result[0] -> id;?>" />
    <main class="two-cloumn coffe-club">
            <div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

        <div class="container">

            <div class="row">
                <div class="col-12 col-md-9">
                    <div class="js_ajax_dynamic">
                    <?php
					
					$result =  $result[0] ;
					
				
					
					
					if( $result -> uid == 0 )
					{
						
						
						
						$profile_photo = url( '/css/img/user-img.png' );
						if( $result -> logo != '' )
						{
							$profile_photo =  'https://www.expatsschools.com/secure_admin/media/images/logos/' .$result -> logo;
						}
						
						$profile_link = url('/school/'.  $result -> url );
						$description  = $result -> description;
						$post_name 	  = $result -> title;
						$name		  = $result -> name;
					}
					else
					{
						
						
						
						
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
						$css_close = 'style="color:#6c757d;"';
						if( $result -> close_account == 1)
						{
							$css_close = 'style="color:#6c757d;"';
							$profile_link = '#';
						}
						else
						{
							$css_close = '';
							$profile_link = url('/profile/'.  $result -> username );
						}
						
						$description = $result -> body_copy;
						$post_name = $result -> title;
						$name = $result -> first_name.' '.$result -> last_name;
						
					}
					
					
					
					
					$image =  url('/articles/' . $result ->  photo );
					
					$d_none = '';
					if(  $result -> like_counter == 0  &&    $result -> comment_counter  == 0 )
					{
						$d_none = 'd-none';
					}
					
					
					$html = '';
					$html .='<ul class="post_activity_container js_post_activity_container '. $d_none   .'">';
					if( $result ->  like_counter > 0 )
					{
						$html .='<li><a href="" data-id="'.  $result -> id  .'" class="js_like_bootloader"><span>'.  $result -> like_counter  .'</span> Like</a></li>';
					}
					if( $result -> comment_counter > 0 )
					{
						$html .='<li><a href=""  data-id="'.   $result -> id  .'" class="js_comments_bootloader"><span>'.  $result -> comment_counter  .'</span> Comment</a></li>';
					}
					$html .='</ul>';
					?>
                    
                    
                    
                    <div class="feed">
                    	<a href="<?php echo $profile_link;?>" class="dp"><img src="<?php echo $profile_photo;?>" alt="<?php echo $name."'s post" ;?>"></a>
                      	<div>
                        <a href="<?php echo $profile_link;?>" class="publisher" <?php echo $css_close;?>><?php echo $name ;?> </a> <span class="text-muted"> shared</span>
                        <h2><?php echo $post_name;?></h2>
                        <small class="text-muted"><?php echo  $result -> dated;?></small>
                       </div>
						<?php	
								
								if( $result ->  post_type ==  'event' )
								{
									?>
                                    <p>Date: <?php echo date('d-m-Y', strtotime( $result ->  dated) );?> </p>
                                    <p>Time: <?php echo date('H:i A', strtotime( $result ->  timed) );?> </p>
                                    <p>Address: <?php echo  $result ->  address;?> </p>
                                    <?php	
								}
						?>
                        <p><?php echo $description;?></p>

					<?php if( $result ->  photo  != '' ) { ?>
                    
                     	 <img src="<?php echo $image;?>" alt="<?php echo $name ;?>" class="img-fluid">
                        
                    <?php } ?>
                    <?php
						echo $html ;
					?>
                      <ul class="actions">
                        <li><a href=""  data-id="<?php echo $result -> id;?>" class="js_like" class="js_like"><svg class="icon icon-thumb_up"><use xlink:href="<?php echo url('/css/ico/symbol-defs.svg')?>#icon-thumb_up"></use></svg>Like</a></li>
                        <li><a href=""  data-id="<?php echo $result -> id;?>" class="js_comments"><svg class="icon icon-chat_bubble"><use xlink:href="<?php echo url('/css/ico/symbol-defs.svg')?>#icon-chat_bubble"></use></svg>Comment</a></li>
                        <li><button  addthis:url="<?php echo  url()->current();?>" addthis:title="<?php echo $post_name;?>" class="js_share addthis_button"><svg class="icon icon-share"><use xlink:href="<?php echo url('/css/ico/symbol-defs.svg')?>#icon-share"></use></svg>Share</button></li>
                      </ul>
                      <div class="add-comment"><a href=""><img src="" alt="<?php echo $name ;?>"></a>
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="write your comment...">
                          <div class="input-group-append">
                            <button type="button" id="button-addon2"><svg class="icon icon-send"><use xlink:href="<?php echo url('/css/ico/symbol-defs.svg')?>#icon-send"></use></svg></button>
                          </div>
                        </div>
                      </div>
                   
				<?php
               
			    $html  = '';
                if( $result ->  comment_counter > 0 )
				{
					$html .='<p class="text-center"><a class="js_load_comments" data-id="'. $result -> id  .'" href="">view all comments</a></p>';
				}
				echo $html .='<div class="comment-box"></div>';
				?>
                    
                    
                     </div>
                    
                    
                    
                    
                    
                    </div>
                 </div>
                
                
                <div class="col-12 col-md-3 col-right">
                    <div class="frame recommendations js_faq">
                        <div class="footer">
                            <a href="{{ asset('about') }}">About</a> <span>·</span>
                            <a href="{{ asset('help') }}">Help Center</a> <span>·</span>
                            <a href="{{ asset('privacy') }}">Privacy Policy</a> <span>·</span>
                            <a href="{{ asset('terms') }}">Term &amp; Conditions</a> <span>·</span>
                            <small>© <?php echo date('Y');?>. All Rights Reserved.</small>
                        </div>
                    </div>
                </div>
           
            
            
            
          
        </div>
    </main>



