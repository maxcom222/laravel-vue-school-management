<template>


    <div class="contactInfo">








        <div v-if="contactModal">

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog modal-md" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title" v-if="selfView===1">  Edit Contact Information</h5>

                                    <h5 class="modal-title" v-else> Contact Information</h5>

                                    <button type="button"  @click="closePop" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

                                </div>

                                <div class="modal-body">


                                    <div v-if="selfView===1">

                                        <p class="lead">Provide as much information as you can.</p>


                                        <div class="form-group  row">

                                            <label for="" class="col-12 col-form-label"> First Name
                                            </label>

                                            <div class="col-12">

                                                <input type="text"
                                                       class="form-control"
                                                       name="first_name"
                                                       v-model="first_name"
                                                       v-validate="'required'"
                                                >


                                                <small   v-show="errors.has('first_name')"  class="form-control-feedback e-feedback">
                                                    {{ errors.first('first_name') }}
                                                </small>


                                            </div>

                                        </div>

                                        <div class="form-group  row">

                                            <label for="" class="col-12 col-form-label"> Last Name
                                            </label>

                                            <div class="col-12">

                                                <input type="text"
                                                       class="form-control"
                                                       name="last_name"
                                                       v-model="last_name"
                                                       v-validate="'required'"
                                                >


                                                <small   v-show="errors.has('last_name')"  class="form-control-feedback e-feedback">
                                                    {{ errors.first('last_name') }}
                                                </small>


                                            </div>

                                        </div>


                                        <div class="form-group  row">

                                            <label for="" class="col-12 col-form-label"> Email Address
                                            </label>

                                            <div class="col-12">

                                                <input type="text"
                                                       class="form-control"
                                                       name="email"
                                                       v-model="email"
                                                       v-validate="'required|email'"
                                                >


                                                <small   v-show="errors.has('email')"  class="form-control-feedback e-feedback">
                                                    {{ errors.first('email') }}
                                                </small>

                                                <p>

                                                    <input

                                                        @input="email_public=!email_public"

                                                        type="checkbox"

                                                        v-model="email_public"

                                                        name="email_public"

                                                        class="form-check-input">Visible to public

                                                </p>


                                            </div>

                                        </div>

                                        <div class="form-group  row">

                                            <label for="" class="col-12 col-form-label"> Contact Number
                                            </label>

                                            <div class="col-12">

                                                <input type="text"
                                                       class="form-control"
                                                       name="contact_number"
                                                       v-model="contact_number"
                                                >


                                                <p>

                                                    <input

                                                            @input="contact_number_public=!contact_number_public"

                                                            type="checkbox"

                                                            v-model="contact_number_public"

                                                            name="contact_number_public"

                                                            class="form-check-input">Visible to public

                                                </p>



                                            </div>



                                        </div>

                                        <div class="form-group  row">

                                            <label for="" class="col-12 col-form-label">Skype</label>

                                            <div class="col-12">

                                                <input type="text"
                                                       class="form-control"
                                                       name="skype"
                                                       v-model="skype"

                                                >

                                                <p>

                                                    <input

                                                            @input="skype_public=!skype_public"

                                                            type="checkbox"

                                                            v-model="skype_public"

                                                            name="skype_public"

                                                            class="form-check-input">Visible to public

                                                </p>



                                            </div>

                                        </div>






                                        <div class="form-group  row">

                                            <label for="" class="col-12 col-form-label">Date of birth
                                            </label>

                                            <div class="col-4">

                                                <v-select
                                                        placeholder="Select Day"

                                                        v-model="day" name="day"

                                                        :options="dayModal">

                                                </v-select>

                                            </div>

                                            <div class="col-4">

                                                <v-select
                                                        placeholder="Select Month"

                                                        v-model="month" name="month"

                                                        :options="monthModal">

                                                </v-select>

                                            </div>

                                            <div class="col-4">

                                                <v-select
                                                        placeholder="Select Year"

                                                        v-model="year" name="year"

                                                        :options="yearModal">

                                                </v-select>

                                            </div>


                                            <div class="col-12">

                                                <p>

                                                    <input

                                                            @input="dob_public=!dob_public"

                                                            type="checkbox"

                                                            v-model="dob_public"

                                                            name="dob_public"

                                                            class="form-check-input">Visible to public

                                                </p>

                                            </div>



                                        </div>

                                        <div class="form-group  row">


                                            <div class="col-12">

                                                <p v-if="isDone===1" class="alert-success nice-padding">

                                                    Your data is saved successfully
                                                </p>

                                            </div>

                                        </div>

                                    </div>


                                    <div v-else>

                                        <ul class="job-stats">


                                            <li><strong>Working at:</strong><p> {{  user.recent_job  }}</p></li>

                                            <li v-if="user.type === 'teacher' "><strong>Current School:</strong><p> {{  user.recent_school }}</p></li>

                                            <li v-if="user.email_public === 1">><strong>Email:</strong><p><a :href="'mailto:' + user.email">{{ user.email }}</a></p></li>

                                            <li v-if="user.contact_number_public === 1">><strong>Contact No:</strong><p class="js_cn"> {{  user.contact_number }}</p></li>

                                            <li  v-if="user.skype_public === 1"><strong>Skype:</strong><p class="js_skype"> {{ user.skype   }}</p></li>

                                            <li  v-if="user.dob_public === 1">><strong>Birthday:</strong><p class="js_birthday"> {{    user.birthday  }}</p></li>

                                            <li><strong>Current Address:</strong><p class="js_address"> {{ user.city  }}</p></li>


                                        </ul>





                                    </div>
                                </div>



                                <div class="modal-footer" v-if="selfView===1"   >

                                    <!--
                                    <button type="button" @click="closePop"   class="btn btn-default modal-btn" data-dismiss="modal">Close</button>
