<template>

<div>

    <h2>Update password</h2>

        <div class="feed">

            <form>

                <div class="form-group row">

                    <label for="first-name" class="col-3 col-form-label">Current Password</label>

                    <div class="col-9">

                        <input


                                name="current_password"

                                class="form-control form-control-sm"

                                v-validate="'required'"

                                v-model="current_password"

                                type="password">

                        <small
                                v-show="errors.has('current_password')"

                                class="form-control-feedback e-feedback">

                            {{ errors.first('current_password') }}

                        </small>

                    </div>

                </div>

                <div class="form-group row">

                    <label for="last-name" class="col-3 col-form-label">New Password</label>

                    <div class="col-9">

                        <input

                                name="password"

                                class="form-control form-control-sm"

                                ref="password"

                                v-model="new_password"

                                v-validate="'required|min:6|max:35'"

                                type="password">


                        <small
                                v-show="errors.has('password')"

                                class="form-control-feedback e-feedback">

                            {{ errors.first('password') }}

                        </small>



                    </div>

                </div>

                <div class="form-group row">

                    <label for="email" class="col-3 col-form-label">Confirm New Password</label>

                    <div class="col-9">

                        <input
                                name="confirm_password"

                                v-validate="'required|confirmed:password'"

                                class="form-control form-control-sm"

                                type="password">


                        <small
                                v-show="errors.has('confirm_password')"

                                class="form-control-feedback e-feedback">

                            {{ errors.first('confirm_password') }}

                        </small>






                    </div>

                </div>


                <div class="form-group row" v-if="isDone === 1">

                    <label  class="col-4 col-form-label"></label>

                    <div class="col-8">

                        <p  :class="alertClass" class=" nice-padding">{{ isDoneText }}</p>


                    </div>

                </div>

                <div class="form-group row">

                    <div class="offset-4 col-8">

                        <button

                                @click="submitBasic"

                                name="submit"

                                type="button"

                                class="btn btn-sm btn-primary">
                            Save

                            <span  v-if="inprogress===1"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>


                        </button>

                    </div>

                </div>



            </form>

        </div>


</div>


</template>

<script>
    export default {

        name: "Settingsecurity",


        data() {


            return {

                current_password: '',

                new_password: '',

                inprogress: 0,

                isDone: 0,

                isDoneText: '',

                fullPath: this.$parent.fullPath,

                user: this.$parent.user,

                alertClass: 'alert-success',



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


            submitBasic() {

                let param = {

                    current_password: this.current_password,

                    new_password: this.new_password,

                    save_security: 1,
                };

                this.validateBeforeSubmit().then(data => {

                    console.log(data);

                    if(  data === true   ) {


                        this.inprogress = 1;


                        axios.post( this.fullPath + 'settings/user_update_password', param )
                            .then( res => {

                                if( parseInt( res.data.result )  ===  3 ) {

                                    this.isDoneText =  res.data.data;

                                    this.alertClass  = 'alert-danger';


                                } else {

                                    this.isDoneText = 'Password is updated successfully';

                                    this.alertClass  = 'alert-success';
                                }

                                this.inprogress = 0;

                                this.isDone  = 1;



                            });




                    }
                });








            }

        },

        mounted() {




            const dict = {
                custom: {

                    current_password: {

                        required: 'Your current password can not be empty',



                    },

                    password: {

                        required: 'Your password can not be empty',

                        min: 'Your password should have at least six characters',

                        max: 'Your password should have maximum thirty five characters',


                    },

                    confirm_password:{

                        required: 'Your confirm password can not be empty',

                        confirmed: () => 'Your password and confirm password does not match.'

                    }


                }
            };

            this.$validator.localize('en', dict);



        },
    }
</script>

<style scoped>



</style>