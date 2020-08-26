<template>

    <div>
<!--authorize-->
        <main class=" register">


            <div v-if="loaderShow" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

            <div class="reg-box">

                <h2>Register your  account</h2>


                <div  v-if="mini_step === 1">

                    <p class="lead">Register your  account as parent or teacher.</p>

                    <p class="lead"> If you want to join Expat Teachers Club you must be registered as a teacher.

                    </p>

                    <div class="form-group row">

                        <div class="col-sm-12 ">

                            <label class="mglft-7">

                                <input @change="registerAs" name="register_as" value="teacher" type="radio">

                                Teacher</label>

                        </div>


                            <div class="col-sm-12 ">

                            <label  class="mglft-7">

                                <input @change="registerAs" type="radio" name="register_as" value="parent">

                                Parent</label>

                            </div>


                    </div>


                </div>

                <transition name="slide" >


                     <form  autocomplete="off"  v-if="mini_step !== 1"  method="post" @submit.prevent="submitRegister">

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

                                           autocomplete="false"


                                           placeholder="">

                                    <small
                                            v-if="errors.has('register_email')"

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
                                            v-if="errors.has('password')"

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
                                            v-if="errors.has('confirmed_password')"

                                            class="form-control-feedback e-feedback">

                                        {{ errors.first('confirmed_password') }}

                                    </small>


                                </div>

                            </div>
                            <div class="form-group row">

                                <div class="col-sm-12">

                                    <button type="submit" class="btn btn-primary">Register <i v-if="progress" class="glyphicon glyphicon-refresh glyphicon-spin"></i>

                                    </button>

                                </div>

                            </div>

                        </form>


                </transition>

            </div>

        </main>



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

                mini_step: 1,

                progress: false,

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


                         this.progress =  true;

                        let param = {

                            email: this.register_email ,

                            password: this.register_password,

                            type: this.type,

                        };


                        axios.post(this.fullPath + '/user/post/register', param  )

                            .then( res => {

                                this.progress =  false;

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


            registerAs(){


                if(  event.target.checked  ===  true ){

                    this.type = event.target.value;
                }

                lscache.set('init_choice', this.type );

                console.log( lscache.get('init_choice') );

               this.mini_step ++;
            }




        },


        created()  {


            this.loaderShow = false;


        },

        mounted() {



            if( lscache.get('type') === null ){

                lscache.set('type', 'teacher');
            }

            this.type = lscache.get('type');

            setTimeout(() => {

                this.register_email = '';

                this.register_password = '';

            }, 40)

            const dict = {

                custom: {

                    register_email: {

                        required: 'Your email address can not be empty',
                        email:  'Please provide valid email  address.',

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

<style scoped>


    .form-control-feedback, .has-danger label {
        color: #d9534f;
        text-align: center;
        display: block;
        width: 100%;
        margin-top: 12px;
    }

    .reg-box{

        box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);

        padding: 40px; background:#FFF;

        max-width: 500px;
    }
    main {display: flex; justify-content: center;}

    .lead{color: #01ae79;
        font-size: 1.1em;
        font-weight: bold;}

    .reg-box h2{color:#3e3d95;}
    .mglft-7{font-weight:bold;}


    .slide-leave-active,
    .slide-enter-active {
        transition: 300ms;
    }
    .slide-enter {
        transform: translate(100%, 0);
    }
    .slide-leave-to {
        transform: translate(-100%, 0);
    }


</style>
