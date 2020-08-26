<template>


    <div class="frame-header">


        <header>

            <div class="container edge">

                <a href=""     v-if="selfView===1"        @click.prevent="updateCp=!updateCp"    class="btn-edit btn-edit-cover js_edit_cover">

                    <svg class="icon icon-mode_edit">

                        <use :xlink:href="this.$parent.icon_edit">


                        </use>

                    </svg>

                </a>

                <div class="cover "

                     style="background:rgba(62, 61, 149, 0.7);"

                     >

                    <img :src="cover_photo">


                </div>

        </div>


        </header>

        <div class="row no-gutters">

            <div class="col-12 col-md-6  profilePhoto">

                <div>

                    <a href="" v-if="selfView===1"        @click.prevent="updatePhoto=!updatePhoto" class="btn-edit btn-edit-cover">
                        <svg class="icon icon-mode_edit">
                            <use :xlink:href="this.$parent.icon_edit"></use>
                        </svg>
                    </a>
                    <img

                            :src="profile_photo"

                            alt="Expats' Profile"

                    >

                </div>

            </div>
        </div>

        <div class="col-12 col-md-2 d-none align-self-end">

            <div>

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


        </div>

        <div class="row no-gutters profileContact">

            <div class="col-12 col-md-6  personalInfo">

                <h2>{{  user.first_name }}  {{  user.last_name }}</h2>

                <p>{{ user.current_emp_status }}</p>

                <p  v-if=" user.recent_school !== 'undefined' ">>{{  user.recent_school }}</p>



                <p>Followers: {{  user.followers }}</p>

                <div class="epc-join"  v-if="membershipStatus===0 && selfView === 1 ">

                        <h3>Expat <span>Teachers Club</span></h3>

                        <p>You are <b>not</b> a member. <a  @click.prevent="showEtcDialog" href="">Join Now</a> </p>

                </div>

                <div class="epc-join">

                    <h3   v-if="membershipStatus==1" >

                        Member of <span>Expat Teachers Club</span>
                    </h3>

                </div>




                <button v-if="selfView !== 1" @click="follow_user" class="btn btn-primary">

                    {{ followStatus  }}

                    <span v-if="followProgress" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                    <span  v-if="followStatus=== 'following'"><svg class="icon icon-check"><use :xlink:href="icon_check"></use></svg></span>

                </button>



                <div class="epc-join"  v-if="selfView===1 && user.tutor ===  0 ">

                    <p>Are  you available for tutoring. If yes click below button </p>

                    <button v-if="selfView === 1" @click="availableTutor" class="btn btn-primary">

                        Yes

                        <span v-if="tutorProgress" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </button>

                </div>


                <div  v-if="user.tutor ===  1 " class="epc-join">

                    <h3>I am available <span>for  tutoring</span></h3>

                    <p>Contact me  by  clicking <a   href="">here</a> </p>

                </div>




            </div>

            <div class="col-12 col-md-6 contactInfo">

                <div v-if="spec.length <  1">

                    <p v-if="user.birthday !== '' &&   user.birthday !== null && user.dob_public === 1">Date of birth: {{ birthDay( user.birthday) }}</p>

                    <p  v-if="user.contact_number !== '' && user.contact_number !== null && user.contact_number_public === 1 ">Contact Number: {{  user.contact_number }}</p>

                    <p  v-if="user.email !== '' && user.email !== null && user.email_public === 1">Email Address: {{  user.email }}</p>

                    <p  v-if="user.skype !== '' && user.skype !== null && user.skype_public === 1">Skype: {{  user.skype }}</p>

                    <!--<p  v-if="user.address !== '' && user.address !== null ">Current Address: {{  user.address }}</p>
                        -->

                </div>






                <ul  class="spec-list">

                    <li  v-ripple.mouseover="'rgba(193,216,254, 0.35 )'"   v-for="specs  in spec">

                        <svg class="icon icon-verify">
                            <use :xlink:href="verify_icon"></use>
                        </svg>

                        {{ specs }}
                    </li>

                </ul>



                <div  v-if="selfView!==1">

                    <button  v-ripple.mouseover="'rgba(193,216,254, 0.35 )'" @click="recommendationModal"   class="btn btn-cta">

                        Write a Recommendation

                    </button>
                </div>






            </div>


        </div>







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

    let VueScrollTo = require('vue-scrollto');

    import {eventBus} from '../../app.js'

    let moment = require('moment');



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

            spec: [],

            verify_icon: this.fullPath +  'css/ico/symbol-defs.svg#icon-verify',

            icon_check: this.fullPath +  'css/ico/symbol-defs.svg#icon-check',

            followProgress: false,

            followStatus:  'Follow',

            tutorProgress: false,

            userFollowing:  lscache.get('user_follower'),

            recommendationBox: false,

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

            if(  this.cover ===  ''   ||  this.cover ===  null   ){

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


        birthDay(date){

            var dateTime = new Date( date );

            return dateTime = moment(dateTime).format("DD-MM-YYYY");
        },



        recommendationModal(){

            let obj = {show: true };

            eventBus.$emit('recDialogHeaderMenu', obj );

        },

        updateProfilePhoto( e ) {
            this.photo =  e;
        },

        updateCoverPhoto( e ) {
            this.cover =  e;
        },

        scrollTo( element ){

            VueScrollTo.scrollTo( element , 300)

        },


        availableTutor(){



            this.tutorProgress = true;

            let param = { uid: this.user.id, tutor:1 };

            this.user.tutor  = 1;


            axios.post( this.fullPath +'user/profile/save_contact_info',  param )
                .then( res => {

                    this.tutorProgress = false;

                });


        },

        showEtcDialog(){


            eventBus.$emit('etcDialog', {} );

        },

        follow_user() {

            this.followProgress = true;

            let status  = this.followStatus ;

            if( this.followStatus === 'Following') {

                this.followStatus = 'Follow';

            } else {

                this.followStatus = 'Following';

            }

            let param = { school_id: this.user.id , type:'person', status:status };


            axios.post( this.fullPath +'schools/follow',  param )
                .then( res => {

                    this.followProgress = false;

                    this.followStatus === 'Following' ? this.user.followers  ++  :  this.user.followers  --;

                    let user_follower = res.data.data;

                    lscache.set('user_follower', user_follower );


                });
        }



    },



    created() {




        if( this.user.spec  !== '' &&  this.user.spec !== null ){

                this.spec  = this.user.spec.split(',');
            }

            setTimeout( () => {

                if(this.userFollowing !== 'undefined' && this.userFollowing !== null  )
                {
                    this.userFollowing.forEach( item => {

                        if( item.type === 'person'  && item.object_id === this.user.id ) {

                            this.followStatus = 'Following'
                        }

                    });
                }


            }, 100);



    }
}
</script>

