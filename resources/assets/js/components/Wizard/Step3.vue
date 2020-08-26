<template>
    <div>


        <div class="tab-pane active" id="pills-step-2" role="tabpanel">

            <p class="lead">Work History</p>

            <div class="form-group row">

                <div class="col-sm-12 teacher-status-selection">

                    <label>

                        <input @change="addStatusValue('role1')" ref="role1" value="Currently Supply Teaching" type="checkbox">

                        Currently Supply Teaching</label>

                    <label>

                        <input  @change="addStatusValue('role2')" ref="role2" type="checkbox"  value="Currently Seeking Employment">

                        Currently Seeking Employment</label>

                    <label>

                        <input   @change="addStatusValue('role3')" ref="role3" type="checkbox"  value="Currently qualifying">

                        Currently qualifying</label>

                </div>

            </div>

            <p class="lead">OR</p>


            <div class="form-group row">
                <label  class="col-12 col-form-label">Current job title</label>

                <div class="col-12">

                    <v-select name="prop"

                              placeholder="Type and select"

                              :close-on-select="true"

                              v-model="recent_job"

                              @input="$emit('update:recent_job' , recent_job  )"

                              :options="propModal">


                    </v-select>

                </div>

            </div>


            <div class="form-group row">
                <label  class="col-12 col-form-label">Current school</label>

                <div class="col-12">

                    <v-select name="category"

                              placeholder="Type and select"

                              :close-on-select="true"

                              v-model="recent_school"

                              @input="$emit('update:recent_school' , recent_school  )"

                              :options="schoolTitle">

                    </v-select>

                </div>

            </div>


            <div class="form-group row" v-if="invalid_option">

                <div class="col-sm-12">

                   <p class="alert-danger alert">{{ invalid_text }}</p>

                </div>

            </div>



            <div class="form-group row">

                <div class="col-sm-12">

                    <button @click="saveNext"

                            type="button"

                            class="btn  btn-primary d-none">

                        Continue

                    </button>

                </div>

            </div>



        </div>



        <div class="break"></div>



    </div>
    
</template>

<script>


    export default {


        name: "Step3",

        props:['fullPath'],

        data() {


            return{

                propModal: [],

                schoolTitle: [],

                recent_job: '',

                recent_school: '',

                current_emp_status: '',


                invalid_option: false,

                invalid_text : '',


            }
        },


        methods:{

            loadSchool(){


                axios.post(  this.fullPath +  'school_search', {}  )
                    .then( res => {

                        let prop = res.data.data;

                        prop.forEach( obj => {

                            let item = {code: obj.name, label:  obj.name };

                            this.schoolTitle.push( item );

                        });
                    });
            },

            loadProp() {


                axios.post(  this.fullPath +  'ajax/get_prof_collection', {}  )
                    .then( res => {

                        let prop = res.data.data;

                        res.data.data.forEach( obj => {

                            let item = {code: obj.title, label:  obj.title };

                            this.propModal.push( item );

                        });
                    });
            },


            saveNext() {

                if( this.$refs.role1.checked === false

                    &&  this.$refs.role2.checked === false

                    &&  this.$refs.role3.checked === false  ) {

                    this.current_emp_status = this.recent_job.code;

                 }




                 if(  this.current_emp_status === '' ||   typeof  this.current_emp_status === 'undefined' ){

                    this.invalid_option  = true;

                    this.invalid_text    = 'Please select your recent job title or any options in top three';

                    return false;

                 }



                 let rj = '';

                 let rs  = '';

                 if( typeof this.recent_job !== 'undefined' &&  this.recent_job !== null  ){

                     rj = this.recent_job.code;
                 }

                 if( typeof this.recent_school !== 'undefined' &&  this.recent_school !== null  ){

                    rs = this.recent_school.code;
                 }

                 return  true;





                 let param =  {

                     recent_job: rj,

                     recent_school: rs,

                     current_emp_status: this.current_emp_status,

                     first_name: this.$parent.first_name,

                     last_name: this.$parent.last_name,

                     country: this.$parent.country.code,

                     city: this.$parent.city,

                     uid:  lscache.get('sess_uid'),

                 }

                axios.post(  this.fullPath +  'user/save_profile_wizard', param  )
                    .then( res => {

                        this.$parent.step = 4;
                    });


           },

            addStatusValue( ref_item ){



                if( ref_item === 'role1' ){

                    this.current_emp_status = this.$refs.role1.value

                    this.$refs.role2.checked =  false; this.$refs.role3.checked =  false;
                }

                if( ref_item === 'role2' ){
                    this.current_emp_status = this.$refs.role2.value
                    this.$refs.role1.checked =  false; this.$refs.role3.checked =  false;
                }

                if( ref_item === 'role3' ){

                    this.current_emp_status = this.$refs.role3.value

                    this.$refs.role1.checked =  false; this.$refs.role2.checked =  false;
                }


                this.$emit( 'update:current_emp_status' , this.current_emp_status )

            }






        },


        created(){

            this.loadSchool();

            this.loadProp();

            this.$parent.tabSelected = 3;


        }
    }
</script>

<style scoped>

    .teacher-status-selection label {

        display: block;

        margin-bottom: 10px;

        margin-top: 10px;
    }

    .break {
        margin-bottom: 10px;
        clear: both;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
</style>