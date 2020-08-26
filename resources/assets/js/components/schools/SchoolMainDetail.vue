<template>
<div>

    <div v-if="loader" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

    <schooldetail-header

            v-if="loader === false "

            :full-path="fullPath"

            :school-profile="school_profile"
    >


    </schooldetail-header>




    <detail-nav :url="url"  :full-path="fullPath">

    </detail-nav>

    <main class="school_profile">

        <div class="container">

            <div class="row">

                <div class="col-12 col-md-3 col-left">

                    <social-sharing :url="school_url(school_profile.url)"
                                    :title="school_profile.name"
                                    inline-template>
                        <div id="social-share" class="text-center">


                            <network network="facebook">

                                <i class="fab fa-facebook"></i> Facebook

                            </network>


                            <network network="linkedin">

                                <i class="fab fa-linkedin"></i> LinkedIn

                            </network>


                            <network network="twitter">

                                <i class="fab fa-twitter"></i> Twitter

                            </network>

                        </div>

                    </social-sharing>



                    <schooladmission-component v-if="school_profile.admission_email  !== null &&  school_profile.admission_email  !== ''   "

                            :full-path="fullPath"

                            :school-profile="school_profile"
                    >


                    </schooladmission-component>




                </div>

                <div class="col-12 col-md-9 col-right ">

                    <h2>Leadership: <span style="color:rgba(0, 0, 0, 0.7)">{{  school_profile.principal_name }}</span></h2>

                    <school-welcome

                            :full-path="fullPath"

                            :school-profile="school_profile"
                    >


                    </school-welcome>

                    <div v-if="school_profile.video !== ''  &&  typeof school_profile.video !== 'undefined' " class="frame" id="video">

                        <h2>School Video</h2>

                        <div class="embed-responsive embed-responsive-16by9">

                            <iframe class="embed-responsive-item" :src="videoUrl" allowfullscreen></iframe>

                        </div>

                    </div>

                    <div class="frame" id="profile">

                        <h2>Profile</h2>

                        <ul class="data-type">

                            <li><strong>School type</strong><span>{{ school_profile.school_type  }} </span></li>

                            <li>
                                <strong>Ages taught</strong>

                                <span>

                                     <ul>  <li :key="index" v-for="(age,index)  in ages_taught">{{ age  }}</li></ul>

                                 </span>

                            </li>


                            <li><strong>School Size</strong><span>{{ school_profile.boy_size  }} boys  {{ school_profile.girl_size  }} girls</span> </li>

                            <li><strong>Curriculums</strong><span>{{ school_profile.curriculums  }}</span> </li>

                            <li><strong>Day and Boarding</strong><span>{{ school_profile.day_boarding  }}</span> </li>

                            <li v-if="school_profile.key_features !==  ''">

                                    <strong>Key features</strong>

                                <span>

                                    {{    school_profile.key_features }}

                                </span>

                            </li>


                        </ul>

                    </div>


                    <div v-if="school_news.length >  0" class="frame" id="news">

                        <h2>News &amp; Events</h2>

                        <div class="owl-carousel owl-theme owl-news">

                            <input type="hidden" id="news_count" :value="school_news.length"  />

                            <div v-for="news_o in school_news" class="item">


                                <a :href="newsUrl(news_o.id,  news_o.url  )" >

                                    <img :src="imageUrl(news_o.photo)" alt="">

                                </a>


                                <h3>

                                    <a  :href="newsUrl"  >

                                        {{ news_o.title }}

                                    </a>

                                </h3>


                                <small>
                                        {{ news_o.dated }}

                                </small>


                            </div>

                        </div>

                    </div>



                    <div class="frame" id="admission">
                        <h2>Admission &amp; Fees</h2>
                        <h2 class="title">Year 2018-2019</h2>
                        <div class="table-responsive">
                            <table class="table  table-sm table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Stage</th>
                                    <th scope="col">Fee (Annual)</th>
                                    <th scope="col">Enrolled Students</th>
                                    <th   scope="col">Open/Waiting List</th>
                                    <th   scope="col">Classes</th>
                                </tr>
                                </thead>
                                <tbody>



                                <tr v-for="obj in year1">
                                    <th scope="row">{{  obj.stage }}</th>
                                    <td>{{  obj.fee }}</td>
                                    <td>{{  obj.students }}</td>
                                    <td>{{  obj.availability }}</td>
                                    <td>{{  obj.classes }}</td>

                                </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="next_year">
                            <h2 class="title">Year 2019-2020</h2>

                            <h2 v-if="year2.length === 0 ">No information found.</h2>

                            <div class="table-responsive">
                                <table class="table  table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">Stage</th>
                                        <th scope="col">Fee (Annual)</th>
                                        <th scope="col">Enrolled Students</th>
                                        <th   scope="col">Open/Waiting List</th>
                                        <th   scope="col">Classes</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr v-for="obj in year2">
                                        <th scope="row">{{  obj.stage }}</th>
                                        <td>{{  obj.fee }}</td>
                                        <td>{{  obj.students }}</td>
                                        <td>{{  obj.availability }}</td>
                                        <td>{{  obj.classes }}</td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>



                        </div>


                        <div class="next_year">
                            <h2 class="title">Year 2020-2021</h2>


                            <h2 v-if="year3.length === 0 ">No information found.</h2>


                            <div class="table-responsive">
                                <table class="table  table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">Stage</th>
                                        <th scope="col">Fee (Annual)</th>
                                        <th scope="col">Enrolled Students</th>
                                        <th   scope="col">Open/Waiting List</th>
                                        <th   scope="col">Classes</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr v-for="obj in year3">
                                        <th scope="row">{{  obj.stage }}</th>
                                        <td>{{  obj.fee }}</td>
                                        <td>{{  obj.students }}</td>
                                        <td>{{  obj.availability }}</td>
                                        <td>{{  obj.classes }}</td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>


                        </div>



                    </div>

                    <div v-if="school_uniform.length > 0  " class="frame" id="job">
                        <h2>Uniform</h2>
                        <div class="table-responsive">
                            <table class="table  table-sm table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Link</th>
                                    <th scope="col">Price</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="uniform in school_uniform">

                                    <td><a target="_blank" :href="uniform.link_to">View Detail</a></td>
                                    <td scope="row">AED {{ uniform.cost }}</td>

                                </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>




                    <div v-if="jobs.length > 0  " class="frame">

                        <h2>Jobs</h2>

                        <div class="requests row">

                            <div v-for="obj in jobs" class="item col-md-6 col-sm-6 col-xs-12">

                                <div class="user-card">

                                    <a
                                            @click.prevent="jobUrl( obj.url) "

                                            :href="job_url( obj.url) ">

                                        {{ obj.title }}
                                    </a>

                                    <span>

                                        <p>Experience:  {{ obj.experience }}</p>

                                        <p>Apply  Before: {{ obj.apply_before }}</p>


                                     </span>


                                    <a
                                            @click.prevent="jobUrl( obj.url) "

                                            :href="job_url( obj.url) "

                                            class="btn btn-primary"

                                    >
                                        View Job

                                    </a>


                                </div>

                            </div>

                        </div>

                    </div>



                    <school-staff  :full-path="fullPath"  :school-profile="school_profile">


                    </school-staff>



                    <div v-if="school_reviews.length > 0 " class="frame" id="recommend">

                        <h2>Recommendation</h2>

                        <div class="owl-carousel owl-theme owl-recommend">

                            <div v-for="obj in school_reviews" class="item">

                                <div class="recommend">

                                    <img :src="reviewImage" alt="">

                                    <strong>{{ obj.text }}</strong>

                                    <small>{{ obj.date_added }}</small>

                                    <p>{{ obj.text }}</p>

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="frame" id="contact-info">


                        <h2>Contact</h2>

                        <p>

                            <svg class="icon icon-room">
                                <use :xlink:href="icon_room"></use>
                            </svg>

                            {{    school_profile.address  }}

                        </p>

                        <p>

                            <svg class="icon icon-phone">
                                <use :xlink:href="icon_phone"></use>
                            </svg>

                            {{    school_profile.phone  }}

                        </p>

                        <p>

                            <svg class="icon icon-mail_outline">
                                <use :xlink:href="icon_mail_outline"></use>
                            </svg>

                            <a href="mailto:<?php echo $school_profile -> email;?>">

                                {{    school_profile.email  }}

                            </a>

                        </p>

                        <img :src="mapUrl" alt="School Map" class="img-fluid">


                        <p class="text-center d-none"><a href="" class="js_large_map">Enlarge Map</a></p>


                    </div>





                </div>

            </div>

        </div>

    </main>

