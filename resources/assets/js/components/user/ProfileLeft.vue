<template>
    <ul class="nav profile-page flex-column ">


        <li class="nav-item ">

            <a href=""  v-ripple.mouseover="'rgba(193,216,254, 0.35 )'"    @click.prevent="showContactDialog" class="nav-link ">

                <svg class="icon  icon-chat_bubble">

                    <use :xlink:href="chat_bubble"></use>

                </svg>

                Contact Information

            </a>

        </li>

        <li class="nav-item">

            <a href=""  v-ripple.mouseover="'rgba(193,216,254, 0.35 )'" @click.prevent="showTwitterDialog"  class="nav-link">

                <svg class="icon icon-twitter">

                    <use :xlink:href="twitter_icon"></use>

                </svg>

                 Twitter Feed

            </a>

        </li>



        <li v-if="selfView!==1"  class="nav-item">

            <a href="" @click.prevent="sendMessage()"  v-ripple.mouseover="'rgba(193,216,254, 0.35 )'" class="nav-link">

                <svg class="icon icon-comment">

                    <use :xlink:href="icon_comment"></use>

                </svg>

                Send Message

            </a>

        </li>

        <li v-if="selfView!==1"  class="nav-item">

            <a   href=""   v-ripple.mouseover="'rgba(193,216,254, 0.35 )'" class="nav-link">

                <svg class="icon  icon-graduation-cap">

                    <use :xlink:href="graduation_cap"></use>

                </svg>

                Block

            </a>

        </li>






        <li  v-if="selfView===1" class="nav-item">

            <a :href="classifieds_url"    v-ripple.mouseover="'rgba(193,216,254, 0.35 )'"  class=" ">

                <svg class="icon icon-bullhorn">

                    <use :xlink:href="icon_ads"></use>

                </svg>

                Classifieds

            </a>

        </li>








    </ul>

</template>

<script>

    import {eventBus} from '../../app.js'

    export default {

        name: "ProfileLeft",

        props:  ['fullPath', 'selfView'],

        data(){

            return {

                classifieds_url: this.fullPath + 'settings/user-ads',

                icon_ads :  this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-bullhorn',

                graduation_cap: this.fullPath +  'css/plugins/menu/symbol-defs.svg#icon-graduation-cap',

                twitter_icon:this.fullPath +  'css/ico/symbol-defs.svg#icon-twitter',

                tut_icon:this.fullPath +  'css/ico/symbol-defs.svg#icon-tut',

                verify_icon: this.fullPath +  'css/ico/symbol-defs.svg#icon-verify',

                chat_bubble: this.fullPath +  'css/ico/symbol-defs.svg#icon-chat_bubble',

                icon_comment:  this.fullPath +  'js/plugins/menu/symbol-defs.svg#icon-comment',




            }
    },

        methods: {


            showTwitterDialog(){

                let obj = {show: true };

                eventBus.$emit('twitterDialogLeftMenu', obj );
            },

            showContactDialog(){



                let obj = {show: true };

                eventBus.$emit('contact_DialogLeftMenu', obj );
            },

            showSpecDialog(){

                let obj = {show: true };

                eventBus.$emit('specDialogLeftMenu', obj );
            },

            sendMessage(){

                this.$router.push('/inbox/' + this.$parent.user.id  );

            }



        },
    }
</script>

<style scoped>

    .profile-page li a { font-size: 14px; font-weight: bold; color: rgba(0,0,0,0.5);
        display: flex;

        color: #222;

        padding: 9px 20px;

        cursor: pointer;


    }

    .profile-page li a:focus,.profile-page li a:hover {
        color: #008329;
        background-color: #F9F9F9;
        text-decoration: none;

        cursor: pointer;
    }
    .icon {


        display: inline-block;
        width: 1em;
        height: 1em;
        stroke-width: 0;
        stroke: currentColor;
        fill: currentColor;
        float: left;

        min-height: 100%;
        font-size: 16px;
        line-height: 16px;
        margin: 0 20px 0 0;
        margin-top: 3px;
        vertical-align: middle;
    }
    .profile-page .icon{margin-top: 5px;}

</style>