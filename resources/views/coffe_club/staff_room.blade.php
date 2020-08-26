

    <main class="two-cloumn coffe-club">
            <div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

<div class="only-mobile">
  	  <div class="text-center mg-bottom-20">
      	<button class="btn btn-sm  js_slide_staffroom_filters btn-primary" type="button"><span class="glyphicon  glyphicon-filter"></span>  Filters</button>
   	</div>
</div>
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-3 col-left js_filters_left">
                    <div class="frame cafe-sort filters desktop-filters   js_staff_room_filter" >
                       
                        
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    
                   <div class="requested d-none js_connection_container">
                      <h3>Connection Suggestions</h3>
                      <a href="">View all suggestions</a>
                      <div class="owl-carousel owl-theme requests">
                       
                       
                        
                        
                      </div>
                    </div> 
						<div class="requested d-none">
                        <h3>Follow Requests</h3><a href="">View all requests</a>
                        <div class="owl-carousel owl-theme requests">
                            <div class="item">
                                <div class="user-card">
                                    <a href="" class="decline"><svg class="icon icon-close"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-close"></use></svg></a>
                                    <a href=""><img src="{{ asset('css/img/teacher-05.jpg') }}" alt=""></a>
                                    <span>
                                        <strong>Rossie Fisler</strong>
                                        <small>Junior Teacher</small>
                                    </span>
                                    <a href="" class="btn btn-sm btn-primary"><svg class="icon icon-check"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-check"></use></svg> Accept</a>
                                </div>
                            </div>
                            <div class="item">
                                <div class="user-card">
                                    <a href="" class="decline"><svg class="icon icon-close"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-close"></use></svg></a>
                                    <a href=""><img src="{{ asset('css/img/teacher-04.jpg') }}" alt=""></a>
                                    <span>
                                        <strong>Rossie Fisler</strong>
                                        <small>Junior Teacher</small>
                                    </span>
                                    <a href="" class="btn btn-sm btn-primary"><svg class="icon icon-check"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-check"></use></svg> Accept</a>
                                </div>
                            </div>
                            <div class="item">
                                <div class="user-card">
                                    <a href="" class="decline"><svg class="icon icon-close"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-close"></use></svg></a>
                                    <a href=""><img src="{{ asset('css/img/teacher-03.jpg') }}" alt=""></a>
                                    <span>
                                        <strong>Rossie Fisler</strong>
                                        <small>Junior Teacher</small>
                                    </span>
                                    <a href="" class="btn btn-sm btn-primary"><svg class="icon icon-check"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-check"></use></svg> Accept</a>
                                </div>
                            </div>                            
                        </div>
                    </div>



                    <!--/new-post-->
					
                    <div class="js_staff_listing">
                    
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
            
            
            
            
            <div class="row load-more-container d-none">
                <div class="col-12 text-center">
                    <a href="" class="btn btn-sm btn-secondary">Load more...</a>
                </div>
            </div>
            
        </div>
    </main>



<div class="modal fade" id="uiMsgDailog" tabindex="-1" role="dialog" aria-labelledby="uiContactLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uiMesssageLabel">Write your message here</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
       	
         <div class="form-group  row">
            <label for="" class="col-12 col-form-label">Message</label>
            <div class="col-12">
                <textarea style="height:200px;" class="form-control" id="chat_messsage"></textarea>
                <p><small>Check the response of your message in inbox. Access your inbox from top menu.</small></p>
                <p class="js_response_to_msg  d-none alert alert-success"></p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary modal-btn modal-btn-action  js_send_msg  go modal-btn-padding-extended ">Send Message</button>
      </div>
    </div>
  </div>
</div>


