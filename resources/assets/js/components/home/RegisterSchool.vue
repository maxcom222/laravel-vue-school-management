<template>


    <div>

        <header class="page-title bg-feed">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>Register your school</h1>
                    </div>
                </div>
            </div>
        </header>




        <main class="two-cloumn" >

            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-3 col-left">
                    </div>

                    <div class="col-12 col-md-6">

                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

                                <form id="login_form">


                                    <div class="form-group row">

                                        <label for="email" class="col-sm-2 col-form-label">Subject</label>

                                        <div class="col-sm-10">

                                            <input


                                                    name="subject"

                                                    class="form-control form-control-sm"

                                                    v-validate="'required'"

                                                    v-model="subject"

                                                    type="text">

                                            <small
                                                    v-show="errors.has('subject')"

                                                    class="form-control-feedback e-feedback">

                                                {{ errors.first('subject') }}

                                            </small>


                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">


                                            <input


                                                    name="name"

                                                    class="form-control form-control-sm"

                                                    v-validate="'required'"

                                                    v-model="name"

                                                    type="text">

                                            <small
                                                    v-show="errors.has('name')"

                                                    class="form-control-feedback e-feedback">

                                                {{ errors.first('name') }}

                                            </small>


                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Phone</label>
                                        <div class="col-sm-10">


                                            <input


                                                    name="phone"

                                                    class="form-control form-control-sm"

                                                    v-validate="'required'"

                                                    v-model="phone"

                                                    type="text">

                                            <small
                                                    v-show="errors.has('phone')"

                                                    class="form-control-feedback e-feedback">

                                                {{ errors.first('phone') }}

                                            </small>


                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="password" class="col-sm-2 col-form-label">Message</label>
                                        <div class="col-sm-10">
                                        <textarea class="form-control"  placeholder=""

                                                  name="message"

                                                  v-validate="'required'"

                                                  v-model="message"

                                        >



                                        </textarea>

                                            <small
                                                    v-show="errors.has('message')"

                                                    class="form-control-feedback e-feedback">

                                                {{ errors.first('message') }}

                                            </small>




                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <p v-if="isDone" class="alert alert-success">

                                                Your message is sent successfully. We will contact you shortly

                                            </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"></label>


                                        <div class="col-sm-10">
                                            <button
                                                    type="button"

                                                    class="btn btn-primary"

                                                    @click="submitFrm"

                                            >
                                                Send

                                                <span
                                                        class="spinner-border spinner-border-sm"

                                                        role="status" aria-hidden="true"

                                                        v-if="inprogress"
                                                >

                                            </span>

                                            </button>
                                        </div>
                                    </div>
                                </form>








                            </div>

                        </div>


                    </div>


                </div>
            </div>


        </main>


    </div>





</template>

<script>
    export default {

        name: "RegisterSchool",

        props:['fullPath'],

        data(){


            return{

                subject: '',

                name: '',

                phone: '',

                message: '',

                inprogress:false,

                isDone: 0,

            }
        },
        methods:{


            validateBeforeSubmit() {

                return this.$validator.validateAll().then((result) => {

                    if (result  ===  true ) {

                        return true;

                    } else {

                        return false;
                    }

                });
            },

            submitFrm() {

                let param = {

                    name: this.name,

                    subject: this.subject,

                    message: this.message,

                    phone: this.phone,

                    save_basic_info: 1,

                    type:  'register'
                };

                this.validateBeforeSubmit().then(data => {



                    if(  data === true   ) {


                        this.inprogress = true;

                        axios.post( this.fullPath + 'post/contact_info', param )
                            .then( res => {

                                this.inprogress = false;

                                this.isDone  = 1;

                                setTimeout(()  =>{

                                    this.name = '';

                                    this.message = '';

                                    this.phone  = '';

                                    this.subject = '';

                                }, 10000 )


                            });




                    }
                });








            }

        },
        created(){

            const dict = {
                custom: {

                    name: {

                        required: 'Your name can not be empty',

                    },

                    subject: {

                        required: 'Your subject  can not be empty',

                    },

                    message: {

                        required: 'Your message can not be empty',

                    },

                    phone: {

                        required: 'Your phone can not be empty',

                    },



                }
            };

            this.$validator.localize('en', dict);
        }

    }
</script>

<style scoped>


    .two-cloumn { margin-top: 30px; }


</style>