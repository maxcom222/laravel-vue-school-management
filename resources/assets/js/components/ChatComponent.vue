<template>
    <div class="container msg-container" >
        <div class="row  justify-content-center">


            <div v-if="inboxLoader" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>



            <div class="col-md-4">
                <div class="card card-default">
                    <div class="card-header">

                        <form class="search search-frm" style="">


                            <autocomplete

                                    ref="autocomplete"

                                    placeholder="Find people by name to connect"

                                    :source="sourceTypeAhead"

                                    input-class="form-control search-friend-input"

                                    results-property="data"

                                    results-display="name"

                                    @selected="refreshFriendWindow"

                                   >
                            </autocomplete>

                        </form>


                    </div>



                    <ul class="list-group">

                        <li class="list-group-item"

                            v-for="friend in friends"

                            v-if="friend.visibleInWindow"
                        >

                            <a href=""

                               @click.prevent="openChat(friend)"

                            >

                                <img :src="profile_image( friend.profile_photo)" alt="profile photo">

                                {{ friend.name }}

                                <span v-if="friend.session  && (friend.session.unreadCount > 0 )" class="text-danger"> {{ friend.session.unreadCount}} </span>



                            </a>

                            <span>

                                 <svg :class="friend.online===true? 'text-success':  'text-warning'" class="icon icon-circle">

                                         <use :xlink:href="icon_circle"></use>
                                 </svg>

                            </span>

                        </li>

                    </ul>


                </div>
            </div>


            <div class="col-md-8">

                <div v-if="showMessageWindowLoader" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

                <div v-if="openChatWindow===false" class="card card-no-message">
                    <h3>You don’t have a message selected
                    </h3>
                    <p>Choose one from your existing messages, or start a new one by Selecting user from  the search on right side.</p>

                </div>
                <span v-for="friend in friends" :key="friend.id"  v-if="friend.session">

                         <message-component :full-path="fullPath" :friend="friend"  v-if="friend.session.open" @close="close">

                         </message-component>

                </span>


            </div>








        </div>
    </div>
</template>

