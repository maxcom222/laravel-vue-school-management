<template>


    <div>

        <div class="frame contact-buyer">

            <h3>Reply to this Ad:</h3>

            <form>

                <div class="form-row">

                    <div class="form-group col-12">

                        <label for="">Email</label>

                        <input type="email"  name="email" v-validate="'required'" v-model="email_address" class="form-control"  placeholder="">

                        <small v-show="errors.has('email')" class="form-control-feedback e-feedback">{{ errors.first('email') }}</small>

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group col-md-6">

                        <label for="">Name</label>

                        <input type="text" name="name" class="form-control"  v-validate="'required'"  v-model="name" placeholder="">

                        <small v-show="errors.has('name')" class="form-control-feedback e-feedback">{{ errors.first('name') }}</small>

                    </div>

                    <div class="form-group col-md-6">

                        <label for="">Phone</label>

                        <input type="text"  name="phone"  class="form-control" v-model="phone" placeholder="">



                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-12">

                        <label for="">Message</label>

                        <textarea class="form-control" name="message"   v-validate="'required'"  v-model="message"></textarea>

                        <small v-show="errors.has('message')" class="form-control-feedback e-feedback">{{ errors.first('message') }}</small>



                    </div>

                </div>

            </form>

            <p class="alert alert-primary ">By clicking on 'Send Reply', I agree to the Expats' School Terms & Conditions and Privacy Policy</p>

            <p class="alert alert-success"  v-if="reply_submit===1">Your request is submitted successfully</p>

            <p class="alert alert-danger"  v-if="applied===1">You have send a message for this  ad</p>

            <button  @click="reply_ad"  v-if="applied===0"    class="btn btn-sm btn-primary">

                Send Reply

                <span :class="reply_progress===1? '': 'd-none'" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>


            </button>


        </div>





    </div>



</template>

<script>




    export default {

        name: "AdreplyComponent",

        props: ['fullPath', 'adItem'],

        components: {

        },

        data() {

            return {

                reply_progress: 0,

                reply_submit: 0,

                message:  '',

                phone:'',

                name:'',

                email_address:'',

                rec_email:  '',

                ad_link: '',

                applied: 0,


                icon_flag: this.fullPath +  'css/ico/symbol-defs.svg#icon-flag',

                icon_favorite: this.fullPath +  'css/ico/symbol-defs.svg#icon-favorite',



            }


        },

        computed: {


        },


        methods: {

            validateBeforeSubmit() {

                return this.$validator.validateAll().then((result) => {

                    if (result  ===  true ) {

                        return true;

                    } else {


                        return false;

                    }


                });
            },


            reply_ad(){


                this.validateBeforeSubmit().then(data => {

                    if(  data === true   ) {

                        this.reply_progress = 1;


                        let param =
                            {
                                reply_ad : 1,

                                cid: this.adItem.id,

                                rec_email: this.rec_email,

                                message: this.message,

                                phone_number:  this.phone,

                                name: this.name,

                                email: this.email_address,

                                ad_link: this.ad_link,

                            };

                        axios.post( this.fullPath + 'classifieds/reply_ad/post', param )
                            .then( res => {

                                this.reply_progress = 0;

                                this.reply_submit = 1;

                                let cid = this.adItem.id;

                                let item_id = 'ad_applied_' + cid;

                                lscache.set( item_id , '1'  );

                                this.applied  = 1;


                            });



                    }
                })




            },




        },

        created()  {


        },
        mounted() {



            let cid = this.adItem.id;

            let item_id = 'ad_applied_' + cid;

            this.rec_email =  this.adItem.email;

            //lscache.set( item_id, null  );

            this.ad_link = this.fullPath + 'classifieds/' + this.adItem.url;

            if( lscache.get( item_id ) !== null ) {

                this.applied = '1';
            }

        }



    }








</script>



<style scoped>

    textarea {

        height:200px;
    }

    input[aria-invalid="true"], textarea[aria-invalid="true"]{
        border:1px solid red;
    }

</style>
