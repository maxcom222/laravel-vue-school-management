<template>

    <div class="frame school-panel">

        <div>

            <a @click.prevent="redirect" :href="school_url"

               class="logo-small">

                <img :src="logo"

                     :alt="school.name">

            </a>

        </div>
        <h2 class="js_name">

            {{ school.name }}

        </h2>

        <a
                 v-if="authUser !== null"

                href=""

                @click.prevent="follow_school"

                class="btn btn-sm btn-primary">

            <span v-if="!followProgress">{{ followStatus}} </span>

            <span v-if="followProgress">

                <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>

                <span>{{ followStatus }}</span>

            </span>



        </a>
        <div>

            <span class="rating">

                <svg class="icon icon-star">

                    <use :xlink:href="icon_star"></use>

                </svg>

                KHDA Rating: {{ school.rating }}

            </span>

            <span class="people"><svg class="icon icon-people">

                <use :xlink:href="icon_people"></use>

                 </svg>  {{ school.followers }} followers</span>

            <span class="d-none js_address">{{ school.address }}</span>


        </div>

        <p>{{ description }}</p>

        <a
                :href="school_url"

                @click.prevent="redirect"

                class="btn btn-sm btn-view"
        >

            View Profile

            <svg class="icon icon-keyboard_arrow_right">

                 <use :xlink:href="keyboard_arrow_right"></use>

            </svg>

        </a>


    </div>








</template>

<script>

    export default {


        name: "ItemComponent",


        props: ['fullPath', 'school' ],

        data() {

            return {

                icon_url: this.fullPath + 'css/ico/symbol-defs.svg#',

                icon_people:  this.icon_url + 'icon-people',

                icon_star: this.icon_url + 'icon-star',

                keyboard_arrow_right: this.icon_url + 'icon-keyboard_arrow_right',

                followProgress: false,

                followStatus:  'Follow',

                userFollowing:  lscache.get('user_follower'),

                authUser: this.$root.authUser,


            }

        },
        computed:{

            school_url(  ) {

                return this.fullPath +  'school/' + this.school.url;
            },
            logo()  {

                return 'https://d2heijv3bffmsx.cloudfront.net/' + this.school.logo;
            },

            description()  {

                let description  = this.stripHtml  ( this.school.description  ) ;

                return description.substring(0, 300 ) + '...';

            },

        },


        methods: {

            redirect( ){

                this.$router.push('school/' + this.school.url );
            },

            stripHtml(  html ) {

                var temporalDivElement = document.createElement("div");

                temporalDivElement.innerHTML = html;

                return temporalDivElement.textContent || temporalDivElement.innerText || "";
            },

            follow_school() {

                this.followProgress = true;

                let status  = this.followStatus ;

                if( this.followStatus === 'Following') {

                    this.followStatus = 'Follow';

                } else {

                    this.followStatus = 'Following';

                }

                let param = { school_id: this.school.id , type:'school', status:status };


                axios.post( this.fullPath +'schools/follow',  param )
                    .then( res => {

                        this.followProgress = false;

                        this.followStatus === 'Following' ? this.school.followers  ++  :  this.school.followers  --;

                        let user_follower = res.data.data;

                        lscache.set('user_follower', user_follower );


                    });
            }
        },


        created()  {







        },

        mounted() {




            setTimeout( () => {

                if(this.userFollowing !== 'undefined' && this.userFollowing !== null  )
                {
                    this.userFollowing.forEach( item => {

                        if( item.type === 'school'  && item.object_id === this.school.id ) {

                            this.followStatus = 'Following'
                        }

                    });
                }


            }, 100);






        }
    }
</script>
