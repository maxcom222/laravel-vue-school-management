<template>


    <div>



        <nav class="sticky profile">

            <span
                    class="menu"

                    onclick="openNav()">

                <svg class="icon icon-menu">

                    <use :xlink:href="icon_menu">

                    </use>

                </svg>

                Profile Navigation

            </span>

            <ul id="nav" class="sidenav profile-nav">

                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>


                <li><a  @click.prevent="scrollTo('#education')" href="">Education</a></li>

                <li><a  @click.prevent="scrollTo('#experience')" href=""    >Experience</a></li>

                <li><a  @click.prevent="scrollTo('##gallery')" href=""  >Gallery</a></li>

                <li><a  @click.prevent="scrollTo('#recommend')" href=""   >Recommendation</a></li>

                <li><a @click.prevent="scrollTo('#publication')" href="" >Publications</a></li>

                <li><a  @click.prevent="scrollTo('#my_follower')" href="">Followers</a></li>

                 <li v-if="selfView!==1"><a href="" class="js_inbox">Message</a></li>

                 <li   v-if="selfView===1"><a   @click.prevent="scrollTo('#invite_friend')" href="">Invite Friends</a></li>


                <li  v-if="selfView!==1 && block===0"  >

                    <a
                            href=""


                            class="js_block_user">

                        Block

                    </a>

                </li>



                <li v-if="selfView!==1 &&  block!==0 "  >

                    <a
                            href=""

                            class="js_block_user">

                        Unblock

                    </a>

                </li>



            </ul>
        </nav>






    </div>

</template>



<script>

    var VueScrollTo = require('vue-scrollto');


    export default {

    name: "ProfileNav",

    props: ['fullPath', 'user', 'selfView', 'block'],


    data()  {


        return{

            icon_menu : this.fullPath + 'css/ico/symbol-defs.svg#icon-menu',



        }
    },

    computed: {

        user_follower() {

            return  this.user.followers === 0  ?  'No followers' : this.user.followers  + ' followers';
        },



    },
    methods:{

        scrollTo( element ){

            VueScrollTo.scrollTo( element , 300)

        },

    },



    created() {


    }
}
</script>

<style scoped>

</style>