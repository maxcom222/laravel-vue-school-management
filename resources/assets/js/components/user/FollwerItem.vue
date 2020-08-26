<template>

    <div>


        <a

                @click.prevent="profileUrl(fol.username)"

                :href="profile_url(fol.username)"

                class="teachers-card"
        >

            <img

                    :src="profile_photo(fol.profile_photo)"

                    alt="Profile">



        </a>


        <span>

                     <strong>{{ fol.first_name }} {{ fol.last_name }} </strong>

                     <small>{{  fol.recent_job }}</small>

                </span>

        <span class="people">
                    <svg class="icon icon-people">

				         <use :xlink:href="icon_people"></use>

                    </svg>

                    {{  fol.followers }}  followers

                </span>


        <p>{{ description(fol.about) }}</p>

        <ul class="fav-actions">

            <li>

                <a
                        href=""

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


            </li>


            <li>

                <a
                        @click.prevent="profileUrl(fol.username)"

                        :href="profile_url(fol.username)">

                    <svg class="icon icon-open_in_new">

                        <use :xlink:href="icon_open_in_new"></use>

                    </svg>

                    View Profile

                </a>

            </li>

        </ul>




    </div>
</template>

<script>


    export default {

        name: "FollwerItem",

        props:['fol','fullPath','user'],

        data(){


                return{

                    icon_check: this.fullPath + 'css/ico/symbol-defs.svg#icon-check',

                    icon_open_in_new: this.fullPath + 'css/ico/symbol-defs.svg#icon-open_in_new',

                    icon_people:  this.fullPath + 'css/ico/symbol-defs.svg#icon-people',

                    followProgress: false,

                    followStatus:  'Follow',

                    userFollowing:  lscache.get('user_follower'),

                    icon_remove_circle:  this.fullPath + 'css/ico/symbol-defs.svg#icon-remove_circle',


                }

        },

        methods:{

            profileUrl(u){


                this.$router.push('/profile/' + u );
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

                let param = { school_id: this.fol.id , type:'person', status:status };

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
        },

        created(){

            setTimeout( () => {

                if(this.userFollowing !== 'undefined' )
                {
                    this.userFollowing.forEach( item => {

                        if( item.type === 'person'  && item.object_id === this.fol.id ) {

                            this.followStatus = 'Following'
                        }

                    });
                }


            }, 50);

        }
    }
</script>

<style scoped>
.fav-actions li a{
    cursor: pointer; }
</style>