<script>


    import MessageComponent from  './MessageComponent'

    import Autocomplete from 'vuejs-auto-complete'

    export default {

        components: {   MessageComponent, Autocomplete },


        props: ['fullPath'],

        data() {

            return  {

                open: true,

                friends: [],

                userTypeAhead: [],

                sourceTypeAhead: this.fullPath + 'user_by_name?q=',

                icon_search: this.fullPath + 'css/ico/symbol-defs.svg#icon-search',

                icon_circle: this.fullPath + 'css/ico/symbol-defs.svg#icon-circle',

                joinedUser: [],

                showMessageWindowLoader: false,

                inboxLoader: true,

                openChatWindow: false,

            }
        },
        computed: {
            channel() {
                return Echo.join('online');
            }
        },

        methods: {

            changevisibleInWindow( id ){

                console.log('passed from child'  + id );

                for( let i =0; i  <   this.friends.length; i ++ ){


                    if( this.friends[i].id  === id ){

                        this.friends[i].visibleInWindow = true;
                    }
                }

            },

            close() {

                this.open = false;
            },
            profile_url(username) {

              return this.fullPath + 'user/profile' + username ;
            },

            profile_image( imagePath ){

                return 'https://d2heijv3bffmsx.cloudfront.net/' + imagePath ;
            },

            refreshFriendWindow(e){

                    let obj = {

                        email :e.selectedObject.email,

                        username:e.selectedObject.username,

                        profile_photo: e.selectedObject.profile_photo,

                        id: e.value,

                        name: e.selectedObject.name,

                        session:null,

                        visibleInWindow:true,
                    };

                    for( let i =0; i  <   this.friends.length; i ++ ){


                        if( this.friends[i].id  === e.value ){

                            return;
                        }
                    }



                   this.friends.unshift(obj);

                   //this. openChat(obj);

                    this.joinedUser.forEach(  user => {

                        if( user.id ===   obj.id  ){

                            this.changeStatus( obj.id )

                        }
                    });


             },


            refreshFriendWindowFromParam(e){

                let obj = {

                    email :e.email,

                    username:e.username,

                    profile_photo: e.profile_photo,

                    id: e.id,

                    name: e.name,

                    session:null,

                    visibleInWindow:true,
                };

                for( let i =0; i  <   this.friends.length; i ++ ){


                    if( this.friends[i].id  === e.value ){

                        return;
                    }
                }

                console.log( obj );


                this.friends.unshift(obj);

                this.openChat(obj);

                this.joinedUser.forEach(  user => {

                    if( user.id ===   obj.id  ){

                        this.changeStatus( obj.id )

                    }
                });



                this.inboxLoader = false;


            },

            changeStatus( idCheck ){

                this.friends.forEach(  friend => {

                        if(idCheck   ===  friend.id) {

                            friend.online = true;
                        }
                });

            },

            getFriends() {


                axios.post(  this.fullPath + 'user/getfriends')
                    .then( response => {

                        if( parseInt( response.data.result )  === 2 ){


                        } else {

                            this.friends = response.data.data;

                            this.friends.forEach( friend => {

                                if( friend.session ) {

                                    friend.visibleInWindow =  true;

                                    this.listenForEverySession(friend);
                                }

                            });
                        }


                    });

            },

            openChat(friend)  {


                this.openChatWindow = true;

                this.showMessageWindowLoader = true;

                setTimeout(() => {

                    this.showMessageWindowLoader = false;

                }, 1000 );


                if( friend.session ) {

                    this.friends.forEach( friend =>  {

                        if( friend.session ) {

                            friend.session.open = false;
                        }


                    });

                    friend.session.open = true;

                    friend.session.unreadCount = 0;


                }  else {

                    this.create_session( friend );

                }


            },

            create_session(friend) {


                axios.post( this.fullPath + 'session/create', {friend_id: friend.id })
                    .then(response => {

                        friend.session = response.data.data;
                        this.friends.forEach( friend =>  {

                            if( friend.session ) {

                                friend.session.open = false;
                            }

                        });

                        friend.session.open = true;
                    } );
            },

            listenForEverySession(friend) {



                Echo.private(`Chat.${friend.session.id}`)

                    .listen('ChatEvent', (e) => {

                        if( friend.session.open === false  )  {

                            friend.session.unreadCount++;
                        }

                        friend.visibleInWindow  = true;


                    });
            },

            joinFriends(){

                this.channel
                    .here((users) => {




                        users.forEach(  user => {

                            this.joinedUser.push( user );

                        });

                        setTimeout(() => {

                            this.friends.forEach(  friend => {

                                users.forEach( user => {



                                    if(user.id   ===  friend.id) {

                                        friend.online = true;
                                    }
                                });

                            });

                        }, 1000 );

                        this.friends.forEach(  friend => {

                            users.forEach( user => {



                                if(user.id   ===  friend.id) {

                                    friend.online = true;
                                }
                            });

                        });
                    })
                    .joining((user) => {




                        this.joinedUser.push(user);

                        this.friends.forEach(  friend =>{

                            if( user.id ===  friend.id  )  {

                                friend.online  = true;
                            }

                        })
                    })
                    .leaving((user) => {



                        let id = user.id;
                        this.joinedUser = this.joinedUser.filter(function( obj ) {

                            return obj.id !== id;

                        });




                        this.friends.forEach(  friend =>{

                            if( user.id ===  friend.id  )  {

                                friend.online  = false;

                                let id = friend.id;


                            }
                        });
                    });


            },


            listSessionEvent(){// it must be a wrong place

                Echo.channel( 'Chat')

                    .listen('SessionEvent', (e) => {


                        let obj = {

                            email: e.user_data[0].email,

                            id: e.user_data[0].id,

                            name: e.user_data[0].name,

                            online: true,

                            profile_photo: e.user_data[0].profile_photo,

                            session: null,

                            visibleInWindow: false,

                            username: e.user_data[0].username,
                        };

                        let friend = this.friends.find( friend => friend.id = e.session_by );

                        if(friend === null || typeof friend === 'undefined'){

                            this.friends.unshift(obj);
                            // return;
                        }

                        friend = this.friends.find( friend => friend.id = e.session_by );

                        friend.session = e.session;

                        this.listenForEverySession(friend);

                    });


            },


        },

        mounted () {


            this.joinFriends();


        },

        destroyed() {


            Echo.leave('online');


        },


        created(){


            this.getFriends();

            this.listSessionEvent();


            if(  this.$route.params.id    ){

                this.inboxLoader = true;

                axios.post( this.fullPath + 'chat/open_window', {friend_id: this.$route.params.id } )
                    .then(res => {

                        this.refreshFriendWindowFromParam( res.data.data[0] );

                        //this.inboxLoader = false;

                    } );


            } else {


                this.inboxLoader = false;
            }

            setTimeout(()  => {

                this.joinFriends();

            }, 1000 );



        }

    }


</script>
<style scoped>


.msg-container {

    margin-top: 20px;
}
.search-frm input{outline:0}

.search-frm{width: 100%;margin: 0;}

.contacts{width:30%;}

.list-group-item img {
    width: 32px;
    border-radius: 50%;
    display: inline-block;
    vertical-align: middle;
}

.form-control:focus {

    color: #495057;

    background-color: #fff;

    border-color: #ccc;

    outline: 0;

    box-shadow: none;

    font-size: 14px;
}

.col-4, .col-8{padding-right:0; padding-left:0;}

.form-control{ font-size: 14px;}

.list-group-item{border:none;}

.list-group-item a{ text-decoration: none;}

.icon{ font-size: 2em;}

.list-group-item .text-success{padding-top: 0 !important; font-size: 2em !important; }

</style>

<style>

    .autocomplete__icon {


        margin-top: -6px;
    }

    .card-no-message{ padding: 40px; }

</style>