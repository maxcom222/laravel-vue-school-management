<header style="opacity:0;"></header>
<input  type="hidden" id="s_school_followers"  value="1">

    <main class="two-cloumn">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-3 col-left">
                      @include("layout/settings")
                </div>
                <div class="col-12 col-md-6 js_staff_listing">                    
                    
                   
                    
                    
                </div>

                <div class="col-12 col-md-3 col-right set-help">
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

