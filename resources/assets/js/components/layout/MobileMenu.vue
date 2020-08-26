<template>

    <div>



        <div class="mobile-header" role="banner">

            <div class="middle-icons">

                <a :href="fullPath">

                <img alt="expatsschools.com logo" :src="logoa"></a>

            </div>

            <div class="left-icons">

                <button type="button" @click="showMainNav('left')" >

                    <svg class="icon icon-menu">

                        <use :xlink:href="icon_menu"></use>

                    </svg>

                </button>

                <button type="button" data-id="js_main_search"><i class="icon-search"></i></button>

            </div>

            <div class="right-icons">

                <button type="button" data-id="js_main_settings"><i class="icon-gear"></i></button>

                <button type="button" @click="showMainNav('right')"><svg class="icon icon-person"><use :xlink:href="icon_person"></use></svg></button>


            </div>


        </div>


        <aside id="js-sidebar" class="trv-sidebar"  :class="menuShown===true? 'trv-sidebar--active' : 'd-none'" >

            <div class="trv-sidebar__content "  :class="slideFrom==='left'? 'trv-sidebar__content--leading' : 'trv-sidebar__content--trailing'">

                <div id="js-trv-sidebar-container">


                    <div class="sidebar__close__header close_menu_sidebar">

                        <div @click="closeSideBar" class="sidebar__banner"><span class="">Close</span></div>

                    </div>

                    <div class="fav-list js-right-bar-content">

                        <div class="sidebar-section">

                            <section class="cnt-box">

                                <div class="cnt-box__content js-window">

                                    <ul v-if="slideFrom  ===  'right' && user_data === null  " class="popover__select-ul">

                                        <li>Login as</li>

                                        <li><a  href=""  @click.prevent="loginRedirect('teacher')" ><svg class="icon icon-user-circle"><use :xlink:href="this.$parent.icon_circle"></use></svg><span>Teacher</span></a> </li>

                                        <li><a  href=""   @click.prevent="loginRedirect('parent')" ><svg class="icon icon-user-circle"><use :xlink:href="this.$parent.icon_circle"></use></svg><span>Parent</span></a> </li>

                                        <li><a  href="https://www.expatsschools.com/secure_admin/Admin/register" target="_blank" ><svg class="icon icon-user-circle"><use :xlink:href="this.$parent.icon_circle"></use></svg><span>School</span></a> </li>

                                        <li><a  @click.prevent="contactUrl"  :href="contact_url"><svg class="icon icon-shield"><use :xlink:href="this.$parent.icon_shield"></use></svg><span>Contact</span></a> </li>



                                    </ul>

                                    <ul v-if="slideFrom===  'right' && user_data !== null  " class="popover__select-ul">

                                        <li><p>You are logged in as</p></li>

                                        <li class="text-center">

                                            <a class="prof-image" :href="this.$parent.profile_url" >

                                                 <img :src="this.$parent.profile_photo" />
                                                 <br>

                                                <span>{{  user_data.first_name   }} {{  user_data.last_name   }}</span>

                                            </a>

                                        </li>

                                        <li>

                                            <a  @click.prevent="settingUrl" :href="setting_url"><svg class="icon icon-cog">

                                                <use :xlink:href="icon_cog"></use></svg>

                                                <span>Settings</span>
                                            </a>

                                        </li>
                                        <li>

                                            <a @click.prevent="logoutUser"  :href="logout_url"  >

                                                <svg class="icon icon-power-off">

                                                    <use :xlink:href="icon_power">

                                                    </use>

                                                </svg>

                                                <span>Logout</span>

                                            </a>

                                        </li>



                                    </ul>




                                    <ul v-if="slideFrom==='left' && user === null" class="popover__select-ul">



                                        <li>

                                            <a @click.prevent="loginRedirect('teacher')"  :href="about_url">

                                                <svg class="icon icon-sentiment_neutral">

                                                    <use :xlink:href="sentiment_neutral">

                                                    </use>

                                                </svg>
                                                School Staff

                                            </a>

                                        </li>

                                        <li>

                                            <a @click.prevent="loginRedirect('parent')"  :href="about_url">

                                                <svg class="icon icon-verified_user">
                                                    <use :xlink:href="verified_user"></use>
                                                </svg>
                                                Parents

                                            </a>

                                        </li>


                                        <li>

                                            <a
                                                    @click.prevent="registerSchool"

                                                    :href="about_url">

                                                <svg class="icon icon-graduation-cap">

                                                    <use :xlink:href="graduation_cap"></use>
                                                </svg>

                                                Schools

                                            </a>

                                        </li>



                                        <li>
                                            <a  @click.prevent="contactUrl()"  :href="contact_url"><svg class="icon icon-chat_bubble">

                                                <use :xlink:href="chat_bubble"></use>

                                            </svg>

                                                Contact
                                            </a>

                                        </li>


                                        <li>

                                            <a :href="about_url" @click.prevent="aboutUrl">

                                                <svg class="icon icon-info">
                                                    <use :xlink:href="icon_info"></use>
                                                </svg>
                                                About
                                            </a>

                                        </li>


                                    </ul>

                                    <ul v-if="slideFrom==='left' && user !== null" class="popover__select-ul">




                                            <li :class="page==='home'? 'current' : '' ">

                                                <a  @click.prevent="homeUrl" :href="home_url">

                                                    <svg class="icon icon-home">

                                                        <use :xlink:href="this.$parent.icon_home"></use>

                                                    </svg>

                                                    My Feed

                                                </a>

                                            </li>

                                            <li :class="page==='messages2'? 'current' : '' ">

                                                <a  @click.prevent="inboxUrl"   :href="messages_url">

                                                    <svg class="icon icon-comment">

                                                        <use :xlink:href="icon_comment"></use>

                                                    </svg>

                                                    Inbox

                                                </a>

                                            </li>

                                            <li :class="page==='user/network'? 'current' : '' ">

                                                <a  @click.prevent="networkUrl" :href="network_url">

                                                    <svg class="icon icon-handshake-o">

                                                        <use :xlink:href="icon_handshake"></use>

                                                    </svg>

                                                    Network

                                                </a>

                                            </li>

                                            <li :class="page==='news/index'? 'current' : '' ">

                                                <a  @click.prevent="newsUrl" :href="news_url">

                                                    <svg class="icon icon-coffee">

                                                        <use :xlink:href="icon_coffee"></use>

                                                    </svg>

                                                    News and Views

                                                </a>

                                            </li>

                                            <li :class="page==='classified/index'? 'current' : '' ">

                                                <a @click.prevent="adUrl" :href="classifieds_url">

                                                    <svg class="icon icon-bullhorn">

                                                        <use :xlink:href="icon_ads"></use>

                                                    </svg>

                                                    Classified

                                                </a>

                                            </li>

                                            <li :class="page==='jobs/joblist'? 'current' : '' ">

                                                <a @click.prevent="jobUrl" :href="job_url">

                                                    <svg class="icon icon-suitcase">

                                                        <use :xlink:href="icon_suitcase"></use>

                                                    </svg>

                                                    Jobs

                                                </a>

                                            </li>

                                            <li :class="page==='schools/list_school'? 'current' : '' ">

                                                <a @click.prevent="schoolUrl"  :href="school_url">

                                                    <svg class="icon icon-graduation-cap">

                                                        <use :xlink:href="graduation_cap"></use>

                                                    </svg>

                                                    Schools

                                                </a>

                                            </li>

                                            <li class="static-mobile-links">

                                             <a @click.prevent="aboutUrl"  :href="about_url" title="About"><span>About </span></a>

                                             <a @click.prevent="privacyUrl" :href="about_url" title=""><span style="">Privacy Policy</span></a>

                                             <!--<a @click.prevent="faqUrl" :href="faqs_url" title="Faq's"><span>FAQ'S</span></a> -->


                                             <a @click.prevent="termUrl"  :href="about_url" title="Terms &amp; Conditions"><span>Terms &amp; Conditions</span></a>

                                             <a  @click.prevent="" title="expatsschools.com"><span style="font-size: 11px;">© 2019 All rights reserved</span></a>

                                         </li>


                                     </ul>

                                </div>

                            </section>

                        </div>

                    </div>

                </div>

            </div>

        </aside>


    </div>
    
