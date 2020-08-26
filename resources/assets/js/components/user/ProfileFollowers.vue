<template>

    <div id="my_follower" class="frame">

        <h2>Followers</h2>

         <div class="row  no-gutters">



            <div class="feed col-12 col-md-6  follower "

                 v-for="(fol,index) in followers"

                 :key="index"

                 v-if="showAllFollowers===true || index <= 3"

            >

                <follwer-item

                        :key="index + '_follower_item'"

                        :full-path="fullPath"

                        :user="user"

                        :fol="fol"
                    >


                </follwer-item>




            </div>



             <button

                     @click="show_all_followers"

                     v-if="followers.length > 4 && show_view_all"

                     class="btn btn-outline-secondary btn-view-all"

             >
                 View all followers

             </button>


        </div>


    </div>

</template>



<script>

    import  FollwerItem from './FollwerItem'


export default {

    name: "ProfileFollowers",

    components: {


        FollwerItem

    },
    props: ['fullPath', 'user', 'selfView'],


    data()  {


        return {


            followers: [],

            showAllFollowers: false,

            show_view_all: true,

            icon_edit: this.fullPath + 'css/ico/symbol-defs.svg#icon-mode_edit',

            icon_del:   this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

            icon_adds: this.fullPath + 'css/ico/symbol-defs.svg#icon-add',

            icon_check: this.fullPath + 'css/ico/symbol-defs.svg#icon-check',

            icon_open_in_new: this.fullPath + 'css/ico/symbol-defs.svg#icon-open_in_new',

            icon_people:  this.fullPath + 'css/ico/symbol-defs.svg#icon-people',

            followProgress: false,

            followStatus:'',




        }
    },

    computed: {



    },

    methods:  {


        profileUrl(u){


            this.$router.push('/profile/' + u );
        },
        show_all_followers()  {


            this.showAllFollowers =  true;

            this.show_view_all = false;



        },


        profile_url( url ) {

            return  this.fullPath +   'profile/' + url ;
        },

        profile_photo( profile_photo ) {

            return 'https://d2heijv3bffmsx.cloudfront.net/' + profile_photo;
        },

        stripHtml(  html ) {

            var temporalDivElement = document.createElement("div");

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



        description( desc ){


            desc = this.stripHtml(  desc );

            if( desc.length > 100 ) {

                return desc.substr(  0, 100 ) +  '...';

            } else  {

               return desc;
            }

        },

        loadFollowers(){


            axios.post( this.fullPath + 'user/profile/get_followers',  {uid:  this.$parent.user.id } )
                .then( res  => {

                        this.followers = res.data.data;
                })

        },



    },



    created() {


        this.loadFollowers();


    }
}
</script>

<style scoped>

    .feed {

        padding: 15px !important;
    }



</style>