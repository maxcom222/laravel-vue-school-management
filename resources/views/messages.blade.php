<input type="hidden" id="friend_id" />
 <input type="hidden" value="inbox" id="current_page" />
  <input type="hidden" value="user" id="message_type" />

<header></header>
 
     <main class="two-cloumn   es-inbox">
        <div class="container">

            <div class="row">
                
                <div class="col-12 col-md-9">                    
                    <div class="inbox">
                    	
					<div class="tab-in">
							<div  data-i="user" class="js_in_tab  inbox-tabs active">Friends</div>
								<div  data-i="school" class="js_in_tab  inbox-tabs ">Schools</div>
                                 <div class="contacts">
                        		</div><!--contacts-->
					</div>
                       
                        <div class="chat">
                            <div class="chat-user"></div>
                            <div class="chat-bg"></div>
                            <div class="send-msg">
                                <textarea name="" id="chat_messsage" placeholder="Type your message here..."></textarea><button type="button" class="js_send_message"><svg class="icon icon-send"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-send"></use></svg> Send</button>
                            </div><!--send-msg-->
                        </div><!--chat-->
                    </div><!--inbox-->
                </div>

                <div class="col-12 col-md-3 col-right help_topics_inbox">
                    <div class="frame recommendations">
                        <h5>Help Topics</h5>
                        <div class="pop-question">
                            <a href="">Who endorses nominations in the principal and school award categories?</a>
                        </div>
                        <div class="pop-question">
                            <a href="">Do the WA Education Awards provide travel and accommodation to nominators who wish to attend the awards ceremony?</a>
                        </div>
                        <div class="pop-question">
                            <a href="">Can representatives of a school council/board or parents and citizens’ association prepare a nomination?</a>
                        </div>
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

<div class="modal fade" id="uiMessageDailog" tabindex="-1" role="dialog" aria-labelledby="uiModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uiMessageLabel">No messages found.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <p>You can send messages by visiting the profile of a person.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default modal-btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
