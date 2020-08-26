<footer>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-lg-12 offset-lg-0 newsletter d-none">
                    <p>Subscribe to our newsletter for latest school news and jobs.</p>
                    <form id="newsletter">
                        <div class="input-group">
                            <input type="text" class="form-control js_email" placeholder="Email address">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary js_subscribe_newsletter" type="button">Subscribe</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <a href=""><img src="<?php echo e(asset('css/img/logo-footera.png')); ?>" alt=""></a>
                    <p>Tipping the Balance</p>
                </div>
                   <div class="col-12 col-md-6 col-lg-3"></div>
                      <div class="col-12 col-md-6 col-lg-3 "></div>
                <div class="col-12 col-md-6 col-lg-3">
                    <h4>Sitemap</h4>
                    <ul>

                        <router-link  tag="li" to="/es/about" >
                            <a> About  us </a>
                        </router-link>

                        <router-link  tag="li" to="/es/privacy" >
                            <a> Privacy Policy </a>
                        </router-link>

                        <router-link  tag="li" to="/es/terms" >
                            <a> Term and Conditions </a>
                        </router-link>

                        <router-link  tag="li" to="/es/contact" >
                            <a> Contact </a>
                        </router-link>

                        <router-link  tag="li" to="/schools" >
                            <a> Schools </a>
                        </router-link>

                        <router-link  tag="li" to="/network" >
                            <a> Teachers </a>
                        </router-link>

                        <router-link  tag="li" to="/parents" >
                            <a> Parents </a>
                        </router-link>




                    </ul>
                </div>
                <div class="col-12 col-md-6 col-lg-3 d-none">
                    <h4>Top Destinations</h4>
                    <ul>
                    
                      	 <li><a href="<?php echo e(url('city/dubai')); ?>">Dubai</a></li>
                      	 <li><a href="<?php echo e(url('city/abudhabi')); ?>">Abu Dhabi (coming soon)</a></li>
                       	 <li><a href="<?php echo e(url('city/hongkong')); ?>">Hong Kong (coming soon)</a></li>
                         <li><a href="<?php echo e(url('city/singapore')); ?>">Singapore (coming soon)</a></li>
                         <li><a href="<?php echo e(url('city/beijing')); ?>">Beijing (coming soon)</a></li>
                        
                    </ul>
                </div>
                <div class="col-12 col-md-6 col-lg-3  d-none">
                    <h4>Top Schools</h4>
                    <ul>
                        <li><a href="<?php echo e(url('/school/jumeirah-english-speaking-school-1538370119')); ?>">Jumeirah English Speaking School</a>
                        </li><li><a href="<?php echo e(url('/school/ranches-primary-school-1538734489')); ?>">Ranches Primary School</a></li>
                        <li><a href="<?php echo e(url('/school/foremarke-school-1538383838')); ?>">Foremarke School</a></li>
                        
                         <li><a href="<?php echo e(url('/school/dubai-college')); ?>">Dubai College</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <ul class="social">
                        <li><a		 target="_blank" href=""><svg class="icon icon-twitter"><use xlink:href="#icon-twitter"></use></svg></a>
                        </li><li><a  target="_blank"  href=""><svg class="icon icon-facebook-official"><use xlink:href="#icon-facebook-official"></use></svg></a>
                        </li><li><a  target="_blank" href=""><svg class="icon icon-instagram"><use xlink:href="#icon-instagram"></use></svg></a>
                        </li><li><a  target="_blank" href=""><svg class="icon icon-youtube-play"><use xlink:href="#icon-youtube-play"></use></svg></a>
                        </li>
                    </ul>
                    <p>Copyright <?php echo date('Y') ;?> Expats' Schools. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/es/resources/views/layout/footer.blade.php ENDPATH**/ ?>