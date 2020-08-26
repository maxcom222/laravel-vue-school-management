<template>
    <div class="card card-default chat-box" v-if="open">



        <div class="card-header">

            <img :src="this.$parent.profile_image( friend.profile_photo)" alt="profile photo">


            <strong :class="{ 'text-danger': session.block}">

                {{ friend.name }}

                <span v-if="isTyping"> is typing...</span>

                <span v-if="session.block"> (blocked) </span>
            </strong>





            <div class="dropdown float-right  chat-u-options  mr-4">

                    <a  href=""

                       @click.prevent="unblock"

                       v-if="session.block && canUnblock"

                    >Unblock</a>



                    <a  v-if="!session.block" href="" @click.prevent="block">Block</a>

                    <a  href="" @click.prevent="clear">Clear Chat</a>

                    <!-- <a  style="display: none;" href=""  @click.prevent="close" class="">Close</a>
                    -->

            </div>

        </div>

        <div class="card-body" v-chat-scroll>
            <p class="card-text"



               v-for="(chat,index) in chats"

               :key="chat.index"

               :class="{'text-right': chat.type == 0, 'text-success': chat.read_at != null }"


            >
                <span  v-if="chat.message !== null  &&  chat.message !== ''  " :class="{'float-right': chat.type == 0, 'text-success': chat.read_at != null }">

                     {{ chat.message }} <small >{{  chat.read_at  }}</small>

                </span>

                <span  v-if="chat.attachment !== '' &&  chat.attachment !== null " :class="{'float-right': chat.type == 0, 'text-success': chat.read_at != null }">

                <a class="attachment-anchor" :href="imageSource( chat.attachment)" target="_blank">

                    <img class="attachmentImage" :src="imageSource( chat.attachment)"  >

                </a>

                    <!--  <small><time-ago

                           :refresh="60"

                           :datetime="new Date(chat.created_at)"

                   ></time-ago></small>-->

              <small >{{  chat.read_at  }}</small>

                    </span>




            </p>
        </div>

        <div  class="card-footer" @submit.prevent="send">

            <div class="msg-composer">

                <div   v-if="ready_to_upload_files.length === 0" class="msg-composer-attach-left">

                    <svg class="icon icon-upload"><use :xlink:href="icon_upload"></use></svg>

                    <input type="file" ref="file" accept="image/*"    @change="handleFileUpload"     name="file[]">

                </div>
                <span class="msg-composer-section ">

                  <textarea class="msg-composer-area"

                          :disabled="session.block === 1"

                          v-on:keydown.enter.exact.prevent="send"

                          ref="textarea"  v-model="message"

                        >

                    </textarea>

                    <div class="msg-composer-actions">

                         <span
                                 class="emoji-trigger"

                                 :class="{ 'triggered': showEmojiPicker }"

                                 @mousedown.prevent="toggleEmojiPicker"
                         >
                             <svg id="smileEmoji"   style="width:20px;height:20px" viewBox="0 0 24 24" ><path fill="#888888" d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8C16.3,8 17,8.7 17,9.5M12,17.23C10.25,17.23 8.71,16.5 7.81,15.42L9.23,14C9.68,14.72 10.75,15.23 12,15.23C13.25,15.23 14.32,14.72 14.77,14L16.19,15.42C15.29,16.5 13.75,17.23 12,17.23Z" /></svg>

                         </span>

                    <picker

                            v-click-outside="hideEmojiPicker"

                            v-show="showEmojiPicker"

                            title="Pick your emoji"

                            emoji=""

                            @select="addEmoji"
                    />

                    </div>

            </span>





                 <span class="msg-composer-section msg-composer-send">



                        <button :disabled="showImageUpload===false"    @click="send" class="btn-conversation">
                            <svg class="icon icon-send_message"><use :xlink:href="icon_send"></use></svg>
                        </button>

                  </span>

            </div>

            <div class="story-attachments-both">

                <div  class="story-attachment composer-file-attachment">

                    <div class="story-attachment-file composer-file" v-for="(imageData,index) in ready_to_upload_files" >

                        <div class="story-body">

                            <div ng-if="file.previewUrl" class="img-preview">
                               <a  class="image-loader landscape loaded measured">
                                   <img  :src="imageData.image" >
                               </a>
                            </div>


                            <div class="msg-composer-file">

                                <strong>{{  imageData.name  }}</strong>

                                <span class="text-muted">{{  imageSize(imageData.image) }} kb</span>

                                <span class="dash-icon-ok" ng-show="file.status.progress === 100"></span>

                                <span ng-show="file.status.errorMessage" class="msg-composer-file-error ng-hide">

                                  <span class="glyphicon air-icon-exclamation-circle m-0"></span><br>

                                  <span class="file-upload-error"></span>
                            </span>

                            </div>

                            <a class="story-attachment-delete" href="" @click.prevent="deleteAttachment(index)">

                                <svg class="icon icon-delete"><use :xlink:href="icon_delete"></use></svg>

                            </a>

                            <div class="progress-striped msg-composer-file-progress progress ng-hide"

                                 type="success" max="100"

                                 value="file.status.progress">

                                <div class="progress-bar progress-bar-success"

                                      role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"

                                      :style="{ width: ( imageData.progress < 100 ? imageData.progress : 100) + '%' }"
                                >

                                <span ng-transclude="">

                                 </span>
                                </div>

                            </div>

                        </div>

                        <div class="clearfix"></div>


                    </div>


                </div>

            </div>












        </div>


    </div>
