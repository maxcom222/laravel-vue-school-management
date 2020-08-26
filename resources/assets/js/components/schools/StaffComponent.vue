<template>

    <div>


        <div class="user-card">

            <a :href="profile_url(tech.username)">

                <img :src="profile_image(tech.profile_photo)" :alt="tech.first_name + 'profile'">

            </a>

            <span>

                            <strong>{{ tech.first_name }} {{ tech.last_name }}</strong>

                            <small>{{  tech.recent_job }}</small>

                        </span>


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



            <!-- <a href=""

               class="btn btn-sm js_follow_user btn-primary"
            >
                <svg class="icon icon-check">

                  <use :xlink:href="icon_check"></use>

               </svg>

                Follow

            </a> -->

        </div>

    </div>
    
</template>

<script>
    export default {

        name: "StaffComponent",

        props: ['fullPath', 'tech'],

        data(){


            return {


                followProgress: false,

                followStatus:  'Follow',

                userFollowing:  lscache.get('user_follower'),

                icon_check:  this.fullPath + 'css/ico/symbol-defs.svg#icon-check',


                icon_remove_circle:  this.fullPath + 'css/ico/symbol-defs.svg#icon-remove_circle',


            }
        },

        methods:{

            profile_url( u ){

                return this.fullPath + 'user/profile/' + u;
            },

            profile_image( photo ){

                if( photo === '' ){

                    return 'https://www.expatsschools.com/css/img/user-img.png';
                }

                return 'https://d2heijv3bffmsx.cloudfront.net/' + photo;
            },

            follow_user() {

                this.followProgress = true;

                let status  = this.followStatus ;

                if( this.followStatus === 'Following') {

                    this.followStatus = 'Follow';

                } else {

                    this.followStatus = 'Following';

                }

                let param = { school_id: this.tech.id , type:'person', status:status };


                axios.post( this.fullPath +'schools/follow',  param )
                    .then( res => {

                        this.followProgress = false;

                        //this.followStatus === 'Following' ? this.tech.followers  ++  :  this.staff.followers  --;

                        let user_follower = res.data.data;

                        lscache.set('user_follower', user_follower );


                    });
            }
        },

        mounted(){


            setTimeout( () => {

                if(this.userFollowing !== 'undefined' )
                {
                    this.userFollowing.forEach( item => {

                        if( item.type === 'person'  && item.object_id === this.tech.id ) {

                            this.followStatus = 'Following'
                        }

                    });
                }


            }, 50);
        }



    }
</script>

<style scoped>

    .user-card {

        box-shadow: 0 1px 6px rgba(57,73,76,0.35);

        margin-bottom: 20px;
    }
    .btn{ padding: 2px 10px 2px 10px; }



</style>