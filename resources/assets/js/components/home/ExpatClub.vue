<template>
    <div>


        <main class="etc-home homes">

            <section class="etc_container_m"  >
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2>Expat Teachers Club</h2>


                            <carousel :autoplay="true" :nav="false"

                                      :responsive="{ 0:{items:1},

                                 768:{items:1},

                                 992:{items:1},

                                 1200:{items:1}

                      }"

                            >


                                <div class="item">
                                    <a href="" >
                                        <img :src="etc_main_image" alt="ETC ">
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="" >
                                        <img :src="etc_p_11" alt="ETC ">
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="" >
                                        <img :src="etc_p_2" alt="ETC ">
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="" >
                                        <img :src="etc_p_3" alt="ETC ">
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="" >
                                        <img :src="etc_p_4" alt="ETC ">
                                    </a>
                                </div>




                            </carousel>







                            <button v-if="user !== null " type="button"  class="btn    btn-cta">Enjoy</button>

                            <button v-else type="button" @click.prevent="loginUrl"  class="btn  js_join  btn-cta">Join us today</button>

                        </div>
                    </div>
                </div>
            </section>

            <section class="member-info expats">
                <div class="container">
                    <div class="row space-free our-apps" style="width:100%;">

                        <div class="col-12 col-md-6">

                            <h2>Tipping The Balance</h2>
                            <h3 class="text-center">Download our free app</h3>
                            <div class="mobile-icon"></div>

                            <div class=" text-center">
                                <a class="app-store" style="background-image: url('https://www.godesto.com/skin/f/theme/images/app_ios.png')"   href="https://itunes.apple.com/us/app/expat-teachers-club/id1446470008" target="_blank" ></a>
                                <a class="play-store" style="background-image: url('https://www.godesto.com/skin/f/theme/images/app_google.png')" href="https://play.google.com/store/apps/details?id=com.etc.godesto" target="_blank"></a>
                                <p>Teaching or working in schools is a tough job; not so much a job as a vocation; a passion. At expatsschools.com we want to recognize the great work done by teachers throughout Dubai, by giving them a little extra back. Our Expat Teachers Club gives you fantastic discounts on all aspects of life; entertainment, fashion, travel, finance and of course socializing. It is the only programme that rewards teachers, enabling them to enjoy more for less, outside of the classroom. Plus, the site features all the top teaching and support staff vacancies across Dubai’s schools as well as training and tutoring information. Whilst you’re preparing your class for the future we’re looking out for you and your career.</p>
                            </div>
                        </div>



                        <div class="col-6 col-md-6 screens">
                            <div class="iphone"></div>
                            <div class="android"></div>
                        </div>



                    </div>
                </div>
            </section>


            <section class="member-info">
                <div class="container">
                    <div class="row">
                        <div class="col-12" data-aos="fade-up" data-aos-offset="100">
                            <h3>Membership</h3>
                            <p>Step 1: Sign up as a teacher on the expatsschools.com website</p>
                            <p>Step 2: Once logged in, go to your profile and use your school email to verify that you are a teacher (currently only Dubai Schools).</p>
                            <p>Step 3: Download the Expat Teachers Club APP and log in using your personal email. </p>
                            <p>Step 4: If your school has been unlocked you will be able to enjoy a whole host of discounts and benefits. If not (check by clicking on verify membership), contact us.</p>
                        </div>
                    </div>
                </div>
            </section>



            <section class="spnsrd-slide">

                <div class="container">

                    <div class="row">

                        <div class="col-12">

                            <h2 class="spnsrd-title" style="text-align:left;">Friends of expatsschools</h2>


                            <carousel :autoplay="true" :nav="false"  :margin="20"

                                      :responsive="{ 0:{items:1},

                                 768:{items:2},

                                 992:{items:3},

                                 1200:{items:3}

                      }"

                            >


                                <div   v-for="(obj,index) in expatsFriends"   class="item">


                                    <a  :href="friend_url(obj.url)" @click.prevent="friendUrl(obj.url)" >

                                        <img
                                                :alt="obj.company_name"

                                                :src="coverImage(obj.cover_image)"

                                        >

                                    </a>

                                    <h3>{{ obj.company_name  }}</h3>

                                    <button

                                            class="btn f-red btn-cta"

                                            @click.prevent="friendUrl(obj.url)"
                                    >

                                        Take a Peek

                                    </button>
                                </div>


                            </carousel>


                        </div>
                    </div>
                </div>
            </section>


        </main>


    </div>
</template>

<script>

    import carousel from 'vue-owl-carousel'



    export default {

        name: "ExpatClub",

        props: ['fullPath'],

        components: {

            carousel,
        },

        data(){

            return{

                etc_main_image: this.fullPath + 'css/img/etc_main_image.png',

                etc_p_11: this.fullPath + 'css/img/etc_p_11.jpg',

                etc_p_2: this.fullPath + 'css/img/etc_p_2.jpg',

                etc_p_3: this.fullPath + 'css/img/etc_p_3.jpg',

                etc_p_4: this.fullPath + 'css/img/etc_p_4.jpg',

                user: lscache.get('user_data'),

                expatsFriends: [],


            }
        },

        methods: {

            friend_url( url ){

                return this.fullPath + 'friends/' + url ;

            },

            friendUrl(  url ){

                this.$router.push('/friends/' +  url  );

            },


            loginUrl(){

                this.$router.push('/login');

            },


            coverImage( c ){

                return 'https://www.expatsschools.com/secure_admin/media/images/home_gallery/'  + c;
            },
        },
        created(){

                this.expatsFriends = this.$parent.expatsFriends;

            console.log( this.expatsFriends );
        }
    }
</script>

<style scoped>


    .owl-stage-outer h3 {

        font-size: 1rem;

        margin: 10px 10px 5px 10px;
    }

    .owl-stage-outer img {

        border-radius: 3px;

        display: block;

        width: 100%;
    }


</style>