<template>

    <div>

        <div class="tab-pane active show" id="pills-step-2" role="tabpanel">

            <div>

                <div  v-if="mini_step === 1">

                    <p class="lead">Do your children attend an international school?</p>

                    <div class="form-group row">

                        <div class="col-sm-12 text-center">

                            <label class="mglft-7">

                                <input @change="selectSchoolOpt" name="school_selection" value="1" type="radio">

                                Yes</label>

                            <label>

                                <input @change="selectSchoolOpt" type="radio" name="school_selection" value="0">

                                No</label>

                        </div>


                    </div>


                </div>



                <div class="form-group child-school row" v-if="school_selection == 1 && mini_step ==  1">

                    <div class="col-sm-12   text-center">

                        <label> Child's school </label>

                        <v-select name=""

                                  placeholder="Type and select"

                                  :close-on-select="true"

                                  v-model="child_school_one"

                                  :options="schoolTitle">

                        </v-select>

                    </div>

                    <div class="col-sm-12 text-center">

                        <label> Child's school </label>

                        <v-select name=""

                                  placeholder="Type and select"

                                  :close-on-select="true"

                                  v-model="child_school_two"

                                  :options="schoolTitle">

                        </v-select>

                    </div>



                    <div class="col-sm-12 text-center">

                        <label> Child's school </label>

                        <v-select name=""

                                  placeholder="Type and select"

                                  :close-on-select="true"

                                  v-model="child_school_three"

                                  :options="schoolTitle">

                        </v-select>

                    </div>


                    <div class="col-sm-12 d-none">

                        <button type="button" @click="next_mini" class="btn  btn-primary">Continue</button>

                    </div>




                </div>


                <div   v-if="mini_step === 1" >

                    <p class="lead">We have many qualified teachers who offer personal tutoring. Are you interested in more information?</p>

                    <div class="form-group  row">

                        <div class="col-sm-12 text-center">

                            <label class="mglft-7">

                                <input @change="tutorSelection" name="tutor_selection" value="1" type="radio">
                                Yes</label>


                            <label>
                                <input @change="tutorSelection"  type="radio" name="tutor_selection" value="0">
                                No</label>

                        </div>

                    </div>

                    <div class="form-group row  text-center" v-if="tutor_selection===1">

                        <div class="col-12">

                            <label>Provide us with your location</label>


                            <v-select name=""

                                      placeholder="Type and select"

                                      :close-on-select="true"

                                      v-model="area"

                                      :options="areaSelect">

                            </v-select>
                        </div>

                    </div>


                    <div class="form-group row d-none">

                        <div class="col-sm-12">

                            <button type="button" @click="next_mini" class="btn  btn-primary">Continue</button>

                        </div>

                    </div>


                </div>


                <div v-if="mini_step === 1" >

                    <p class="lead">Schools are always looking for parents to be involved on voluntary basis but maybe you are interested in paid work in a school as a teacher, LA/TA or even an  administrative post?</p>

                    <div class="form-group  row">

                        <div class="col-sm-12 text-center">

                            <label class="mglft-7">

                                <input @change="workSelection" checked="" name="work_selection" value="1" type="radio">

                                Yes</label>

                            <label>

                                <input  @change="workSelection" type="radio" name="work_selection" value="0">

                                No</label>

                        </div>

                    </div>

                    <div class="form-group row d-none">

                        <div class="col-sm-12">

                            <button type="button" @click="saveParent" class="btn   btn-primary">Continue</button>

                        </div>

                    </div>


                </div>










            </div>
        </div>

    </div>
</template>

<script>
    export default {


        name: "ParentStep2",

        props:['fullPath'],

        data(){

            return {

                school_selection: '',

                child_school_one:'',

                child_school_two: '',

                child_school_three: '',

                schoolTitle:  [],

                mini_step: 1,

                tutor_selection: '',

                work_selection:  1,

                area  : '',

                areaSelect: [],


            }



        },

        methods:{

            selectSchoolOpt( event ){


                if(  event.target.checked  ===  true ){

                    this.school_selection = event.target.value;
                }

                if(  parseInt( this.school_selection ) === 0 ){

                    //this.mini_step  = 2;
                }



            },

            tutorSelection(event){


                if(  event.target.checked  ===  true ){

                    this.tutor_selection = event.target.value;
                }

                   // this.mini_step  = 3;


            },

            workSelection(event){


                if(  event.target.checked  ===  true ){

                    this.work_selection = event.target.value;


                }

               // this.mini_step  = 4;

            },

            saveParent(){


                let c_school_one = '';

                let c_school_two = '';

                let c_school_three = '';

                if( typeof  this.child_school_one  !== 'undefined'  &&  this.child_school_one  !== null ){

                    c_school_one = this.child_school_one.code
                }

                if( typeof  this.child_school_two  !== 'undefined'  &&  this.child_school_two  !== null ){

                    c_school_two = this.child_school_two.code
                }

                if( typeof  this.child_school_three  !== 'undefined'  &&  this.child_school_three  !== null ){

                    c_school_three = this.child_school_three.code
                }

                let param = {

                    child_school_one: c_school_one,

                    child_school_two: c_school_two,

                    child_school_three: c_school_three,

                    tutor_selection: this.tutor_selection,

                    work_selection:  this.work_selection,

                    area  : this.area,

                };


                return  param;


                return;




                axios.post(  this.fullPath +  'save_parent_profile', param )
                    .then( res => {

                        this.nextStep();
                    });


            },



            next_mini(){

                this.mini_step =  this.mini_step  +  1;
            },

            loadSchool(){

                axios.post(  this.fullPath +  'school_search', {}  )
                    .then( res => {

                        let prop = res.data.data;

                        prop.forEach( obj => {

                            let item = {code: obj.id, label:  obj.name };

                            this.schoolTitle.push( item );

                        });
                    });
            },

            loadArea(){

                axios.post(  this.fullPath +  'schools/load_areas', {}  )
                    .then( res => {

                        let prop = res.data.data;

                        prop.forEach( obj => {

                            let item = {code: obj.area, label:  obj.area };

                            this.areaSelect.push( item );

                        });
                    });
            },



            nextStep(){

                this.$parent.step   =   4;
            }






        },

        created(){


            this.loadSchool();

            this.loadArea();



        },
    }
</script>

<style scoped>

    .child-school label{ margin-top:10px;}

</style>