</template>

<script>

    import TimeAgo from 'vue2-timeago';

    import { Picker } from 'emoji-mart-vue';

    import ClickOutside from 'vue-click-outside'


    export default {

        name: "MessageComponent",

        props: ['friend',  'fullPath'],

        directives: {

            ClickOutside

        },

        components:  {

            TimeAgo,

            Picker,

            ClickOutside


        },
        data(){

            return {

                chats:[],

                open: true,

                message: '',

                session_block: false,

                authId:  lscache.get('user_data'),

                isTyping: '',

                showEmojiPicker: false,

                icon_upload: this.fullPath + 'css/ico/symbol-defs.svg#icon-upload',

                icon_send: this.fullPath + 'css/ico/symbol-defs.svg#icon-send_message',

                icon_delete: this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

                file: '',

                ready_to_upload_files: [],

                dialog_msg:  false,

                showImageUpload: true,
            }
        },
        computed:{

            session() {

                return this.friend.session;
            },

            unblockReady(){




                if( this.session.block ===  1  && this.canUnblock ===  true  ){


                    return true;

                } else {

                    return false;
                }

            },
            canUnblock() {


                return this.session.blocked_by === this.authId.id;


            },


        },

        watch: {

            message( value )  {

                if( value ) {

                    Echo.private(`Chat.${this.friend.session.id}` )
                        .whisper('typing', {

                            name: 'bilal'
                        });
                }

            },

        },

        methods:{



            hideEmojiPicker(e){

                if(  e.srcElement.id !== 'smileEmoji' ){

                    this.showEmojiPicker = false;

                }

            },
            deleteAttachment(index){


                this.ready_to_upload_files.splice(index, 1);


            },
            imageSize( src ){


                let base64Length = src.length - (src.indexOf(',') + 1);

                let padding = (src.charAt(src.length - 2) === '=') ? 2 : ((src.charAt(src.length - 1) === '=') ? 1 : 0);

                let fileSize = base64Length * 0.75 - padding;

                return  fileSize / 1000;
            },
            imageName(  ){

                let val = this.$refs.file.value;

                let filename = val.split('\\').pop().split('/').pop();

                filename = filename.substring(0, filename.lastIndexOf('.'));

                return  filename;
            },

            uploadServer( indexUpload, file  ){

                let formData = new FormData();

                formData.append('file', file);

                formData.append('window', this.friend.session.id );

                this.showImageUpload = false;

                axios.post( this.fullPath + 'messages/upload_image',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: function( progressEvent ) {

                            this.ready_to_upload_files[indexUpload].progress  = parseInt(progressEvent.loaded / progressEvent.total * 100, 10);

                            if( this.ready_to_upload_files[indexUpload].progress === 100 ){

                                this.ready_to_upload_files[indexUpload].progress  = 90;

                                this.dialog_msg = 'Still uploading... Please wait';

                                this.showImageUpload = false;
                            }

                        }.bind(this)
                    }
                ).then( res  => {

                    this.dialog_msg = 'Your image is uploaded successfully.';

                    this.showImageUpload  = true;

                    this.ready_to_upload_files[indexUpload].name         = res.data.data;

                    this.ready_to_upload_files[indexUpload].upload_path  = res.data.url;

                    this.ready_to_upload_files[indexUpload].progress = 100;



                })
                    .catch(function(){

                        window.alert('There was some error in uploading. Try  again');
                    });
            },

            imageSource( src ){

                return 'https://d2heijv3bffmsx.cloudfront.net/' + src;
            },

            handleFileUpload(){

                    this.file = this.$refs.file.files[0];

                    let reader  = new FileReader();

                    reader.addEventListener("load", function () {

                        //this.showPreview = true;

                        let val = this.$refs.file.value;

                        let filename = val.split('\\').pop().split('/').pop();

                        filename = filename.substring(0, filename.lastIndexOf('.'));

                        let obj = {name: filename, image: reader.result, progress: 0, upload_path: '' };

                        this.ready_to_upload_files.push(  obj );

                        console.log( this.ready_to_upload_files.length - 1 );

                        this.uploadServer( this.ready_to_upload_files.length - 1,  this.file   );


                    }.bind(this), false);

                    /*
                      Check to see if the file is not empty.
                    */
                    if( this.file ){
                        /*
                          Ensure the file is an image file.
                        */
                        //if ( /\.(jpe?g|png|gif)$/i.test( this.file.name ) ) {


                            reader.readAsDataURL( this.file );
                       // }
                    }
                },


            addEmoji (emoji) {

                const textarea = this.$refs.textarea;

                const cursorPosition = textarea.selectionEnd;


                let start = 0;
                let end = 0;

                if( this.message ===  null )
                {
                    start = 0;

                    end = 0;
                } else {

                    start = this.message.substring(0, textarea.selectionStart);

                    end = this.message.substring(textarea.selectionStart);

                }


                this.message   = start + emoji.native + end;

                //this.$emit('input', text);

                textarea.focus();

                this.$nextTick(() => {

                    textarea.selectionEnd = cursorPosition + emoji.native.length

                })
            },

            toggleEmojiPicker () {

                this.showEmojiPicker = !this.showEmojiPicker;

            },

            checkAttachment(){

                if( this.ready_to_upload_files.length >  0 ){

                    if( this.ready_to_upload_files[0].upload_path !==  ''  ){

                        return  true;
                    }

                } else {

                    return false;
                }


            },

            send(){

                this.showEmojiPicker = false;

                    let attachment = '';

                    if( this.ready_to_upload_files.length >  0 ){

                        attachment = this.ready_to_upload_files[0].upload_path;
                    }

                    if( this.message || this.checkAttachment() ) {

                    this.chats.push( {message:this.message, attachment: attachment,  type:0, send_at: 'just now', read_at:null  } );

                    axios.post( this.fullPath + `send_message/${this.friend.session.id}`, {

                        content: this.message,
                        to_user: this.friend.id,
                        attachment: this.ready_to_upload_files,

                    } )
                        .then( res => {

                            this.message = '';

                            this.chats[ this.chats.length - 1].id = res.data;

                            this.ready_to_upload_files =  [];

                            console.log(  this.ready_to_upload_files );
                        });

                }


            },


            getAllMessages() {

                axios.post( this.fullPath + `get_messages/${this.friend.session.id}`, { } )
                    .then( res => {

                        this.chats  = res.data.data;
                    } );


            },


            close() {

                this.$emit('close');
            },


            clear() {

                axios.post( this.fullPath + `session/${this.friend.session.id}/clear`  )
                    .then( res => {

                        this.chats = [];

                    });

            },


            block(){

                this.session.block = 1;



                axios.post( this.fullPath + `session/${this.friend.session.id}/block`  )
                    .then( res => {

                        this.chats = [];


                        this.session.blocked_by = this.authId.id;



                    });


            },


            unblock(){

                this.session.block = 0;

                axios.post( this.fullPath + `session/${this.friend.session.id}/unblock`  )
                    .then( res => {

                        this.chats = [];

                        this.session.blocked_by = null;

                    });



            },
            read() {

                axios.post( this.fullPath + `session/${this.friend.session.id}/read`  );


            }
        },
        created (){


            setTimeout(()=>{

                this.showImageUpload = true;

                document.getElementsByClassName('btn-conversation')[0].removeAttribute('disabled');

                console.log( document.getElementsByClassName('btn-conversation')[0] );


            },  300);

            this.read();
            this.getAllMessages();


            Echo.private( `Chat.${this.friend.session.id}`)

                .listen('PrivateChatEvent', (e) => {

                    if( this.friend.session.open ) {

                        this.read();
                    }

                    this.$parent.changevisibleInWindow( this.friend.id );



                    this.chats.push( {message:e.content, attachment: e.attachment,  type:1, send_at: 'just now'  } );

                });

              Echo.private( `Chat.${this.friend.session.id}`)

                .listen('MsgReadEvent', (e) => {

                    this.chats.forEach( chat => {


                        if( chat.id === e.chat.id ) {

                            chat.read_at = e.chat.read_at;

                            console.log( chat  )

                        }
                    })



                });



            Echo.private( `Chat.${this.friend.session.id}`)

                .listen('BlockEvent', (e) => {


                    let block ;

                    e.blocked === true ? block = 1 : block  = 0;

                    this.session.block =  block;

                    console.log( this.session.blocked_by +  '&&'  +   this.canUnblock  );


                })


            Echo.private( `Chat.${this.friend.session.id}`  )
                .listenForWhisper('typing', (e) => {


                    this.isTyping = true;

                    setTimeout( () => {

                        this.isTyping =  false;

                    }, 4000)
                });




        }
    }
