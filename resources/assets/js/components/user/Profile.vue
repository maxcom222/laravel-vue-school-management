<template>
<div>

    <div v-if="loader===1" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>



    <main v-if="loader!==1"  class="two-cloumn  profile-ui-page">


        <div class="container">

            <div class="row">

                <div class="col-12 col-md-3   col-left">

                    <profile-left 

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"
                    >


                    </profile-left>



                </div>

                <div class="col-12 col-md-9 col-right pro-edit">


                    <profile-header2  

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"

                            :membership-status="membershipStatus"


                    >

                    </profile-header2>

                    <parent-school  

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"
                    >


                    </parent-school>

                    <profile-about  

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"


                    >


                    </profile-about>

                    <join-etc

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"


                    >


                    </join-etc>

                    <profile-twitter  

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"

                            :twitter-name="twitterName"
                    >


                    </profile-twitter>

                    <profile-contact

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"
                    >


                    </profile-contact>



                    <profile-education  

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"
                    >


                    </profile-education>

                    <profile-experience  

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"
                    >


                    </profile-experience>


                    <profile-followers  

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"
                    >


                    </profile-followers>

                    <profile-invite  

                            v-if="selfView===1"

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"
                    >


                    </profile-invite>


                    <profile-schoolemailaddress   

                            v-if="selfView===1"

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"
                    >


                    </profile-schoolemailaddress>



                    <profile-albums  

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"
                    >


                    </profile-albums>


                    <profile-recommendation  

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"

                        >

                    </profile-recommendation>


                    <profile-publication  

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"
                    >


                    </profile-publication>



                    <profile-spec  

                            :user="user"

                            :full-path="fullPath"

                            :self-view="selfView"
                    >


                    </profile-spec>





                </div>



            </div>


        </div>

    </main>





</div>

</template>



<script>

    import ProfileHeader2 from  './ProfileHeader2.vue';

    import ProfileNav from './ProfileNav.vue';

    import ProfileEducation from './ProfileEducation.vue';

    import ProfileExperience from './ProfileExperience.vue';

    import ProfileAbout from './ProfileAbout.vue';

    import ProfileFollowers from './ProfileFollowers.vue';

    import ProfileInvite    from './ProfileInvite.vue';

    import ProfileSchoolemailaddress    from './ProfileSchoolemailaddress.vue';

    import ProfilePublication    from './ProfilePublication.vue';

    import ProfileContact    from './ProfileContact.vue';

    import ProfileLeft    from './ProfileLeft.vue';

    import ProfileTwitter    from './ProfileTwitter.vue';

    import ProfileSpec    from './ProfileSpec.vue';

    import ProfileAlbums    from './ProfileAlbums.vue';

    import ProfileRecommendation from './ProfileRecommendation';

    import ParentSchool from './ParentSchool';


    import JoinEtc from './JoinEtc';


    import {eventBus} from '../../app.js'

    export default {

        name: "profile",

        props:  ['fullPath'],

        //'user', 'selfView', 'twitterName', 'membershipStatus'

        components:  {

            ProfileHeader2,

            ProfileNav,

            ProfileEducation,

            ProfileExperience,

            ProfileAbout,

            ProfileFollowers,

            ProfileInvite,

            ProfileSchoolemailaddress,

            ProfilePublication,

            ProfileContact,

            ProfileLeft,

            ProfileTwitter,

            ProfileSpec,

            ProfileAlbums,

            ProfileRecommendation,

            ParentSchool,

            JoinEtc



        },

        data() {


            return {

                loader: 1,

                selfView:  this.$parent.selfView,

                twitterName: this.$parent.twitterName,

                membershipStatus: this.$parent.membershipStatus,

                user: this.$parent.user,


                icon_edit: this.fullPath + 'css/ico/symbol-defs.svg#icon-mode_edit',

                icon_del:   this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

                icon_adds: this.fullPath + 'css/ico/symbol-defs.svg#icon-add',

                icon_check: this.fullPath + 'css/ico/symbol-defs.svg#icon-check',

                icon_open_in_new: this.fullPath + 'css/ico/symbol-defs.svg#icon-open_in_new',

                icon_people:  this.fullPath + 'css/ico/symbol-defs.svg#icon-people',

                showSpecDialog: false,

                showRecommendationDialog: false,


            }
        },

       

        methods:{

            updatedKey(){

                return ''+ Math.floor(Math.random() * 10000);
            },

            updateData(){

                let param = { username : this.$route.params.username };

                axios.post( this.fullPath +'status_checking',  param )
                    .then( res => {

                        this.loader = 0;

                        this.membershipStatus = res.data.data.membership_status;

                        this.twitterName = res.data.data.twitter_name;

                        this.selfView = res.data.data.self_view;

                        this.user = res.data.data.user_data;

                    });
            },



    },

        created() {


            eventBus.$on('justVerifiedSchool', (message) => {

                this.updateData();

            });



            this.$forceUpdate();

            this.updateData();

        }



    }
</script>

<style>

   .profile-ui-page .icon{     margin-top: -7px; }

    .intro{
        padding: 20px;}

   .go {

       padding: 8px 8px
   }
    .modal-btn{
        padding: 8px 8px;
    }

   .profile-ui-page .vs__dropdown-toggle{
       border-left: 1px solid rgba(60,60,60,.26) !important;}

</style>