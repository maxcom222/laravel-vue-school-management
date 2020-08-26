<template>


    <div>

        <h2>Block Users</h2>

        <div class="alert alert-dark" v-if="showNoticeMessage">

            Your  block list is empty

        </div>

        <div
                v-for="(follow,index) in blocks"

                :key="index + '_follow' "
                >









            <div class="feed follower">

                <a

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

                        <a href="" @click.prevent="un_block(follow.uid2, 0)"  class="active">

                            <svg class="icon icon-remove_circle">

                                <use :xlink:href="icon_remove_circle">

                                </use>

                            </svg>

                            <span  v-if="unFollowProgress===1"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>


                            Blocked
                        </a>

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

        name: "BlockUser",


        data() {


            return {



                blocks : [],

                name: '',

                position: '',

                icon_people:this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-people',

                icon_remove_circle: this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-remove_circle',

                icon_new_tab: this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-open_in_new',

                icon_block: this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-block',

                unFollowProgress: 0,

                user: this.$parent.user,

                fullPath: this.$parent.fullPath,

                showNoticeMessage:false,



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

            user_profile_photo( photo ) {

                return 'https://d2heijv3bffmsx.cloudfront.net/' +  photo;

            },

            un_block(uid2,status ){

                this.unFollowProgress = 1;

                axios.post( this.fullPath + 'post/user/discard_block', {uid2: uid2, status: status } )

                    .then( res => {

                        this.unFollowProgress = 0;

                        this.blocks = [];

                        if( parseInt(  res.data.result  ) ===  1 ){

                            this.blocks = res.data.data;

                        } else {

                            this.showNoticeMessage = true;
                        }

                    })


            },



            loadblock() {


                axios.post( this.fullPath + 'post/get_block', {} )

                    .then( res => {


                        if( parseInt(  res.data.result  ) ===  1 ){

                            this.blocks = res.data.data;

                        } else {

                            this.showNoticeMessage = true;
                        }

                    })
            }


        },


        created() {


            this.loadblock();


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