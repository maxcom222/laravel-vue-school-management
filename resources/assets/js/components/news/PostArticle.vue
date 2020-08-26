<template>

    <div>

        <div class="form-group row">

            <label for="" class="col-12 col-form-label">Headline</label>

            <div class="col-12">

                <input type="text"

                       :class="{'is-invalid': errors.has('headline') }"

                       v-validate="'required|max:100|min:2'"

                       name="headline"

                       v-model="headline"

                       class="form-control"  placeholder="">

                <small
                        v-show="errors.has('headline')"

                        class="form-control-feedback e-feedback"
                >
                    {{ errors.first('headline') }}

                </small>

            </div>
        </div>



        <div class="form-group row">

            <label for="" class="col-12 col-form-label">Small description ( upto 50 characters)  </label>

            <div class="col-12">

                <input type="text"

                       :class="{'is-invalid': errors.has('small_desc') }"

                       v-validate="'required|max:100|min:2'"

                       name="small_desc"

                       v-model="small_desc"

                       class="form-control"  placeholder="">

                <small
                        v-show="errors.has('small_desc')"

                        class="form-control-feedback e-feedback"
                >
                    {{ errors.first('small_desc') }}

                </small>

            </div>

        </div>

        <div class="form-group  row">

            <label for="" class="col-12 col-form-label">Description</label>

            <div class="col-12">

                <vue-editor v-model="description"></vue-editor>

            </div>

        </div>


        <div class="form-group  row">

            <label for="" class="col-12 col-form-label">Want to tag school?</label>

            <div class="col-12">

                <vue-bootstrap-typeahead

                        v-model="school"

                        :data="typeahead"

                        placeholder="Type school name..."
                />


            </div>

        </div>



        <div class="form-group row">

            <label for="" class="col-12 col-form-label">Add image</label>

            <div class="col-12">

                 <span  class="btn btn-success fileinput-button"  >

                    <i class="glyphicon glyphicon-plus"></i>

                    <span>Select file</span>

                   <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>

                </span>

                <div id="progress" class="progress">

                    <div
                            class="progress-bar progress-bar-success"

                            :style="{'width': uploadPercentage + '%' }"
                    >

                    </div>

                </div>

                <div  v-if="showImageUpload===true" class="alert-warning nice-padding">

                    {{ dialog_msg  }}

                </div>

            </div>

         </div>


        <div class="form-group row" v-if="showSuccessMessage">

            <label for="" class="col-12 col-form-label"></label>

            <div class="col-12">
                    <div class="alert-success nice-padding">
                        Your post is published successfully.
                    </div>
            </div>
        </div>





        <div class="form-group row">

            <label for="" class="col-12 col-form-label"></label>

            <div class="col-12">

                <button :disabled="disableSubmit" type="button" @click="publishArticle" class="btn btn-sm btn-primary">Publish Article</button>


            </div>

        </div>





    </div>
    
</template>

<script>

    import { VueEditor } from "vue2-editor";

    import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';

    export default {

        name: "PostArticle",

        props:['fullPath'],

        components: {

            VueEditor,

            VueBootstrapTypeahead,
        },

        data() {

            return {


                headline : '',

                small_desc : '',

                description:'',

                school: '',

                image: '',

                typeahead: [],

                uploadPercentage: 0,

                showImageUpload:false,

                showSuccessMessage: false,

                dialog_msg: '',

                disableSubmit: false,


            }

        },

        methods: {


            handleFileUpload(){

                let formData = new FormData();

                this.file = this.$refs.file.files[0];

                formData.append('file', this.file);

                this.disableSubmit = true;

                axios.post( this.fullPath + 'news/upload_image',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: function( progressEvent ) {

                            this.uploadPercentage  = parseInt(progressEvent.loaded / progressEvent.total * 100, 10);

                            if( this.uploadPercentage === 100 ){

                                this.dialog_msg = 'Still uploading... Please wait';

                                this.showImageUpload = true;
                            }





                        }.bind(this)
                    }
                ).then( res  => {


                    this.dialog_msg = 'Your image is uploaded successfully.';

                    this.showImageUpload  = true;

                    this.image  = res.data.data;

                    this.disableSubmit = true;



                })
                    .catch(function(){

                        window.alert('There was some error in uploading. Try  again');
                    });


            },


            validateBeforeSubmit() {

                return this.$validator.validateAll().then((result) => {

                    if (result  ===  true ) {

                        return true;

                    } else {

                        // this.scrollTo();

                        return false;

                    }


                });
            },



            publishArticle() {

                this.validateBeforeSubmit().then(data => {

                    if (data === true) {

                        this.disableSubmit  = false;

                        let param  =
                             {
                                 headline: this.headline,

                                 small_desc: this.small_desc,

                                 description: this.description,

                                 school: this.school,

                                 image: this.image,

                                 post_id: 0,

                                 save_article: '1',

                             }



                        axios.post( this.fullPath + 'news/publish', param )
                            .then( res =>  {




                                    this.headline = '';

                                    this.small_desc = '';

                                    this.description= '';

                                    this.school = '';

                                    this.image = '';

                                    this.showSuccessMessage = true;

                                    this.disableSubmit  = true;

                                    this.$parent.goBack('post');

                            });




                    }
                });

            },

            school_type_ahead() {

                axios.post( this.fullPath + 'schools/school_type_ahead', {} )
                    .then( res =>  {

                        res.data.data.forEach( school  => {

                            this.typeahead.push( school.name );
                        });


                    });

            },

            customMessages(){

                const dict = {

                    custom: {

                        headline: {

                            required: 'Headline can not be empty',

                            min:  'Minimum 2 characters are allowed',

                            max:'Maximum 100 characters are allowed'

                        },

                        small_desc: {

                            required: 'Small description can not be empty',

                            min:  'Minimum 2 characters are allowed',

                            max:'Maximum 100 characters are allowed'

                        },



                    }
                };

                this.$validator.localize('en', dict);

            }


        },

        created()  {


            this.customMessages();


            this.school_type_ahead();


        }


    }
</script>

<style scoped>
    .col-form-label {

        font-size: 1.4em;
    }

    .fileinput-button {

        position: relative;

        overflow: hidden;

        display: block;

        width: 300px;

        margin: 0 auto;

        display: block;

        line-height: 60px;
    }
</style>