<template>
    <div>

        <div class="tab-pane active" id="pills-step-4" role="tabpanel">

            <p class="lead">Let's confirm your email</p>

            <p>We have sent a code to you. Enter the code below to confirm you have access to this email.</p>

            <div class="form-group row">

                <div class="col-12">

                    <label>Verification Code</label>


                    <input type="text"  v-validate="'required'"

                           class="form-control" v-model="verification_code" name="code" placeholder="">

                    <p class="nice-padding alert-success" v-if="response.length >  0 ">

                        {{ response }}

                    </p>

                </div>

            </div>


            <div class="form-group row"  v-if="successVerification===false">

                <div class="col-sm-12">

                    <button type="button"  @click="confirmCode" class="btn btn-primary">

                        Confirm

                        <span v-if="progress" class="fa fa-refresh fa-spin"></span>

                    </button>

                </div>

            </div>



            <div class="form-group row" v-if="successVerification">

                <div class="col-sm-12">

                    <button type="button"  @click="nextStep" class="btn btn-primary">Next</button>

                </div>

            </div>


            <p>
                Code invalid or didn’t receive it?

                <a class="" @click.prevent="sendAgain" href="">Send again

                    <span v-if="progressAgain" class="fa fa-refresh fa-spin"></span>

            </a></p>

        </div>



    </div>
    
</template>

<script>
    export default {

        name: "Step4",

        props:['fullPath'],

        data(){


            return{


                verification_code: '',

                response: '',

                successVerification:  false,

                progress: false,

                progressAgain: false,


            }
        },

        methods: {

            sendAgain()  {

                let param = {  code:1, id: lscache.get('sess_uid')  };

                this.progressAgain = true;

                axios.post(  this.fullPath +  'resend_code', param  )
                    .then( res => {

                        this.progressAgain = false;

                        if( parseInt( res.data.result ) === 1 ){

                            this.response  = 'New verification code is sent to your email address.'

                            this.successVerification = true;


                        } else {

                            this.response  = 'Please try again'
                        }

                    });




            },

            nextStep(){

                this.$parent.step = 2;

            },

            confirmCode() {


                this.progress = true;

                if( this.verification_code === ''  ){

                    return;
                }

                let param = { verification_code:  this.verification_code,  uid: lscache.get('sess_uid')  };

                axios.post(  this.fullPath +  'verify_primary_email', param  )
                    .then( res => {

                        this.progress = false;

                        if( res.data.result === 1 ){

                            this.response  = 'Your account is verified successfully.'

                            this.successVerification = true;


                        } else {

                            this.response  = 'Your verification code is incorrect. Please try again'
                        }

                    });



            }
        }
    }
</script>

<style scoped>

.alert-success {

    margin-top: 20px;
}

</style>