<template>

    <header>
        <div class="container edge">

            <div class="row no-gutters">

                <div class="col-12 col-md-2 align-self-end">

                    <a :href="urlProfile()" class="logo">

                        <img :src="logo()" :alt="schoolProfile.name">

                    </a>

                </div>

                <div class="col-12 col-md-7 align-self-end">

                    <h1 class="js_school_name">{{schoolProfile.name}}


                        <input type="hidden" id="domain_email"   :value="schoolProfile.domain_email" />

                        <input type="hidden" id="js_school_name" :value="schoolProfile.name" />

                    </h1>

                    <em>{{schoolProfile.motto}}</em>

                    <em><svg class="icon icon-star"><use :xlink:href="icon_star"></use></svg>KHDA Rating: {{schoolProfile.rating}}</em>

                </div>

                <div class="col-12 col-md-3 align-self-end">

                    <button v-if="this.$root.authUser !== null "  @click="follow_user"  class="btn follow">{{ followStatus  }}</button>

                    <small class="followers">

                       {{schoolProfile.followers}} followers

                    </small>

                </div>

            </div>

            <div class="cover" v-if="schoolProfile.cover_image !== '' " :style="styleObject" >

                     <span> </span>
            </div>

        </div>

    </header>

</template>

<script>


    export default {

        name: "SchooldetailHeader",

        props:['fullPath', 'schoolProfile'],

        data(){


            return {

                icon_star: this.fullPath + 'css/ico/symbol-defs.svg#icon-star',

                styleObject: {

                    'background-image': 'https://d2heijv3bffmsx.cloudfront.net/'  + this.schoolProfile.cover_image,

                    'background-size': '100% 100%',
                },

                followProgress: false,

                followStatus:  'Follow',

                userFollowing:  lscache.get('user_follower'),

                followerCount:  this.schoolProfile.followers,

            }
        },

        methods:{

            urlProfile(){

                return  this.fullPath  + this.schoolProfile.url;
            },

            logo(){

                return  'https://d2heijv3bffmsx.cloudfront.net/' + this.schoolProfile.logo;
            },

            follow_user() {

                this.followProgress = true;

                let status  = this.followStatus ;

                if( this.followStatus === 'Following') {

                    this.followStatus = 'Follow';

                } else {

                    this.followStatus = 'Following';


                }

                let param = { school_id: this.schoolProfile.id , type:'school', status:status };


                axios.post( this.fullPath +'schools/follow',  param )
                    .then( res => {

                        this.followProgress = false;

                        this.followStatus === 'Following' ? this.schoolProfile.followers  ++  :  this.schoolProfile.followers  --;

                        let user_follower = res.data.data;

                        lscache.set('user_follower', user_follower );


                    });
            }


        },

        created(){


            setTimeout( () => {

                if(this.userFollowing !== 'undefined' )
                {
                    this.userFollowing.forEach( item => {

                        if( item.type === 'school'  && item.object_id === this.schoolProfile.id ) {

                            this.followStatus = 'Following'
                        }

                    });
                }


            }, 50);


        }
    }
</script>

<style scoped>

</style>