<template>


    <div id="experience">

        <div class="frame" >

            <h2>
                Experience (current and previous employment)
            </h2>

            <a href="" @click.prevent="addExp"  v-if="selfView===1" class="btn-edit" >

                <svg class="icon icon-add">

                    <use :xlink:href="icon_add"></use>

                </svg>

            </a>

            <ul class="alist">

                <li v-for="(exp, index) in experience" :key="exp.id + 'key' ">


                    <em>

                        {{ exp.title }} - {{ exp.location }}

                    </em>


               <p>

                   <strong>

                       {{ exp.company }}

                       <span>

                           {{ from_date(exp.from_month, exp.from_year) }} -  {{ to_date(exp.to_month, exp.to_year, exp ) }}

                       </span>

                   </strong>

               </p>


                <div v-html="exp.description">


                </div>

                    <p>

                        <a href="" @click.prevent="editExperience(exp)" v-if="selfView===1" class="btn-edit">

                            <svg class="icon icon-mode_edit">

                                <use :xlink:href="icon_edit">

                                </use>

                            </svg>
                        </a>

                        <a href=""  v-if="selfView===1" @click.prevent="delExperience(index, exp.id )" class="btn-edit">

                            <svg class="icon icon-delete">

                                <use :xlink:href="icon_del">


                                </use>

                            </svg>

                        </a>

                    </p>

                </li>

            </ul>

        </div>





        <div v-if="expModal">

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog modal-md" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">{{ expModalTitle  }}</h5>

                                    <button type="button"  @click="closePop" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

                                </div>

                                <div class="modal-body">

                                    <p class="lead">Provide as much information as you can.</p>

                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">Title</label>

                                        <div class="col-12">

                                            <input type="text"
                                                   class="form-control"
                                                   name="title"
                                                   v-model="title"
                                                   v-validate="'required'"
                                            >


                                            <small   v-show="errors.has('title')"  class="form-control-feedback e-feedback">
                                                {{ errors.first('title') }}
                                            </small>


                                        </div>

                                    </div>

                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">School/Company</label>

                                        <div class="col-12">

                                            <input type="text"
                                                   class="form-control"
                                                   name="company"
                                                   v-model="company"
                                                   v-validate="'required'"
                                            >

                                            <small   v-show="errors.has('company')"  class="form-control-feedback e-feedback">
                                                {{ errors.first('company') }}
                                            </small>


                                        </div>

                                    </div>

                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">Location</label>

                                        <div class="col-12">

                                            <input type="text"
                                                   class="form-control"
                                                   name="location"
                                                   v-model="location"
                                                   v-validate="'required'"
                                            >

                                            <small   v-show="errors.has('location')"  class="form-control-feedback e-feedback">
                                                {{ errors.first('location') }}
                                            </small>


                                        </div>

                                    </div>



                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">From Year</label>

                                        <div class="col-12">

                                            <v-select
                                                    placeholder="Select from year"

                                                    v-model="from_year" v-validate="'required'" name="from_year"

                                                    :options="yearModal">

                                            </v-select>


                                            <small   v-show="errors.has('from_year')"  class="form-control-feedback e-feedback">
                                                {{ errors.first('from_year') }}
                                            </small>


                                        </div>

                                    </div>

                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">From Month</label>

                                        <div class="col-12">

                                            <v-select
                                                    placeholder="Select from month"

                                                    v-model="from_month" v-validate="'required'"  name="from_month"

                                                    :options="monthModal">

                                            </v-select>

                                            <small   v-show="errors.has('from_month')"  class="form-control-feedback e-feedback">
                                                {{ errors.first('from_month') }}
                                            </small>


                                        </div>

                                    </div>


                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">To Year</label>

                                        <div class="col-12">

                                            <v-select
                                                        placeholder="Select to year"

                                                        v-model="to_year"

                                                        :options="yearModal">

                                            </v-select>


                                        </div>

                                    </div>

                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">To Month</label>

                                        <div class="col-12">


                                            <v-select
                                                    placeholder="Select to month"

                                                    v-model="to_month"

                                                    :options="monthModal">

                                            </v-select>

                                        </div>

                                    </div>


                                    <div class="form-group current-job filters row ">

                                        <label for="" class="col-12 col-form-label">Current Job</label>

                                        <div class="col-12">

                                            <a href="" @click.prevent="switchCurrentJob"   :class="current_job===1?   'active' : '' " class="new-checkbox">
                                                <span>

                                                    <svg class="icon icon-square-o">

                                                        <use :xlink:href="icon_s_o"></use>


                                                    </svg>

                                                    <svg class="icon icon-check-square-o">

                                                        <use :xlink:href="icon_check_square_o">

                                                        </use>
                                                    </svg>

                                                </span>

                                                <em>Current Job (update current job on my profile)</em>

                                            </a>

                                        </div>

                                    </div>


                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">Description</label>

                                        <div class="col-12">

                                            <vue-editor v-model="description"></vue-editor>

                                        </div>

                                    </div>


                                    <div class="form-group  row">


                                        <div class="col-12">

                                            <p v-if="isDone===1" class="alert-success nice-padding">

                                                Your data is saved successfully
                                            </p>

                                        </div>

                                    </div>


                                </div>

                                <div class="modal-footer">

                                    <button type="button" @click="closePop"   class="btn btn-default modal-btn" data-dismiss="modal">Close</button>

                                    <button

                                            type="button"

                                            @click="saveExp"

                                            class="btn btn-primary modal-btn modal-btn-action   go "> Save Experience

                                        <span

                                                :class="progress===1? '': 'd-none'"

                                                class="glyphicon glyphicon-refresh glyphicon-refresh-animate">


                                        </span>

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

    import { VueEditor } from "vue2-editor";

    var VueScrollTo = require('vue-scrollto');

    export default {

    name: "ProfileExperience",

    props: ['fullPath', 'user', 'selfView'],

    components:  {

     VueEditor,

    }  ,


    data()  {


        return{

            experience:[],

            expModalTitle:  'Experience',

            expModal: false,

            icon_add: this.fullPath + 'css/ico/symbol-defs.svg#icon-add',

            icon_edit: this.fullPath + 'css/ico/symbol-defs.svg#icon-mode_edit',

            icon_del:   this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

            icon_s_o: this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-square-o',

            icon_check_square_o: this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-check-square-o',

            edit_id: 0,

            title: '',

            progress:   0,

            description: '',

            from_month: '',

            to_month:  '',

            from_year: '',

            to_year: '',

            current_job:  '',

            location : '',

            company:  '',

            yearModal:  [],

            monthModal: [],

            isDone:0,

            months_english : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],


    }
    },

    computed: {


    },

    methods:{



        validateBeforeSubmit() {

            return this.$validator.validateAll().then((result) => {

                if (result  ===  true ) {

                    return true;

                } else {

                    this.scrollTo();

                    return false;

                }


            });
        },


        from_date( from_month, from_year  )  {

            if( typeof  this.months_english[from_month] === 'undefined' )
            {

                return ' ' + from_year;
            }

           return this.months_english[from_month] +' '+ from_year;

        },

        to_date( to_month, to_year,  exp  ){


            let  to_string = '';

            if(typeof  this.months_english[to_month] === 'undefined' )
            {

                this.months_english[to_month] = '';

            }

            if( exp . current_job ===  1 )
            {

                to_string  = 'present';

            }
            else
            {

                to_string = this.months_english[to_month] +' '+  to_year

            }

            return to_string;
        },

        loadExperience(){

            axios.post( this.fullPath + 'user/profile/get_experience', {uid:  this.$parent.user.id } )
                .then( res => {

                    this.experience = res.data.data;

                })

        },

        delExperience( index, id ){

            this.experience.splice( index, 1);

            axios.post( this.fullPath + 'user/profile/get_experience', {id:id, del:1} )
                .then( res => {

                });

        },

        editExperience( obj ) {


            this.title = obj.title;

            this.description = obj.description;

            this.from_month = obj.from_month;

            this.to_month   = obj.to_month;

            this.from_year = obj.from_year;

            this.to_year = obj.to_year;

            this.current_job = obj.current_job;

            this.location = obj.location;

            this.company = obj.company;

            this.edit_id = obj.id;

            document.body.classList.add("modal-open");

            this.expModal = true;

            this.expModalTitle = 'Edit Experience';


        },

        switchCurrentJob() {


            if ( this.current_job === 1) {

                this.current_job  = 0;

            } else {

                this.current_job  = 1;
            }

        },

        saveExp()  {


            let from_month_code = '';

            let to_month_code = '';

            if( this.from_month !== null && typeof this.from_month !== 'undefined') {

                from_month_code =  this.from_month.code;
            }

            if( this.to_month !== null && typeof this.to_month !== 'undefined') {

                to_month_code =  this.to_month.code;
            }





            let param = {

                    title: this.title,

                    description: this.description,

                    from_month: from_month_code,

                    to_month:  to_month_code,

                    from_year: this.from_year,

                    to_year: this.to_year,

                    current_job: this.current_job,

                    location:  this.location,

                    company: this.company,

                    edit_id: this.edit_id,
                 };


            this.validateBeforeSubmit().then(data => {


                if(  data === true   ) {

                    this.progress = 1;

                    axios.post( this.fullPath + 'user/profile/save_experience', param )
                        .then( res => {

                                this.progress = 0;

                                this.isDone  = 1;

                                this.experience = res.data.experience;




                        });




                }
            });








        },

        fillMod ()  {

            for( let i =  new Date().getFullYear(); i >= 1950 ; i-- )
            {
                this.yearModal.push( i );

            }

            for(let  i = 0; i < 11; i++ ) {

                let obj = { code: i+1, label: this.months_english[i] };

                this.monthModal.push( obj )
            }


        },

        scrollTo(){



            VueScrollTo.scrollTo('body', 300)

        },

        addExp() {

            this.title  = '';

            this.description =  '';

            this.from_month =  '';

            this.to_month =  '';

            this.from_year =  '';

            this.to_year =  '';

            this.current_job =  '';

            this.location =  '';

            this.company =  '';

            this.edit_id = 0;

            document.body.classList.add("modal-open");

            this.expModal = true;

            this.expModalTitle = 'Add Experience';

        },

        closePop() {


            document.body.classList.remove("modal-open");

            this.expModal = false;

            this.expModalTitle = 'Experience';

        }




    },

    created() {


        const dict = {
            custom: {

                title: {

                    required: 'Title can not be empty',

                },

                company: {

                    required: 'Company/School  name can not be empty',

                },

                location: {

                    required: 'Place/location can not be empty',


                },

                from_year: {

                    required: 'from year can not be empty',


                },

                to_year: {

                    required: 'to year can not be empty',


                },





            }
        };

        this.$validator.localize('en', dict);



        this.fillMod();

        this.loadExperience();



    }
}
</script>

<style scoped>




    .alist li{

        display:block;
    }

    .alist em{

        font-size:1.4em;
    }
    .alist strong {
        display: block;
        font-size: 1.1em;
        margin-bottom: 10px;
        margin-top: 10px;
    }

    .alist p {
        padding: 0 0 5px 0px;
    }

    @media (min-width: 1200px) {

        .alist p {
            padding: 0 0 5px 0px;
        }

        .alist div p {
            padding: 0 0 5px 0px;
        }
    }

    [aria-invalid="true"] {
        border: 1px solid red;
    }
</style>