</div>


</template>

<script>

    import   SchooldetailHeader from  './SchooldetailHeader';

    import   DetailNav from  './DetailNav';

    import   SchooladmissionComponent from  './SchooladmissionComponent';

    import   SchoolWelcome from  './SchoolWelcome';

    import   SchoolStaff from  './SchoolStaff';

    let SocialSharing = require('vue-social-sharing');


    export default {

        name: "SchoolMainDetail",

        props: ['fullPath'],

        components: {

            SchooldetailHeader,

            DetailNav,

            SchooladmissionComponent,

            SchoolWelcome,

            SchoolStaff,

            SocialSharing,
        },

        data(){

            return {

                ages_taught: [],

                school_profile : '',

                school_uniform : '',

                jobs : '',

                school_reviews : '',

                year1 : '',

                year2 : '',

                year3 : '',

                school_fee: '',

                loader: true,

                url:'',

                school_news: [],

                icon_mail_outline:  this.fullPath + 'css/ico/symbol-defs.svg#icon-mail_outline',

                icon_phone:  this.fullPath + 'css/ico/symbol-defs.svg#icon-phone',

                icon_room:  this.fullPath + 'css/ico/symbol-defs.svg#icon-room',

             }

        },

        computed:{
            //
            // <?php echo $school_profile -> latitude;?>,<?php echo $school_profile -> longitude;?>

            mapUrl(){

               if( typeof this.school_profile.latitude !== 'undefined' ){

                   return 'https://maps.googleapis.com/maps/api/staticmap?center=Dubai&zoom=13&size=365x180&maptype=roadmap&markers=color:red%7Clabel:S%7C'

                       + this.school_profile.latitude + ',' +    this.school_profile.longitude +  '&key=AIzaSyB_O3eana1MbjibnAWKwIg7cPCHXQ-8fN4';

               }

               return  '';

            },


            videoUrl(){

                if( typeof this.school_profile.video !== 'undefined' ){

                    let video = this.school_profile.video.split('?v=');

                    if( typeof video !== 'undefined' ){

                        video = video[1];

                        return 'https://www.youtube.com/embed/' + video + '?rel=0';
                    }

                }


                return  '';

            },

        },

        methods:{

            reviewImage(){

              return  this.fullPath + 'css/img/user-05.png';
            },

            newsUrl(id, url){

                return  this.fullPath +  'post/' + id + '/' + url;

            },

            imageUrl( photo  ){

                let image  ='';

                if( photo  === '' )
                {
                    image = this.fullPath +  '/css/img/image-01.jpg';
                }
                else
                {
                    image = this.fullPath  + '/articles/' +   photo ;
                }

                return   image;

            },

            school_url( url ){

               return this.fullPath + '/school/' + url ;
            },

            job_url( job_url ){

                return this.fullPath + '/jobs/' + this.school_profile.url  +  '/'  + job_url;
            },
            jobUrl( job_url ){

                this.$router.push( '/jobs/' + this.school_profile.url  +  '/'  + job_url );

            },
            school_data(){

                axios.post(  this.fullPath + 'sp/school/detail', {url:   this.url})

                    .then( response => {

                        let response_info = response.data.data;

                        this.school_profile = response_info.school_profile[0];

                        this.ages_taught = this.school_profile.ages_taught.split(',');

                        this.school_uniform = response_info.school_uniform;

                        this.school_reviews = response_info.school_reviews;

                        this.jobs           = response_info.jobs;

                        this.school_uniform = response_info.school_uniform;

                        this.year1          = response_info.year1;

                        this.school_fee     = response_info.school_fee;

                        this.year2           = response_info.year2;

                        this.year3           = response_info.year3;

                        this.school_news     = response_info.school_news;

                        this.loader          = false;

                    });

            },

        },

        beforeCreate(){

        },





        mounted(){

            this.url = this.$route.params.url;

            this.school_data();
        }
    }
</script>

<style scoped>

    .school_profile{ margin-top: 20px;}

    #social-share{margin-bottom: 20px; }

</style>