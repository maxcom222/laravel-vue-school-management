<template>
<div>


    <div class="tab-pane fade"  :class="step===1? 'show active' : 'd-none'" id="pills-step-1" role="tabpanel">

        <p class="lead">Start adding some details for your ad post.</p>
        <form  data-vv-scope="stepj" >

            <div class="form-group row">
                <label for="" class="col-12 col-form-label">Title</label>
                <div class="col-12">
                    <input type="text"

                           :class="{'is-invalid': errors.has('stepj.ad_title') }"

                           v-validate="'required'"

                           name="ad_title"

                           v-model="ad_title"

                           class="form-control"  :placeholder="title_placeholder">

                    <small v-show="errors.has('stepj.ad_title')" class="form-control-feedback e-feedback">{{ errors.first('stepj.ad_title') }}</small>

                </div>
            </div>


            <div class="form-group row">
                <label for="" class="col-12 col-form-label">Category</label>
                <div class="col-12">

                    <v-select name="category"

                              v-validate="'required'"

                               placeholder="Select Top Category"

                              :close-on-select="true"

                              @input="load_next_level($event,1)"

                              v-model="model_category"

                              :options="category"></v-select>

                    <small v-show="errors.has('stepj.category')" class="form-control-feedback e-feedback">{{ errors.first('stepj.category') }}</small>

                </div>
            </div>



            <div class="form-group row sub_cat" v-if="cat_level > 1">
                <label for="" class="col-12 col-form-label">Sub Category</label>
                <div class="col-12">

                    <v-select

                            placeholder="Select Sub Category"

                              :close-on-select="true"

                              @input="load_next_level($event,2)"


                              v-model="model_sub_category"

                              :options="sub_category"></v-select>




                </div>
            </div>


            <div class="form-group row level_3"    v-if="cat_level>2">
                <label for="" class="col-12 col-form-label">Level 3 Category</label>
                <div class="col-12">

                    <v-select   class="level_3"

                                placeholder="Select Sub Category"

                              :close-on-select="true"

                              @input="load_next_level($event,3)"


                              v-model="model_level_cat_3"

                              :options="level_cat_3"></v-select>


                </div>
            </div>


            <div class="form-group row level_4"   v-if="cat_level>3 && model_category.code === 1242">
                <label for="" class="col-12 col-form-label">Model</label>
                <div class="col-12">


                    <v-select   class="level_3" ref="js_cars_modals"

                                placeholder="Select Model"

                                :close-on-select="true"

                                @input="load_next_level($event,4)"


                                v-model="model_level_cat_4"

                                :options="level_cat_4"></v-select>

                </div>
            </div>

            <div class="form-group row level_5"   v-if="cat_level>4">
                <label for="" class="col-12 col-form-label">Year</label>
                <div class="col-12">


                    <v-select   class="level_5" ref="js_year"

                                :close-on-select="true"

                                placeholder="Select year"

                                @input="load_next_level($event,4)"


                                v-model="years"

                                :options="yearModal"></v-select>


                </div>
            </div>

            <div class="form-group row level_5 "  v-if="cat_level>4">
                <label for="" class="col-12 col-form-label">Mileage</label>
                <div class="col-12">
                    <input  style="width:100%;" value="0"  v-model="range_mileage"  type="range" min="0" max="1000000"  class="level_4"  id="js_mileage"  />
                    <span id="js_mileage_span">{{ range_mileage }} KM</span>
                </div>
            </div>


            <div class="form-group row level_5"  v-if="cat_level>4">
                <label for="" class="col-12 col-form-label">Service History</label>
                <div class="col-12">
                    <input  class="form-control level_4"    type="checkbox"   id="service_history"  />
                </div>
            </div>





            <div class="form-group row ">
                <label for="" class="col-12 col-form-label">Address ( select address from dropdown list )</label>
                <div class="col-12">

                    <input type="text" name="address"

                           v-validate="'required'"

                           :value="address"    class="form-control" autocomplete="thirstycrow" id="address"   />


                    <small v-show="errors.has('stepj.address')" class="form-control-feedback e-feedback">{{ errors.first('stepj.address') }}</small>

                    <br /><Br />

                    <input type="hidden"  :value="longitude" id="longitude" />
                    <input type="hidden" :value="latitude" id="latitude" />
                    <div class="map_container">
                        <p><strong>OR</strong> Select Location by clicking on map</p>
                        <div id="js_bigMap" style="height: 400px; border:1px solid #000; position: relative; overflow: hidden;"></div>
                    </div>

                </div>
            </div>








            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="button" @click="next_step"  class="btn btn-primary">Next</button>
                </div>
            </div>
        </form>

    </div>












    <div class="tab-pane fade"    :class="step===2 ? 'show active' : 'd-none' "  role="tabpanel">
        <p class="lead">Important details</p>


        <form   data-vv-scope="step2" >

        <div class="form-group row">
            <label for="" class="col-12 col-form-label">Phone number</label>
            <div class="col-12  price-ui">

                <v-select

                            :close-on-select="true"

                            placeholder="Select country code"

                            name="phone_number_code"

                            v-model="phone_number_code"
                            :options="phone_number_code_collection"

                            >



                </v-select>




                <input type="text"
                       v-validate="'required'" name="phone_number"
                       value="" v-model="phone_number" class="form-control" id="phone_number"  placeholder="">

                <small v-show="errors.has('step2.phone_number')" class="form-control-feedback e-feedback">{{ errors.first('step2.phone_number') }}</small>


            </div>
        </div>

        <div class="form-group row">
            <label for="" class="col-12 col-form-label">Price</label>
            <div class="col-12 price-ui">

                <v-select


                        v-model="price_currency"
                        :options="currency_collection"
                        placeholder="Select currency"
                        >




                </v-select>

                <input type="text"

                       v-validate="'required'" name="price"

                       value=""  v-model="price" class="form-control"
                       id="price"

                       placeholder="">

                <small v-show="errors.has('step2.price')" class="form-control-feedback e-feedback">{{ errors.first('step2.price') }}</small>

            </div>
        </div>


        <div class="form-group row">
            <label for="" class="col-12 col-form-label">Description</label>
            <div class="col-12">
                <textarea value=""
                          v-validate="'required'" name="description"
                          v-model="description" style="height:100px;" class="form-control" id="description"></textarea>

                <small v-show="errors.has('step2.description')" class="form-control-feedback e-feedback">{{ errors.first('step2.description') }}</small>

            </div>
        </div>


        <div class="form-group row">
            <label for="" class="col-12 col-form-label">Age</label>
            <div class="col-12">

                <v-select
                        v-model="age"
                        :close-on-select="true"
                        placeholder="Select age"



                        :options="[

                        { code:1, label:'Brand New'  },
                        { code:2, label:'0-1 month'  },
                        { code:3, label:'1-6 months'  },
                        { code:4, label:'6-12 months'  },
                        { code:5, label:'1-2 years'  },
                        { code:6, label:'2-5 years'  },
                        { code:7, label:'5-10 years'  },
                        { code:8, label:'10+ years'  }


                        ]"
                >



                </v-select>

            </div>
        </div>


        <div class="form-group row ">
            <label for="" class="col-12 col-form-label">Usage</label>
            <div class="col-12">
                <v-select
                        :close-on-select="true"
                        placeholder="Select usage"
                        v-model="usage"

                        v-validate="'required'" name="usage"

                        :options="[{ code:1, label:'Still in original packaging'},
                        { code:2, label: 'Out of original packaging, but only used once'} ,
                        { code:3, label: 'Used only a few times'} ,
                        { code:4, label: 'Used an average amount, as frequently as would be expected'} ,
                        { code:5, label: 'Used an above average amount since purchased'} ]"

                >


                </v-select>

                <small v-show="errors.has('step2.usage')" class="form-control-feedback e-feedback">{{ errors.first('step2.usage') }}</small>


            </div>
        </div>

        <div class="form-group row">
            <label for="" class="col-12 col-form-label">Condition</label>
            <div class="col-12">

                <v-select
                        :close-on-select="true"
                        placeholder="Select condition"
                        v-model="condition"

                        v-validate="'required'" name="condition"

                        :options="[
                        { code: 5, label:'Perfect inside and out'},
                        { code: 4, label:'Almost no noticeable problems or flaws'},
                        { code: 3, label:'A bit of wear and tear, but in good working condition'},
                        { code: 2, label:'Normal wear and tear for the age of the item, a few problems here and there'},
                        { code: 1, label:'Above average wear and tear.  The item may need a bit of repair to work properly'}]"


                >

                </v-select>

                <small v-show="errors.has('step2.condition')" class="form-control-feedback e-feedback">{{ errors.first('step2.condition') }}</small>


            </div>
        </div>

        <div class="form-group row">
            <label for="" class="col-12 col-form-label">Warranty</label>
            <div class="col-12">

                <v-select
                        :close-on-select="true"
                        placeholder="Select warranty"

                        v-validate="'required'" name="warranty"


                        v-model="warranty"
                        :options="[
                        {code:'Yes', label: 'Yes'  },
                        {code:'No', label: 'No'  },
                        {code:'Does not apply', label: 'Does not apply'  }

                        ]"
                >


                </v-select>

                <small v-show="errors.has('step2.warranty')" class="form-control-feedback e-feedback">{{ errors.first('step2.warranty') }}</small>


            </div>
        </div>
        <input type="hidden" id="ad_photos" name="ad_photos"  />
        <input type="hidden" id="ad_id_m" name="ad_id_m"  />

        <div class="form-group row">
            <div class="col-sm-12">
                <button type="button" @click="next_step"   class="btn  btn-primary">Continue</button>
            </div>
        </div>
        </form>

    </div>




    <div class="tab-pane fade"   :class="step===3 ? 'show active' : 'd-none' "  role="tabpanel">

        <div class="bio">
            <div class="pro-img-2">Upload cover photo for your ad</div>
        </div>


        <span  class="btn btn-success fileinput-button"  >

            <i class="glyphicon glyphicon-plus"></i>
            <span>Select file</span>

           <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>


        </span>

        <div id="progress" class="progress">

            <div class="progress-bar progress-bar-success"
                 :style="{'width': uploadPercentage + '%' }"

            >
            </div>
        </div>


    </div>


    <div class="tab-pane fade"   :class="step===4 ? 'show active' : 'd-none' " id="pills-step-4" role="tabpanel">

        <div class="bio">
            <div class="pro-img-2">Upload more images</div>
        </div>


        <vue-dropzone
                        id="moreimages"

                        @vdropzone-success="file_uploaded"

                        :options="dropzoneOptions"

                        @vdropzone-removed-file="removeThisFile"


                        :useCustomSlot=true
        >
        <div class="dropzone-custom-content">
            <h3 class="dropzone-custom-title">Drag and drop to upload content!</h3>
            <div class="subtitle">...or click to select a file from your computer</div>
        </div>
    </vue-dropzone>


        <div class="form-group row  submit-ad"  :class="step >= 3 ? '' : 'd-none'">
            <div class="col-sm-12 text-center">
                <button type="button" @click="submitAd" class="btn  btn-primary">Confirm &amp; Submit</button>
            </div>
        </div>


    </div>






    <div v-if="adPostModal">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Post an Ad</h5>
                                <button type="button"  :class="removeCancel ===  true ? 'd-none'  : '' " class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" @click="adPostModal = false">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>{{ dialog_msg }}</p>
                            </div>
                            <div class="modal-footer " :class="dialogWithFooter ===  false ? 'd-none'  : '' "  >
                                <button type="button" class="btn  btn-primary btn-continue" @click="continueHome">Continue  to home</button>
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


    export default {

        components: {

            vueDropzone: vue2Dropzone,

        },




        props: ['fullPath' ],
        data() {

            return {


                dropzoneOptions: {

                    url: this.fullPath +  'classifieds/album/post',

                    thumbnailWidth: 150,

                    //addRemoveLinks: true,

                    headers: { "X-CSRF-TOKEN":  document.head.querySelector('meta[name="csrf-token"]').content }
                },

                step:  1,

                title_placeholder: 'e.g Mobile Phone',

                topCategory:'',

                category: [],

                longitude: '',

                latitude: '',

                sub_category:  [],

                cat_level: 1,

                level_cat_3: [],

                level_cat_4 : [],

                model_sub_category: '',
                model_category: '',
                model_level_cat_3:'',
                model_level_cat_4:'',
                dialog_msg: '',

                range_mileage:  0,

                ad_title: '',

                address: '',

                price_currency:'',

                price:  '',

                age : '',
                condition:'',
                warranty: '',
                usage: '',

                description:'',
                phone_number:'',
                phone_number_code:'',
                yearModal: [],

                phone_number_code_collection:  [{codetype:"AE" ,code:"971"  ,label:   "UAE (+971)" },
                    {  codetype: "US" ,code:"1"   ,label:   "USA (+1)" },
                    { codetype:"GB" ,code:"44"  ,label:   "UK (+44)" },
                    { codetype:"DZ" ,code:"213"  ,label:   "Algeria (+213)" },
                    { codetype:"AD" ,code:"376"  ,label:   "Andorra (+376)" },
                    { codetype:"AO" ,code:"244"  ,label:   "Angola (+244)" },
                    { codetype:"AI" ,code:"1264"  ,label:   "Anguilla (+1264)" },
                    { codetype:"AG" ,code:"1268"  ,label:   "Antigua &amp; Barbuda (+1268)" },
                    { codetype:"AR" ,code:"54"  ,label:   "Argentina (+54)" },
                    { codetype:"AM" ,code:"374"  ,label:   "Armenia (+374)" },
                    { codetype:"AW" ,code:"297"  ,label:   "Aruba (+297)" },
                    { codetype:"AU" ,code:"61"  ,label:   "Australia (+61)" },
                    { codetype:"AT" ,code:"43"  ,label:   "Austria (+43)" },
                    { codetype:"AZ" ,code:"994"  ,label:   "Azerbaijan (+994)" },
                    { codetype:"BS" ,code:"1242"  ,label:   "Bahamas (+1242)" },
                    { codetype:"BH" ,code:"973"  ,label:   "Bahrain (+973)" },
                    { codetype:"BD" ,code:"880"  ,label:   "Bangladesh (+880)" },
                    { codetype:"BB" ,code:"1246"  ,label:   "Barbados (+1246)" },
                    { codetype:"BY" ,code:"375"  ,label:   "Belarus (+375)" },
                    { codetype:"BE" ,code:"32"  ,label:   "Belgium (+32)" },
                    { codetype:"BZ" ,code:"501"  ,label:   "Belize (+501)" },
                    { codetype:"BJ" ,code:"229"  ,label:   "Benin (+229)" },
                    { codetype:"BM" ,code:"1441"  ,label:   "Bermuda (+1441)" },
                    { codetype:"BT" ,code:"975"  ,label:   "Bhutan (+975)" },
                    { codetype:"BO" ,code:"591"  ,label:   "Bolivia (+591)" },
                    { codetype:"BA" ,code:"387"  ,label:   "Bosnia Herzegovina (+387)" },
                    { codetype:"BW" ,code:"267"  ,label:   "Botswana (+267)" },
                    { codetype:"BR" ,code:"55"  ,label:   "Brazil (+55)" },
                    { codetype:"BN" ,code:"673"  ,label:   "Brunei (+673)" },
                    { codetype:"BG" ,code:"359"  ,label:   "Bulgaria (+359)" },
                    { codetype:"BF" ,code:"226"  ,label:   "Burkina Faso (+226)" },
                    { codetype:"BI" ,code:"257"  ,label:   "Burundi (+257)" },
                    { codetype:"KH" ,code:"855"  ,label:   "Cambodia (+855)" },
                    { codetype:"CM" ,code:"237"  ,label:   "Cameroon (+237)" },
                    { codetype:"CA" ,code:"1"  ,label:   "Canada (+1)" },
                    { codetype:"CV" ,code:"238"  ,label:   "Cape Verde Islands (+238)" },
                    { codetype:"KY" ,code:"1345"  ,label:   "Cayman Islands (+1345)" },
                    { codetype:"CF" ,code:"236"  ,label:   "Central African Republic (+236)" },
                    { codetype:"CL" ,code:"56"  ,label:   "Chile (+56)" },
                    { codetype:"CN" ,code:"86"  ,label:   "China (+86)" },
                    { codetype:"CO" ,code:"57"  ,label:   "Colombia (+57)" },
                    { codetype:"KM" ,code:"269"  ,label:   "Comoros (+269)" },
                    { codetype:"CG" ,code:"242"  ,label:   "Congo (+242)" },
                    { codetype:"CK" ,code:"682"  ,label:   "Cook Islands (+682)" },
                    { codetype:"CR" ,code:"506"  ,label:   "Costa Rica (+506)" },
                    { codetype:"HR" ,code:"385"  ,label:   "Croatia (+385)" },
                    { codetype:"CY" ,code:"90"  ,label:   "Cyprus - North (+90)" },
                    { codetype:"CY" ,code:"357"  ,label:   "Cyprus - South (+357)" },
                    { codetype:"CZ" ,code:"420"  ,label:   "Czech Republic (+420)" },
                    { codetype:"DK" ,code:"45"  ,label:   "Denmark (+45)" },
                    { codetype:"DJ" ,code:"253"  ,label:   "Djibouti (+253)" },
                    { codetype:"DM" ,code:"1809"  ,label:   "Dominica (+1809)" },
                    { codetype:"DO" ,code:"1809"  ,label:   "Dominican Republic (+1809)" },
                    { codetype:"EC" ,code:"593"  ,label:   "Ecuador (+593)" },
                    { codetype:"EG" ,code:"20"  ,label:   "Egypt (+20)" },
                    { codetype:"SV" ,code:"503"  ,label:   "El Salvador (+503)" },
                    { codetype:"GQ" ,code:"240"  ,label:   "Equatorial Guinea (+240)" },
                    { codetype:"ER" ,code:"291"  ,label:   "Eritrea (+291)" },
                    { codetype:"EE" ,code:"372"  ,label:   "Estonia (+372)" },
                    { codetype:"ET" ,code:"251"  ,label:   "Ethiopia (+251)" },
                    { codetype:"FK" ,code:"500"  ,label:   "Falkland Islands (+500)" },
                    { codetype:"FO" ,code:"298"  ,label:   "Faroe Islands (+298)" },
                    { codetype:"FJ" ,code:"679"  ,label:   "Fiji (+679)" },
                    { codetype:"FI" ,code:"358"  ,label:   "Finland (+358)" },
                    { codetype:"FR" ,code:"33"  ,label:   "France (+33)" },
                    { codetype:"GF" ,code:"594"  ,label:   "French Guiana (+594)" },
                    { codetype:"PF" ,code:"689"  ,label:   "French Polynesia (+689)" },
                    { codetype:"GA" ,code:"241"  ,label:   "Gabon (+241)" },
                    { codetype:"GM" ,code:"220"  ,label:   "Gambia (+220)" },
                    { codetype:"GE" ,code:"7880"  ,label:   "Georgia (+7880)" },
                    { codetype:"DE" ,code:"49"  ,label:   "Germany (+49)" },
                    { codetype:"GH" ,code:"233"  ,label:   "Ghana (+233)" },
                    { codetype:"GI" ,code:"350"  ,label:   "Gibraltar (+350)" },
                    { codetype:"GR" ,code:"30"  ,label:   "Greece (+30)" },
                    { codetype:"GL" ,code:"299"  ,label:   "Greenland (+299)" },
                    { codetype:"GD" ,code:"1473"  ,label:   "Grenada (+1473)" },
                    { codetype:"GP" ,code:"590"  ,label:   "Guadeloupe (+590)" },
                    { codetype:"GU" ,code:"671"  ,label:   "Guam (+671)" },
                    { codetype:"GT" ,code:"502"  ,label:   "Guatemala (+502)" },
                    { codetype:"GN" ,code:"224"  ,label:   "Guinea (+224)" },
                    { codetype:"GW" ,code:"245"  ,label:   "Guinea - Bissau (+245)" },
                    { codetype:"GY" ,code:"592"  ,label:   "Guyana (+592)" },
                    { codetype:"HT" ,code:"509"  ,label:   "Haiti (+509)" },
                    { codetype:"HN" ,code:"504"  ,label:   "Honduras (+504)" },
                    { codetype:"HK" ,code:"852"  ,label:   "Hong Kong (+852)" },
                    { codetype:"HU" ,code:"36"  ,label:   "Hungary (+36)" },
                    { codetype:"IS" ,code:"354"  ,label:   "Iceland (+354)" },
                    { codetype:"IN" ,code:"91"  ,label:   "India (+91)" },
                    { codetype:"ID" ,code:"62"  ,label:   "Indonesia (+62)" },
                    { codetype:"IQ" ,code:"964"  ,label:   "Iraq (+964)" },
                    { codetype:"IE" ,code:"353"  ,label:   "Ireland (+353)" },
                    { codetype:"IL" ,code:"972"  ,label:   "Israel (+972)" },
                    { codetype:"IT" ,code:"39"  ,label:   "Italy (+39)" },
                    { codetype:"JM" ,code:"1876"  ,label:   "Jamaica (+1876)" },
                    { codetype:"JP" ,code:"81"  ,label:   "Japan (+81)" },
                    { codetype:"JO" ,code:"962"  ,label:   "Jordan (+962)" },
                    { codetype:"KZ" ,code:"7"  ,label:   "Kazakhstan (+7)" },
                    { codetype:"KE" ,code:"254"  ,label:   "Kenya (+254)" },
                    { codetype:"KI" ,code:"686"  ,label:   "Kiribati (+686)" },
                    { codetype:"KR" ,code:"82"  ,label:   "Korea - South (+82)" },
                    { codetype:"KW" ,code:"965"  ,label:   "Kuwait (+965)" },
                    { codetype:"KG" ,code:"996"  ,label:   "Kyrgyzstan (+996)" },
                    { codetype:"LA" ,code:"856"  ,label:   "Laos (+856)" },
                    { codetype:"LV" ,code:"371"  ,label:   "Latvia (+371)" },
                    { codetype:"LB" ,code:"961"  ,label:   "Lebanon (+961)" },
                    { codetype:"LS" ,code:"266"  ,label:   "Lesotho (+266)" },
                    { codetype:"LR" ,code:"231"  ,label:   "Liberia (+231)" },
                    { codetype:"LY" ,code:"218"  ,label:   "Libya (+218)" },
                    { codetype:"LI" ,code:"417"  ,label:   "Liechtenstein (+417)" },
                    { codetype:"LT" ,code:"370"  ,label:   "Lithuania (+370)" },
                    { codetype:"LU" ,code:"352"  ,label:   "Luxembourg (+352)" },
                    { codetype:"MO" ,code:"853"  ,label:   "Macao (+853)" },
                    { codetype:"MK" ,code:"389"  ,label:   "Macedonia (+389)" },
                    { codetype:"MG" ,code:"261"  ,label:   "Madagascar (+261)" },
                    { codetype:"MW" ,code:"265"  ,label:   "Malawi (+265)" },
                    { codetype:"MY" ,code:"60"  ,label:   "Malaysia (+60)" },
                    { codetype:"MV" ,code:"960"  ,label:   "Maldives (+960)" },
                    { codetype:"ML" ,code:"223"  ,label:   "Mali (+223)" },
                    { codetype:"MT" ,code:"356"  ,label:   "Malta (+356)" },
                    { codetype:"MH" ,code:"692"  ,label:   "Marshall Islands (+692)" },
                    { codetype:"MQ" ,code:"596"  ,label:   "Martinique (+596)" },
                    { codetype:"MR" ,code:"222"  ,label:   "Mauritania (+222)" },
                    { codetype:"YT" ,code:"269"  ,label:   "Mayotte (+269)" },
                    { codetype:"MX" ,code:"52"  ,label:   "Mexico (+52)" },
                    { codetype:"FM" ,code:"691"  ,label:   "Micronesia (+691)" },
                    { codetype:"MD" ,code:"373"  ,label:   "Moldova (+373)" },
                    { codetype:"MC" ,code:"377"  ,label:   "Monaco (+377)" },
                    { codetype:"MN" ,code:"976"  ,label:   "Mongolia (+976)" },
                    { codetype:"MS" ,code:"1664"  ,label:   "Montserrat (+1664)" },
                    { codetype:"MA" ,code:"212"  ,label:   "Morocco (+212)" },
                    { codetype:"MZ" ,code:"258"  ,label:   "Mozambique (+258)" },
                    { codetype:"MN" ,code:"95"  ,label:   "Myanmar (+95)" },
                    { codetype:"NA" ,code:"264"  ,label:   "Namibia (+264)" },
                    { codetype:"NR" ,code:"674"  ,label:   "Nauru (+674)" },
                    { codetype:"NP" ,code:"977"  ,label:   "Nepal (+977)" },
                    { codetype:"NL" ,code:"31"  ,label:   "Netherlands (+31)" },
                    { codetype:"NC" ,code:"687"  ,label:   "New Caledonia (+687)" },
                    { codetype:"NZ" ,code:"64"  ,label:   "New Zealand (+64)" },
                    { codetype:"NI" ,code:"505"  ,label:   "Nicaragua (+505)" },
                    { codetype:"NE" ,code:"227"  ,label:   "Niger (+227)" },
                    { codetype:"NG" ,code:"234"  ,label:   "Nigeria (+234)" },
                    { codetype:"NU" ,code:"683"  ,label:   "Niue (+683)" },
                    { codetype:"NF" ,code:"672"  ,label:   "Norfolk Islands (+672)" },
                    { codetype:"NP" ,code:"670"  ,label:   "Northern Marianas (+670)" },
                    { codetype:"NO" ,code:"47"  ,label:   "Norway (+47)" },
                    { codetype:"OM" ,code:"968"  ,label:   "Oman (+968)" },
                    { codetype:"PK" ,code:"92"  ,label:   "Pakistan (+92)" },
                    { codetype:"PW" ,code:"680"  ,label:   "Palau (+680)" },
                    { codetype:"PA" ,code:"507"  ,label:   "Panama (+507)" },
                    { codetype:"PG" ,code:"675"  ,label:   "Papua New Guinea (+675)" },
                    { codetype:"PY" ,code:"595"  ,label:   "Paraguay (+595)" },
                    { codetype:"PE" ,code:"51"  ,label:   "Peru (+51)" },
                    { codetype:"PH" ,code:"63"  ,label:   "Philippines (+63)" },
                    { codetype:"PL" ,code:"48"  ,label:   "Poland (+48)" },
                    { codetype:"PT" ,code:"351"  ,label:   "Portugal (+351)" },
                    { codetype:"PR" ,code:"1787"  ,label:   "Puerto Rico (+1787)" },
                    { codetype:"QA" ,code:"974"  ,label:   "Qatar (+974)" },
                    { codetype:"RE" ,code:"262"  ,label:   "Reunion (+262)" },
                    { codetype:"RO" ,code:"40"  ,label:   "Romania (+40)" },
                    { codetype:"RU" ,code:"7"  ,label:   "Russia (+7)" },
                    { codetype:"RW" ,code:"250"  ,label:   "Rwanda (+250)" },
                    { codetype:"SM" ,code:"378"  ,label:   "San Marino (+378)" },
                    { codetype:"ST" ,code:"239"  ,label:   "Sao Tome &amp; Principe (+239)" },
                    { codetype:"SA" ,code:"966"  ,label:   "Saudi Arabia (+966)" },
                    { codetype:"SN" ,code:"221"  ,label:   "Senegal (+221)" },
                    { codetype:"CS" ,code:"381"  ,label:   "Serbia (+381)" },
                    { codetype:"SC" ,code:"248"  ,label:   "Seychelles (+248)" },
                    { codetype:"SL" ,code:"232"  ,label:   "Sierra Leone (+232)" },
                    { codetype:"SG" ,code:"65"  ,label:   "Singapore (+65)" },
                    { codetype:"SK" ,code:"421"  ,label:   "Slovak Republic (+421)" },
                    { codetype:"SI" ,code:"386"  ,label:   "Slovenia (+386)" },
                    { codetype:"SB" ,code:"677"  ,label:   "Solomon Islands (+677)" },
                    { codetype:"SO" ,code:"252"  ,label:   "Somalia (+252)" },
                    { codetype:"ZA" ,code:"27"  ,label:   "South Africa (+27)" },
                    { codetype:"ES" ,code:"34"  ,label:   "Spain (+34)" },
                    { codetype:"LK" ,code:"94"  ,label:   "Sri Lanka (+94)" },
                    { codetype:"SH" ,code:"290"  ,label:   "St. Helena (+290)" },
                    { codetype:"KN" ,code:"1869"  ,label:   "St. Kitts (+1869)" },
                    { codetype:"SC" ,code:"1758"  ,label:   "St. Lucia (+1758)" },
                    { codetype:"SR" ,code:"597"  ,label:   "Suriname (+597)" },
                    { codetype:"SD" ,code:"249"  ,label:   "Sudan (+249)" },
                    { codetype:"SZ" ,code:"268"  ,label:   "Swaziland (+268)" },
                    { codetype:"SE" ,code:"46"  ,label:   "Sweden (+46)" },
                    { codetype:"CH" ,code:"41"  ,label:   "Switzerland (+41)" },
                    { codetype:"TW" ,code:"886"  ,label:   "Taiwan (+886)" },
                    { codetype:"TJ" ,code:"992"  ,label:   "Tajikistan (+992)" },
                    { codetype:"TH" ,code:"66"  ,label:   "Thailand (+66)" },
                    { codetype:"TG" ,code:"228"  ,label:   "Togo (+228)" },
                    { codetype:"TO" ,code:"676"  ,label:   "Tonga (+676)" },
                    { codetype:"TT" ,code:"1868"  ,label:   "Trinidad &amp; Tobago (+1868)" },
                    { codetype:"TN" ,code:"216"  ,label:   "Tunisia (+216)" },
                    { codetype:"TR" ,code:"90"  ,label:   "Turkey (+90)" },
                    { codetype:"TM" ,code:"993"  ,label:   "Turkmenistan (+993)" },
                    { codetype:"TC" ,code:"1649"  ,label:   "Turks &amp; Caicos Islands (+1649)" },
                    { codetype:"TV" ,code:"688"  ,label:   "Tuvalu (+688)" },
                    { codetype:"UG" ,code:"256"  ,label:   "Uganda (+256)" },
                    { codetype:"UA" ,code:"380"  ,label:   "Ukraine (+380)" },
                    { codetype:"AE" ,code:"971"  ,label:   "United Arab Emirates (+971)" },
                    { codetype:"UY" ,code:"598"  ,label:   "Uruguay (+598)" },
                    { codetype:"UZ" ,code:"998"  ,label:   "Uzbekistan (+998)" },
                    { codetype:"VU" ,code:"678"  ,label:   "Vanuatu (+678)" },
                    { codetype:"VA" ,code:"379"  ,label:   "Vatican City (+379)" },
                    { codetype:"VE" ,code:"58"  ,label:   "Venezuela (+58)" },
                    { codetype:"VN" ,code:"84"  ,label:   "Vietnam (+84)" },
                    { codetype:"VG" ,code:"1"  ,label:   "Virgin Islands - British (+1)" },
                    { codetype:"VI" ,code:"1"  ,label:   "Virgin Islands - US (+1)" },
                    { codetype:"WF" ,code:"681"  ,label:   "Wallis &amp; Futuna (+681)" },
                    { codetype:"YE" ,code:"969"  ,label:   "Yemen (North)(+969)" },
                    { codetype:"YE" ,code:"967"  ,label:   "Yemen (South)(+967)" },
                    { codetype:"ZM" ,code:"260"  ,label:   "Zambia (+260)" },
                    { codetype:"ZW" ,code:"263"  ,label:   "Zimbabwe (+263)" },],
                currency_collection: [{ code:  "AED",  label: "AED"},
                    { code: "USD",  label: "USD"},
                    { code: "AFN",  label: "AFN"},
                    { code: "ALL",  label: "ALL"},
                    { code: "DZD",  label: "DZD"},
                    { code: "ARS",  label: "ARS"},
                    { code: "AUD",  label: "AUD"},
                    { code: "ATS",  label: "ATS"},
                    { code: "BSD",  label: "BSD"},
                    { code: "BHD",  label: "BHD"},
                    { code: "BDT",  label: "BDT"},
                    { code: "BBD",  label: "BBD"},
                    { code: "BEF",  label: "BEF"},
                    { code: "BMD",  label: "BMD"},
                    { code: "BRL",  label: "BRL"},
                    { code: "BGN",  label: "BGN"},
                    { code: "CAD",  label: "CAD"},
                    { code: "XOF",  label: "XOF"},
                    { code: "XAF",  label: "XAF"},
                    { code: "CLP",  label: "CLP"},
                    { code: "CNY",  label: "CNY"},
                    { code: "CNY",  label: "CNY"},
                    { code: "COP",  label: "COP"},
                    { code: "XPF",  label: "XPF"},
                    { code: "CRC",  label: "CRC"},
                    { code: "HRK",  label: "HRK"},
                    { code: "CYP",  label: "CYP"},
                    { code: "CZK",  label: "CZK"},
                    { code: "DKK",  label: "DKK"},
                    { code: "DEM",  label: "DEM"},
                    { code: "DOP",  label: "DOP"},
                    { code: "NLG",  label: "NLG"},
                    { code: "XCD",  label: "XCD"},
                    { code: "EGP",  label: "EGP"},
                    { code: "EEK",  label: "EEK"},
                    { code: "EUR",  label: "EUR"},
                    { code: "FJD",  label: "FJD"},
                    { code: "FIM",  label: "FIM"},
                    { code: "FRF*",  label: "FRF*"},
                    { code: "DEM",  label: "DEM"},
                    { code: "XAU",  label: "XAU"},
                    { code: "GRD",  label: "GRD"},
                    { code: "GTQ",  label: "GTQ"},
                    { code: "NLG",  label: "NLG"},
                    { code: "HKD",  label: "HKD"},
                    { code: "HUF",  label: "HUF"},
                    { code: "ISK",  label: "ISK"},
                    { code: "XDR",  label: "XDR"},
                    { code: "INR",  label: "INR"},
                    { code: "IDR",  label: "IDR"},
                    { code: "IRR",  label: "IRR"},
                    { code: "IQD",  label: "IQD"},
                    { code: "IEP*",  label: "IEP*"},
                    { code: "ILS",  label: "ILS"},
                    { code: "ITL*",  label: "ITL*"},
                    { code: "JMD",  label: "JMD"},
                    { code: "JPY",  label: "JPY"},
                    { code: "JOD",  label: "JOD"},
                    { code: "KES",  label: "KES"},
                    { code: "KRW",  label: "KRW"},
                    { code: "KWD",  label: "KWD"},
                    { code: "LBP",  label: "LBP"},
                    { code: "LUF",  label: "LUF"},
                    { code: "MYR",  label: "MYR"},
                    { code: "MTL",  label: "MTL"},
                    { code: "MUR",  label: "MUR"},
                    { code: "MXN",  label: "MXN"},
                    { code: "MAD",  label: "MAD"},
                    { code: "NLG",  label: "NLG"},
                    { code: "NZD",  label: "NZD"},
                    { code: "NOK",  label: "NOK"},
                    { code: "OMR",  label: "OMR"},
                    { code: "PKR",  label: "PKR"},
                    { code: "XPD",  label: "XPD"},
                    { code: "PEN",  label: "PEN"},
                    { code: "PHP",  label: "PHP"},
                    { code: "XPT",  label: "XPT"},
                    { code: "PLN",  label: "PLN"},
                    { code: "PTE",  label: "PTE"},
                    { code: "QAR",  label: "QAR"},
                    { code: "RON",  label: "RON"},
                    { code: "ROL",  label: "ROL"},
                    { code: "RUB",  label: "RUB"},
                    { code: "SAR",  label: "SAR"},
                    { code: "XAG",  label: "XAG"},
                    { code: "SGD",  label: "SGD"},
                    { code: "SKK",  label: "SKK"},
                    { code: "SIT",  label: "SIT"},
                    { code: "ZAR",  label: "ZAR"},
                    { code: "KRW",  label: "KRW"},
                    { code: "ESP",  label: "ESP"},
                    { code: "XDR",  label: "XDR"},
                    { code: "LKR",  label: "LKR"},
                    { code: "SDD",  label: "SDD"},
                    { code: "SEK",  label: "SEK"},
                    { code: "CHF",  label: "CHF"},
                    { code: "TWD",  label: "TWD"},
                    { code: "THB",  label: "THB"},
                    { code: "TTD",  label: "TTD"},
                    { code: "TND",  label: "TND"},
                    { code: "TRY",  label: "TRY"},
                    { code: "GBP",  label: "GBP"},
                    { code: "USD",  label: "USD"},
                    { code: "VEB",  label: "VEB"},
                    { code: "VND",  label: "VND"},
                    { code: "ZMK",  label: "ZMK"}


                ],
                file: '',
                uploadPercentage: 0,
                adPostModal:false,
                images: '',
                validate :  false,
                removeCancel: false,




                map : '',

                window_width: window.innerWidth,

                markers: [],

                query:'',

                center: {
                    lat: 10.0,
                    lng: 10.0
                },


                showPopup:false,

                progressWidth: 0,

                openSub: null,

                cover_photo_name: '',

                sidebar: 'd-none',

                lead_trail : 'trv-sidebar__content--trailing',

                style_sidebar: 0,

                dialogWithFooter: false,

                userFollowing :  lscache.get('user_follower'),

                icon_square_o: this.fullPath +  'js/plugins/menu/symbol-defs.svg#icon-square-o',

                icon_check_square_o: this.fullPath +  'js/plugins/menu/symbol-defs.svg#icon-check-square-o',



            }


        },

        computed:{



        },
        watch:{

            Category(v, old) {
                 console.log(v);
            },

        },
        methods: {

            scrollTo(){



                VueScrollTo.scrollTo('body', 300)

            },

             validateBeforeSubmit(scope) {

                  return this.$validator.validateAll(scope).then((result) => {

                    if (result  ===  true ) {

                        return true;

                    } else {

                        this.scrollTo();

                        return false;

                    }


                });
            },

            submitAd() {

                if ( this.model_sub_category  ===  '') {

                    this.model_sub_category = { code:0, label:''};
                }
                if ( this.model_level_cat_3  === '' ){

                    this.model_level_cat_3 = { code:0, label:''};
                }
                if ( this.model_level_cat_4 === '' ) {

                    this.model_level_cat_4 = { code:0, label:''};
                }




               let params  =
                   {
                       title: this.ad_title ,
                       condition:this.condition.label,
                       usage: this.usage.label,
                       ages: this.age.label,
                       phone_number: this.phone_number_code + ' '+ this.phone_number,
                       price: this.price_currency  + '' + this.price,
                       description: this.description,
                       warranty: this.warranty.label,

                       longitude:  this.longitude,
                       latitude: this.latitude,
                       address: this.address,

                       mileage: this.range_mileage,
                       cover_photo: this.cover_photo_name,
                       images: this.images,
                       service_history : this.service_history,

                       category: this.model_category.code,
                       sub_category:  this.model_sub_category.code,
                       level_3: this.model_level_cat_3.code,
                       level_4: this.model_level_cat_4.code,
                       year: this.year,



                   };




                    axios.post( this.fullPath + 'classifieds/save_ad', params  )
                    .then( res => {

                        this.removeCancel = true;

                        this.dialog_msg = 'Your ad is submitted for approval.';

                        this.adPostModal = true;

                        this.dialogWithFooter =  true;


                    })


            },
            continueHome()  {

                document.location = this.fullPath;

                this.$router.push('/');

            },

            removeThisFile(file) {

               console.log( file );
            },



            file_uploaded(file, response ) {



                if( parseInt( response.result ) === 1 ) {

                    this.images = this.images + '##' + response.data;

                    this.dialog_msg = 'Your image is uploaded successfully.';

                    this.adPostModal = true;


                } else {


                    this.dialog_msg = 'There was some error in uploading your image. Try  different image.';

                    this.adPostModal = true;



                }



            },

            next_step() {


                if( this.step === 1  )  {



                    this.validateBeforeSubmit('stepj').then(data => {

                        if(  data === true   ) {

                            this.step ++;
                            this.scrollTo();

                        }
                    });




                } else if(  this.step === 2   ) {



                    this.validateBeforeSubmit('step2').then(data => {

                        if(  data === true   ) {

                            this.step ++;
                            this.scrollTo();

                        }
                    })

                } else {

                    this.step ++;
                    this.scrollTo();

                }






            },
            handleFileUpload(){

                let formData = new FormData();

                this.file = this.$refs.file.files[0];

                formData.append('file', this.file);

                axios.post( this.fullPath + 'classifieds/upload_cover_photo',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: function( progressEvent ) {

                            this.uploadPercentage  = parseInt(progressEvent.loaded / progressEvent.total * 100, 10);

                            if( this.uploadPercentage === 100 ){

                                this.dialog_msg = 'Still uploading... Please wait';

                                this.adPostModal = true;
                            }





                        }.bind(this)
                    }
                ).then( res  => {


                        this.dialog_msg = 'Your image is uploaded successfully.';

                        this.adPostModal  = true;

                        this.cover_photo_name  = res.data.data;

                        this.step ++;

                    })
                    .catch(function(){

                        window.alert('There was some error in uploading. Try  again');
                    });


            },



            load_next_level( event, level ) {


                let id = '';
                level ++;
                this.cat_level = level;


                if( this.cat_level === 2 ) {



                    id = this.model_category.code;

                    this.sub_category = [];
                    this.level_cat_3  = [];
                    this.level_cat_4  = [];
                }
                if( this.cat_level === 3 ) {

                    if( this.model_sub_category === null ){

                        this.cat_level = 2;
                        this.level_cat_3  = [];
                        this.level_cat_4  = [];
                        return;

                    }

                    id = this.model_sub_category.code;

                    this.level_cat_3  = [];
                    this.level_cat_4  = [];

                }
                if( this.cat_level === 4 ) {


                    if( this.model_level_cat_3 === null ){

                        this.cat_level = 3;
                        this.level_cat_3  = [];
                        this.level_cat_4  = [];
                        return;

                    }

                    id = this.model_level_cat_3.code;
                    this.level_cat_4  = [];

                }






                axios.post( this.fullPath + 'classifieds/get_cats', {child:1, id: id } )
                    .then( res => {


                        if( this.cat_level === 2 ) {

                            res.data.data.forEach( cat =>  {

                                let obj = {code:  cat.id,   label: cat.text };
                                this.sub_category.push(obj)
                            });

                        }
                        if( this.cat_level === 3 ) {

                            res.data.data.forEach( cat =>  {

                                let obj = {code:  cat.id,   label: cat.text };
                                this.level_cat_3.push(obj)
                            });

                        }
                        if( this.cat_level === 4 ) {



                            if( res.data.data.length < 1) {

                                this.cat_level = 3;

                            }
                            else {

                                res.data.data.forEach( cat =>  {

                                    let obj = {code:  cat.id,   label: cat.text };
                                    this.level_cat_4.push(obj)
                                });

                            }

                        }




                    })
            },

            get_cats(){

                for( let i = 1970; i <= new Date().getFullYear() ; i++ )
                {
                    this.yearModal.push( i );

                }

                axios.post( this.fullPath + 'classifieds/get_cats', {} )
                    .then( res => {

                        res.data.data.forEach( cat =>  {

                            let obj = {code:  cat.id,   label: cat.text };
                            this.category.push(obj)
                        });

                    })

            },
            add_map() {

                let input = document.getElementById('address');


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
            place_holder_animate() {

                let n = 0;

                let placeHolder = ['e.g Mobile Phone','e.g Macbook Pro','e.g Car','e.g Shoes','e.g T-Shirts '];


                let loopLength=placeHolder.length;

                setInterval(() => {


                    if( n < loopLength)  {

                        let newPlaceholder = placeHolder[n];

                        n++;

                        this.title_placeholder = newPlaceholder;


                    } else {


                        this.title_placeholder = placeHolder[0];


                        n=0;
                    }
                },1000);
            },

            map_maker() {

                let marker;

                this.map = new google.maps.Map(

                    document.getElementById("js_bigMap"), {
                        center: new google.maps.LatLng(25.276987, 55.277397),
                        zoom: 13,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        superElement:this
                    });




                google.maps.event.addListener( this.map, "click", function(e)
                {

                    let superElement    = this.superElement;

                    superElement.latitude  = e.latLng.lat();

                    superElement.longitude = e.latLng.lng();



                    superElement.geocodeLatLng(e.latLng.lat(), e.latLng.lng() );

                    if (marker && marker.setMap)
                    {
                        marker.setMap(null);
                    }


                     marker = new google.maps.Marker({
                        position: {lat: e.latLng.lat(), lng: e.latLng.lng() },
                        map: superElement.map
                    });


                });
            },

            geocodeLatLng(lat, lng ) {

                let geocoder = new google.maps.Geocoder;

                let latlng = {lat: lat, lng: lng };


                geocoder.geocode({'location': latlng}, (results, status )  =>
                {
                    if (status === 'OK')
                    {
                        if (results[0])
                        {
                            this.address = results[0].formatted_address ;


                            var marker = new google.maps.Marker({
                                position: latlng,
                                map: this.map
                            });

                        }
                        else
                        {
                            window.alert('No results found');
                        }
                    }
                    else
                    {
                        window.alert('Place api failed due to: ' + status);
                    }

                });
            }


        },

        created()  {

            let withParam = { page: this.page };

            this.get_cats(  );

            this.place_holder_animate();





        },
        mounted() {

            setTimeout(  () => {

                this.add_map();

                this.map_maker();

            }, 400);



            const dict = {

                custom: {

                    ad_title: {

                        required: 'Ad title can not be empty',

                    },

                    phone_number: {

                        required: 'Phone number  can not be empty',

                    },


                }
            };

            this.$validator.localize('en', dict);




        }



    }


</script>



<style scoped>

    .col-12.price-ui .v-select {
        float: left;
        width: 32%;}

    .price-ui #price{width:67%;}
    .price-ui #phone_number{width:67%;}

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }
    .modal-body{ height: 100px;}
    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .submit-ad {

        margin-top: 20px;
    }

    .btn-continue{
        padding: 7px !important;
        font-size: 11px;
        border: 0px;
        font-weight: normal;
        background-color: #3e3d95;
        border-color: #3e3d95;
    }



</style>
