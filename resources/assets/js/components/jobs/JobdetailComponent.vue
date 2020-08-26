<template>


    <div>


        <div v-if="loader" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>



        <div  v-if="loader===false"  >
            <header class="page-title bg-job">

                <div class="container">

                    <div class="row">

                        <div class="col-12 job-title">

                            <a @click.prevent="schoolUrl(schoolProfile.url)" :href="schoolProfile.url"  class="logo-company">

                                    <img :src="schoolLogo(schoolProfile.logo)" :alt="schoolProfile.name">

                             </a>

                            <h1>{{ jobItem.title }}</h1>

                            <span>

                                Published: {{ jobItem.date_posted }}


                            </span>


                            <em>by

                                <a @click.prevent="schoolUrl(schoolProfile.url)" :href="schoolProfile.url">

                                    {{ schoolProfile.name  }}

                                </a>

                            </em>

                        </div>

                    </div>

                </div>

            </header>


            <main class="two-cloumn">

                <div class="container">

                    <div class="row">

                        <div class="col-12 col-md-4 col-left">

                            <div class="frame share job-info">

                                <ul class="job-stats">

                                    <li>
                                        <strong>Apply before:</strong>

                                        <p>

                                            {{  jobItem.apply_before  }}

                                            <!--  job_url -->

                                            <!-- jid -->

                                            <!-- school_url -->

                                        </p>

                                    </li>

                                    <li> <strong>Contract Type:</strong><p>{{ jobItem.contract_type  }}</p>

                                    </li>

                                    <li> <strong>Total Positions:</strong><p>{{ jobItem.total_position  }}</p>

                                    </li>

                                    <li> <strong>Experience:</strong><p>{{ jobItem.experience  }}</p>

                                    </li>


                                    <li> <strong>Gender:</strong><p>{{ jobItem.gender  }}</p>

                                    </li>

                                    <li> <strong>Salary:</strong><p>{{ jobItem.salary_band  }}</p>

                                    </li>

                                </ul>


                                <button @click="job_modal=!job_modal" class="btn btn-primary" v-if="user !== null ">Apply for this Job</button>

                                <p v-else class="login-j-content">Login <a class="login" @click.prevent="loginUrl" :href="login_url">here </a> to apply</p>



                                <p class=" text-center al-app d-none alert alert-success"></p>

                                <strong>Share</strong>


                                <social-sharing :url="detailUri"
                                                :title="jobItem.title"
                                                inline-template>
                                    <div id="social-share " class="text-center">

                                        <network network="email">

                                            <i class="fa fa-envelope"></i> Email

                                        </network>

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


                            </div>

                        </div>

                        <div class="col-12 col-md-8 col-right">

                            <div class="frame news-article">

                                <h2>Job Summary</h2>

                                <div v-html="jobItem.description">



                                </div>

                                <h2>Benefits</h2>

                                <ul class="benefits">


                                    <li  v-for="(ben,index) in benefits"  :key="Math.random() + '_' + index">

                                        <svg class="icon icon-check"><use :xlink:href="icon_check"></use></svg>

                                        {{ ben }}

                                    </li>



                                </ul>

                                <h2>About {{ schoolProfile.name}}</h2>

                                <div v-html="schoolProfile.description">

                                </div>




                            </div>

                        </div>

                    </div>




                </div>

            </main>


        </div>










        <div v-if="job_modal">

            <transition name="modal">

                <div class="modal-mask" >

                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title" id="coverUiLabel">Job Application</h5>



                                    <button type="button"  class="close" data-dismiss="modal" aria-label="Close">

                                        <span aria-hidden="true"  @click="job_modal=!job_modal">&times;</span>

                                    </button>



                                </div>

                                <div class="modal-body" style="height: 500px;">

                                    <p class="lead">Your public profile link will be shared with the employer.</p>


                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">Cover letter *</label>


                                        <div class="col-12">

                                            <textarea

                                                     v-model="user_about"

                                                     class="form-control"

                                                      id="cover_letter"

                                                      style="height:200px;" ></textarea>


                                        </div>

                                    </div>


                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">

                                            <input type="checkbox" ref="approve1"  />

                                            I confirm that the information provided in my profile

                                            and cover letter is accurate and true.

                                        </label>

                                    </div>


                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">

                                            <input type="checkbox" ref="approve2"   />

                                            I understand that only shortlisted

                                            candidates may be contacted.

                                        </label>

                                    </div>


                                    <div class="form-group  row" :class="check_cond===false ? 'd-none' : ''">

                                        <div class="col-12 text-center">

                                            <p class="alert-danger nice-padding">Please check on both checkboxes</p>

                                        </div>


                                    </div>



                                    <div class="form-group  row" v-if="check_if_already_applied ===  false">

                                        <label for="" class="col-12 col-form-label"></label>

                                        <div class="col-12 text-center">

                                            <button @click="submitApplication"  class="btn btn-primary">Submit Application</button>


                                        </div>

                                    </div>

                                    <div class="form-group  row"  v-if="check_if_already_applied ===  true">


                                        <div class="col-12 text-center">

                                            <p class="alert-success alert nice-padding">
                                                You have already applied for this job.
                                            </p>

                                        </div>

                                    </div>



                                    <div class="form-group  row" :class="apply_success===false ? 'd-none' : ''">

                                        <div class="col-12 text-center">

                                            <p class="alert-success alert nice-padding">Your application is submitted successfully</p>

                                        </div>


                                    </div>


                                </div>

                                <div class="modal-footer">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </transition>

        </div>



    </div>


