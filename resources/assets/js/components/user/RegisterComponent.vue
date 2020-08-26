<template>

    <div>


        <form  method="post" @submit.prevent="submitRegister">

                            <div class="form-group row">

                                <div class="col-12 col-sm-12">

                                    <h2 class="expat-teacher-register text-center">

                                        Please enter your

                                        <span style="color:#01ae79;">

                                            personal email address

                                        </span>

                                        and we will send you a

                                        <span style="color:#01ae79;"> verification code</span>

                                    </h2>

                                </div>



                            </div>

                            <div class="form-group row">

                                <label for="email" class="col-sm-12 col-form-label">Personal Email (NOT your school email)</label>

                                <div class="col-sm-12">

                                    <input type="email"

                                           v-validate="'required|email'"

                                           class="form-control"

                                           :class="{'is-invalid': errors.has('register_email') }"

                                           name="register_email"

                                           v-model="register_email"



                                           placeholder="">

                                    <small
                                            v-show="errors.has('register_email')"

                                            class="form-control-feedback e-feedback">

                                        Provide valid email address

                                    </small>


                                </div>

                            </div>



                            <div class="form-group row">

                                <label for="password" class="col-sm-12 col-form-label">Password</label>

                                <div class="col-sm-12">

                                    <input
                                            type="password"

                                            class="form-control"

                                            v-model="register_password"

                                            :state="!errors.has('password')"


                                            v-validate="'required|min:6|max:35'"

                                            name="password"

                                           placeholder="">

                                    <small
                                            v-show="errors.has('password')"

                                            class="form-control-feedback e-feedback">

                                        {{ errors.first('password') }}

                                    </small>


                                </div>






                            </div>

                            <div class="form-group row">

                                <label for="password2" class="col-sm-12 col-form-label">Confirm Password</label>

                                <div class="col-sm-12">

                                    <input

                                            type="password"

                                            class="form-control"

                                            name="confirmed_password"

                                            v-validate="'required|confirmed:password'"

                                            placeholder="">

                                    <small
                                            v-show="errors.has('password')"

                                            class="form-control-feedback e-feedback">

                                        {{ errors.first('confirmed_password') }}

                                    </small>


                                </div>

                            </div>
                            <div class="form-group row">

                                <div class="col-sm-12">

                                    <button type="submit" class="btn btn-primary">Register</button>

                                </div>

                            </div>

                        </form>




    </div>




</template>

<script>





    export default {

        name: "RegisterComponent",

        props: ['fullPath'],

        data() {

            return {

                loaderShow: true,

                register_email: '',

                register_password: '',

                reset_password_email: '',

                type: '',

        }


        },
        computed:{


        },


        methods: {


            validateBeforeSubmit(scope) {

                return this.$validator.validateAll(scope).then((result) => {

                    if (result  ===  true ) {

                        return true;

                    } else {

                       // this.scrollTo();

                        return false;

                    }


                });
            },


            submitRegister(){


                this.validateBeforeSubmit('registerFrm').then(data => {

                     if(  data === true   ) {

                        let param = {

                            email: this.register_email ,

                            password: this.register_password,

                            type: this.type,

                        };


                        axios.post(this.fullPath + '/user/post/register', param  )

                            .then( res => {



                                let data = res.data;

                                if( parseInt(  data.response ) === 1 )
                                {

                                    lscache.set('user', 1 );

                                    let ad = lscache.get( 'ad');

                                    lscache.set('sess_uid', data.uid );

                                    lscache.set('reg_step', 1);

                                    document.location.href = this.fullPath + 'user/profile_wizard/' + this.type ;
                                }
                                else if( parseInt(  data.response ) === 2 )
                                {

                                    this.$parent.noticeHeader = 'Account Registration';

                                    this.$parent.noticeMsg = 'Email address is already registered. Use new email address or reset your password.';

                                    this.$parent.noticeModal = true;

                                }
                                else if( parseInt(  data.response ) === 3 )
                                {

                                    this.$parent.noticeHeader = 'Account Registration';

                                    this.$parent.noticeMsg = 'Error found. Please try later.';

                                    this.$parent.noticeModal = true;

                                }


                            })

                    }
                });


            },




        },


        created()  {



        },

        mounted() {



            if( lscache.get('type') === null ){

                lscache.set('type', 'teacher');
            }

            this.type = lscache.get('type');

            const dict = {

                custom: {

                    register_email: {

                        required: 'Your email can not be empty',
                        email:  'Your email address should be valid email address',

                    },

                    register_password: {

                        required: 'Your password can not be empty',

                        min: 'Your password should have at least six characters',

                        max: 'Your password should have maximum thirty five characters',


                    },

                    confirmed_password:{

                        required: 'Your confirm password can not be empty',

                        confirmed: () => 'Your password and confirm password does not match.'

                    }


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
