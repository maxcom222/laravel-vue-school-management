<template>

    <div class="schoolEmail">


        <div v-if="etcModal">

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog modal-md" role="document">

                            <div class="modal-content">

                                <div class="modal-header">


                                    <h5 class="modal-title"> Provide your current school email address</h5>

                                    <button type="button"  @click="closePop" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

                                </div>

                                <div class="modal-body">

                                    <div  class="frame widget pro-widget" >

                                        <h3>Add Your <span>School Email Address</span></h3>

                                        <div v-if="verficationCodeSent===0">

                                            <div class="form-group">

                                                <label for="" class="col-12 col-form-label">School Email address</label>


                                                <div class="row">

                                                    <div class="col-4 col-4-no-right-padding">


                                                        <input

                                                                type="text"

                                                                v-validate="'required'"

                                                                class="form-control"

                                                                name="name"

                                                                v-model="name"

                                                                placeholder="Name part"

                                                        >

                                                        <small v-show="errors.has('name')"

                                                               class="form-control-feedback e-feedback">

                                                            {{ errors.first('name') }}

                                                        </small>


                                                    </div>

                                                    <div class="col-8 col-8-no-left-padding">

                                                        <v-select

                                                                name="school"

                                                                v-model="school"

                                                                :options="school_domains"

                                                                placeholder="Select School Domain"

                                                                v-validate="'required'"
                                                        >
                                                        </v-select>



                                                        <small v-show="errors.has('school')"

                                                               class="form-control-feedback e-feedback">

                                                            {{ errors.first('school') }}

                                                        </small>

                                                    </div>

                                                    <div class="col-12">

                                                        <p v-if="isDone===1" class="alert-success nice-padding mg-bottom-10  mg-top-10">

                                                            Verification code is sent successfully.
                                                        </p>

                                                    </div>


                                                </div>

                                            </div>

                                            <div class="form-group  row">

                                                <div class="col-12">

                                                    <button

                                                            type="button"

                                                            @click="updateEmail"

                                                            class="btn btn-primary"
                                                    >

                                                        Send Verification Code

                                                        <span v-if="progress===1" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>



                                                    </button>

                                                </div>

                                            </div>


                                        </div>

                                        <div class="form-group  row" v-if="verficationCodeSent===1">

                                            <label for="" class="col-12 col-form-label">Enter verification Code</label>

                                            <div class="col-12">

                                                <input

                                                        type="text"

                                                        value=""

                                                        class="form-control"

                                                        v-validate="'required'"

                                                        name="verification_code"

                                                        v-model="verification_code"

                                                        placeholder="">

                                                <small v-show="errors.has('verification_code')"

                                                       class="form-control-feedback e-feedback">

                                                    {{ errors.first('verification_code') }}

                                                </small>

                                            </div>

                                            <div class="col-12">


                                                <p v-if="isDone===1"   class="alert-success nice-padding  mg-top-10">

                                                    {{  msg }}
                                                </p>


                                            </div>




                                            <div class="col-12">

                                                <button

                                                        type="button"

                                                        @click="verifyEmail"

                                                        class="btn btn-primary"
                                                >

                                                    Verify Email Address

                                                    <span v-if="progress===1" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>


                                                </button>


                                            </div>



                                        </div>



                                    </div>
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

        props: ['fullPath', 'user', 'selfView'],

        name: "JoinEtc",


        data()  {


            return {

                etcModal: false,

                invite_email_address:  '',

                isDone: 0,

                progress:0,

                school_domains: [],

                school: '',

                name: '',

                verficationCodeSent: 0,

                verification_code: '',

                msg: 'Verification code is sent to your  select school email address',

            }
        },

        computed: {


        },
        methods:{

            showContact(){

                this.etcModal = true;

            },

            validateBeforeSubmit() {

                return this.$validator.validateAll().then((result) => {

                    if (result  ===  true ) {

                        return true;

                    } else {


                        return false;

                    }


                });
            },


            verifyEmail() {

                this.validateBeforeSubmit().then(data => {

                    if(  data === true   ) {

                        this.progress = 1;

                        let email = this.name + this.school.code;

                        axios.post( this.fullPath + 'user/profile/membership_email', { verify:1, verification_code : this.verification_code, email:email } )
                            .then( res => {

                                this.progress = 0;

                                this.isDone  = 1;

                                this.msg = 'Your school email address is verified. Thank you';

                                eventBus.$emit('justVerifiedSchool',  {} );





                                setTimeout(  () => {


                                    this.isDone  = 0;

                                    this.msg = 'Verification code is sent to your  select school email address';

                                    this.verification_code  = '';

                                    this.verficationCodeSent = 0;

                                    this.name = '';

                                    this.school= '';


                                }, 4000)

                            });
                    }
                });

            },

            closePop(){

                this.etcModal  =   false;

                document.body.classList.remove("modal-open");
            },



            updateEmail(){

                this.validateBeforeSubmit().then(data => {

                    if(  data === true   ) {

                        let email = this.name + this.school.code;

                        this.progress = 1;

                        axios.post( this.fullPath + 'user/profile/membership_email', {email:email, send_code:1 } )
                            .then( res => {

                                this.progress = 0;

                                this.isDone  = 1;

                                this.verficationCodeSent = 1;



                            });

                    }
                });


            },

            loadSchool(){

                axios.post( this.fullPath + 'select/school_domains', {} )
                    .then( res => {

                        res.data.data.forEach( school =>  {

                            let obj = {code:  school.domain_email,   label:  school.domain_email + ' [' + school.name + ']'  };
                            this.school_domains.push(obj)
                        });

                    })

            },




        },


        created() {

            eventBus.$on('etcDialog', (message) => {

                this.showContact();

            });




            this.loadSchool();


            const dict = {
                custom: {

                    name: {

                        required: 'Your  name part can not be empty',

                    },


                    email: {

                        required: 'Your email can not be empty',

                        email: 'Your email should be a valid email address',

                    },



                }
            };

            this.$validator.localize('en', dict);

        }
    }
</script>



<style scoped>

    .nice-padding.mg-top-10
    {
        margin-bottom: 20px;
    }

    .form-control[name='name'] {

        height: 34px;  border-right:0px;border-radius:0;
    }


    .schoolEmail > .frame  {

        overflow: visible;
    }


    .col-8-no-left-padding {

        padding-left:0;
    }

    .col-4-no-right-padding {

        padding-right:0;
    }

    .form-control:focus{

        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important; border-color:#019567;
    }

</style>


