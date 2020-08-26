<template>

    <div>

        <input type="hidden" id="login_page" value="1" />


             <div v-if="loaderShow" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>


        <main class="authorize register">


            <div v-if="loaderShow" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

            <div class="user-box">


                <a :href="home_ur"><img :src="logoa" alt="Expats' Schools Logo"></a>



                <ul class="nav nav-pills" id="pills-tab" role="tablist">

                    <li class="nav-item">

                        <a
                                :class="step===1? 'active': ''"

                                @click.prevent="step=1"

                               >

                            Login

                        </a>

                    </li>

                    <li class="nav-item">
                        <a


                                @click.prevent="redirectToRegister"

                               >

                            Register

                        </a>

                    </li>

                </ul>

                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane fade" :class="step===1? 'show active' : 'd-none'"  >

                        <form id="login_form" v-if="showLoginDiv" data-vv-scope="login" >



                            <div class="form-group row">

                                <label for="email" class="col-sm-2 col-form-label">Email</label>

                                <div class="col-sm-10">

                                    <input type="email"

                                           v-validate="'required|email'"

                                           class="form-control"

                                           name="email_login"

                                           v-model="email_login"  placeholder="Email">

                                </div>

                                <small
                                        v-show="errors.has('login.email_login')"

                                        class="form-control-feedback e-feedback">

                                    {{ errors.first('login.email_login') }}

                                </small>


                            </div>

                            <div class="form-group row">

                                <label for="password" class="col-sm-2 col-form-label">Password</label>

                                <div class="col-sm-10">

                                    <input type="password"

                                           class="form-control"

                                           v-validate="'required'"

                                           name="password"

                                           v-model="password_login" @keyup.enter="submitLogin"

                                           placeholder="Password">

                                </div>


                                <small
                                        v-show="errors.has('login.password')"

                                        class="form-control-feedback e-feedback">

                                    {{ errors.first('login.password') }}

                                </small>

                            </div>

                            <div class="form-group row">

                                <label for="forgot" class="col-sm-2 col-form-label"></label>

                                <div class="col-sm-10"><p>Forgot password? <a href="" @click.prevent="showResetPassword" class="">Reset</a> here.</p></div>

                            </div>




                            <div class="form-group row">

                                <div class="col-sm-12">

                                    <button type="button" @click="submitLogin" class="btn btn-primary">Login</button>

                                    <p>Don't have an account? <a href="" @click.prevent="step=2">Register</a> now.</p>

                                </div>

                            </div>


                        </form>

                        <div class="reset_password_form"  v-if="showResetDiv" >

                            <reset-component :full-path="fullPath">


                            </reset-component>

                        </div>







                    </div>


                    <div class="tab-pane fade" :class="step===2? 'show active' : 'd-none'">

                    </div>

                </div>

            </div>
        </main>









        <div v-if="noticeModal">
            <transition name="modal">
                <div class="modal-mask" @click="noticeModal = false">
                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ noticeHeader }}</h5>
                                    <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" @click="adFavModal = false">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>{{ noticeMsg }}</p>
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




    import ResetComponent from './ResetComponent.vue';

    import {eventBus} from '../../app.js'

    export default {

        name: "LoginComponent",

        components: { ResetComponent },

        props: ['fullPath'],

        data() {

            return {

                loaderShow: true,

                step: 1,

                logoa: this.fullPath + 'css/img/logoa.png',

                icon_url: this.fullPath + 'css/ico/symbol-defs.svg#',

                icon_people:  this.icon_url + 'icon-people',

                icon_star: this.icon_url + 'icon-star',

                keyboard_arrow_right: this.icon_url + 'icon-keyboard_arrow_right',

                followProgress: false,

                followStatus:  'Follow',

                home_ur: this.fullPath,

                showLoginDiv: true,

                showResetDiv: false,

                email_login: '',

                password_login: '',

                reset_password_email: '',

                noticeModal:  false,

                noticeMsg: '',

                noticeHeader: 'Account Login',



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

            redirectToRegister(){

               // document.location.href = this.fullPath  +  'account/registration';

                this.$router.push('/registration');
            },


            submitLogin(){


                this.validateBeforeSubmit('login').then(data => {

                    if(  data === true   ) {

                        let param = {

                            email: this.email_login ,

                            password: this.password_login,

                        };

                        axios.post(this.fullPath + '/user/post/login', param  )

                            .then( res => {

                                if( parseInt(  res.data.response  )  === 2  ){

                                    this.noticeModal = true;

                                    this.noticeMsg = 'You email address or password is incorrect.'

                                } else {


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

                                    let ad = lscache.get( 'ad'); /* ad=1 post ad, ad=2 job redirect*/

                                    eventBus.$emit('hideHeader', {  value : 0} );

                                    if( ad === 1 )
                                    {

                                        lscache.set( 'ad', null );

                                        this.$router.push('/classifieds/post');
                                    }

                                    else
                                    {

                                        let init_choice = data.user_choice;


                                        if( init_choice === 'teacher' )
                                        {

                                            //window.location.href  = this.fullPath   + 'user/profile/' + data.username	;

                                            this.$router.push( '/profile/' +  data.username );

                                        }
                                        else
                                        {
                                           // window.location.href  = this.fullPath  + 'parents';
                                            this.$router.push( '/parents' );

                                        }

                                    }

                                }

                            });

                    }
                });


            },



            showLogin(){


                this.showLoginDiv = true;

                this.showResetDiv = false;
            },



            showResetPassword(){


                this.showLoginDiv = false;

                this.showResetDiv = true;
            },

            showRegister(){


            },

            stripHtml(  html ) {

                var temporalDivElement = document.createElement("div");

                temporalDivElement.innerHTML = html;

                return temporalDivElement.textContent || temporalDivElement.innerText || "";
            },


        },


        created()  {


        },

        mounted() {

            this.loaderShow = false;



            eventBus.$emit('hideHeader', {  value : 1} );


            const dict = {

                custom: {

                    email_login: {

                        required: 'Your email can not be empty',

                        email:  'Your email address should be valid email address',
                    },

                    password_login: {

                        required: 'Your password can not be empty',

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
