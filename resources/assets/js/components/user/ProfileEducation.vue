<template>


    <div  id="education">

        <div class="frame" >

            <h2>Education/Qualification</h2>

            <a href=""  @click.prevent="addEdu" v-if="selfView===1" class="btn-edit" >

                <svg class="icon icon-add">

                    <use :xlink:href="icon_add"></use>

                </svg>

            </a>

            <ul class="alist">

                <li v-for="(edu, index) in education" :key="edu.id + 'key' ">



                    <em> {{  edu.from_year }} - {{  edu.to_year }} </em>

                    <p>

                        <strong>

                            {{ edu.degree }}

                            <span>

                               {{ edu.field_of_study }} at {{ edu.school}}

                            </span>

                        </strong>

                    <span v-html="edu.description"></span>

                        <a href="" @click.prevent="editEducation(edu)"  v-if="selfView===1" class="btn-edit">

                            <svg class="icon icon-mode_edit">

                                <use :xlink:href="icon_edit">

                                </use>

                            </svg>
                        </a>

                        <a href=""  v-if="selfView===1" @click.prevent="delEducation(index, edu.id )" class="btn-edit">

                            <svg class="icon icon-delete">

                                <use :xlink:href="icon_del">


                                </use>

                            </svg>

                        </a>

                    </p>

                </li>

            </ul>

        </div>






        <div v-if="eduModal">

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog modal-md" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">{{ eduModalTitle  }}</h5>

                                    <button type="button"  @click="closePop" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

                                </div>

                                <div class="modal-body">

                                    <p class="lead">Provide as much information as you can.</p>

                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">School/College/University
                                        </label>

                                        <div class="col-12">

                                            <input type="text"
                                                   class="form-control"
                                                   name="school"
                                                   v-model="school"
                                                   v-validate="'required'"
                                            >


                                            <small   v-show="errors.has('school')"  class="form-control-feedback e-feedback">
                                                {{ errors.first('school') }}
                                            </small>


                                        </div>

                                    </div>



                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">Qualification</label>

                                        <div class="col-12">

                                            <v-select
                                                    placeholder="Select"

                                                    v-model="qualification" v-validate="'required'" name="qualification"

                                                    :options="[
                                                    { code:'Other',  label:'Other'  },
                                                    { code:'Skills for Life',  label:'Skills for Life'  },
                                                    { code:'GCSE',  label:'GCSE'  },
                                                    { code:'IGCSE',  label:'IGCSE'  },
                                                    { code:'Level 2 Teaching Assistant',  label:'Level 2 Teaching Assistant'  },
                                                    { code:'Level 3 Teaching Assistant',  label:'Level 3 Teaching Assistant'  },
                                                    { code:'Level 2 Supporting Teaching and Learning in Schools',  label:'Level 2 Supporting Teaching and Learning in Schools'  },
                                                    { code:'HLTA',  label:'HLTA'  },
                                                    { code:'High School Graduate',  label:'High School Graduate'  },
                                                    { code:'BTEC',  label:'BTEC'  },
                                                    { code:'GNVQ',  label:'GNVQ'  },
                                                    { code:'As Level',  label:'As Level'  },
                                                    { code:'A-Level',  label:'A-Level'  },
                                                    { code:'Higher National Certificate',  label:'Higher National Certificate'  },
                                                    { code:'Higher National Diploma',  label:'Higher National Diploma'  },
                                                    { code:'Bachelor or Arts (BA)',  label:'Bachelor or Arts (BA)'  },
                                                    { code:'College Graduate',  label:'College Graduate'  },
                                                    { code:'Associate Degree',  label:'Associate Degree'  },
                                                    { code:'Bachelor of Education (BEd)',  label:'Bachelor of Education (BEd)'  },
                                                    { code:'Bachelor of Science (BSc)',  label:'Bachelor of Science (BSc)'  },
                                                    { code:'Post Graduate Certificate in Education (PGCE)',  label:'Post Graduate Certificate in Education (PGCE)'  },
                                                    { code:'Professional Graduate Diploma in Education (PGDE)',  label:'Professional Graduate Diploma in Education (PGDE)'  },
                                                    { code:'Masters of Science (MSc)',  label:'Masters of Science (MSc)'  },
                                                    { code:'Masters of Arts (MA)',  label:'Masters of Arts (MA)'  },
                                                    { code:'Masters of Business Administration  (MBA)',  label:'Masters of Business Administration  (MBA)'  },
                                                    { code:'Masters of Education (MEd)',  label:'Masters of Education (MEd)'  },
                                                    { code:'Doctor of Education (DEd)',  label:'Doctor of Education (DEd)'  },
                                                    { code:'Doctor of Philosophy (PhD)',  label:'Doctor of Philosophy (PhD)'  },
                                                    { code:'Leaving Certificate',  label:'Leaving Certificate'  },
                                                    { code:'Junior Certificate',  label:'Junior Certificate'  },


                                                    ]">

                                            </v-select>


                                            <small   v-show="errors.has('qualification')"  class="form-control-feedback e-feedback">
                                                {{ errors.first('qualification') }}
                                            </small>


                                        </div>

                                    </div>




                                    <div class="form-group  row"  v-if="showDegree">

                                        <label for="" class="col-12 col-form-label">Degree
                                        </label>

                                        <div class="col-12">

                                            <input type="text"
                                                   class="form-control"
                                                   name="degree"
                                                   v-model="degree"

                                            >



                                        </div>

                                    </div>
                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">Field of study</label>

                                        <div class="col-12">

                                            <input type="text"
                                                   class="form-control"
                                                   name="field_of_study"
                                                   v-model="field_of_study"
                                                   v-validate="'required'"
                                            >

                                            <small   v-show="errors.has('field_of_study')"  class="form-control-feedback e-feedback">
                                                {{ errors.first('field_of_study') }}
                                            </small>


                                        </div>

                                    </div>

                                    <div class="form-group  row">

                                        <label for="" class="col-12 col-form-label">Grade</label>

                                        <div class="col-12">

                                            <input type="text"
                                                   class="form-control"
                                                   name="grade"
                                                   v-model="grade"
                                                   v-validate="'required'"
                                            >

                                            <small   v-show="errors.has('grade')"  class="form-control-feedback e-feedback">
                                                {{ errors.first('grade') }}
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

                                        <label for="" class="col-12 col-form-label">To Year</label>

                                        <div class="col-12">

                                            <v-select
                                                    placeholder="Select to year"

                                                    v-model="to_year" name="to_year"

                                                    :options="yearModal">

                                            </v-select>

                                            <small   v-show="errors.has('to_year')"  class="form-control-feedback e-feedback">
                                                {{ errors.first('to_year') }}
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

                                            @click="saveEdu"

                                            class="btn btn-primary modal-btn modal-btn-action   go "> Save Education

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
export default {

    name: "ProfileEducation",

    props: ['fullPath', 'user', 'selfView'],


    data()  {


        return{

            education:[],

            icon_add: this.fullPath + 'css/ico/symbol-defs.svg#icon-add',

            icon_edit: this.fullPath + 'css/ico/symbol-defs.svg#icon-mode_edit',

            icon_del:   this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

            edit_id: 0,

            eduModalTitle: 'Education',

            eduModal      : false,

            showDegree: false,

            field_of_study: '',

            qualification: '',

            description: '',

            degree: '',

            school: '',

            from_year: '',

            to_year: '',

            progress:   0,

            grade: '',

            yearModal: [],

            qualificationModal: [],

            isDone: 0,



        }
    },

    computed: {




    },

    watch:{

      qualification( val  ){

          if(  val !==  null  && typeof val !==  'undefined' ){

              console.log( val );

              if( val.code === 'Other' ){

                  this.showDegree = true;

              } else {

                  this.showDegree = false;
              }
          }


      }

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


        loadEducation(){

            axios.post( this.fullPath + 'user/profile/get_education', {uid:  this.$parent.user.id } )
                .then( res => {

                    this.education = res.data.data;

                })

        },
        delEducation( index, id ){

            this.education.splice( index, 1);

            axios.post( this.fullPath + 'user/profile/get_education', {id:id, del:1} )
                .then( res => {

                });

        },
        editEducation( obj  ) {


            this.school       = obj.school;

            this.qualification =  obj.qualification;

            if( obj.qualification === 'Other' ) {

                this.degree  =  obj.degree;
            }

            this.field_of_study =  obj.field_of_study;

            this.grade =  obj.grade;

            this.to_year =  obj.to_year;

            this.from_year =  obj.from_year;

            this.description = obj.description;

            this.edit_id = obj.id;

            document.body.classList.add("modal-open");

            this.eduModal = true;

            this.eduModalTitle = 'Edit Education';

        },




        saveEdu()  {

            let q_code =  '';

            if( typeof this.qualification !== 'undefined' ) {

                q_code =    this.qualification.code;
            }


            let param = {

                school: this.school,

                field_of_study: this.field_of_study,

                degree: this.degree,

                from_year: this.from_year,

                to_year: this.to_year,

                qualification: q_code,

                grade:  this.grade,

                description: this.description,

                add_edu: 1,

                edit_id: this.edit_id,

            };


            this.validateBeforeSubmit().then(data => {


                if(  data === true   ) {

                    this.progress = 1;

                    axios.post( this.fullPath + 'user/profile/save_education', param )
                        .then( res => {

                            this.progress = 0;

                            this.isDone  = 1;

                            this.education = res.data.education;


                        });




                }
            });








        },

        fillMod ()  {

            for( let i =  new Date().getFullYear(); i >= 1950 ; i-- )
            {
                this.yearModal.push( i );

            }



        },

        scrollTo(){



            VueScrollTo.scrollTo('body', 300)

        },

        addEdu() {



            this.school  = '';

            this.qualification =  '';

            this.degree =  '';

            this.field_of_study =  '';

            this.grade =  '';

            this.to_year =  '';

            this.from_year =  '';

            this.description =  '';

            this.edit_id  = 0;


            document.body.classList.add("modal-open");

            this.eduModal = true;

            this.eduModalTitle = 'Add Education';

        },

        closePop() {


            document.body.classList.remove("modal-open");

            this.eduModal = false;

            this.eduModalTitle = 'Education';

        }





    },

    created() {



        const dict = {
            custom: {

                field_of_study: {

                    required: 'Field of study can not be empty',

                },

                qualification: {

                    required: 'Qualification can not be empty',

                },

                school: {

                    required: 'School  can not be empty',


                },


                grade: {

                    required: 'Grade  can not be empty',


                },



            }
        };

        this.$validator.localize('en', dict);


        this.loadEducation();

        this.fillMod();



    }
}
</script>

<style scoped>

</style>