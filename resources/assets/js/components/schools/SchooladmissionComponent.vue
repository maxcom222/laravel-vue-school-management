<template>

    <div class="frame contact-buyer" id="contact-buyer">

        <h3>Contact Admissions:</h3>

        <form>


            <div class="form-row">

                <div class="form-group col-12">

                    <label for="">Parent's Email</label>


                    <input type="email"

                           v-model="email"

                           class="form-control"

                           name="email"

                           v-validate="'required|email'"

                    >

                    <small v-show="errors.has('email')"

                           class="form-control-feedback e-feedback">

                        {{ errors.first('email') }}

                    </small>


                    <!--  admission_email -->


                </div>

            </div>


            <div class="form-row">

                <div class="form-group col-md-12">

                    <label for="">Parent's Full Name</label>

                    <input type="text" v-model="name" class="form-control" name="name" placeholder="">

                    <small v-show="errors.has('name')"

                           class="form-control-feedback e-feedback">

                        {{ errors.first('name') }}

                    </small>

                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-12">

                    <label for="">Child's Name</label>

                    <input
                            type="email"

                            v-model="child_name"

                            class="form-control" name="child_name"

                            placeholder="">

                    <small v-show="errors.has('child_name')"

                           class="form-control-feedback e-feedback">

                        {{ errors.first('child_name') }}

                    </small>


                </div>


            </div>


            <div class="form-row">

                <div class="form-group col-12">

                    <label for="">Message</label>

                    <textarea

                            class="form-control"

                            v-model="message"

                            style="height:200px;"

                            name="message">


                    </textarea>


                    <small v-show="errors.has('message')"

                           class="form-control-feedback e-feedback">

                        {{ errors.first('message') }}

                    </small>

                </div>

            </div>


        </form>

        <p class="alert alert-primary ">By clicking on 'Send', I agree to the Expats' School

            <a target="_blank" :href="term_url">Terms & Conditions</a> and

            <a  target="_blank" :href="privacy_url">Privacy Policy</a></p>

        <p class="alert alert-success"  v-if="request_sent_status">

             Your request is submitted successfully
        </p>

        <a @click.prevent="sendRequest" href="" class="btn btn-sm btn-primary">

            Send

            <span v-if="submit_progress" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>

        </a>

    </div>


</template>

<script>


    var VueScrollTo = require('vue-scrollto');

    export default {

        name: "SchooladmissionComponent",

        props:['fullPath', 'schoolProfile' ],

        data() {


            return {

                name: '',

                email: '',

                child_name: '',

                message: '',

                email_sent:'',

                privacy_url:  this.fullPath + 'privacy',

                term_url:  this.fullPath + 'terms',

                request_sent_status: false,

                school_id: '',

                submit_progress: false,


            };

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

            scrollTo(){



                VueScrollTo.scrollTo('#contact-buyer', 300)

            },

            sendRequest() {



                this.validateBeforeSubmit().then(data => {

                    if(  data === true   ) {

                        this.submit_progress = true;


                        let param = {

                            name: this.name,

                            email: this.email,

                            child_name: this.child_name,

                            message: this.message,

                            email_sent:this.email_sent,

                            school_id: this.school_id,

                            enquiry: 1,


                        };


                        axios.post( this.fullPath + 'schools/post/enquiry_school', param )

                            .then(res => {



                                this.submit_progress    = false;

                                this.request_sent_status = true;

                                this.name = '';

                                this.email = '';

                                this.child_name = '';

                                this.message = '';




                            });

                    }
                });



                //request_sent_status = true

            }


        },

        created() {

            this.school_id  = this.schoolProfile.id;

            this.email_sent = this.schoolProfile.admission_email;


        },



    }


</script>

<style scoped>

</style>