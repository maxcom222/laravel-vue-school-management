<template>
    <div>




        <div  v-if="profilePhotoModal">

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">Update your cover  photo</h5>


                                </div>

                                <div class="modal-body" style="height:500px;" >





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







                                </div>


                                <div class="modal-footer "  >

                                    <button type="button" class="btn  btn-primary btn-continue" @click="closeDialog">Close</button>

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


    import VueCroppie from 'vue-croppie';

    import Slim from '../slim/slim';


    import 'croppie/croppie.css'

    //Vue.use(VueCroppie);


    export default {

        name: "ProfileCover",

        props: ['fullPath', 'user', 'selfView'],

        components:{


            'slim-cropper': Slim


        },

        data(){

            return{

                user_image: this.fullPath + 'css/img/user-img.png',

                cropped: null,

                showEditor: false,

                imageSelectionDone: true,

                progressWidth: 0,

                file: '',

                uploadPercentage: 0,

                name: this.user.name,

                profilePhotoModal: false,

                user_data: lscache.get('user_data'),

                dialog_msg:  '',

                slimOptions: {


                    service: this.savePhoto,

                    didInit: this.slimInit,

                    size:  "600,300",

                    push: false,
                }

            }
        },

        computed:{


            profile_photo() {

                return  'https://d2heijv3bffmsx.cloudfront.net/' +  this.user_data.profile_photo;

            }


        },

        methods:{

            slimInit (data, slim) {

            },

            closeDialog(){

                this.$parent.updateCp    =   false;
            },


            savePhoto(formdata, progress, success, failure, slim){

                formdata.append('cover', '1');


                axios.post( this.fullPath + 'profile/user/logo_upload',
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

                    this.dialog_msg = 'Cover photo is updated successfully';

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

                    this.$emit( 'updateCoverPhoto',   data.data );


                });



            },
        },

        mounted(){


            this.profilePhotoModal = true;
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


    .btn-primary {

        display: block;

        margin: 0 auto;

        margin-top: 20px;
    }
.pro-img{
    height: 200px;
    width:600px; border-radius: 0;}
    .pro-img img{border-radius: 0;}


</style>