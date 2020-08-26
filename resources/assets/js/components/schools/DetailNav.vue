<template>

    <div>

    <nav :class="floating_nav===true? 'is_stuck': ''" class="sticky" ref="nav">

        <span class="menu js_open_nav" >

            <svg class="icon icon-menu">

                <use :xlink:href="icon_menu">

                </use>
            </svg>

            School Navigation

        </span>

        <ul id="nav" class="sidenav">

            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>

            <li class="current"><a  @click.prevent="scrollTo('#profile')" href="">Profile</a> </li>

            <li><a  @click.prevent="scrollTo('#gallery')" href="">Galleries</a> </li>


            <li v-if="ranches"><a  class="go_new" :href="url">Social Media</a> </li>

            <li>

                <a  @click.prevent="scrollTo('#news')"  href="">News &amp; Event</a>

            </li>

            <li>

                <a  @click.prevent="scrollTo('#admission')"   href="">Admission &amp; Fees</a>

            </li>

            <li>

                <a  @click.prevent="scrollTo('#job')"   href="">Jobs</a>

            </li>

            <li>

                <a  class="recommendation"	href="">Recommendation</a>

            </li>

            <li>

                <a  @click.prevent="scrollTo('#staff')" href="">Staff</a>

            </li>

            <li>

                <a  @click.prevent="scrollTo('#contact-info')" href="">Contact</a>

            </li>

        </ul>

    </nav>


    </div>

</template>

<script>

    var VueScrollTo = require('vue-scrollto');

    export default {

        name: "DetailNav",

        props: ['fullPath', 'url' ],

        data(){

            return{

                icon_menu:  this.fullPath + 'css/ico/symbol-defs.svg#icon-menu',

                ranches: false,

                floating_nav: false,

            }


        },

        methods:{


            scrollTo( element ){

                VueScrollTo.scrollTo( element , 300)

            },

            scroll () {

                /*
                *
                *   var stickySidebar = $('#sub-menu').offset().top;
                    $(window).scroll(function() {
                        if ($(window).scrollTop() > stickySidebar) {
                            $('#sub-menu').addClass('affix');
                        }
                        else {
                            $('#sub-menu').removeClass('affix');
                        }
                    });
	            */

                window.onscroll = (event) => {



                    let scrollY      =  window.scrollY ;
                    let wh           =  window.innerHeight;
                    let offsetTop    = this.$refs.nav.offsetTop;
                    let offsetH      = this.$refs.nav.offsetHeight;


                    if( scrollY >  offsetTop   ) {

                       this.floating_nav = true;

                    } else {

                        this.floating_nav = false;
                    }
                }
            },
        },
        created(){

            if( this.url === '"ranches-primary-school-1538734489"' ){

                this.ranches = true;

                this.url = this.fullPath  + 'school/news-events/'  + this.url;

            }

            this.scroll();
        }
    }
</script>

<style scoped>

    .is_stuck{position: fixed; top: 0px; width:100%;background: #3e3d95;}
    .is_stuck #nav a {color:#FFF;}

    .is_stuck #nav{    background: #3e3d95;
        color: #FFF;
        border-color: #3e3d95;}

</style>