<template>
    <div>




        <div  v-if="profilePhotoModal">

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">Update your photo</h5>


                                </div>

                                <div class="modal-body" style="height:500px;" >


                                    <div class="pro-img" v-if="imageSelectionDone">

                                        <img id="drag-image2"   :src="user_image" alt="User Profile Photo">

                                    </div>

                                    <div class="pro-img" v-else>

                                        <img   v-bind:src="cropped" id="logoImage"  ref="croppedImage" alt="User Profile Photo">

                                    </div>


                                    <span class="btn btn-success fileinput-button " >

                                           <i class="glyphicon glyphicon-plus"></i>

                                               <span>Select profile photo</span>

                                                      <input id="fileupload" type="file" @change="enableEditor" name="profile_image">
                                    </span>


                                    <vue-croppie

                                            v-if="showEditor"

                                            ref="croppieRef"

                                            :enableOrientation="true"

                                            @result="result"


                                            @update="update">


                                    </vue-croppie>


                                    <div class="col-xs-12 col-md-12 text-center mg-top-30">



                                        <button  class="btn btn-dark"    @click="rotate(-90)"><i class="fa fa-rotate-left" aria-hidden="true"></i></button>

                                        <button  class="btn btn-dark"   @click="rotate(90)"><i class="fa fa-rotate-right" aria-hidden="true"></i></button>

                                        <button  class="btn btn-dark"   @click="crop()">View image</button>



                                    </div>

                                    <button type="button" v-if="showEditor"  @click="savePhoto"  class="btn btn-primary">Save Profile Photo</button>

                                    <div id="progress" class="progress">

                                        <div class="progress-bar progress-bar-success"
                                             :style="{'width': uploadPercentage + '%' }"

                                        >
                                        </div>
                                    </div>

                                    <p><a href="" class="text-muted skip-photo d-none js_skip">Skip</a></p>

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

    import 'croppie/croppie.css'

    Vue.use(VueCroppie);


    export default {

        name: "ProfilePhoto",

        props: ['fullPath', 'user', 'selfView'],

        components:{



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

            }
        },

        computed:{


            profile_photo() {

                return  'https://d2heijv3bffmsx.cloudfront.net/' +  this.user_data.profile_photo;

            }


        },

        methods:{

            closeDialog(){

                this.$parent.updatePhoto    =   false;
            },

            enableEditor() {


                this.imageSelectionDone  = true;

                let file = event.target.files[0];

                let reader = new FileReader();


                reader.onload = function(e, vm) {


                    this.$refs.croppieRef.bind({

                        url: e.target.result,
                    });

                    this.imageSelectionDone  = false;


                }.bind(this);

                reader.readAsDataURL(file);

                this.showEditor = true;


                setTimeout( ()  => {

                    this.crop();

                }, 100)




            },

            bind() {

                this.$refs.croppieRef.bind({

                    url: url,
                });
            },
            crop() {

                let options = {
                    format: 'jpeg',
                    circle: false
                }
                this.$refs.croppieRef.result(options, (output) => {
                    this.cropped = output;
                });

                this.showEditor =  true;
            },
            // EVENT USAGE
            cropViaEvent() {
                this.$refs.croppieRef.result(options);
            },
            result(output) {
                this.cropped = output;
            },
            update(val) {

            },
            rotate(rotationAngle) {
                // Rotates the image
                this.$refs.croppieRef.rotate(rotationAngle);
            },



            savePhoto(){

                this.crop();

                let formData = new FormData();

                this.file = this.cropped;

                formData.append('file', this.file);

                formData.append('uid', lscache.get('sess_uid') );

                axios.post( this.fullPath + 'profile/user/logo_upload',
                    formData,
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

                    this.$emit( 'updateProfilePhoto',   data.user_data.profile_photo );




                })
                    .catch(function(){

                        window.alert('There was some error in uploading. Try  again');
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

</style>