-->
                                    <button

                                            type="button"

                                            @click="saveContact"

                                            class="btn btn-primary modal-btn modal-btn-action "> Save Information

                                        <span

                                                :class="progress===1? '': 'd-none'"

                                                class="glyphicon glyphicon-refresh glyphicon-refresh-animate">


                                        </span>

                                    </button>

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

    import {eventBus} from '../../app.js'

    export default {

    name: "ProfileContact",

    props: ['fullPath', 'user', 'selfView'],


    data()  {


        return{

            education:[],

            icon_add: this.fullPath + 'css/ico/symbol-defs.svg#icon-add',

            icon_edit: this.fullPath + 'css/ico/symbol-defs.svg#icon-mode_edit',

            icon_del:   this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

            edit_id: 0,


            contactModal      : false,

            showDegree: false,

            first_name: this.user.first_name,

            last_name: this.user.last_name,

            email: this.user.email,

            contact_number:  this.user.contact_number,

            skype: this.user.skype,

            contact_public: false,

            mobile_number_public: 0,

            progress:   0,

            yearModal: [],

            year:  '',

            month: '',

            day: '',

            months_english : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],

            dayModal: [],

            monthModal: [],

            isDone: 0,

            dob_public: this.user.dob_public,

            email_public: this.user.email_public,

            contact_number_public: this.user.contact_number_public,

            skype_public: this.user.skype_public,



        }
    },

    computed: {




    },

    watch:{



    },

    methods:{

        validateBeforeSubmit() {

            return this.$validator.validateAll().then((result) => {

                if (result  ===  true ) {

                    return true;

                } else {

                    this.scrollTo();

                    return false;

                }


            });
        },



        saveContact()  {

            let q_code =  '';

            if( typeof this.qualification !== 'undefined' ) {

                q_code =    this.qualification.code;
            }


            let param = {

                email: this.email,

                first_name: this.first_name,

                last_name: this.last_name,

                contact_number: this.contact_number,

                skype: this.skype,

                dob: this.year + '-'  + this.month.code + '-' +  this.day ,

                add_edu: 1,

                edit_id: this.edit_id,

                dob_public: this.dob_public,

                email_public: this.email_public,

                contact_number_public: this.contact_number_public,

                skype_public: this.skype_public,


            };


            this.validateBeforeSubmit().then(data => {


                if(  data === true   ) {

                    this.progress = 1;

                    axios.post( this.fullPath + 'user/profile/save_contact_info', param )

                        .then( res => {

                            eventBus.$emit('justVerifiedSchool',  {} );

                            this.progress = 0;

                            this.isDone  = 1;

                        });




                }
            });








        },

        fillMod ()  {

            for( let i = 1; i <= 31 ; i++ )
            {
                let j =  '';
                i <  10 ?  j  = '0'  +  i  : j =  i;
                this.dayModal.push( j );

            }

            for( let i =  new Date().getFullYear(); i >= 1950 ; i-- )
            {
                this.yearModal.push( i );

            }

            for(let  i = 0; i < 11; i++ ) {

                let j =  '';

                j = i + 1;

                i <  10 ?  j  = '0'  +  j  : '';

                let obj = { code: j, label: this.months_english[i] };

                this.monthModal.push( obj )
            }




        },

        scrollTo(){



            VueScrollTo.scrollTo('body', 300)

        },

        showContact() {

           // document.body.classList.add("modal-open");

            this.contactModal = true;

        },

        closePop() {

            document.body.classList.remove("modal-open");

            this.contactModal = false;


        },

        addErrorMessages(){


            const dict = {
                custom: {

                    first_name: {

                        required: 'first name can not be empty',

                    },

                    last_name: {

                        required: 'last name can not be empty',

                    },

                    email: {

                        required: 'Email address  can not be empty',


                    },


                    grade: {

                        required: 'Grade  can not be empty',


                    },



                }
            };

            this.$validator.localize('en', dict);

        },





    },

    created() {


        eventBus.$on('contact_DialogLeftMenu', (message) => {

            this.showContact();

        });



          this.addErrorMessages();

          this.fillMod();



    }
}
</script>

<style>
    @media (min-width: 576px)
    {
        .modal-dialog {

            max-width: 600px

        }
    }

    .modal-body {


        height: 400px;

        overflow-y: scroll;

        overflow-x: hidden;

    }

    .go {
        border: 1px solid;
        border-radius: 2px;
        box-sizing: content-box;
        font-size: 14px;
        -webkit-font-smoothing: antialiased;
        font-weight: bold;
        justify-content: center;
        padding: 10px 10px;
        position: relative;
        text-align: center;
        text-shadow: none;
        vertical-align: middle;
        background: #3e3d95;
        color: #FFF;
        border: 1px solid #3e3d95;
    }

    .vs__open-indicator{
        position: absolute;
        right: 10px;
    }
    .vs__clear{
        display:none;
    }

    .profileContct p{      margin-bottom: 10px !important;}

    .contactInfo .form-group{     border-bottom: 1px solid #ccc;

        padding-bottom: 10px;

    }
    .contactInfo .form-group  .col-12 p{

        margin-left: 20px;
        margin-top: 20px;
    }


</style>