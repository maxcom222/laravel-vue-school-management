<template>
    <div>

        <div class="tab-pane active" id="pills-step-3" role="tabpanel" >

            <div class="bio">

                <p class="lead">{{ name }}</p>


                <p class="lead mg-bottom-10">Please provide us a mug shot for your Profile</p>
                <p>Please note it needs a passport quality</p>

                <p><small>Profile image more than 1MB may result in errors or  could be very  slow to upload</small></p>

            </div>


            <slim-cropper :options="slimOptions">

                <input type="file" name="slim"/>

            </slim-cropper>

            <div id="progress" class="progress">

                <div class="progress-bar progress-bar-success"
                     :style="{'width': uploadPercentage + '%' }"

                >
                </div>
            </div>

            <p class="alert alert-warning" v-if="dialog_msg !== '' ">
                {{  dialog_msg }}
            </p>


            <button type="button" v-if="showSaveProfile"  @click="savePhoto2"  class="btn btn-profile btn-primary">Save Profile Information</button>






        </div>


        <div class="break"></div>



    </div>

</template>

<script>




    import Slim from '../slim/slim';


    export default {

        name: "Step4",

        props:['fullPath', ],

        components:{

            'slim-cropper': Slim
        },

        data(){

            return{

                user_image: this.fullPath + 'css/img/user-img.png',

                cropped: null,

                showEditor: false,

                imageSelectionDone: true,

                icon_right:  this.fullPath + 'css/ico/symbol-defs.svg#icon-rotate-right',

                icon_left:  this.fullPath + 'css/ico/symbol-defs.svg#icon-rotate-left',

                file: '',

                dialog_msg:  '',

                uploadPercentage:  0,


                slimOptions: {

                    service: this.savePhoto,

                    didInit: this.slimInit,

                    size:  "600,600",

                    push: false,
                },

                showSaveProfile: false,



               // uploadPercentage: 0,

            }
        },

        computed:{

            name(){

                return this.$parent.first_name + '  ' + this.$parent.last_name;

            },


        },

        methods:{

            slimInit (data, slim) {

            },


            savePhoto(formdata, progress, success, failure, slim){



                axios.post( this.fullPath + 'profile/user/logo_upload_wizard',
                    formdata,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },

                        onUploadProgress: function( progressEvent ) {

                            this.uploadPercentage  = parseInt(progressEvent.loaded / progressEvent.total * 100, 10);

                            if( this.uploadPercentage === 100 ){

                                this.dialog_msg = 'Still uploading... Please wait';

                            }

                        }.bind(this)

                    }
                ).then( res  => {

                    this.dialog_msg = 'Please click Save Profile Information';

                    this.file = res.data.url;

                    this.showSaveProfile = true;

                });



            },

            savePhoto2( image ){

                this.$emit('saveInformation', this.file);

            },
        },

        mounted(){

            console.log( lscache.get('sess_uid') );

            this.$parent.tabSelected = 4;
        }
    }
</script>

<style scoped>

    .croppie-container {

        width: 400px;

        height: 200px;

        margin: 0 auto;

        margin-top: 20px;

        margin-bottom: 20px;
    }
    .mg-top-30{

        margin-top: 40px;
    }

    .break {
        margin-bottom: 10px;
        clear: both;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .btn-profile {

        margin: 0 auto;

        display: flex;

        margin-top: 30px;
    }
</style>