<style scoped>

    .member  {

        text-shadow: 0 0 6px rgba(0, 0, 0, 1);

        color: #FFF;

        padding: 10px 10px 5px;

    }

    .frame-header{

        margin-right: -15px;

        margin-bottom: 20px;

        box-shadow: 0 1px 6px rgba(57,73,76,0.35);

        background: linear-gradient(to bottom,#3e3d95,#3e3d95 4px,#fff 4px,#fff);

    }

    header{ height: 200px; margin-bottom: 20px; }

    header:hover .cover img{opacity: 0.4; }

    .cover{ background-repeat: no-repeat !important; background-size:cover !important; }

    .cover  img{    width: 100%;   height: 200px;}

    .profileContact h2{ font-size: 2.4em;
        font-weight:bold; }

    .profileContact p{  font-size: 1em; font-weight: bold; }

    .personalInfo, .contactInfo {padding:  25px; padding-top: 3px; }


    .profilePhoto{ justify-content: center;  padding: 25px; padding-bottom: 0;}

    .profilePhoto div{ position: relative;  margin-top: -120px;  border: 1px  solid  #ccc; width: 150px; height:150px; border-radius: 50%;}

    .profilePhoto div img{ width: 150px; height: 150px; border-radius: 50%; }

    .profilePhoto div:hover .btn-edit-cover {     background: #000 !important; color: #FFF;}

    .personalInfo  h2{margin-bottom: 0;}

    .profileContact p{margin-bottom: 3px;}

    .spec-list li {

        width: auto;
        background: #3e3d95;
        padding: 5px;
        color: #FFF;
        margin-bottom: 10px;
        border-radius: 4px;
        text-align: center;
        margin-right: 6px;
        float: left;
        list-style: none;
    }

    .epc-join{  margin-top: 20px; }

    .btn-cta{  border-radius: 4px;margin-left: 40px;}

</style>