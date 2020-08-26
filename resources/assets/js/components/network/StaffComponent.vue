<template>


    <div class="feed follower">

        <a
                @click.prevent="profileUrl(staff.username)"
                :href="profile_url"

                class="teachers-card"

        >
            <img
                    :src="logo"

                    :alt="staff.first_name"

            >
            <span>

                <strong>

                    {{ staff.first_name }} {{ staff.last_name }}

                </strong>

                <small>

                    {{ staff.current_emp_status}}

                </small>

                <span class="people">

                    <svg class="icon icon-people">

                         <use :xlink:href="icon_people"></use>

                    </svg>

                    {{staff.followers }} followers

                </span>

            </span>

        </a>


        <p>

            {{    description }}

        </p>


        <ul class="fav-actions">


            <li>

                <a
                        href=""

                        class="btn btn-primary"

                        @click.prevent="follow_user"


                >

                    <svg v-if="followStatus === 'Following'"

                         class="icon icon-remove_circle">

                        <use :xlink:href="icon_remove_circle"></use>

                     </svg>

                    <svg v-else

                         class="icon icon-check">

                        <use :xlink:href="icon_check"></use>

                    </svg>


                    {{ followStatus }}

                </a>

            </li>


            <li>

                <a :href="send_message_url(staff.id)" class="btn btn-primary" @click.prevent="sendMessage(staff.id)">

                    <svg class="icon icon-chat_bubble">

                         <use :xlink:href="icon_chat_bubb"></use>

                     </svg>

                     Send Message

                </a>

            </li>


            <li>

                <a @click.prevent="profileUrl(staff.username)"  class="btn btn-primary" :href="profile_url">

                    <svg class="icon icon-open_in_new">

                        <use :xlink:href="icon_open_in_new"></use>

                    </svg>

                    View Profile

                </a>

            </li>
        </ul>
    </div>






</template>

<script>

    export default {


        name: "StaffComponent",


        props: ['fullPath', 'staff' ],

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

                followProgress: false,

                followStatus:  'Follow',

                userFollowing:  lscache.get('user_follower'),

            }

        },
        computed:{

            profile_url(  ) {

                return this.fullPath +  'profile/' + this.staff.username;
            },
            logo()  {

                return 'https://d2heijv3bffmsx.cloudfront.net/' + this.staff.profile_photo;
            },

            description()  {

                let description  = this.stripHtml  ( this.staff.about  ) ;

                if( description.length > 300  ) {

                    return description.substring(0, 300) + '...';

                } else {

                    return description;

                }





            },

        },


        methods: {

            stripHtml(  html ) {

                var temporalDivElement = document.createElement("div");

                temporalDivElement.innerHTML = html;

                return temporalDivElement.textContent || temporalDivElement.innerText || "";
            },

            send_message_url(id){


                return this.fullPath + 'inbox/' + id;

            },

            profileUrl(  url  ){

                this.$router.push('/profile/' + url  );
            },
            sendMessage(id){


                this.$router.push('/inbox/' + id );


            },

            follow_user() {

                this.followProgress = true;

                let status  = this.followStatus ;

                if( this.followStatus === 'Following') {

                    this.followStatus = 'Follow';

                } else {

                    this.followStatus = 'Following';

                }

                let param = { school_id: this.staff.id , type:'person', status:status };


                axios.post( this.fullPath +'schools/follow',  param )
                    .then( res => {

                        this.followProgress = false;

                        this.followStatus === 'Following' ? this.staff.followers  ++  :  this.staff.followers  --;

                        let user_follower = res.data.data;

                        lscache.set('user_follower', user_follower );


                    });
            }
        },


        created()  {


        },

        mounted() {


            setTimeout( () => {

                if(this.userFollowing !== 'undefined' )
                {
                    this.userFollowing.forEach( item => {

                        if( item.type === 'person'  && item.object_id === this.staff.id ) {

                            this.followStatus = 'Following'
                        }

                    });
                }


            }, 50);






        }
    }
</script>


<style scoped>

    .feed ul a:hover {

        color: #fff;

        background: #017b56;
    }

    .feed ul a {
        display: block;
        padding: 4px 8px;
        color: #FFF;
        border-radius: 0;
        margin-top: 10px;
        font-size: 1em;
        font-weight: bold;
    }
    .feed:hover{

        background:#f5f5f5;
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

</style>