</template>

<script>


    export default {


        name: "MobileMenu",

        props:['fullPath', 'user', 'page'],

        data(){

            return {


                icon_menu: this.fullPath  +  'css/ico/symbol-defs.svg#icon-menu',

                icon_person: this.fullPath  +  'css/ico/symbol-defs.svg#icon-person',

                logoa:  this.fullPath  + 'css/img/logoa.png',

                about_url: this.fullPath +  'about',

                contact_url: this.fullPath + 'contact',

                school_register: this.fullPath +'register-your-school',

                messages_url: this.fullPath + 'messages',

                home_url: this.fullPath + 'home',

                network_url: this.fullPath + 'network',

                news_url: this.fullPath + 'news',

                classifieds_url: this.fullPath + 'classifieds',

                logout_url:  this.fullPath + 'user/logout',

                job_url: this.fullPath + 'jobs/list',

                school_url: this.fullPath + 'list_school',

                faqs_url:  this.fullPath + 'faqs',


                icon_info: this.fullPath +  'css/ico/symbol-defs.svg#icon-info',

                icon_coffee: this.fullPath +  'js/plugins/menu/symbol-defs.svg#icon-coffee',

                icon_suitcase: this.fullPath +  'js/plugins/menu/symbol-defs.svg#icon-suitcase',

                icon_handshake: this.fullPath +  'js/plugins/menu/symbol-defs.svg#icon-handshake-o',

                icon_ads :  this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-bullhorn',

                icon_circle :  this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-user-circle',

                icon_shield :  this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-shield',

                icon_power   :    this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-power-off',

                icon_cog:   this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-cog',

                icon_search:    this.fullPath +  'css/ico/symbol-defs.svg#icon-search',

                user_img: this.fullPath + 'css/img/user-img.png',

                setting_url:  this.fullPath + '/settings/basic',

                icon_bell:  this.fullPath +'js/plugins/menu/symbol-defs.svg#icon-bell-o',


                icon_comment: this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-comment',

                sentiment_neutral: this.fullPath +  'css/ico/symbol-defs.svg#icon-sentiment_neutral',

                verified_user: this.fullPath +  'css/ico/symbol-defs.svg#icon-verified_user',

                graduation_cap: this.fullPath +  'js/plugins/menu/symbol-defs.svg#icon-graduation-cap',

                chat_bubble: this.fullPath +  'css/ico/symbol-defs.svg#icon-chat_bubble',

                name: '',

                user_data: lscache.get('user_data'),

                menuShown: false,

                slideFrom: 'left',

            }


        },

        methods:{

            loginRedirect( type  ){

                lscache.set('init_choice', type );

                this.$router.push('/login') ;

            },

            termUrl(){

                this.$router.push('/es/terms' );
            },

            privacyUrl(){

                this.$router.push('/es/privacy' );
            },

            aboutUrl(){

                this.$router.push('/es/about' );
            },

            registerSchool(){

                this.$router.push('/register-your-school' );
            },





            schoolUrl(){

                this.$router.push('/schools');
            },

            profileUrl(){

                this.$router.push('/profile/' + this.user.username );
            },


            inboxUrl(){

                this.$router.push('/inbox');
            },


            adUrl(){

                this.$router.push('/classifieds');
            },

            jobUrl(){

                this.$router.push('/jobs');
            },

            newsUrl(){

                this.$router.push('/news');
            },

            networkUrl(){

                this.$router.push('/network');
            },



            contactUrl(){

                this.$router.push('/es/contact' );
            },




            logoutUser(   ){

                lscache.set('user_likes', null );

                lscache.set('user_block',   null );

                lscache.set('user',  null );

                lscache.set('user_data',  null );

                lscache.set('favourite',  null);

                axios.post( this.fullPath +'user/logout',  {} )
                    .then( res => {

                        window.location.href = this.fullPath ;
                    });




            },


            showMainNav( from ){

                if( from === 'left') {



                    setTimeout(() => {

                        this.slideFrom = 'left';

                        this.menuShown = true;

                        document.getElementsByTagName('body')[0].classList.add( 'aside-on' );

                    }, 100 );


                } else {



                    setTimeout(() => {

                        this.slideFrom = 'right';

                        this.menuShown = true;

                        document.getElementsByTagName('body')[0].classList.add( 'aside-on' );

                    }, 100 )


                }



            },
            closeSideBar() {

                setTimeout(() => {

                    this.menuShown = false;

                    document.getElementsByTagName('body')[0].classList.remove( 'aside-on' );
                }, 100 )
            }
        },
        created(){

                console.log(this.user_data);
        },
    }
</script>

<style scoped>

    a{ text-decoration: none; }

</style>