<template>


<div>

    <main>


        <section class="intro         expat-items">

            <div class="container">

                <div class="row">

                    <div class="col-lg-6 col-md-6 col-12">

                        <h2>Join the home of international education</h2>

                        <p class="mg-top-30 text-center  d-none d-lg-block d-xl-block ">

                            <a class="btn f-red btn-cta inline-block" href="">

                                Learn More

                            </a>
                        </p>

                        <ul class="tag-cloud-list">
                            <li >
                                <a href="" class="pill"  @click.prevent="">
                                    Teachers
                                </a>
                            </li>
                            <li >
                                <a href=""   class="pill"  @click.prevent=""    >
                                    Teach abroad
                                </a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   >Parents</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Schools</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Jobs</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   >News and views</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   >Rewards</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Discounts</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Staff welfare</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Staff wellbeing</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   >Marketing</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Tutoring</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Dubai</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   >Free</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Recruitment</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Save</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Deals</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""    > Discover</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""  >Compare</a>
                            </li>
                            <li >
                                <a href=""     class="pill"  @click.prevent=""   > International</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""  > Expats</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Share</a>
                            </li>
                            <li >
                                <a href=""  class="pill"  @click.prevent=""   > Support</a>
                            </li>

                        </ul>


                    </div>

                    <div class="col-lg-6 col-md-6 col-12">



                        <div class="round-" >

                            <img
                                    :src="home1"
                                    alt="Connecting the world">


                        </div>


                    </div>


                </div>
            </div>



        </section>



        <section  id="#ES" class="home-slider">


            <carousel :autoplay="true" :nav="false"

                      :responsive="{ 0:{items:1},

                                 768:{items:1},

                                 992:{items:1},

                                 1200:{items:1}

                      }"

            >


                <div class="item" >
                    <div class="bg-fat-burn">


                        <img :src="icon_burner" alt="Teachers + Support Staff">

                        <h3>Teachers + Support Staff</h3>

                        <p >Expats' Schools is for teachers by teachers. We want to recognise the amazing work you do, by making life a little easier.</p>

                        <a href=""  @click.prevent="regUrl" ><span>Sign Up</span>

                            <svg class="icon icon-arrow_forward">

                                <use :xlink:href="icon_f"></use>
                            </svg>

                        </a>

                    </div>
                </div>



                <div class="item">
                    <div class="bg-fat-burn two">

                        <img :src="icon_burner" alt="For Schools"><h3>For Parents</h3>

                        <p>
                            Selecting a school away from home can be confusing, fear not Expats' Schools is designed to make. Choosing the best school for your kids that much simpler.
                        </p>

                        <a href="" @click.prevent="regUrl">

                            <span>Sign Up</span>

                            <svg class="icon icon-arrow_forward">

                                <use :xlink:href="icon_f"></use>

                            </svg>

                        </a>
                    </div>

                </div>



                <div class="item">

                    <div class="bg-fat-burn three">

                        <img :src="icon_burner" alt="For Schools">

                        <h3>For Schools</h3>

                        <p>
                            Expats' Schools is an independent platform. Connecting schools, parents and teachers
                        </p>

                        <a :href="register_school" @click.prevent="registerSchool">

                            <span>Sign Up</span>

                            <svg class="icon icon-arrow_forward">

                                <use :xlink:href="icon_f"></use>

                            </svg>

                        </a>


                    </div>
                </div>


            </carousel>






        </section><!-- END home-slider -->



        <section class="intro expat-list">

            <div class="container">

                <h2>We have no limits when we come together</h2>

                <div class="row no-gutters">


                    <div class="expat-list-container">

                        <a :href="es_url"  @click.prevent="esUrl">

                            <div class="expat-list-item">

                                <div class="expat-list-width  expat-list-text">

                                    <img :src="Etc_home" >

                                </div>

                                <div class="expat-list-width etc-sign etc-sign-one">

                                    <h3>Expat Teachers Club</h3>

                                    <p>

                                        Shh, just for us


                                    </p>

                                </div>

                            </div>

                        </a>

                    </div>

                    <div class="break">

                    <span>

                        <img :src="graduation_cap">


                    </span>

                    </div>

                    <div class="expat-list-container">

                        <a @click.prevent="jobUrl" :href="job_url">

                            <div class="expat-list-item">



                                <div class="expat-list-width etc-sign etc-sign-bg2">

                                    <h3>Jobs</h3>

                                    <p>

                                        No harm in looking

                                    </p>

                                </div>



                                <div class="expat-list-width expat-list-text">

                                    <img :src="jobs_home_2" >

                                </div>

                            </div>

                        </a>

                    </div>

                    <div class="break">

                    <span>

                        <img :src="graduation_cap">

                    </span>

                    </div>

                    <div class=" expat-list-container">

                        <a @click.prevent="jobUrl" :href="job_url">

                            <div class="expat-list-item">



                                <div class="expat-list-width expat-list-text">

                                    <img :src="tutoring_home_2" >

                                </div>

                                <div class="expat-list-width etc-sign etc-sign-bg3">

                                    <h3>Tutoring</h3>

                                    <p>

                                        That little boost
                                    </p>

                                </div>


                            </div>

                        </a>

                    </div>

                    <div class="break">

                    <span>

                        <img :src="graduation_cap">


                    </span>

                    </div>


                    <div class=" expat-list-container">

                        <a @click.prevent="schoolUrl" :href="school_url">

                            <div class="expat-list-item">



                                <div class="expat-list-width etc-sign etc-sign-bg4">

                                    <h3>Schools</h3>

                                    <p>

                                        Where in the world?

                                    </p>

                                </div>


                                <div class="expat-list-width expat-list-text">

                                    <img :src="school_home_2" >

                                </div>

                            </div>

                        </a>

                    </div>

                </div>







            </div>



        </section>



        <section class="intro expat-friend ">

            <div class="container">


                <div class="row">

                    <div class="col-12">

                        <h2>We get by with a little help from our friends</h2>

                    </div>

                </div>

                <div
                        v-for="(obj,index) in expatsFriends"

                        class="partner"

                        :class="exactClass(index)"


                >

                    <div class="container">

                        <div class="row">


                            <div class="col-12 col-sm-4 col-md-3 col-xl-4">
                                <div class="partner-logo">

                                    <img
                                            :alt="obj.company_name"

                                            :src="coverImage(obj.cover_image)"
                                    >

                                </div>

                            </div>

                            <div class="col-12 col-sm-8 col-md-9 col-xl-8">

                                <h2>{{ obj.company_name  }}</h2>
                                <p v-html="obj.intro">

                                </p>

                                <a :href="friend_url(obj.url)" @click.prevent="friendUrl(obj.url)"

                                   class="btn  js_join  btn-cta">

                                    Read More

                                </a>

                            </div>


                        </div>


                    </div>


                </div>

                <div class="break">

                    <span>

                        <img :src="graduation_cap">

                    </span>
                </div>




            </div>

        </section>







    </main>

