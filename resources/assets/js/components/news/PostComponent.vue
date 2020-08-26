<template>


    <div class="feed">

        <a href=""   ref="showum2" v-if="user_data.id === post.uid" @click.prevent="showPostOpt=!showPostOpt" class="pop-edit">

            <svg class="icon icon-more_vert">

                <use :xlink:href="icon_m_v">

                </use>

            </svg>

        </a>

        <ul class="user-menu2" ref="um2"

            v-show="showPostOpt"

            v-closable="{

                exclude: ['um2', 'showum2'],

                handler: 'onClose'

              }"


        >

            <li>
                <a class="" href="">Edit Post</a>

            </li>

            <li>
                <a class="" href="">Delete Post</a>

            </li>

        </ul>

        <a href=""

           class="pop-edit   heart-icon"

           @click.prevent="addFav"   :class="favStatus === 'fav' ? 'activity-active' : ''"

        >

            <svg class="icon icon-favorite  ">

                <use :xlink:href="this.$parent.icon_fav"></use>

            </svg>

        </a>


        <a :href="profile_url"  @click.prevent="profileUrl"   class="dp">

            <img
                    :src="logo"

                    :alt="post.first_name"
            >

        </a>

        <div>

            <a :href="profile_url"  @click.prevent="profileUrl"  class="publisher">

                {{ post.first_name }}  {{ post.last_name }}

            </a>

            <span class="text-muted">

                shared

            </span>

            <h2>

                <a
                        @click.prevent="postUrl"

                        :href="post_url">

                    {{ post.title }}

                </a>

            </h2>


            <small class="text-muted">
                <time-ago

                        :refresh="60"

                        :datetime="new Date(post.dated)"

                ></time-ago>

                </small>

        </div>

        <p>

            {{ description }}

        </p>

        <p>

            <a

                    @click.prevent="profileUrl"


                    v-if="post.photo !==  null &&  post.photo !==   '' "
                    :href="profile_url" class="featured">

                <img
                        :src="postImage"

                        :alt=" post.first_name +  'post' "

                        class="img-fluid">
            </a>

        </p>


        <ul class="post_activity_container " v-if="this.post.like_counter > 0 || this.post.comment_counter > 0   ">

            <li  v-if="this.post.like_counter > 0 ">

                <a href=""   >

                    <span>{{  this.post.like_counter }}</span>Like
                </a>


            </li>

            <li  v-if="this.post.comment_counter > 0 ">

                <a href=""  @click.prevent="showComments"

                   class="">

                    <span>{{  this.post.comment_counter }}</span> comments


                </a>


            </li>
        </ul>


        <ul class="actions">


            <li>

                <a

                        href=""

                        @click.prevent="likeItem"

                        :class="[ (likeStatus === 'like' ? 'activity-active' : ''), (animateDisplay===true? 'animate' :  '')]"

                        class="confetti-button"




                >

                    <svg  :class=" animateRotate === true ? 'animate-rotate' :  '' " class="icon icon-thumb_up">

                         <use :xlink:href="this.$parent.icon_like"></use>

                    </svg>



                </a>


            </li>


            <li>

                <button


                        class="addthis_button"
                >

                        <svg class="icon icon-share">

                             <use :xlink:href="this.$parent.icon_share"></use>

                         </svg>

                    Share

                </button>

            </li>


        </ul>


        <div class="add-comment" >

            <a
                    @click.prevent="profileUrl"


                    :href="profile_url">

                <img :src="add_comment_user_image"

                     :alt="user_data.first_name +  ' '  +  user_data.last_name">

            </a>


            <div class="input-group">

                <input
                        v-bind:disabled="commentDisable"

                        type="text"

                       v-model="comment"

                       class="form-control comment-field"

                       placeholder="Write a comment..."

                       @keyup.enter="addComment"
                >



            </div>

        </div>

        <p class="text-center" v-if="this.post.comment_counter > 0 && view_all_not_clicked ">

            <a class="l-comments" @click.prevent="showComments"
               href=""
            >
                view all comments
            </a>

        </p>

        <div class="comment-plugin">



            <div class="comment-box" v-for="comment in comment_collection">

                <div class="row">

                    <a class="actor-comment" target="_blank" :href="comment_user_profile(comment.username)" style="">

                        <img :src="comment_user_image(comment.profile_photo)" alt="" style="">
                    </a>

                    <div class="pro-edit comment-pro-edit">

                        <p>

                            <a target="_blank" class="actor-name" :href="comment_user_profile(comment.username)">

                                {{ comment.first_name }}  {{ comment.last_name }}

                            </a>

                            <span class="float-right">

                                <time-ago

                                        :refresh="60"

                                        :datetime="new Date(comment.dated)"

                                ></time-ago>

                            </span>


                        </p>

                        <p>
                            <span class="comment_text"> {{ comment.text }}

                            </span>
                        </p>




                    </div>

                </div>

                <div class="row user-actions-comment">

                    <p v-if="comment.uid  == user_id ">

                        <a href="" class="" @click.prevent="editComment( comment.id, comment.text )">
                            Edit
                        </a>

                        <a href=""  @click.prevent="delComment(comment.id)">
                            Delete
                        </a>

                    </p>
                </div>

            </div>


        </div>



    </div>





