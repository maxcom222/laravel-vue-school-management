
<div id="app">
<input type="hidden" id="friend_id" />
 <input type="hidden" value="inbox" id="current_page" />
  <input type="hidden" value="user" id="message_type" />


    <chat-component :full-path="fullPath">


    </chat-component>


</div>

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
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/es/resources/views/messages2.blade.php ENDPATH**/ ?>