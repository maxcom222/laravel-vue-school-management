<template>


    <div>


        <header>

            <div class="container edge">

                <div class="row no-gutters">

                    <a href=""     v-if="selfView===1"        @click.prevent="updateCp=!updateCp"    class="btn-edit btn-edit-cover js_edit_cover">

                        <svg class="icon icon-mode_edit">

                            <use :xlink:href="this.$parent.icon_edit">


                            </use>

                        </svg>

                    </a>

                    <div class="col-12 col-md-2 align-self-end">

                        <a href="" v-if="selfView===1"        @click.prevent="updatePhoto=!updatePhoto" class="btn-edit btn-edit-cover">

                            <svg class="icon icon-mode_edit">

                                <use :xlink:href="this.$parent.icon_edit"></use>

                            </svg>

                        </a>

                        <a href="" class="logo">

                            <img

                                    :src="profile_photo"

                                    alt="Expats' Profile"

                            >

                        </a>

                    </div>

                    <div class="col-12 col-md-7  u-name  align-self-end">

                        <h1>
H
                            {{ user.name  }}

                        </h1>

                        <em class="recent_job_em">

                            {{ user.recent_job }}

                        </em>

                        <p class="member" v-if="membershipStatus==1" >

                                <i class="fa fa-check-circle"></i>

                                ETC Member
                        </p>

                    </div>

                    <div class="col-12 col-md-3 align-self-end">



                        <button v-if="selfView!==1"

                                class="btn  follow">

                            Follow

                        </button>



                        <small class="followers">

                            {{ user_follower }}

                        </small>

                    </div>


                    <div class="only-desktop  parent-school-badges js_parent-school-badges">

                    </div>

                </div>

                <!--
                <?php

                    if( $user -> cover_image == '')
                        {

                    ?>

                    <input type="hidden" id="cover-photo-flag" value="0"  />

                    <?php

                     } else {

                      $width = $width + 5;

                       }


                ?>-->


                <div class="cover "

                     style="background:rgba(62, 61, 149, 0.7);"

                     >

                </div>

                <div class="fit-cover">

                    <div class="fit-cover-text">

                        Drag to Reposition Cover

                    </div>

                </div>

                <button

                        type="button"

                        class="btn btn-sm btn-outline-primary js_save_cover_design save-cover">

                    Save

                </button>


        </div>


        </header>


        <profile-photo

                @updateProfilePhoto="updateProfilePhoto"

                v-if="updatePhoto"

                :full-path="fullPath" :user="user" :self-view="selfView">


        </profile-photo>



        <profile-cover

                @updateCoverPhoto="updateCoverPhoto"

                v-if="updateCp"

                :full-path="fullPath" :user="user" :self-view="selfView">


        </profile-cover>




    </div>

</template>



<script>

    import  ProfilePhoto from './ProfilePhoto';

    import  ProfileCover from './ProfileCover';

export default {

    name: "ProfileHeader",

    props: ['fullPath', 'user', 'selfView', 'membershipStatus'],

    components:  {

        ProfilePhoto,

        ProfileCover

    },

    data()  {


        return{

            updatePhoto: false,

            updateCp: false,

            user_data: lscache.get('user_data'),

            photo: this.user.profile_photo,

            cover:  this.user.cover_image,

        }
    },

    computed: {

        user_follower() {

            return  this.user.followers === 0  ?  'No followers' : this.user.followers  + ' followers';
        },

        profile_photo() {

            return  'https://d2heijv3bffmsx.cloudfront.net/' +  this.photo;

        },

        cover_photo() {

            if(  this.cover ===  ''  ){

                return  'https://d2heijv3bffmsx.cloudfront.net/' +  'users/expats_1567593889_5943_.jpeg';

            }  else {

                return  'https://d2heijv3bffmsx.cloudfront.net/' +  this.cover;

            }




        },


    },

    watch:{

        photo( val ){

            document.getElementsByClassName('profile-photo')[0].src = 'https://d2heijv3bffmsx.cloudfront.net/' +  val;

        },
        cover( val ){

            let  cover =  'https://d2heijv3bffmsx.cloudfront.net/'  +  val ;

            document.getElementsByClassName('cover')[0].style.backgroundImage = " url("  +  cover   + ")" ;

        }
    },

    methods:{


        updateProfilePhoto( e ) {
            this.photo =  e;
        },

        updateCoverPhoto( e ) {
            this.cover =  e;
        },
    },



    created() {



    }
}
</script>

<style scoped>

    .member  {

        text-shadow: 0 0 6px rgba(0, 0, 0, 1);

        color: #FFF;

        padding: 10px 10px 5px;

    }

    .cover{ background-repeat: no-repeat !important; background-size:cover !important; }


</style>