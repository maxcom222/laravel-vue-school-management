<header style="opacity:0;"></header>
    <main class="two-cloumn">
    
    <input type="hidden"  id="load_followers" value="1">
    
    
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-3 col-left">
                    
                      @include("layout/settings")
                </div>
                <div class="col-12 col-md-6 js_staff_listing">                    
                    
                   
                    
                    
                </div>

                <div class="col-12 col-md-3 col-right">
                    <div class="frame recommendations set-help">
                       
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

>