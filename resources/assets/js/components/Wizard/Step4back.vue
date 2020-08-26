<template>
    <div>

        <div class="tab-pane active" id="pills-step-3" role="tabpanel" >

            <div class="bio">

                <p class="lead">{{ name }}</p>


                <p class="lead mg-bottom-10">Please provide us a mug shot for your Profile</p>

                <p><small>Please upload upto 1MB file. File size more than 1MB might result in errors</small></p>

            </div>

            <div class="pro-img" v-if="imageSelectionDone">

                <img id="drag-image2"   :src="user_image" alt="User Profile Photo">

            </div>

            <div class="pro-img" v-else>

                <img   v-bind:src="cropped" id="logoImage"  ref="croppedImage" alt="User Profile Photo">

            </div>





            <span class="btn btn-success fileinput-button " data-id="pills-step-4-tab">

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



                <button  class="btn btn-dark"    @click="rotate(-90)">

                    <i class="fa fa-rotate-left" aria-hidden="true"></i>

                    <svg class="icon icon-rotate-left" style="    transform: rotate(90deg);">

                        <use :xlink:href="icon_left"></use>

                    </svg>


                </button>

                <button  class="btn btn-dark"   @click="rotate(90)">

                    <svg class="icon icon-rotate-left">

                        <use :xlink:href="icon_left"></use>

                    </svg>



                </button>

                <button  class="btn btn-dark"   @click="crop()">View image</button>



            </div>




            <button type="button" v-if="showEditor"  @click="savePhoto"  class="btn btn-profile btn-primary">Save Profile Information</button>


            <div id="progress" class="progress">

                <div class="progress-bar progress-bar-success"
                     :style="{'width': uploadPercentage + '%' }"

                >
                </div>
            </div>


            <p><a href="" class="text-muted skip-photo d-none js_skip">Skip</a></p>

        </div>


        <div class="break"></div>



    </div>

</template>

<script>


    import VueCroppie from 'vue-croppie';

    import 'croppie/croppie.css'



    export default {

        name: "Step4",

        props:['fullPath',  'uploadPercentage', 'dialog_msg'],

        components:{

            VueCroppie

        },

        data(){

            return{

                user_image: this.fullPath + 'css/img/user-img.png',

                cropped: null,

                showEditor: false,

                imageSelectionDone: true,

                icon_right:  this.fullPath + 'css/ico/symbol-defs.svg#icon-rotate-right',

                icon_left:  this.fullPath + 'css/ico/symbol-defs.svg#icon-rotate-left',


                // progressWidth: 0,

                file: '',



               // uploadPercentage: 0,

            }
        },

        computed:{

            name(){

                return this.$parent.first_name + '  ' + this.$parent.last_name;

            },


        },

        methods:{

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
                console.log(val);
            },
            rotate(rotationAngle) {
                // Rotates the image
                this.$refs.croppieRef.rotate(rotationAngle);
            },



            savePhoto(){

                this.crop();

                let formData = new FormData();

                this.file = this.cropped;

                this.$emit('saveInformation', this.file);

                return;

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

                    let init_choice = data.user_choice;


                    if( init_choice === 'teacher' )
                    {

                        window.location.href  = this.fullPath   + 'user/profile/' + data.username	;

                    }
                    else
                    {

                        window.location.href  = this.fullPath  + 'parents';

                    }






                })
                    .catch(function(){

                        window.alert('There was some error in uploading. Try  again');
                    });


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