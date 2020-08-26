
<input type="hidden" id="school_listing" value="1" />
<input type="hidden" id="view_on" value="list" />
 <div class="only-mobile school_list_mobile">
	<div class="text-center mg-bottom-20">
	<h1>Schools in Dubai, UAE</h1>
	<span><?php echo $school_count;?> schools</span>
</div>

</div>
 <header class="page-title bg-dubai" style="">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Schools in Dubai, UAE</h1>
                    <span><?php echo $school_count;?> schools</span>
                </div>
            </div>
        </div>
    </header>

    <div id="myCanvasNav" class="overlay" onclick="closeNav()"></div>

    <main class="schools">
    <div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>
    <div class="only-mobile">
  	  <div class="text-center mg-bottom-20">
      	<button class="btn btn-sm  js_slide_filters btn-primary" type="button"><span class="glyphicon  glyphicon-filter"></span>  Filters</button>
      	<button class="btn btn-sm  js_slide_map btn-primary" type="button"><span class="glyphicon  glyphicon glyphicon-map-marker"></span> Map</button>
   	</div>
    </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-10  search_by_text_frm" style="margin:0 auto;">
                    <form class="school-search">
                    <div class="form-group">
                     <select class="custom-select" id="city"><option value="dubai">Dubai</option><option value="united kingdom">United Kingdom</option></select>
                    <select class="custom-select js_area">
                    </select>
                    <div class="input-group">
                    <input type="text" id="js_txt_search" class="form-control js_txt_search" placeholder="School name...">
                    <input type="hidden" class="js_txt_search_hide" name="js_txt_search_hide" />
                    <div class="input-group-append school-search-div">
                    <button class="btn btn-outline-secondary school-search-button js_search_school" type="button">Search</button>
                    </div>
                    </div>
                    </div>
                    </form>

                </div>
            </div>
            <div class="row js_data_container">
                <div class="col-12 col-md-3 col-left">
                    <div class="frame filters accordion desktop-filters  js_school_filter sticky">
                    </div>
                </div>
                <div class="col-12 col-md-6 js_school_listing col-right" >
                </div>
                <div class="col-12 col-md-3 close-map">
                    <div class="map">
                        <img src="https://maps.googleapis.com/maps/api/staticmap?center=Dubai&zoom=13&size=637x440&maptype=roadmap&markers=color:red%7Clabel:S%7C25.135958,55.196242&key=AIzaSyB_O3eana1MbjibnAWKwIg7cPCHXQ-8fN4" class="img-fluid" alt="google map">
                        <p><a href="" class="js_show_map">Map View</a></p>
                    </div>
                </div>
            </div>
            
        </div>
    </main>
    