</script>

<style scoped>


    .msg-composer-attach-left {
        display: inline-block;  position: relative;
    }
    .msg-composer-section {
        display: inline-block;
        vertical-align: top;
        padding-left: 0;
        width: calc(100% - 100px);
        position: relative;
    }

    .msg-composer-section.msg-composer-send {
        padding-left: 0px;
        width: auto;
        padding-top: 4px;
    }
    .msg-composer {
        width: 100%;
    }

    .msg-composer-attach-left input[type='file']
    {
        bottom: 0px;
        cursor: inherit;
        height: 50px;
        margin: 0;
        opacity: 0;
        padding: 0;
        position: absolute;
        left: 0;

    }

    .msg-composer-area {

        position: relative!important;
        padding: 10px 12px;
        border: 1px solid #e0e0e0;
        border-radius: 2px;
        height: 44px;
        background-color: #fff; outline: none;
        resize: none;
        width: 100%;
    }

    .msg-composer-actions {
        position: absolute;
        z-index: 2;
        top: 2px;
        right: 10px;
    }

    .story-attachment-file {
        margin-left: 0;
        padding-right: 12px;
        margin-bottom: 5px;
    }

    .story-attachments-both .story-attachment .story-attachment-file {

        background-color: #fff;

        padding: 5px;

        box-shadow: 0 1px 6px rgba(57,73,76,.35);

        margin: 5px 2px;

        border-radius: 2px;
    }

    .story-body {

        margin: 15px 30px 5px;

        min-height: 30px;

        word-wrap: break-word;

        -webkit-transition: background-color .5s linear;

        -o-transition: background-color .5s linear;

        transition: background-color .5s linear;
    }

    .story-attachments-both .story-attachment .story-body {

        margin: 0;

    }

    .story-attachments-both {
        max-height: 150px;
        overflow: auto;
    }


    .msg-composer-file strong {
        max-width: calc(100% - 10px);
        white-space: nowrap;
        display: inline-block;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: middle;
        width: 100%;
    }

    .msg-composer-file {
        float: left;
        width: calc(100% - 88px);
    }

    a.story-attachment-delete {
        float: right;
    }

    .story-attachments-both .story-attachment .story-body .msg-composer-file-progress {
        width: calc(100% - 90px);
        float: left;
        clear: none;
    }
    .image-loader img {
        opacity: 0;
        display: inline-block;
        width: 100%;
        height: 100%;
        -webkit-transition: all .2s ease;
        -o-transition: all .2s ease;
        transition: all .2s ease;
    }
    .image-loader.loaded img {
        opacity: 1;
        -webkit-transition: opacity .2s ease;
        -o-transition: opacity .2s ease;
        transition: opacity .2s ease;

        max-width: 50px;
        max-height: 50px;
        width: 50px;
        height: 12.5px;
    }


    .attachment-anchor{
        width: 360px;
        height: 133px;
        max-width: 360px;
        max-height: 360px;
    }
    .attachment-anchor  img  { width:100%;  height:100%; }


    .btn-conversation{
        border:0; background: transparent;
        cursor: pointer;
    }

    .chat-box {
        height: 400px; margin-bottom: 60px;
    }

    .card-header img {
        width: 32px;
        border-radius: 50%;
        display: inline-block;
        vertical-align: middle;
    }
    .card-body{
        overflow-y:scroll;
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem;
        float: left;
        width: 100%;
    }


    p.card-text span {
        border-bottom-left-radius: 1.25rem;
        border-bottom-right-radius: 1.25rem;
        border-top-left-radius: 1.25rem;
        border-top-right-radius: 1.25rem;
        border-bottom-color: rgb(29, 161, 242);
        border-left-color: rgb(29, 161, 242);
        border-right-color: rgb(29, 161, 242);
        border-top-color: rgb(29, 161, 242);
        background: rgb(29, 161, 242);
        color: #FFF;
        padding: 20px;
        width:300px;
        display:block;
    }
    p.card-text span {
        border-bottom-left-radius: 1.25rem;
        border-bottom-right-radius: 1.25rem;
        border-top-left-radius: 1.25rem;
        border-top-right-radius: 1.25rem;
        border-bottom-color: rgb(29, 161, 242);
        border-left-color: rgb(29, 161, 242);
        border-right-color: rgb(29, 161, 242);
        border-top-color: rgb(29, 161, 242);
        background: rgb(29, 161, 242);
        color: #FFF;
        padding: 10px;
        width:300px;
        display:block;
    }
    .card-text.text-right span {

        color: #000!important;
        background: rgba(0, 0, 0, .05) !important;
    }
    .small, small {

        display:block;
        padding-top:10px;
    }



    .text-right {
        text-align: right!important;
        float: right;
        width: 100%;
    }

    .send-msg button {
        width: auto;
    }
    .send-msg textarea {

        background: rgba(0, 0, 0, .05); padding:10px;
    }
    .send-msg {
        bottom:-19px;
    }

    .chat-u-options a {
        font-size: 11px;
        margin-left: 12px;
        font-weight: bold;
    }

    .autocomplete__icon img{ margin-top:-8px;}

    .send-msg textarea{height:40px; width:100%; border-radius:18px;  }


    .emoji-mart {
        position: absolute;
        bottom: 50px;
        right: 14px;

        height: 250px !important;
    }

    .emoji-mart-preview{

        height: 32px !important;
    }
    .emoji-trigger {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        height: 20px;
    }
    .emoji-trigger path {
        transition: 0.1s all;
    }
    .emoji-trigger:hover path {
        fill: #000000;
    }
    .emoji-trigger.triggered path {
        fill: darken(#FEC84A, 15%);
    }

    .file-upload{position: absolute; color:rgb(136, 136, 136);  top: 10px; right: 50px; cursor: pointer;   height: 20px;}
    .icon-upload{font-size: 2em;}
    .btn-conversation  .icon{font-size: 2em;}

</style>


<style>

    .emoji-mart-title-label {
        color: rgba(0,0,0,0.7) !important;
        font-size: 12px !important;
        font-weight: bold !important;
    }
    .emoji-mart-preview{

        height: 32px !important;
    }

</style>