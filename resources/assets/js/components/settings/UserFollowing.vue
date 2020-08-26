<template>


    <div>



        <h2>People you are following</h2>

        <div class="alert alert-dark" v-if="showNoticeMessage">

            You are not following anyone right now. <a  class="text-success" @click.prevent="postNetworkUrl" :href="post_network_url">Grow your network</a>

        </div>

        <div
                v-for="(follow,index) in user_following"

                :key="index + '_follow' "
                >


            <div class="feed follower">

                <a
                        @click.prevent="userProfileLink(follow.username)"


                        :href="user_profile_link( follow.username )"

                        class="teachers-card"
                >

                    <img
                            :src="user_profile_photo( follow.profile_photo )"

                            alt="Profile"
                    >

                    <span>

                        <strong>

                            {{ follow.first_name }}   {{ follow.last_name }}

                        </strong>

                        <small>

                            {{ follow.current_emp_status }}

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

                        <a @click.prevent="userProfileLink(follow.username)" :href="user_profile_link(follow.username)">

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

        name: "UserFollowing",


        data() {


            return {



                user_following : [],

                name: '',

                position: '',

                icon_people:this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-people',

                icon_remove_circle: this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-remove_circle',

                icon_new_tab: this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-open_in_new',

                unFollowProgress: 0,

                user: this.$parent.user,

                fullPath: this.$parent.fullPath,

                showNoticeMessage: false,

                post_network_url: this.$parent.fullPath + 'network',



            }
        },

        computed: {



        },

        methods: {

            user_profile_link( profile ) {

                return this.fullPath + 'user/profile/' +  profile;

            },

            userProfileLink( p ){

                this.$router.push( '/profile/'  + p );
            },


            postNetworkUrl(){

                this.$router.push( '/network' );
            },

            user_profile_photo( photo ) {

                return 'https://d2heijv3bffmsx.cloudfront.net/' +  photo;

            },

            un_follow_user(object_id ){

                this.unFollowProgress = 1;

                axios.post( this.fullPath + 'post/user/discard_follower', {object_id: object_id, type: 'user'  } )

                    .then( res => {


                        this.unFollowProgress = 0;

                        this.user_following = [];

                        if( parseInt(  res.data.result  ) ===  1 ){

                            this.user_following = res.data.data;

                        } else {

                            this.showNoticeMessage = true;
                        }


                        lscache.set('user_follower', this.user_following );

                        let user_follower = lscache.get('user_follower' );


                    })



            },



            loadFollowing() {


                axios.post( this.fullPath + 'post/user/followers', {} )

                    .then( res => {

                        if( parseInt(  res.data.result  ) ===  1 ){

                            this.user_following = res.data.data;

                        } else {

                            this.showNoticeMessage = true;
                        }



                    })
            }


        },


        created() {


            this.loadFollowing();

            let user_follower = lscache.get('user_follower' );

            console.log( user_follower );

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