
    <main class="two-cloumn coffe-club">
            <div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

<div class="only-mobile">
  	  <div class="text-center mg-bottom-20">
      	<button class="btn btn-sm  js_slide_staffroom_filters btn-primary" type="button"><span class="glyphicon  glyphicon-filter"></span>  Filters</button>
   	</div>
</div>
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-3 col-left">
                    <div class="frame cafe-sort filters desktop-filters js_staff_room_filter" >
                        
                    </div>
                </div>
                <div class="col-12 col-md-6">
                   
                    <div class="new-post">
                        <ul class="nav" id="posts-tab" role="tablist">
                            <li class="nav-item"><a  id="post-article-tab" data-toggle="pill" href="#post-article" role="tab">Write an Article</a></li>
                            <li class="nav-item"><a class="" id="post-question-tab" data-toggle="pill" href="#post-question" role="tab">Ask a Question</a></li>
                            <li class="nav-item"><a class="" id="post-event-tab" data-toggle="pill" href="#post-event" role="tab">Post an Event</a></li>
                        </ul>
                        <div class="tab-content form-group" id="posts-tabContent">
                            <div class="tab-pane tab-article fade " id="post-article" role="tabpanel">
                                <input name="article_title" placeholder="Headline" class="form-control article_title" id="article_title" style="">
                                <input name="article_short_desc" placeholder="Short Description" class="form-control article_short_desc" id="article_short_desc" style="">
								<label>Write full description below</label>
                                <textarea name="" id="description" class="description" placeholder="Write description of your article here..."></textarea>
                                <input type="hidden" id="ad_article_photos" />
                                <div class="m_dropzone" id="m_dropzone_opt" ></div>
                                <div class="edit_photo d-none">
                                
                                </div>
                                <input name="article_school" placeholder="Tag a school" class="form-control article_school" id="article_school" style="">
                                <button type="button" class="btn btn-sm btn-primary js_article">Publish Article</button>
                            </div>
                            <div class="tab-pane tab-question fade " id="post-question" role="tabpanel">
                                <input name="faq_title" placeholder="What's your question? " class="form-control  school-taginput" id="faq_title" style="">
                                <textarea name="faq_question" id="faq_question" placeholder="Describe your question..."></textarea>
                                <input name="faq_school" placeholder="Tag a school" class="form-control faq_school school-taginput" id="faq_school" style="">
                                <button class="btn btn-sm js_publish_question btn-primary">Publish Question</button>
                            </div>
                            
                            <div class="tab-pane tab-event fade" id="post-event" role="tabpanel">
                                <form>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <input type="text" class="form-control form-control-sm" id="event_title" placeholder="Title">
                                        </div>
                                    </div>
                                    
                                     <div class="form-group row">
                                        <div class="col-12">
                                         <input type="hidden" id="latitude"  />
                                         <input type="hidden" id="longitude"  />
                                         <input type="text" class="form-control form-control-sm" id="event_address" placeholder="Location">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12 col-sm-6">
                                            <input type="date" class="form-control form-control-sm" id="event_date" placeholder="Date">
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <input type="text" class="form-control form-control-sm" id="event_time" placeholder="Time">
                                        </div>
                                        
                                    </div>
                                    
                                     <div class="form-group row">
                                        <div class="col-12 col-sm-12">
                                            <input type="text" class="form-control form-control-sm event_school" id="event_school" placeholder="Tag a school">
                                        </div>
                                   </div>
                                    
                                            

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <textarea name="" id="event_description" placeholder="Description..."></textarea>
                                            <button type="button" class="btn btn-sm btn-primary js_publish_event">Post Event</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--/new-post-->
					
                    <div class="js_ajax_dynamic">
                    
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
           
            
            
            
            <div class="row d-none">
                <div class="col-12 text-center">
                    <a href="" class="btn btn-sm btn-secondary">Load more...</a>
                </div>
            </div>
            
            
            
        </div>
    </main>



<div class="modal fade" id="uiLikeDailog" tabindex="-1" role="dialog" aria-labelledby="uiContactLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uiMesssageLabel">See who liked this post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
      <div class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>
       <ul class="like_items"></ul>
      </div>
      <div class="modal-footer">
        <button type="button"  data-dismiss="modal" aria-label="Close" class="btn btn-primary modal-btn modal-btn-action   go  ">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="uiDeleteDailog" tabindex="-1" role="dialog" aria-labelledby="uiContactLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Delete Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
      <p>Are you sure to delete this post?</p>
      </div>
      <div class="modal-footer">
        <button type="button"   class="btn btn-primary js_delete_action_post modal-btn modal-btn-action   go  ">Delete</button>
        <button type="button"  data-dismiss="modal" aria-label="Close" class="btn btn-primary modal-btn modal-btn-action   go ">Close</button>

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="uiDeleteComment" tabindex="-1" role="dialog" aria-labelledby="uiContactLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Delete Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
      <p>Are you sure to delete this comment?</p>
      </div>
      <div class="modal-footer">
        <button type="button"   class="btn btn-primary js_delete_action_comment modal-btn modal-btn-action   go  ">Delete</button>
        <button type="button"  data-dismiss="modal" aria-label="Close" class="btn btn-primary modal-btn modal-btn-action   go ">Close</button>

      </div>
    </div>
  </div>
</div>

