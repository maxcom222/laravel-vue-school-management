<template>

    <div>



<form >
                            <div class="form-group row">

                                <label for="email" class="col-sm-2 col-form-label"></label>

                                <div class="col-sm-10">

                                    <p>Enter your email to receive reset password instruction</p>

                                </div>

                            </div>

                            <div class="form-group row">

                                <label for="email" class="col-sm-2 col-form-label">Email</label>

                                <div class="col-sm-10">

                                    <input type="email"

                                           class="form-control"

                                           placeholder="Email"

                                           v-validate="'required|email'"

                                           v-model="reset_password_email"

                                           name="reset_password"

                                    >


                                    <small
                                            v-show="errors.has('reset_password')"

                                            class="form-control-feedback e-feedback">

                                        {{ errors.first('reset_password') }}

                                    </small>

                                </div>

                            </div>


                            <div class="form-group row">

                                <div class="col-sm-12">

                                    <button type="button" @click="submitResetPassword" class="btn btn-primary">Submit</button>

                                    <p>go back to login <a href=""  @click.prevent="showLogin" class="">Login here</a></p>

                                </div>

                            </div>


</form>


    </div>




</template>

<script>






    export default {

        name: "ResetComponent",


        props: ['fullPath'],

        data() {

            return {


                reset_password_email: '',


        }


        },
        computed:{


        },


        methods: {

            validateBeforeSubmit() {

                return this.$validator.validateAll().then((result) => {

                    if (result  ===  true ) {

                        return true;

                    } else {

                       // this.scrollTo();

                        return false;

                    }


                });
            },

            showLogin() {


                this.$parent.showLogin();

            },




            submitResetPassword(){


                this.validateBeforeSubmit().then(data => {

                    if(  data === true   ) {

                        let param = {

                            email: this.reset_password_email ,

                        };


                        axios.post(this.fullPath + '/user/post/reset', param  )

                            .then( res => {


                                console.log(res.data);

                                let data  = res.data ;


                                if( data.response === 1 )
                                {

                                    this.noticeModal  = true;

                                    this.noticeHeader = 'Reset Password';

                                    this.noticeMsg    = 'Reset password instructions are sent successfully';


                                }
                                else if( data.response === 2 )
                                {
                                    this.noticeModal  = true;

                                    this.noticeHeader = 'Reset Password';

                                    this.noticeMsg    = 'Email address is not registered';



                                }
                                else if( data.response === 3 )
                                {

                                    this.noticeModal = true;

                                    this.noticeHeader = 'Reset Password';

                                    this.noticeMsg = 'Internal server error. Please try later';


                                }


                            })

                    }
                });


            },


        },


        created()  {



        },

        mounted() {


            const dict = {
                custom: {


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

<style>


    .form-control-feedback, .has-danger label {
        color: #d9534f;
        text-align: center;
        display: block;
        width: 100%;
        margin-top: 12px;
    }
</style>
