<template>

    <div class="margin-bottom-40"  v-if="noHeader===0" >


        <div v-if="innerWidth > 980  " class="top-menu">

            <div class="container">


                <div class="row no-gutters">


                    <div class="col-8 col-md-3 order-md-1 col-xl-2 order-xl-1 align-self-center">

                        <a :href="fullPath" class="main-logo">

                            <img :src="main_logo" alt="Expats Schools Logo">
                        </a>

                    </div>


                    <div class="col-4 col-md-3 order-md-3 col-xl-1 order-xl-4 align-self-center">

                        <ul v-if="user_data!==null" class="user">


                            <li>


                                <input v-model="guid"  type="hidden" id="guid" />

                                <a href="javascript:void(0);">

                                    <img class="profile-photo" :src="profile_photo" :alt="name">

                                </a>


                                <ul class="user-menu">


                                    <li>

                                        <a :href="profile_url" @click.prevent="profileUrl">

                                            <svg class="icon icon-user-circle">

                                                <use :xlink:href="icon_circle"></use>

                                            </svg>
                                            Profile

                                        </a>

                                    </li>





                                    <router-link  tag="li" active-class="active" to="/settings/basic" >
                                        <a>
                                            <svg class="icon icon-cog">

                                                <use :xlink:href="icon_cog"></use>
                                            </svg>
                                            Settings
                                        </a>

                                    </router-link>


                                    <li>

                                        <a :href="logout_url" @click.prevent="logoutUser" >

                                            <svg class="icon icon-power-off">
                                                <use xlink:href="icon_power"></use>
                                            </svg>

                                            Logout
                                        </a>

                                    </li>



                                </ul>


                            </li>

                        </ul>


                        <a  v-if="user_data!==null" href="" class="notify">

                            <span class="indctr d-none"></span>

                            <svg class="icon icon-bell-o">

                                <use :xlink:href="icon_bell">

                                </use>
                            </svg>

                        </a>



                        <ul  v-if="user_data===null" class="user">


                            <li>

                                <a href="javascript:void(0);"><img :src="user_img" alt=""></a>


                                <ul class="user-menu">

                                    <li>

                                        <a  onclick="return false"

                                            style="cursor:default;"

                                            href="" >

                                            Login as a
                                        </a>

                                    </li>

                                    <li>

                                        <a href=""  @click.prevent="loginRedirect('teacher')" >

                                            <svg class="icon icon-user-circle">

                                                <use :xlink:href="icon_circle"></use>

                                            </svg>
                                            Teacher

                                        </a>

                                    </li>

                                    <li>

                                        <a      href=""  @click.prevent="loginRedirect('parent')">

                                            <svg class="icon icon-user-circle">

                                                <use :xlink:href="icon_circle"></use>

                                            </svg>

                                            Parent
                                        </a>

                                    </li>



                                    <li>

                                        <a href="https://www.expatsschools.com/secure_admin/Admin/login" target="_blank" >

                                            <svg class="icon icon-user-circle">

                                                <use :xlink:href="icon_circle"></use>

                                            </svg>School

                                        </a>


                                    </li>




                                    <li>

                                        <a @click.prevent="contactUrl" :href="contact_url">

                                            <svg class="icon icon-shield">
                                                <use :xlink:href="icon_shield"></use>
                                            </svg>

                                            Contact

                                        </a>

                                    </li>



                                </ul>



                            </li>


                        </ul>







                    </div>
                    <div class="col-12 col-md-6 order-md-2 col-xl-2 order-xl-2 align-self-center">


                        <form class="search" style="display: none;">


                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Find</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">People</a>
                                        <a class="dropdown-item" href="#">Jobs</a>
                                        <a class="dropdown-item" href="#">Classifieds</a>

                                    </div>
                                </div>

                                <input type="text" class="form-control g_search" aria-label="Text input with dropdown button">


                                <button class="btn g_search_btn" type="button">

                                    <svg class="icon icon-search">

                                        <use :xlink:href="icon_search"></use>

                                    </svg>

                                </button>


                            </div>







                        </form>

                        <div class="ser-autocomplete"> </div>


                    </div>


                    <div v-if="user_data !== null" class="col-12 col-md-12 order-md-4 col-xl-7 order-xl-3 align-self-center">

                        <ul id="menu">


                            <li :class="page==='home'? 'current' : '' ">

                                <a  @click.prevent=""  :href="home_url">

                                    <svg class="icon icon-home">

                                        <use :xlink:href="icon_home"></use>

                                    </svg>

                                    My Feed

                                </a>

                            </li>



                            <router-link  tag="li" active-class="active" to="/inbox" >
                                <a>

                                    <svg class="icon icon-comment">

                                         <use :xlink:href="icon_comment"></use>

                                    </svg>

                                    Inbox

                                </a>

                            </router-link>

                            <router-link  tag="li" active-class="active" to="/network" >
                                <a>

                                    <svg class="icon icon-handshake-o">

                                        <use :xlink:href="icon_handshake"></use>

                                    </svg>

                                    Network

                                </a>

                            </router-link>


                            <router-link  tag="li" active-class="active" to="/news" >
                                <a>

                                    <svg class="icon icon-coffee">

                                        <use :xlink:href="icon_coffee"></use>

                                    </svg>

                                    News and Views
                                </a>

                            </router-link>

                            <router-link  tag="li" active-class="active" to="/classifieds" >
                                <a>
                                    <svg class="icon icon-bullhorn">
                                        <use :xlink:href="icon_ads"></use>
                                    </svg>

                                    Classifieds
                                </a>
                            </router-link>

                            <router-link  tag="li" active-class="active" to="/jobs" >
                                <a>
                                    <svg class="icon icon-suitcase">
                                        <use :xlink:href="icon_suitcase"></use>
                                    </svg>

                                    Jobs
                                </a>
                            </router-link>

                            <router-link  tag="li" active-class="active" to="/schools" >
                                <a>
                                    <svg class="icon icon-graduation-cap">
                                      <use :xlink:href="graduation_cap"></use>
                                    </svg>
                                    Schools
                                </a>
                            </router-link>





                            <!--
                                                        <li :class="page==='messages2'? 'current' : '' ">

                                                            <a :href="messages_url">

                                                                <svg class="icon icon-comment">

                                                                    <use :xlink:href="icon_comment"></use>

                                                                </svg>

                                                                Inbox

                                                            </a>

                                                        </li>

                                                        -->

                            <!--     <li :class="page==='user/network'? 'current' : '' ">

                                     <a :href="network_url">

                                         <svg class="icon icon-handshake-o">

                                             <use :xlink:href="icon_handshake"></use>

                                         </svg>

                                         Network

                                     </a>

                                 </li>

                                 <li :class="page==='news/index'? 'current' : '' ">

                                     <a :href="news_url">

                                         <svg class="icon icon-coffee">

                                             <use :xlink:href="icon_coffee"></use>

                                         </svg>

                                         News and Views

                                     </a>

                                 </li>

                                 <li :class="page==='classified/index'? 'current' : '' ">

                                     <a :href="classifieds_url">

                                         <svg class="icon icon-bullhorn">

                                             <use :xlink:href="icon_ads"></use>

                                         </svg>

                                         Classified

                                     </a>

                                 </li>

                                 <li :class="page==='jobs/joblist'? 'current' : '' ">

                                     <a :href="job_url">

                                         <svg class="icon icon-suitcase">

                                             <use :xlink:href="icon_suitcase"></use>

                                         </svg>

                                         Jobs

                                     </a>

                                 </li>

                                 <li :class="page==='schools/list_school'? 'current' : '' ">

                                     <a :href="school_url">

                                         <svg class="icon icon-graduation-cap">
                                             <use :xlink:href="graduation_cap"></use>
                                         </svg>
                                         Schools

                                     </a>

                                 </li>-->


                             </ul>

                         </div>



                         <div v-if="user_data === null" class="col-12 col-md-12 order-md-4 col-xl-7 order-xl-3 align-self-center">


                             <ul id="menu">


                                 <li>

                                     <a @click.prevent="loginRedirect('teacher')"  :href="login_url">

                                         <svg class="icon icon-sentiment_neutral">

                                             <use :xlink:href="sentiment_neutral">

                                             </use>

                                         </svg>
                                         Teachers + Support Staff

                                     </a>

                                 </li>

                                 <li>

                                     <a @click.prevent="loginRedirect('parent')"  :href="login_url">

                                         <svg class="icon icon-verified_user">
                                             <use :xlink:href="verified_user"></use>
                                         </svg>
                                         Parents

                                     </a>

                                 </li>


                                 <li>

                                     <a
                                             @click.prevent="registerSchool"

                                             :href="school_register">

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


                         </div>


                     </div>

                 </div>
             </div>


             <div v-else >



                 <mobile-menu :full-path="fullPath" :user="user" :page="page">

                 </mobile-menu>

             </div>




         </div>

     </template>

     <script>

         import MobileMenu from './MobileMenu';

         export default {

             name: "Header",

             props:['fullPath', 'user', 'page'],

             components:{

                 MobileMenu,
             },


             data(){


                 return {

                     noHeader: '',

                     guid:  '',

                     main_logo:  this.fullPath + 'css/img/logoa.png',

                     about_url: this.fullPath +  'es/about',

                     contact_url: this.fullPath + 'es/contact',

                     school_register: this.fullPath +'register-your-school',

                     messages_url: this.fullPath + 'messages',

                     home_url: this.fullPath + 'home',

                     network_url: this.fullPath + 'network',

                     news_url: this.fullPath + 'news',

                     classifieds_url: this.fullPath + 'classifieds',

                     logout_url:  this.fullPath + 'user/logout',

                     login_url: this.fullPath + 'login',

                     job_url: this.fullPath + 'jobs/list',

                     school_url: this.fullPath + 'list_school',

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

                     icon_home: this.fullPath +  'css/ico/symbol-defs.svg#icon-home',

                     icon_comment: this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-comment',

                     sentiment_neutral: this.fullPath +  'css/ico/symbol-defs.svg#icon-sentiment_neutral',

                     verified_user: this.fullPath +  'css/ico/symbol-defs.svg#icon-verified_user',

                     graduation_cap: this.fullPath +  'css/plugins/menu/symbol-defs.svg#icon-graduation-cap',

                     chat_bubble: this.fullPath +  'css/ico/symbol-defs.svg#icon-chat_bubble',

                     name: '',

                     user_data: lscache.get('user_data'),

                     innerWidth:  window.innerWidth,

                 }
             },

             computed:{


                 profile_url(){


                     return this.fullPath +  'profile/' + this.user_data.username;
                 },


                 profile_photo(){


                     return  'https://d2heijv3bffmsx.cloudfront.net/' +  this.user_data.profile_photo;
                 },


             },

             methods:{

                 profileUrl(){

                     this.$router.push('/profile/' +  this.user_data.username );
                 },

                 aboutUrl(){

                     this.$router.push('/es/about' );
                 },

                 registerSchool(){

                     this.$router.push('/register-your-school' );
                 },









                 contactUrl(){

                     this.$router.push('/es/contact' );
                 },


                 loginRedirect( type  ){

                     lscache.set('init_choice', type );

                     this.$router.push('/login');

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


             },
             beforeMount(){


                 this.user_data = lscache.get('user_data');

                 if( this.user_data !== null ){

                     this.guid =  this.user_data.id;
                 }

                 this.$parent.page = this.page;

             },
             created(){



                 setTimeout(() =>{

                     this.noHeader = this.$parent.noHeader;

                 }, 400);

             },
         }
     </script>

     <style scoped>



         .input-group>.input-group-prepend>.btn {

             width: auto;

             border-left: 1px solid #dcdcdc;

             font-size: 12px;

             font-weight: bold;
         }

         .input-group>.form-control:not(:first-child){

             height: 32px;

             outline: none;

             box-shadow: none;
         }

         .search{ margin: 0; }

         .margin-bottom-40{ margin-bottom: 40px;}

     </style>