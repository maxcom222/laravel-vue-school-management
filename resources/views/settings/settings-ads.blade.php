
<input type="hidden" class="js_ad_page" value="1" />
 <header class="page-title bg-feed">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Settings</h1>
                </div>
            </div>
        </div>
    </header>


    <main class="two-cloumn">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-3 col-left">
                      @include("layout/settings")
                </div>
                <div class="col-12 col-md-6 js_ads_listing">
					<!--  loading ads -->                    
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


