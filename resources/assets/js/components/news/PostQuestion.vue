<template>

    <div>

        <div class="form-group row">

            <label for="" class="col-12 col-form-label">What's your question? </label>

            <div class="col-12">

                <input type="text"

                       :class="{'is-invalid': errors.has('question') }"

                       v-validate="'required|max:100|min:2'"

                       name="question"

                       v-model="question"

                       class="form-control"  placeholder="">

                <small
                        v-show="errors.has('question')"

                        class="form-control-feedback e-feedback"
                >
                    {{ errors.first('question') }}

                </small>

            </div>
        </div>



        <div class="form-group  row">

            <label for="" class="col-12 col-form-label">Description your question</label>

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




        <div class="form-group row" v-if="showSuccessMessage">

            <label for="" class="col-12 col-form-label"></label>

            <div class="col-12">

                <div class="alert-success nice-padding">

                    Your question is published successfully.

                </div>

            </div>

        </div>





        <div class="form-group row">

            <label for="" class="col-12 col-form-label"></label>

            <div class="col-12">

                <button :disabled="disableSubmit" type="button" @click="publishArticle" class="btn btn-sm btn-primary">Post question</button>


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


                question : '',

                description:'',

                school: '',

                typeahead: [],

                showSuccessMessage: false,

                disableSubmit: false,


            }

        },

        methods: {



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
                                question: this.question,

                                description: this.description,

                                school: this.school,

                                post_id: 0,

                                save_article: '1',

                            }



                        axios.post( this.fullPath + 'news/publish/question', param )
                            .then( res =>  {


                                this.question = '';

                                this.description= '';

                                this.school = '';

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

                        question: {

                            required: 'Question title can not be empty',

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