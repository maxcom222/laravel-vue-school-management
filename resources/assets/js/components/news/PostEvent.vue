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

            <label for="" class="col-12 col-form-label">Location</label>

            <div class="col-12">

                <input type="text"

                       :class="{'is-invalid': errors.has('location') }"

                       v-validate="'required'"

                       name="location" id="location"

                       v-model="location"

                       class="form-control"  placeholder="">

                <small
                        v-show="errors.has('location')"

                        class="form-control-feedback e-feedback"
                >
                    {{ errors.first('location') }}

                </small>

            </div>

        </div>


        <div class="form-group row">

            <label for="" class="col-12 col-form-label">Date</label>

            <div class="col-12">



                <datepicker

                        name="dated"

                        :class="{'is-invalid': errors.has('dated') }"

                        v-model="dated"  v-validate="'required'"

                        input-class="form-control"

                        :format="format"

                ></datepicker>


                <small
                        v-show="errors.has('dateformatd')"

                        class="form-control-feedback e-feedback"
                >
                    {{ errors.first('dated') }}

                </small>

            </div>

        </div>

        <div class="form-group row">

            <label for="" class="col-12 col-form-label">Time</label>

            <div class="col-12">


                <vue-timepicker

                        v-model="time_req"

                        name="time_req"

                        input-class="form-control"

                        >


                </vue-timepicker>


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




        <div class="form-group row" v-if="showSuccessMessage">

            <label for="" class="col-12 col-form-label"></label>

            <div class="col-12">

                    <div class="alert-success nice-padding">

                        Your event is published successfully.

                    </div>

            </div>

        </div>





        <div class="form-group row">

            <label for="" class="col-12 col-form-label"></label>

            <div class="col-12">

                <button :disabled="disableSubmit" type="button" @click="publishArticle" class="btn btn-sm btn-primary">Post Event</button>


            </div>

        </div>





    </div>
    
</template>

<script>

    import { VueEditor } from "vue2-editor";

    import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';

    import Datepicker from 'vuejs-datepicker';

    import VueTimepicker from 'vue2-timepicker'

    import 'vue2-timepicker/dist/VueTimepicker.css'


    export default {

        name: "PostEvent",

        props:['fullPath'],

        components: {

            VueEditor,

            VueBootstrapTypeahead,

            Datepicker,

            VueTimepicker
        },

        data() {

            return {


                headline : '',

                location : '',

                description:'',

                school: '',

                dated: '',

                time_req: {},

                typeahead: [],

                uploadPercentage: 0,

                showImageUpload:false,

                showSuccessMessage: false,

                dialog_msg: '',

                disableSubmit: false,

                latitude: '',

                longitude: '',

                format:  'yyyy-MM-dd',


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

                        this.disableSubmit  = true;

                        let param  =
                             {
                                 headline: this.headline,

                                 location: this.location,

                                 description: this.description,

                                 school: this.school,

                                 post_id: 0,

                                 save_article: '1',

                                 dated: this.dated,

                                 time_req: this.time_req.HH +   ':'     +   this.time_req.mm    +':00'   ,

                                 latitude: this.latitude,

                                 longitude: this.longitude,


                             }



                        axios.post( this.fullPath + 'news/publish/event', param )
                            .then( res =>  {


                                    this.headline = '';

                                    this.location = '';

                                    this.description= '';

                                    this.school = '';

                                    this.dated = '';

                                    this.time_req    = '';

                                    this.showSuccessMessage = true;

                                    this.disableSubmit  = false;

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

            },

            add_map() {

                let input = document.getElementById('location');

                let autocomplete = new google.maps.places.Autocomplete(input);

                google.maps.event.addListener(autocomplete, 'place_changed', function ()
                {
                    let place = autocomplete.getPlace();


                    if(place !== 'undefined' )
                    {
                        this.latitude = place.geometry.location.lat();

                        this.longitude = place.geometry.location.lng();

                    }

                });
            },


        },

        created()  {


            this.customMessages();


            this.school_type_ahead();

            setTimeout(  () => {

                this.add_map();

            }, 400);



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

    .vue__time-picker {

        width: 100%;
    }

    .vue__time-picker input.display-time{
        width: 100%;
    }
    .vue__time-picker input.display-time {

        height:38px;
    }
</style>