</template>

<script>


    import TimeAgo from 'vue2-timeago'

    //import Toasted from 'vue-toasted';

    //Vue.use(Toasted);

    var SocialSharing = require('vue-social-sharing');


    export default {


        name: "PostComponent",

        components:{

            TimeAgo,

        },


        props: ['fullPath', 'post' ],

        data() {

            return {

                icon_url: this.fullPath + 'css/ico/symbol-defs.svg#',

                icon_people:   this.fullPath + 'css/ico/symbol-defs.svg#icon-people',

                icon_star:  this.fullPath + 'css/ico/symbol-defs.svg#icon-star',

                icon_remove_circle:  this.fullPath + 'css/ico/symbol-defs.svg#icon-remove_circle',

                keyboard_arrow_right:  this.fullPath + 'css/ico/symbol-defs.svg#icon-keyboard_arrow_right',

                icon_open_in_new:  this.fullPath + 'css/ico/symbol-defs.svg#icon-open_in_new',

                icon_chat_bubb:  this.fullPath + 'css/ico/symbol-defs.svg#icon-chat_bubble',

                icon_check:  this.fullPath + 'css/ico/symbol-defs.svg#icon-check',

                icon_del: this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

                icon_edit: this.fullPath + 'css/ico/symbol-defs.svg#icon-mode_edit',

                icon_m_v:  this.fullPath + 'css/ico/symbol-defs.svg#icon-more_vert',


                followProgress: false,

                followStatus:  'Follow',

                userFollowing:  lscache.get('user_follower'),

                userLikes: lscache.get('user_likes'),

                userFav: lscache.get('favourite'),

                likeStatus: 'unlike',

                comment: '',

                commentDisable: false,

                comment_collection:[],

                user_id: '',

                user_data: lscache.get('user_data'),

                comment_id: 0,

                view_all_not_clicked: true,

                delete_key: null,

                showPostOpt: false,

                favStatus: '',

                animateDisplay: false,

                animateRotate: false,

            }

        },
        computed:{


            add_comment_user_image( ){

                return 'https://d2heijv3bffmsx.cloudfront.net/' + this.user_data.profile_photo;
            },

            profile_url(  ) {

                if( this.post.close_account  === 1 ){

                    return '#'
                }

                return this.fullPath +  'profile/' + this.post.username;
            },


            post_url(  ) {

                return this.fullPath +  'posts/' + encodeURIComponent(  this.post.username ) + '/' + this.post.url;
            },


            logo()  {

                return 'https://d2heijv3bffmsx.cloudfront.net/' + this.post.profile_photo;
            },
            postImage() {

                return 'https://d2heijv3bffmsx.cloudfront.net/network/' + this.post.photo;

            },
            dateForm( date ){

                let d = new Date(  date );

                return d.toISOString();

            },

            description()  {

                let description  = this.stripHtml  ( this.post.description  ) ;

                if( description.length > 300  ) {

                    return description.substring(0, 300) + '...';

                } else {

                    return description;

                }

            },



        },


        methods: {

            onClose(){


                if( this.showPostOpt === true ){

                    this.showPostOpt = false;
                }


            },

           // var x,y,n=0,ny=0,rotINT,rotYINT
            postUrl(  ) {

                this.$router.push('/posts/' + encodeURIComponent(  this.post.username ) +  '/' + this.post.url ) ;
            },

            profileUrl(){

                this.$router.push('/profile/' + this.post.username );
            },



            rotateDIV(){

                x = document.getElementById("rotate2D");

                clearInterval(rotINT);

                rotINT=setInterval("startRotate()",10);
            },

            startRotate(){

                n=n+1;

                x.style.transform="rotate(" + n + "deg)"

                x.style.webkitTransform="rotate(" + n + "deg)"

                x.style.OTransform="rotate(" + n + "deg)"

                x.style.MozTransform="rotate(" + n + "deg)"

                if (n==180 || n==360)
                {
                    clearInterval(rotINT);
                    if (n==360){n=0}
                }
             },

            showAnimate() {

                this.animateDisplay  = true;

                this.animateRotate = true;

                setTimeout( ()  => {


                    this.animateDisplay  = false;

                   // this.animateRotate  = false;

                }, 1000)
            },



            stripHtml(  html ) {

                let temporalDivElement = document.createElement("div");

                temporalDivElement.innerHTML = html;

                return temporalDivElement.textContent || temporalDivElement.innerText || "";
            },

            follow_user() {

                this.followProgress = true;

                let status  = this.followStatus ;

                if( this.followStatus === 'Following') {

                    this.followStatus = 'Follow';

                } else {

                    this.followStatus = 'Following';

                }

                let param = { school_id: this.post.id , type:'person', status:status };

                axios.post( this.fullPath +'schools/follow',  param )
                    .then( res => {

                        this.followProgress = false;

                        this.followStatus === 'Following' ? this.post.followers  ++  :  this.post.followers  --;

                        let user_follower = res.data.data;

                        lscache.set('user_follower', user_follower );

                    });
            },

            likeItem() {

                if(  this.likeStatus === 'like' ) {

                    this.likeStatus = 'unlike';

                    this.post.like_counter  --;

                } else {

                    this.likeStatus = 'like';

                    this.post.like_counter  ++;
                }


                this.animateDisplay  = true;

                this.animateRotate = true;

                setTimeout( ()  => {

                    this.animateDisplay  = false;

                }, 1000);

                setTimeout( ()  => {

                    this.animateRotate = false;

                }, 500);



                let param = { action: this.likeStatus, object_id: this.post.id };

                axios.post( this.fullPath +'user/action/like',  param )
                    .then( res => {

                        let user_activity  = res.data.data;

                        let user_likes = [];

                        for( let i = 0; i < user_activity.length; i ++ )
                        {

                            user_likes.push( user_activity[i].object_id );

                        }

                        lscache.set('user_likes', user_likes );

                    });


            },


            addFav() {

                if(  this.favStatus === 'fav' ) {

                    this.favStatus = 'unfav';

                } else {

                    this.favStatus = 'fav';
                }

                let param = { action: this.favStatus, object_id: this.post.id, type: 'post' };

                axios.post( this.fullPath +'user/action/fav',  param )

                    .then( res => {

                        let user_fav  = res.data.data;

                        lscache.set('favourite', user_fav );

                    });


            },

            addComment() {

                if( this.comment  === '' ){

                    console.log('empty string');
                    return;
                }

                let param = { action: 'comment', comment: this.comment, object_id: this.post.id, comment_id: this.comment_id };

                if( this.comment_id !== 0 ){

                    param.editAction = 1;
                }

                this.commentDisable = true;

                axios.post( this.fullPath +'user/action/like',  param )
                    .then( res => {

                        let user_activity  = res.data.data;

                        let id  = res.data.id;

                        let d = new Date();


                        let comment_obj =

                            {
                                first_name:  this.user_data.first_name,

                                last_name:  this.user_data.last_name,

                                profile_photo: this.user_data.profile_photo,

                                uid:    this.user_data.id,

                                recent_job: '',

                                dated: new Date(  d.getFullYear() + '-' + d.getMonth() + '-' + d.getDay() + ' '+ d.getHours() + ':' + d.getMinutes() + ':' +d.getSeconds()        )  ,//

                                text: this.comment,

                                id: id,


                            }


                        if( this.comment_id === 0 ){

                            this.post.comment_counter ++;

                            this.comment_collection.unshift( comment_obj );

                        } else  {

                            this.delete_key = id;

                            this.comment_collection.forEach( (item,index) => {

                                if( item.id ===  this.delete_key  ){

                                    this.comment_collection.splice( index, 1, comment_obj );
                                }

                            });

                        }



                        this.comment_id = 0;

                        this.commentDisable = false;

                        this.comment  = '';



                    });

            },

            delComment( comment_id ) {

                let param = { action: 'comment', object_id: this.post.id, delAction: 1, comment_id: comment_id };

                this.commentDisable = true;

                axios.post( this.fullPath +'user/action/like',  param )
                    .then( res => {

                        let user_activity  = res.data.data;

                        let id  = res.data.id;

                        this.delete_key = res.data.id;

                        this.post.comment_counter --;

                        this.comment_collection.forEach( (item,index) => {


                            if( item.id ===  this.delete_key  ){

                                this.comment_collection.splice( index, 1);
                            }


                        });




                        this.commentDisable = false;

                        this.comment  = '';



                    });

            },

            filterArr( id ){


                return this.comment_collection.filter(function(ele){



                    return ele.id !== id ;
                });


            },

            editComment( id, text  ){

                this.comment_id =   id;

                this.comment =  text;
            },

            showComments() {


                let param = { action: 'list_comment',  object_id: this.post.id };

                this.view_all_not_clicked = false;

                axios.post( this.fullPath +'user/action/like',  param )
                    .then( res => {

                        this.comment_collection  = res.data.data;


                    });

            },

            comment_user_image( photo ){

                return 'https://d2heijv3bffmsx.cloudfront.net/' + photo;
            },

            comment_user_profile(   url ){

                return this.fullPath  + 'profile/' + url;
            },

            current_date(){

                let d = new Date();

                d =  d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate();

                return d;
            }




        },


        created()  {
//var d = new Date('2019-08-09 12:12:12');
           // var n = d.toISOString();

        },

        mounted() {


            setTimeout( () => {

                if(this.userLikes  !== 'undefined' )
                {
                    this.userLikes.forEach( item => {

                        if( item === this.post.id ) {

                            this.likeStatus = 'like'
                        }

                    });
                }



               if( typeof this.userFav  !== 'undefined' && this.userFav  !== null )
                {
                    this.userFav.forEach( fav_item => {

                        if( parseInt(fav_item.item_id )  === this.post.id && fav_item.type === 'post' ) {

                            this.favStatus = 'fav'
                        }

                    });
                }




            }, 50);


            Echo.channel( 'like.'  +  this.post.id )

                .listen('LikeEvent', (e) => {



                    if(  e.action === 'like') {

                        //this.$notify({  group: 'social', text: 'post is liked by someone' , title: 'post like', type: 'success' })


                        this.post.like_counter ++;

                    } else {

                        this.post.like_counter --;
                    }

                });




            Echo.channel( 'comment.'  +  this.post.id )

                .listen('CommentEvent', (e) => {

                    console.log( e);

                    if( e.action == 'add_comment' ) {

                        let comment_obj =

                            {
                                first_name:  e.actor.first_name,

                                last_name:  e.actor.last_name,

                                profile_photo: e.actor.profile_photo,

                                uid:    e.actor.id,

                                recent_job: '',

                                dated: (new Date ((new Date((new Date(new Date())).toISOString() )).getTime() - ((new Date()).getTimezoneOffset()*60000))).toISOString().slice(0, 19).replace('T', ' '),

                                text: e.comment_data.text,

                                id: e.comment_data.id,


                            }


                        this.comment_collection.unshift( comment_obj );

                        this.post.comment_counter ++;
                    }


                    if( e.action == 'del_comment' ){

                        this.delete_key = e.comment_data.id;

                        this.comment_collection.forEach( (item,index) => {

                            if( item.id ===  this.delete_key  ){

                                this.comment_collection.splice( index, 1);
                            }


                        });


                    }


                    if( e.action == 'edit_comment' ){


                        this.delete_key = e.comment_data.id;

                        let comment_obj =

                            {
                                first_name:  e.actor.first_name,

                                last_name:  e.actor.last_name,

                                profile_photo: e.actor.profile_photo,

                                uid:    e.actor.id,

                                recent_job: '',

                                dated: (new Date ((new Date((new Date(new Date())).toISOString() )).getTime() - ((new Date()).getTimezoneOffset()*60000))).toISOString().slice(0, 19).replace('T', ' '),

                                text: e.comment_data.text,

                                id: e.comment_data.id,


                            }


                        this.comment_collection.forEach( (item,index) => {

                            if( item.id ===  this.delete_key  ){

                                this.comment_collection.splice( index, 1, comment_obj );
                            }


                        });


                    }





                });


            this.user_id = this.user_data.id ;


        }
    }
