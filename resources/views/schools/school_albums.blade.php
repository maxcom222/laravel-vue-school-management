
<?php
	$school_albums = $school_albums[0];
	$school_profile = $school_profile[0];
?>
    <header class="page-title bg-news">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1><?php echo $school_albums -> headline;?></h1>
                    <span>Published: <?php echo date('M d,Y', strtotime( $school_albums -> dated) );?></span>
                </div>
            </div>
        </div>
    </header>

    <div id="myCanvasNav" class="overlay" onClick="closeNav()"></div>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-left">
                    <div class="frame share sticky">
                        <h2>Share this story</h2>
                          <div class="sharethis-inline-share-buttons"></div>
                    </div>
                </div>
                <div class="col-12 col-md-8 col-right">
                    <div class="frame news-article">
                    
                      <div class="owl-carousel owl-theme owl-recommend featured">
                    	<?php if( $school_albums -> cover_image != ''  )
						{ 
							$cover_image = 'https://www.expatsschools.com/secure_admin/media/images/school_albums/'. $school_albums -> cover_image;

						?>
                        <div class="item"> <img src="<?php echo $cover_image;?>" alt="" class="img-fluid featured"></div>
						<?php } 
						
						$hub_images = explode('##', trim($school_albums -> hub_images, '##' ) );
						
						foreach ( $hub_images as $obj )
						{
							if( $obj == '' ) continue;
							$im = 'https://www.expatsschools.com/secure_admin/media/images/school_albums/'. $obj;
						?>
						 <div class="item"><img src="<?php echo $im;?>" alt="<?php echo $school_albums -> headline;?>"></div>
						<?php
						}
						?>
                     
                    </div> 
                     
                     
                     
                     
                     
                     

                        
                        
                        
                        
                        
                        <?php echo $school_albums -> description;?>
                        
                    </div>
                </div>
            </div>
            
        </div>
    </main>

