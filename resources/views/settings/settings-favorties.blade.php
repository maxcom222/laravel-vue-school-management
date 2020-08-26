<header style="opacity:0;"></header>
    <main class="two-cloumn">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-3 col-left">
                      @include("layout/settings")
                </div>
                <input type="hidden" id="js_fav_page" name="js_fav_page" value="1" />
                <div class="col-12 col-md-6 js_ads_listing">                    
                    
                    
                    
                    
                </div>

                <div class="col-12 col-md-3 col-right">
                    <div class="frame recommendations">
                       
                        <div class="footer">
                            <a href="{{ url('about') }}">About</a> <span>·</span>
                            <a href="{{ url('help') }}">Help Center</a> <span>·</span>
                            <a href="{{ url('privacy') }}">Privacy Policy</a> <span>·</span>
                            <a href="{{ url('terms') }}">Term &amp; Conditions</a> <span>·</span>
                            <small>© <?php echo date('Y');?>. All Rights Reserved.</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>