</script>


<style scoped>


    .feed ul a {
        display:inline-block;
        padding: 4px 8px;
        border-radius: 0;
        margin-top: 10px;
        font-size: 1em;
        font-weight: bold;
    }

    .teachers-card{

        background-color:transparent;
    }
    .teachers-card strong{

        font-size: 1.2em;
        margin-bottom: 10px;
        display: block;
        color: #01ae79;
    }

    .teachers-card small {
        font-size: 100%;
        display: block;
        font-weight: bold;
    }

    .icon-favorite  {

        font-size:2.2em;

    }

    .comment-field {

        background-color: #f2f3f5;

        border: 1px solid #ccd0d5;

        border-radius: 16px;

        display: flex;

        justify-content: flex-end;
    }

    .feed span {

        margin-right: 3px;
    }

    .feed .post_activity_container a {

        color: rgba(0, 0, 0, 0.4) ;
    }

    .feed ul .icon {

        margin: 0 0px 0 0; font-size:2em;
    }

    a .icon-favorite {
        color: rgba(0,0,0, 0.4);
    }


    .comment-box { background: #f2f3f5; position:relative;    border-radius: 18px; padding: 10px; margin-bottom: 10px; }

    .comment-box .row{ margin: 0;     justify-content: flex-end;}

    .comment-box .actor-comment {padding-left: 10px;flex: 0 0 10%;width: 11%;}

    .comment-box .actor-comment img{width: 100%;border-radius: 50%;}

    .comment-pro-edit{flex: 0 0 90%;padding-left: 13px;}


    .actor-name{display: inline !important;width: auto;float: left;font-weight: normal;color: #3e3d95;padding-left: 0px;font-size: 13px;font-weight: bold;}

    .comment_text{ display: inline;padding-left: 10px;font-size: 12px;}


    .comment-box .row {
        margin: 0;
        justify-content: flex-end;
    }


    .row.user-actions-comment a {
        font-size: 12px;
        margin-left: 10px;
    }

    .heart-icon
    {
        transform: rotate(360deg);

        font-size: 1.2em;

        top: 36px;

        right: 3px;

    }

    .user-menu2:before {

        border-color: rgba(204, 204, 204, 0);

        border-bottom-color: #ccc;

        border-width: 11px;

        margin-left: -11px;
    }

    .user-menu2:after, .user-menu2:before {

        bottom: 100%;

        left: 116px;

        border: solid transparent;

        content: " ";

        height: 0;

        width: 0;

        position: absolute;

        pointer-events: none;
    }


    .user-menu2 {
        margin: 0;
        padding: 0;
        list-style: none;
        position: absolute;
        width: 140px;
        background-color: #fff;
        top: 100%;
        right: 4px;
        z-index: 1;
        border: 1px solid rgba(0, 0, 0, 0.2);
        -webkit-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.1), 0 3px 1px -2px rgba(0, 0, 0, 0.1), 0 1px 5px 0 rgba(0, 0, 0, 0.1);
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.1), 0 3px 1px -2px rgba(0, 0, 0, 0.1), 0 1px 5px 0 rgba(0, 0, 0, 0.1);
    }

    .coffe-club .user-menu2 {

        top: 42px;

        right: 2px;

    }

    .activity-active .icon {

        color: #01ae79 !important;

        font-weight: bold;
    }

    .animate-rotate{

        -ms-transform: rotate(-10deg);

        -webkit-transform: rotate(-10deg);

        transform: rotate(-10deg);

        transition: all 300ms ease-in;

    }




</style>



