<template>


    <div>

        <h2>Schools you are following</h2>

        <div class="alert alert-dark" v-if="showNoticeMessage">

            You are not following any school right now. <a  class="text-success" @click.prevent="postNetworkUrl" :href="post_network_url">See all schools</a>

        </div>



        <div
                v-for="(follow,index) in school_following"

                :key="index + '_follow' "
                >


            <div class="feed follower">

                <a

                        @click.prevent="userProfileLink(follow.url)"

                        :href="user_profile_link( follow.url )"

                        class="teachers-card"
                >

                    <img
                            :src="user_profile_photo( follow.logo )"

                            alt="Profile"
                    >

                    <span>

                        <strong>

                            {{ follow.name }}

                        </strong>

                        <small>

                           KHDA Rating:  {{ follow.rating }}

                        </small>

                        <span class="people">

                            <svg class="icon icon-people">

                                <use :xlink:href="icon_people">


                                </use>

                            </svg>

                            {{ follow.followers }} followers

                        </span>

                    </span>

                </a>

                <p>{{ follow.about }}</p>

                <ul class="fav-actions">

                    <li>

                        <a href="" @click.prevent="un_follow_user(follow.id)"  class="active">

                            <svg class="icon icon-remove_circle">

                                <use :xlink:href="icon_remove_circle">

                                </use>

                            </svg>

                            <span  v-if="unFollowProgress===1"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                            <span v-if="unFollowProgress===0">Followed</span>

                        </a>

                    </li>

                    <li>

                        <a @click.prevent="userProfileLink(follow.url)" :href="user_profile_link(follow.url)">

                            <svg class="icon icon-open_in_new">

                                <use :xlink:href="icon_new_tab"></use>

                            </svg>

                            View Profile

                        </a>

                    </li>

                </ul>

            </div>


        </div>


    </div>

</template>

<script>


    export default {

        name: "SchoolFollowing",


        data() {


            return {

                school_following : [],

                name: '',

                position: '',

                user: this.$parent.user,

                fullPath: this.$parent.fullPath,

                icon_people: this.$parent.fullPath +  'css/ico/symbol-defs.svg#icon-people',

                icon_remove_circle: this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-remove_circle',

                icon_new_tab:  this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-open_in_new',

                unFollowProgress: 0,

                post_network_url:   this.$parent.fullPath +'school',

                showNoticeMessage: false,



            }
        },

        computed: {



        },

        methods: {

            user_profile_link( profile ) {

                return this.fullPath + 'school/' +  profile;

            },

            postNetworkUrl(){

                this.$router.push('/schools')
            },

            userProfileLink( p ){

                this.$router.push( '/school/'  + p );
            },


            user_profile_photo( photo ) {

                return 'https://d2heijv3bffmsx.cloudfront.net/' +  photo;

            },

            un_follow_user(object_id ){

                this.unFollowProgress = 1;

                axios.post( this.fullPath + 'post/user/discard_follower', {object_id: object_id, type: 'school' } )

                    .then( res => {


                        this.unFollowProgress = 0;

                        this.school_following = [];

                        if( parseInt(  res.data.result  ) ===  1 ){

                            this.school_following = res.data.data;

                        } else {

                            this.showNoticeMessage = true;
                        }

                        lscache.set('user_follower', this.school_following );

                        let user_follower = lscache.get('user_follower' );



                    })



            },



            loadFollowing() {

                axios.post( this.fullPath + 'post/user/user_following_school', {} )

                    .then( res => {

                        if( parseInt(  res.data.result  ) ===  1 ){

                            this.school_following = res.data.data;

                        } else {

                            this.showNoticeMessage = true;
                        }





                    })
            }


        },


        created() {

            this.loadFollowing();

        }
    }
</script>

<style scoped>



    .feed{box-shadow: 0 1px 6px rgba(57,73,76,0.35); }
    .feed span {
        display: inline-block;
        margin: 0 0 0px;
    }

</style>