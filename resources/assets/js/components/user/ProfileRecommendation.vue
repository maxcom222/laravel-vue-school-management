<template>
    <div>

        <div v-if="recommendations.length >  0" class="frame">




            <div  v-for="(rec,index)  in recommendations" class="feed follower">

                <a
                        :href="profile_url(rec.username)"

                        class="teachers-card"

                >
                    <img
                            :src="profile_photo(rec.profile_photo)"

                            :alt="rec.name"

                    >
                    <span>

                <strong>

                    {{ rec.first_name }} {{ rec.last_name }}

                </strong>

               <small>
                    <time-ago

                            :refresh="60"

                            :datetime="new Date(rec.dated)"

                    ></time-ago>
               </small>

                <span class="people">

                    <svg class="icon icon-people">

                         <use :xlink:href="icon_people"></use>

                    </svg>

                    {{rec.followers }} followers

                </span>

            </span>

                </a>


                <p>

                    {{    rec.text }}

                </p>



            </div>






        </div>




        <div  v-if="recommendationBox">

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">Add Recommendation</h5>

                                </div>

                                <div class="modal-body" style="height:300px;" >

                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label"> Recommendation Text</label>

                                        <div class="col-12">

                                            <textarea type="text"

                                                   class="form-control"

                                                   name="text"

                                                   v-model="text"

                                                   v-validate="'required'"
                                            ></textarea>


                                            <small   v-if="errors.has('text')"  class="form-control-feedback e-feedback">
                                                {{ errors.first('text') }}
                                            </small>


                                        </div>

                                    </div>

                                    <p class="alert alert-success" v-if="dialog_msg !== '' ">
                                        {{  dialog_msg }}
                                    </p>


                                </div>


                                <div class="modal-footer "  >

                                    <button type="button" class="btn  btn-default modal-btn" @click="closeDialog">Close</button>

                                    <button type="button" class="btn btn-default modal-btn" @click="saveRec">Save

                                        <span v-if="recommendationProgress" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

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


    import {eventBus} from '../../app.js'

    import { Hooper,  Slide, Navigation as HooperNavigation } from 'hooper';

    import TimeAgo from 'vue2-timeago'

    export default {

        name: "ProfileRecommendation",

        props: ['fullPath', 'user', 'selfView'],

        components:{


            Hooper,

            Slide,

            HooperNavigation,

            TimeAgo
        },

        data(){

            return{

                user_image: this.fullPath + 'css/img/user-img.png',

                icon_people:  this.fullPath + 'css/ico/symbol-defs.svg#icon-people',


                recommendationBox: false,

                showEditor: false,

                imageSelectionDone: true,

                recommendationProgress: false,

                progressWidth: 0,

                file: '',

                uploadPercentage: 0,

                name: this.user.name,

                user_data: lscache.get('user_data'),

                dialog_msg:  '',

                text: '',

                recommendations: [],



            }
        },

        computed:{




        },

        methods:{

            profile_photo( image ) {

                return  'https://d2heijv3bffmsx.cloudfront.net/' +  image ;

            },

            profile_url( username ) {

                return  this.fullPath + 'user/profile/' + username ;

            },

            closeDialog(){

                this.recommendationBox   =   false;
            },


            saveRec(){

                let param = {friend_id : this.user.id,  text:  this.text, add:1  };

                this.recommendationProgress = true;

                axios.post( this.fullPath + 'profile/user/recommendation',
                    param,

                ).then( res  => {

                    this.dialog_msg = 'Recommendation is added successfully.';

                    setTimeout(() =>{

                        this.recommendationBox = false;

                    }, 1000 );

                    this.recommendationProgress = false;

                    this.recommendations  = res.data.data;

                });



            },

            getRec(){

                let param = {  friend_id : this.user.id  };

                axios.post( this.fullPath + 'profile/user/recommendation',
                    param,

                ).then( res  => {


                    this.recommendations  = res.data.data;

                });

            },
        },

        mounted(){

            eventBus.$on('recDialogHeaderMenu', (message) => {

                this.recommendationBox = true;

            });

            this.getRec();

            const dict = {
                custom: {
                    text: {

                        required: 'Text can not be empty',

                    },
                }
            };

            this.$validator.localize('en', dict);

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

    .recommend p{  padding: 0;}


    .btn-primary {

        display: block;

        margin: 0 auto;

        margin-top: 20px;
    }
    .pro-img{
        height: 200px;
        width:600px; border-radius: 0;}
    .pro-img img{border-radius: 0;}

    textarea.form-control {
        height: 200px;
    }
    .teachers-card img{border-radius: 0px;}
</style>