</div>


</template>

<script>

    //import LoadAnim from './LoadAnim';

    import carousel from 'vue-owl-carousel'


    export default {


        name: "HomeComponent",

        props: ['fullPath'],

        components:{

            carousel,
        },

        data(){


            return{


                icon_burner: this.fullPath + 'css/img/newhome/icon-burner.svg',

                graduation_cap: this.fullPath + 'css/img/newhome/graduate-cap.png',

                home1: this.fullPath + 'css/img/newhome/home1.png',

                Etc_home: this.fullPath + 'css/img/newhome/Etc_home.png',

                jobs_home_2: this.fullPath + 'css/img/newhome/jobs_home_2.png',

                tutoring_home_2: this.fullPath + 'css/img/newhome/tutoring_home_2.jpg',

                school_home_2: this.fullPath + 'css/img/newhome/school_home_2.jpg',

                job_url:  this.fullPath + 'jobs',

                school_url:  this.fullPath + 'schools',

                es_url:  this.fullPath + 'expat-teachers-club',

                expatsFriends:  this.$parent.expatsFriends,

                icon_f: this.fullPath + 'css/plugins/menu/symbol-defs.svg#icon-arrow_forward',

                register_school:  this.fullPath + 'register-your-school',




            }
        },

        computed:{


        },

        methods:{

            friend_url( url ){

                return this.fullPath + 'friends/' + url ;

            },

            friendUrl(  url ){

                this.$router.push('/friends/' +  url  );

            },

            registerSchool( ){

                this.$router.push( '/register-your-school'  );

            },

            regUrl( ){

                this.$router.push( '/registration'  );

            },




            coverImage( c ){

              return 'https://www.expatsschools.com/secure_admin/media/images/home_gallery/'  + c;
            },
            exactClass( index ){

                let cls = '';

                index   = index + 1;

                if( index === 1  ) {

                    cls = 'partner-light';
                }
                if( index === 2  ) {

                    cls = 'partner-blue';
                }
                if( index === 3  ) {

                    cls = 'partner-green';
                }

                return  cls;
            },
            jobUrl(){

                this.$router.push( '/jobs' );
            },

            schoolUrl(){

                this.$router.push( '/schools' );
            },

            esUrl(){

                this.$router.push( '/expat-teachers-club' );
            },

            imgUri( c ){

                return 'https://www.expatsschools.com/secure_admin/media/images/home_gallery/'  +  c;

            },

            urlFriend( url ){

                return this.fullPath +  'friends/' + url ;
            }
        },

        created(){



            //console.log(    JSON.parse(  this.expatFriends  ) );

            //console.log( this.expatFriends[0] );
        }
    }
</script>
<style scoped>


</style>
