<template>
<div>

    <div v-if="loader===1" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>


    <main class=" profile-wizard-page">

        <canvas id="confetti-canvas" style="display:block;z-index:999999;pointer-events:none;position: absolute;" width="1440" height="399"></canvas>
        <div class="reg-box">


            <a :href="home_url" class="logo"><img :src="logoa" alt="Expats logo"></a>


            <ul class="nav nav-wizard d-none" id="pills-tab" role="tablist">

                <li class="nav-item">

                    <a :class="tabSelected===1? 'active': ''" id="pills-step-1-tab" data-toggle="pill"  @click.prevent="" role="tab">1</a>

                </li>

                <li class="nav-item">

                    <a  :class="tabSelected===2? 'active': ''"  @click.prevent=""  role="tab">2</a>

                </li>

                <li class="nav-item">

                    <a :class="tabSelected===3? 'active': ''"  @click.prevent=""  role="tab">3</a>

                </li>

                <li class="nav-item">

                    <a :class="tabSelected===4? 'active': ''"  @click.prevent=""  role="tab">4</a>

                </li>

            </ul>



            <div class="tab-content wizard" id="pills-tabContent">


                <step1
                        v-if="step===1"

                        :full-path="fullPath">


                </step1>


                <step2
                        v-if="step===2    "

                        :full-path="fullPath"

                        :first_name.sync="first_name" :last_name.sync="last_name"

                        :city.sync="city"  :country.sync="country"

                        ref="step2"


                >


                </step2>




                <parent-step2

                        ref="parent_step2"

                        v-if="step===2 && init_choice === 'parent' "

                        :full-path="fullPath"
                    >


                </parent-step2>






                <step3
                        v-if="step===2 && init_choice === 'teacher'"

                        :recent_job.sync="recent_job"

                        :recent_school.sync="recent_school"

                        :current_emp_status.sync="current_emp_status"

                        ref="step3"


                        :full-path="fullPath">


                </step3>



                <step4
                        v-if="step===2"

                        :uploadPercentage="uploadPercentage"

                        :dialogMsg = "dialog_msg"

                        @saveInformation="saveInformation"

                        :full-path="fullPath">


                </step4>







            </div>

        </div>

    </main>



    <div id="profileDialog" v-if="profileDone">

        <transition name="modal">

            <div class="modal-mask">

                <div class="modal-wrapper">

                    <div class="modal-dialog" role="document">

                        <div class="modal-content">

                            <div class="modal-header">

                                <h5 class="modal-title">Profile</h5>


                            </div>

                            <div class="modal-body" style="height:50px;">

                                <p>Your information is saved to  your profile.</p>

                            </div>

                            <div class="modal-footer "  >

                                <button type="button" class="btn  btn-primary btn-continue" @click="redirectProfile">Continue</button>

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



    import Step1 from './Step1';

    import Step2 from './Step2';

    import Step3 from './Step3';

    import Step4 from './Step4';

    import ParentStep2 from './ParentStep2';

    var VueScrollTo = require('vue-scrollto');

    import {eventBus} from '../../app.js'

    export default {

        name: "profile",

        props:  ['fullPath'],

        components:  {

            Step1,

            Step2,

            Step3,

            Step4,

            ParentStep2

        },

        data() {


            return {

                user: this.$parent.userDatastandard,

                loader: 1,

                user_data_standard: this.$parent.userDatastandard,

                v:  this.$parent.v,

                icon_edit: this.fullPath + 'css/ico/symbol-defs.svg#icon-mode_edit',

                icon_del:   this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

                icon_adds: this.fullPath + 'css/ico/symbol-defs.svg#icon-add',

                icon_check: this.fullPath + 'css/ico/symbol-defs.svg#icon-check',

                icon_open_in_new: this.fullPath + 'css/ico/symbol-defs.svg#icon-open_in_new',

                icon_people:  this.fullPath + 'css/ico/symbol-defs.svg#icon-people',




                logoa: this.fullPath + 'css/img/logoa.png',

                step: 1,

                tabSelected: 1,

                first_name: '',

                last_name: '',

                country: '',

                recent_job: '',

                recent_school: '',

                city: '',

                progress :  false,

                current_emp_status: '',

                file: '',

                init_choice: lscache.get('init_choice'),

                home_url:  this.fullPath,

                uploadPercentage: '',

                dialog_msg: '',

                profileDone: false,




            }
        },

        methods: {

            validChild(){



            },


            saveInformation(e){



                if( this.init_choice === 'teacher'  ) {


                    this.file  = e;

                    this.$refs.step2.validateBeforeSubmit().then(data => {

                        if( data === true ){

                            let checkStep2  =  this.$refs.step3.saveNext();

                            if (checkStep2 === true) {




                                let formData = new FormData();

                                formData.append('file', this.file);

                                formData.append('uid', lscache.get('sess_uid') );

                                formData.append('first_name', this.first_name   );

                                formData.append('last_name', this.last_name   );

                                formData.append('city', this.city   );
                                formData.append('country', this.country   );
                                formData.append('recent_job', this.recent_job.code   );
                                formData.append('recent_school', this.recent_school.code   );
                                formData.append('current_emp_status', this.current_emp_status   );

                                axios.post( this.fullPath + 'profile/user/profile_upload',
                                    formData,
                                    {
                                        headers: {
                                            'Content-Type': 'multipart/form-data'
                                        },
                                        onUploadProgress: function( progressEvent ) {

                                            this.uploadPercentage  = parseInt(progressEvent.loaded / progressEvent.total * 100, 10);

                                            if( this.uploadPercentage === 100 ){

                                                this.dialog_msg = 'Still uploading... Please wait';

                                            }





                                        }.bind(this)
                                    }
                                ).then( res  => {




                                    let data = res.data;

                                    let user_follower = data.user_follower;

                                    lscache.set('user_follower', user_follower );

                                    let user_activity  = data.user_activity;

                                    let user_likes 	   = [];

                                    let user_activity_arr = [];

                                    for( let i = 0; i < user_activity.length; i ++ )
                                    {

                                        user_activity_arr.push( user_activity[i].object_id );

                                    }

                                    lscache.set('user_likes', user_activity_arr );

                                    lscache.set('user_block',  data.user_block );

                                    lscache.set('user', 1 );

                                    lscache.set('user_data', data.user_data );

                                    lscache.set('favourite', data.user_fav );



                                    VueScrollTo.scrollTo( '#pills-tab' , 100);

                                    this.profileDone = true;

                                    startConfetti();

                                    setTimeout(()  => {

                                        stopConfetti();

                                        this.redirectProfile();


                                    }, 100000);


                                })
                                    .catch(function(){

                                        window.alert('There was some error in uploading. Try  again');
                                    });




                            } else {

                                return;

                            }

                        } else {

                            return;
                        }

                    });


                }  else {


                    this.file  = e;


                    this.$refs.step2.validateBeforeSubmit().then(data => {

                        if (data === true) {




                            let param = this.$refs.parent_step2.saveParent();

                            let formData = new FormData();

                            console.log(  param );

                            formData.append('file', this.file);

                            console.log(formData);

                            formData.append('uid', lscache.get('sess_uid') );

                            formData.append('first_name', this.first_name   );

                            formData.append('last_name', this.last_name   );

                            formData.append('city', this.city   );

                            formData.append('country', this.country   );

                            console.log(formData);

                            formData.append('recent_job', ''   );

                            formData.append('recent_school', ''  );

                            formData.append('current_emp_status', ''  );
                            console.log(formData);

                            formData.append('child_school_one', param.child_school_one );

                            formData.append('child_school_two', param.child_school_two );

                            formData.append('child_school_three', param.child_school_three );

                            formData.append('tutor_selection', param.tutor_selection );

                            formData.append('work_selection', param.work_selection );

                            formData.append('area', param.area );

                            formData.append('parent', '1' );




                            axios.post( this.fullPath + 'profile/user/profile_upload',
                                formData,
                                {
                                    headers: {
                                        'Content-Type': 'multipart/form-data'
                                    },
                                    onUploadProgress: function( progressEvent ) {

                                        this.uploadPercentage  = parseInt(progressEvent.loaded / progressEvent.total * 100, 10);

                                        if( this.uploadPercentage === 100 ){

                                            this.dialog_msg = 'Still uploading... Please wait';

                                        }





                                    }.bind(this)
                                }
                            ).then( res  => {




                                let data = res.data;

                                let user_follower = data.user_follower;

                                lscache.set('user_follower', user_follower );

                                let user_activity  = data.user_activity;

                                let user_likes 	   = [];

                                let user_activity_arr = [];

                                for( let i = 0; i < user_activity.length; i ++ )
                                {

                                    user_activity_arr.push( user_activity[i].object_id );

                                }

                                lscache.set('user_likes', user_activity_arr );

                                lscache.set('user_block',  data.user_block );

                                lscache.set('user', 1 );

                                lscache.set('user_data', data.user_data );

                                lscache.set('favourite', data.user_fav );

                                let init_choice = data.user_choice;

                                VueScrollTo.scrollTo( '#pills-tab' , 100);

                                this.profileDone = true;

                                startConfetti();

                                setTimeout(()  => {

                                    stopConfetti();

                                    this.redirectProfile();


                                }, 100000);


                            })
                                .catch(function(){

                                    window.alert('There was some error in uploading. Try  again');
                                });
                        }
                    });







                }








            },

            redirectProfile(){

                eventBus.$emit('hideHeader', {  value : 0} );


                let init_choice = lscache.get('init_choice') ;

                let user_data   = lscache.get('user_data');

                if( init_choice === 'teacher' )
                {

                   /// window.location.href  = this.fullPath   + 'user/profile/' + user_data.username	;

                    this.$router.push('/profile/' +    user_data.username	);

                }
                else
                {

                    this.$router.push('/parents');
                }
            }

        },

        created() {


            eventBus.$emit('hideHeader', {  value : 1} );


            if( this.v  !==   0 )  {

                let user_follower =  [];

                lscache.set('user_follower', user_follower );

                let user_activity  = [];

                let user_likes 	   = [];

                let user_activity_arr = [];

                for( let i = 0; i < user_activity.length; i ++ )
                {

                    user_activity_arr.push( user_activity[i].object_id );

                }

                lscache.set('user_likes', user_activity_arr );

                lscache.set('user_block', [] );

                lscache.set('user', 1 );

                lscache.set('user_data', this.user_data_standard );

                console.log(  lscache.get('user_data') );

                lscache.set('favourite', [] );

                this.step  = 2;

                this.loader = 0;


            } else {

                this.loader = 0;
            }

        }



    }
</script>

<style scoped>


    .user-box-bill{

        margin: 0 auto;

        background-color: #fff;

        -webkit-box-shadow: 0px 2px 3px 0px rgba(0, 0, 0, 0.33);

        width: 600px;

    }
    .user-box-logo{


        text-align: center;
        margin: 0 auto;
        display: block;
        margin-bottom: 30px;
        padding-top: 20px;

    }

    main {
        display: flex;
        justify-content: center;
    }
    .reg-box {
        box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
        padding: 40px;
        background: #FFF;
        max-width: 500px;
    }

    .logo{

        margin: 0 auto;
        display: block;
        width: 200px;
        margin-bottom: 20px;

        border:0;
    }




</style>