</template>

<script>


    var SocialSharing = require('vue-social-sharing');


//  if(this.$refs.rolesSelected.checked == false) {

    export default {


        name: "JobdetailComponent",

        props:['fullPath'], //'jobItem', 'user', 'schoolProfile', 'fullPath'

        components: {
            SocialSharing
        },

        data() {

          return {

              login_url: this.fullPath + '/login',

              icon_check: this.fullPath + 'css/ico/symbol-defs.svg#icon-check',

              benefits: [],

              job_modal: false,

              user_about:'',

              check_cond: false,

              apply_success: false,

              check_if_already_applied: false,

              jobItem: '',

              schoolProfile: '',

              user:  lscache.get('user_data'),

              loader: true,



          }


        },

        computed: {

            user_exists() {


                if(  this.user.hasOwnProperty('about')  ) {

                    return true;

                } else {

                    return false;
                }

            },
            detailUri() {

                return window.location.href;
            }



        },

        methods: {


            submitApplication() {

                if( this.$refs.approve1.checked === false ){

                   this.check_cond = true;



                   return;
                }

                if( this.$refs.approve2.checked === false ){

                    this.check_cond = true;

                    return;
                }


                let param =
                     {
                         cover_letter: this.user_about,

                         job_application:1,

                         jid:  this.jobItem.id,

                         job_url: this.jobItem.url,

                         school_url: this.schoolProfile.url,


                     };

                axios.post( this.fullPath + 'jobs/apply/post',  param )
                    .then( res => {

                        if( parseInt(  res.data.result ) === 1  )  {

                            this.apply_success = true;

                            this.check_if_already_applied = true;

                            lscache.set( 'applied' + this.user.id +  this.jobItem.id, '1');

                        }
                    });
            },

            loginUrl(){

              this.$router.push('/login');

            },

            schoolLogo( image ){

                let logo  = this.fullPath + 'css/img/nologo.png' ;

                if( image !== '' )
                {

                    logo = 'https://d2heijv3bffmsx.cloudfront.net/' +  image  ;

                }

                return logo;
            },

            schoolUrl(url){

                this.$router.push('/school/' +  url  );

            },
            get_job_detail(){

                let job_url = this.$route.params.job_url;

                let school_url = this.$route.params.school_url;

                let param  = { job_url:  job_url , school_url:  school_url };

                axios.post( this.fullPath + 'sp/job/detail',  param )

                    .then( res => {

                        if( parseInt(  res.data.result ) === 1  )  {

                            this.jobItem        =  res.data.data.jobs[0];

                            this.schoolProfile  =  res.data.data.school_profile[0];

                            this.benefits   = this.jobItem.benefits.split(',') ;

                            //this.user.user_about  = res.data.data.user_about;


                            if( this.user !== null  ) {

                                this.user_about = this.user.about;

                                if( lscache.get( 'applied' + this.user.id +  this.jobItem.id )  !== null  ) {

                                    this.check_if_already_applied = true;

                                }
                            }


                            this.loader =  false;

                        }

                    });
            }


        },


        created() {



            this.get_job_detail();




        },


    }
</script>

<style>

    .news-article h2{ margin-top:20px; }

    h1,h3,h2{color:#3e3d95;}

    .modal-body{  height:500px;}

   span[data-line]{ margin-bottom:20px;}


</style>