<template>


    <div id="invite_friend">


        <div  class="frame widget pro-widget">

            <h3>Invite <span>Your Friends</span></h3>

            <p>Have 35 people sign up and we will call you with a BIG surprise.</p>

            <div class="form-group  row">

                <label for="" class="col-12 col-form-label">Email address (multiple emails can be comma separated)</label>

                <div class="col-12">

                    <input

                            type="text"

                            value=""

                            class="form-control"

                            v-model="invite_email_address"


                            name="invite_email_address"

                            placeholder="">

                    <p v-if="emailSent===1" class="alert-success nice-padding  mg-top-10">

                        Invitation is sent successfully.
                    </p>

                </div>

            </div>

            <div class="form-group  row">

                <div class="col-12">

                    <button

                            type="button"

                            @click="inviteFriends"

                            class="btn btn-primary"
                    >

                        Send

                        <span v-if="progress===1" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>



                    </button>

                </div>

            </div>

        </div>




    </div>

</template>



<script>
export default {

    name: "ProfileInvite",

    props: ['fullPath', 'user', 'selfView'],


    data()  {


        return{

            invite_email_address:  '',

            emailSent: 0,

            progress:0,



        }
    },

    computed: {


    },
    methods:{

        inviteFriends() {


            if( this.invite_email_address === '' ){

                return;
            }

            if( this.progress ===0 )  {

                this.progress = 1;

                axios.post( this.fullPath + 'user/profile/invite_friend', { email: this.invite_email_address, invite_friend:  1 })
                    .then( res  => {

                        this.progress = 0;

                        this.emailSent = 1;

                        this.invite_email_address = '';

                    });
            }


        }




    },


    created() {


    }
}
</script>

<style scoped>

    .form-control {

        height: 34px;
    }

</style>