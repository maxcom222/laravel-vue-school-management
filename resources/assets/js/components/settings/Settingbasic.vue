<template>

<div>

    <h2>Basic Settings</h2>

        <div class="feed">

            <form>

                <div class="form-group row">

                    <label for="first-name" class="col-3 col-form-label">First Name</label>

                    <div class="col-9">

                        <input


                                name="first-name"

                                class="form-control form-control-sm"

                                v-validate="'required'"

                                v-model="first_name"

                                type="text">

                    </div>

                </div>

                <div class="form-group row">

                    <label for="last-name" class="col-3 col-form-label">Last Name</label>

                    <div class="col-9">

                        <input

                                name="last-name"

                                class="form-control form-control-sm"

                                v-model="last_name"

                                v-validate="'required'"


                                type="text">

                    </div>

                </div>

                <div class="form-group row">

                    <label for="email" class="col-3 col-form-label">Email</label>

                    <div class="col-9">

                        <input
                                name="email"

                                v-model="email"

                                v-validate="'required|email'"

                                class="form-control form-control-sm"

                                type="text">

                    </div>

                </div>

                <div class="form-group row">

                    <label for="phone" class="col-3 col-form-label">Phone</label>

                    <div class="col-9">

                        <input
                                name="phone"

                                v-model="contact_number"

                                class="form-control form-control-sm"

                                type="text">

                    </div>

                </div>

                <div class="form-group row" v-if="isDone === 1">

                    <label  class="col-3 col-form-label"></label>

                    <div class="col-9">

                        <p class="alert-success nice-padding">Data is saved successfully</p>


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

                <br /><Br />


                <p>Closing Your Account:</p>

                <p>By closing your account, you will be logged out of expatsschools.com and your account will be removed.</p>

                <div class="form-group row">

                    <div class="offset-4 col-8">

                        <button name="close"

                                type="button"

                                class="btn btn-sm btn-primary js_close_account">Close your account</button>


                    </div>

                </div>

            </form>

        </div>


</div>


</template>

<script>
    export default {

        name: "Settingbasic",

        data() {


            return {

                first_name: '',

                last_name: '',

                email: '',

                contact_number: '',

                inprogress: 0,

                isDone: 0,

                user: this.$parent.user,

                fullPath: this.$parent.fullPath,

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

                    first_name: this.first_name,

                    email: this.email,

                    last_name: this.last_name,

                    contact_number: this.contact_number,

                    save_basic_info: 1,
                };

                this.validateBeforeSubmit().then(data => {



                    if(  data === true   ) {


                        this.inprogress = 1;


                        axios.post( this.fullPath + 'post/basic_info', param )
                            .then( res => {

                                this.inprogress = 0;

                                this.isDone  = 1;



                            });




                    }
                });








            }

        },

        mounted() {

            this.first_name = this.user.first_name;

            this.last_name = this.user.last_name;

            this.email = this.user.email;

            this.contact_number = this.user.contact_number;


            const dict = {
                custom: {

                    first_name: {

                        required: 'Your first name can not be empty',

                    },

                    last_name: {

                        required: 'Your last name can not be empty',

                    },

                    email: {

                        required: 'Your email can not be empty',

                        email: 'Your email should be a valid email address',

                    },



                }
            };

            this.$validator.localize('en', dict);


        },
    }
</script>

<style scoped>


</style>