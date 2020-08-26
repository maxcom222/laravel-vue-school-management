<template>
    <div>




        <div  v-if="specModal">

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">Specialization</h5>


                                </div>

                                <div class="modal-body" style="height:300px;" >




                                    <ul v-if="selfView!== 1 && specCollection.length > 0 "  class="spec-list">

                                        <li  v-ripple.mouseover="'rgba(193,216,254, 0.35 )'"   v-for="specs  in specCollection">

                                            <svg class="icon icon-verify">
                                                <use :xlink:href="verify_icon"></use>
                                            </svg>

                                            {{ specs }}
                                        </li>

                                    </ul>


                                    <vue-tags-input  v-if="selfView === 1 "

                                            v-model="tag"

                                            :tags="tags"

                                            @tags-changed="newTags => tags = newTags"
                                    />

                                    <p class="alert alert-success mg-top-30" v-if="dialog_msg!== ''">
                                        {{ dialog_msg }}
                                    </p>


                                    <button  v-if="selfView === 1 "  v-ripple.mouseover="'rgba(193,216,254, 0.35 )'"   type="button" class="btn  btn-primary" @click="saveTags">

                                        Save

                                        <span v-if="progress" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    </button>




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

    import VueTagsInput from '@johmun/vue-tags-input';

    import {eventBus} from '../../app.js'


    export default {

        name: "ProfilePhoto",

        props: ['fullPath', 'user', 'selfView'],

        components:{


            VueTagsInput,


        },

        data(){

            return{

                user_image: this.fullPath + 'css/img/user-img.png',

                uploadPercentage: 0,

                name: this.user.name,

                specModal: false,

                progress: false,

                user_data: lscache.get('user_data'),

                dialog_msg:  '',

                tag: '',

                tags: [],

                specCollection:  [],

                verify_icon: this.fullPath +  'css/ico/symbol-defs.svg#icon-verify',




            }
        },

        computed:{



        },

        methods:{


            closeDialog(){

                this.specModal  =   false;

                document.body.classList.remove("modal-open");
            },

            showContact() {

                document.body.classList.add("modal-open");

                this.specModal = true;

            },


            saveTags(){

                let specs_save =  '';
                this.tags.forEach( spec => {
                    let  text  = spec.text;
                    specs_save  =  specs_save  + ',' + text
                });

                let  param = {spec:specs_save,  skill:1 };

                this.progress =  true;

                this.user.spec = specs_save;


                axios.post( this.fullPath + 'user/profile/save_about',  param, ).then( res  => {

                    this.dialog_msg = 'Your Skills list is updated successfully';

                    this.progress =  false;


                });



            },
        },

        mounted(){


            this.tagModal = true;

            if( this.user.spec !==  null  ){

                let  spec = this.user.spec.split(',');

                this.specCollection = spec;

                spec.forEach( spec => {

                    let  obj = { text: spec  };

                    this.tags.push( obj );

                });

            }



            eventBus.$on('specDialogLeftMenu', (message) => {


                this.showContact();

            });
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


<style>

    .ti-input{ height: 200px;}

    .ti-tags{ height:40px;}

    .ti-tag{      font-size: 1em !important;

         font-weight: bold;

        padding: 5px !important;
    }

    .vue-tags-input{ max-width:100%  !important; }

    .spec-list li {

        width: auto;
        background: #3e3d95;
        padding: 5px;
        color: #FFF;
        margin-bottom: 10px;
        border-radius: 4px;
        text-align: center;
        margin-right: 6px;
        float: left;
        list-style: none;
    }

</style>