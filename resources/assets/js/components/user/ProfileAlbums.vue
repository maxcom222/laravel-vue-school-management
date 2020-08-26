<template>
    <div>



        <div class="frame" id="gallery">

            <h2>Albums/E-Portfolio </h2>


            <a href=""

               v-if="selfView === 1"

               @click.prevent="profilePhotoModal=!profilePhotoModal"

               class="btn-edit"><svg class="icon icon-add">

                <use :xlink:href="icon_add"></use>
            </svg>

            </a>

            <div v-if="albums.length > 0 && showSlider ===  false " class="alist albums">

                <div v-for="obj in albums" class="album">

                    <a href="" @click.prevent="playSlider(obj)" >

                        <div class="image-album">

                            <div class="uiScaledImageContainer">

                                <img class="scaledImageFitWidth img" :src="mainImage( obj.user_albums_photos[0].image ) " :alt="obj.album.name">

                            </div>

                            <div class="album-gxb">

                                <div>

                                    <div class="album-gxd pl-8">

                                        <span class="album-iem font-600">{{  obj.album.name }}</span>

                                    </div>

                                    <div class="album-gxe pl-8">

                                        <span class="album-ieq font-600">{{   obj.user_albums_photos.length   }} Items</span>

                                    </div>

                                </div>

                            </div>

                            <div class="_4f0s">

                            </div>

                        </div>

                    </a>

                </div>

            </div>

            <div v-if="showSlider">

                <a href="" @click.prevent="showSlider = !showSlider" class="backTo">

                        <svg class="icon icon-arrow_back2 icon-top">

                            <use :xlink:href="icon_back_arrow"></use>

                        </svg>

                    Back to Albums

                </a>

                <h3>{{  sliderTitle }}</h3>

                <p><b>{{  sliderDesc }}</b><br> Location: {{ sliderLocation }}</p>

                <div class="operate" v-if="selfView===1">

                    <a class="btn-opt" href="">

                        <svg class="icon icon-mode_edit icon-top">

                            <use :xlink:href="this.$parent.icon_edit">

                            </use>

                        </svg>

                        Edit</a>

                    <a  @click.prevent="delAlbumModal"   class="btn-opt"  href="">

                        <svg class="icon icon-delete icon-top">

                            <use :xlink:href="icon_del">

                            </use>

                        </svg>

                        Delete</a>

                </div>

                <hooper      >

                    <slide :key="'slide' + index" v-for="(image_obj,index) in sliderImages">

                        <img :src="mainImage(image_obj.image)" >

                    </slide>

                    <hooper-navigation slot="hooper-addons"></hooper-navigation>

                </hooper>


            </div>





        </div>



        <div  v-show="profilePhotoModal">

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">Upload New Album</h5>


                                </div>

                                <div class="modal-body" style="height:300px;" >



                                    <vue-dropzone

                                            id="more_images"

                                            @vdropzone-success="file_uploaded"

                                            :options="dropzoneOptions"

                                            @vdropzone-removed-file="removeThisFile"

                                            @vdropzone-queue-complete="showAlbumInsert"


                                            :useCustomSlot=true
                                    ></vue-dropzone>

                                    <p class="mg-top-30 alert alert-warning" v-if="uploadMessage">
                                        {{  dialog_msg }}
                                    </p>

                                    <div v-if="uploadDone" id="contentAlbum" >

                                            <div class="form-group row">
                                                <label for="" class="col-12 col-form-label">Title</label>
                                                <div class="col-12">

                                                    <input type="text"

                                                           :class="{'is-invalid': errors.has('title') }"

                                                           v-validate="'required'"

                                                           name="title"

                                                           v-model="title"

                                                           class="form-control">

                                                    <small v-if="errors.has('title')" class="form-control-feedback e-feedback">{{ errors.first('title') }}</small>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="" class="col-12 col-form-label">Description</label>
                                                <div class="col-12">

                                                    <textarea

                                                           :class="{'is-invalid': errors.has('description') }"

                                                           v-validate="'required'"

                                                           name="description"

                                                           v-model="description"

                                                           class="form-control"></textarea>

                                                    <small v-if="errors.has('description')" class="form-control-feedback e-feedback">{{ errors.first('description') }}</small>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="" class="col-12 col-form-label">Location</label>
                                                <div class="col-12">

                                                    <input type="text"

                                                           :class="{'is-invalid': errors.has('location') }"

                                                           v-validate="'required'"

                                                           name="location"

                                                           v-model="location"

                                                           class="form-control">

                                                    <small v-if="errors.has('location')" class="form-control-feedback e-feedback">{{ errors.first('location') }}</small>

                                                </div>
                                            </div>


                                        <div class="form-group row">
                                            <div class="col-sm-12">

                                                <p v-if="dailog_msg2!==   ''  " class="alert alert-success">

                                                    {{ dailog_msg2 }}
                                                </p>
                                                <button type="button" @click="save_album()"  class="btn btn-primary">Save Album

                                                    <span v-if="saveProgress" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                                </button>
                                            </div>
                                        </div>


                                    </div>




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




        <div v-if="userAlbumDelete"   >

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">Delete Album</h5>


                                </div>

                                <div class="modal-body" style="height: 100px; overflow-y: hidden;" >

                                    <p class="text-success">{{ delete_msg }}</p>

                                </div>

                                <div class="modal-footer "  >

                                    <button type="button" class="btn btn-default modal-btn" @click="userAlbumDelete=false">Cancel</button>
                                    <button type="button" class="btn btn-default modal-btn" @click="deleteAlbum()">Delete
                                        <span v-if="delProgress" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    </button>

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

    import vue2Dropzone from 'vue2-dropzone';

    import 'vue2-dropzone/dist/vue2Dropzone.min.css';

    var VueScrollTo = require('vue-scrollto');

    import { Hooper,  Slide, Navigation as HooperNavigation } from 'hooper';



    export default {

        name: "ProfileAlbums",

        props: ['fullPath', 'user', 'selfView'],

        components:{


            vueDropzone: vue2Dropzone,

            Hooper,

            Slide,

            HooperNavigation


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

                icon_add: this.fullPath + 'css/ico/symbol-defs.svg#icon-add',

                icon_back_arrow: this.fullPath + 'css/ico/symbol-defs.svg#icon-arrow_back2',

                icon_del:  this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

                uploadMessage: false,

                dialog_msg:  '',

                images: '',

                albums: '',

                title: '',

                description: '',

                location: '',

                uploadDone:  false,

                saveProgress: false,

                dailog_msg: '',

                delete_msg: 'Are you sure to delete this album?',

                showSlider: false,

                userAlbumDelete: false,

                delProgress: false,

                dailog_msg2: '',

                sliderImages: '',

                sliderLocation: '',

                sliderDesc:  '',

                sliderTitle: '',

                delAlbumId: '',

                dropzoneOptions: {

                    url: this.fullPath +  'user/album/post',

                    thumbnailWidth: 150,

                   // addRemoveLinks: true,

                    headers: { "X-CSRF-TOKEN":  document.head.querySelector('meta[name="csrf-token"]').content }
                },

            }
        },

        computed:{


            profile_photo() {

                return  'https://d2heijv3bffmsx.cloudfront.net/' +  this.user_data.profile_photo;

            },



        },

        methods:{


            playSlider( obj ){


                  this.showSlider = true;

                  this.delAlbumId        = obj.album.id;

                  this.sliderImages      = obj.user_albums_photos;

                  this.sliderTitle       = obj.album.name;

                  this.sliderLocation    = obj.album.location;

                  this.sliderDesc        = obj.album.description;
            },

            closeDialog(){

                this.profilePhotoModal   =   false;

                this.dailog_msg2 =  '';
            },

            delAlbumModal( id ){

                this.userAlbumDelete = true;

                this.delete_msg =  'Are you sure to delete this album?';

            },

            deleteAlbum(){

                this.delete_msg = 'Removing your album...';

                let param = { del:1,  id:this.delAlbumId  };

                this.delProgress = true;

                axios.post(  this.fullPath  + 'user/album/post',  param )
                    .then( res => {

                        this.delProgress = false;

                        this.delete_msg = 'Your album is deleted successfully';

                        this.albums = res.data.data;

                        this.showSlider = false;

                    });
            },

            mainImage( image ){

                return  'https://d2heijv3bffmsx.cloudfront.net/albums/' +  image;
            },

            trimChar(string, charToRemove) {

                while(string.charAt(0) === charToRemove) {
                    string = string.substring(1);
                }

                while(string.charAt(string.length-1) === charToRemove) {

                    string = string.substring(0,string.length-1);
                }

                return string;
            },

            removeThisFile(file) {


                let removing_file = JSON.parse( file.xhr.response);

                removing_file = removing_file.data;

                this.images = this.images.substr(2);

                let image_array  = this.images.split('##');

                image_array.forEach( (image, index) => {

                    console.log( image + '====' + index  );

                    if( image ===  removing_file ){

                        image_array.splice(index, 1);
                    }

                });

                console.log( image_array);

            },

            showAlbumInsert(){

                this.uploadDone = true;

                VueScrollTo.scrollTo('#contentAlbum', 300)
            },


            file_uploaded(file, response ) {


                if( parseInt( response.result ) === 1 ) {

                    this.images = this.images + '##' + response.data;

                    this.dialog_msg = 'One of your image is uploaded successfully.';

                    this.uploadMessage = true;




                } else {


                    this.dialog_msg = 'There was some error in uploading your image. Try  different image.';

                    this.uploadMessage = true;


                }

            },


            save_album(){

                let param = {title: this.title, description: this.description, location: this.location,  images: this.images, album:1,  uid: this.user.id };

                this.saveProgress = true;
                axios.post(  this.fullPath  + 'user/album/post',  param )
                    .then( res => {

                        this.saveProgress = false;

                        this.dailog_msg2 = 'Your album is saved successfully';

                        this.albums = res.data.data;

                        this.title = '';

                        this.description = '';

                        this.location = '';


                    });
            },

            get_album(){

                let param = { fetch_album:1, uid: this.user.id };

                this.saveProgress = true;

                axios.post(  this.fullPath  + 'user/album/post',  param )

                    .then( res => {

                        this.saveProgress = false;

                        this.dailog_msg = 'Your album is saved successfully';

                        this.albums = res.data.data;

                    })

            }



        },

        mounted(){



            const dict = {

                custom: {

                    title: {

                        required: 'Title can not be empty',

                    },

                    location: {

                        required: 'Location can not be empty',

                    },

                    description: {

                        required: 'Description about  album not be empty',

                    },


                }
            };

            this.$validator.localize('en', dict);

            this.get_album();


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

    width:600px; border-radius: 0;

}
    .pro-img img{border-radius: 0;}

    .icon-top{margin-top:  0}

    .backTo{font-size: 12px; font-weight:bold; float: right; }

    .hooper{height:500px}

    .hooper-slide img {
        width: 600px;
        min-height: 400px;
    }

    .hooper{position:relative;width:100%}.hooper,.hooper *{box-sizing:border-box}.hooper-list{overflow:hidden;width:100%;height:100%}.hooper-track{display:-webkit-flex;display:flex;box-sizing:border-box;width:100%;height:100%;padding:0;margin:0}.hooper.is-vertical .hooper-track{-webkit-flex-direction:column;flex-direction:column;height:200px}.hooper.is-rtl{direction:rtl}.hooper-sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0}.hooper-slide{-webkit-flex-shrink:0;flex-shrink:0;height:100%;margin:0;padding:0;list-style:none}.hooper-progress{position:absolute;top:0;right:0;left:0;height:4px;background-color:#efefef}.hooper-progress-inner{height:100%;background-color:#4285f4;transition:.3s}.hooper-pagination{position:absolute;bottom:0;right:50%;-webkit-transform:translateX(50%);transform:translateX(50%);display:-webkit-flex;display:flex;padding:5px 10px}.hooper-indicators{display:-webkit-flex;display:flex;list-style:none;margin:0;padding:0}.hooper-indicator.is-active,.hooper-indicator:hover{background-color:#4285f4}.hooper-indicator{margin:0 2px;width:12px;height:4px;border-radius:4px;border:none;padding:0;background-color:#fff;cursor:pointer}.hooper-pagination.is-vertical{bottom:auto;right:0;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%)}.hooper-pagination.is-vertical .hooper-indicators{-webkit-flex-direction:column;flex-direction:column}.hooper-pagination.is-vertical .hooper-indicator{width:6px}.hooper-next,.hooper-prev{background-color:transparent;border:none;padding:1em;position:absolute;top:50%;-webkit-transform:translateY(-50%);transform:translateY(-50%);cursor:pointer}.hooper-next.is-disabled,.hooper-prev.is-disabled{opacity:.3;cursor:not-allowed}.hooper-next{right:0}.hooper-prev{left:0}.hooper-navigation.is-vertical .hooper-next{top:auto;bottom:0;-webkit-transform:initial;transform:none}.hooper-navigation.is-vertical .hooper-prev{top:0;bottom:auto;right:0;left:auto;-webkit-transform:initial;transform:none}.hooper-navigation.is-rtl .hooper-prev{left:auto;right:0}.hooper-navigation.is-rtl .hooper-next{right:auto;left:0}#nprogress{pointer-events:none}#nprogress .bar{background:#3eaf7c;position:fixed;z-index:1031;top:0;left:0;width:100%;height:2px}#nprogress .peg{display:block;position:absolute;right:0;width:100px;height:100%;box-shadow:0 0 10px #3eaf7c,0 0 5px #3eaf7c;opacity:1;-webkit-transform:rotate(3deg) translateY(-4px);transform:rotate(3deg) translateY(-4px)}#nprogress .spinner{display:block;position:fixed;z-index:1031;top:15px;right:15px}#nprogress .spinner-icon{width:18px;height:18px;box-sizing:border-box;border-color:#3eaf7c transparent transparent #3eaf7c;border-style:solid;border-width:2px;border-radius:50%;-webkit-animation:nprogress-spinner .4s linear infinite;animation:nprogress-spinner .4s linear infinite}

</style>

<style>

    li{list-style: none;}


    .operate a{

        display: block;

        font-size: 12px;

    }

    .text-success{

        font-size: 16px;
        padding-top: 20px;
    }

    .operate{  margin-top: 10px; margin-bottom: 20px; }
    .btn-edit{  margin-bottom: 5px; }

</style>