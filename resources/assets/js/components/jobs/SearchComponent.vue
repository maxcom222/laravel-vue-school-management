<template>

    <div>
        <header class="page-title job-p bg-jobs">

            <div class="container">

                <div class="row">

                    <div class="col-12">

                        <h1>Jobs Listing</h1>

                    </div>

                </div>

            </div>

            <div class="container filters">

                <div class="row">



                    <div class="col-lg-4  col-md-4 ">

                        <label for="">Search</label>

                        <form class="search">

                            <input type="search"  v-model="search_text" class="form-control" placeholder="Search...">


                            <button class="btn" @click="filter_jobs" type="button">

                                <svg class="icon icon-search">

                                    <use :xlink:href="icon_search"></use>

                                 </svg>

                            </button>

                        </form>

                    </div>


                    <div class="col-lg-2 d-none">

                        <label for="">Salary Band</label>

                        <v-select

                                v-model="salary_band"
                                :close-on-select="true"
                                placeholder="Select range"

                                :options="[

                                 {code:'5000', label:'AED 5000 and below',  status:0 },
                                 {code:'10000', label:'AED 5000 - 10000',  status:0},
                                 {code:'20000', label:'AED 10000 - 20000',  status:0},
                                 {code:'30000', label:'AED 20000 - 30000',  status:0},
                                 {code:'40000', label:'AED 40000 and above',  status:0},



                                 ]"
                        >
                        </v-select>

                    </div>


                    <div class="col-lg-4 col-md-4 ">
                        <label for="">School</label>



                        <vue-bootstrap-typeahead
                                @hit="selectedSchool"
                                v-model="school"
                                :data="typeahead"
                                placeholder="Type school name..."
                        />


                    </div>


                    <div class="col-lg-2  d-none">
                        <label for="">Gender</label>


                        <v-select

                                @input="filter_jobs"

                                v-model="gender"

                                :close-on-select="true"

                                placeholder="Select gender"

                                :options="[

                                 {code:'Either', label:'Either',  status:0},
                                 {code:'Female', label:'Female',  status:0},
                                 {code:'Male', label:'Male',  status:0}


                                 ]"
                        >

                        </v-select>


                    </div>



                    <div class="col-lg-4  col-md-4 department ">
                        <label for="">Department</label>

                        <v-select


                                v-model="department"
                                :close-on-select="true"
                                placeholder="Select department"

                                :options="[
                { code:'Nursery', label:'Nursery' , type:'department'},
                { code:'FS1', label:'FS1' , type:'department'},
                { code:'FS2', label:'FS2' , type:'department'},
                { code:'Kindergarten', label:'Year 1/Kindergarten' , type:'department'},
                { code:'Grade 1', label:'Year 2/Grade 1' , type:'department'},
                { code:'Grade 2', label:'Year 3/Grade 2' , type:'department'},
                { code:'Grade 3', label:'Year 4/Grade 3' , type:'department'},
                { code:'Grade 4', label:'Year 5/Grade 4' , type:'department'},
                { code:'Grade 5', label:'Year 6/Grade 5' , type:'department'},
                { code:'Grade 6', label:'Year 7/Grade 6' , type:'department'},
                { code:'Grade 7', label:'Year 8/Grade 7' , type:'department'},
                { code:'Grade 8', label:'Year 9/Grade 8' , type:'department'},
                { code:'Grade 9', label:'Year 10/Grade 9' , type:'department'},
                { code:'Grade 10', label:'Year 11/Grade 10' , type:'department'},
                { code:'Grade 11', label:'Year 12/Grade 11' , type:'department'},
                { code:'Grade 12', label:'Year 13/Grade 12' , type:'department'},
                { code:'Key Stage 1', label:'Key Stage 1' , type:'department'},
                { code:'Key Stage 2', label:'Key Stage 2' , type:'department'},
                { code:'Key Stage 3', label:'Key Stage 3' , type:'department'},
                { code:'Key Stage 4', label:'Key Stage 4' , type:'department'},
                { code:'Key Stage 5', label:'Key Stage 5' , type:'department'},
                { code:'Primary', label:'Primary' , type:'department'},
                { code:'Secondary', label:'Secondary' , type:'department'},
                { code:'Further Education', label:'Further Education' , type:'department'},
                { code:'Leadership', label:'Leadership' , type:'department'},
                { code:'Special Education', label:'Special Education' , type:'department'},
                { code:'Headteacher', label:'Headteacher' , type:'department'},
                { code:'French', label:'French' , type:'department'},
                { code:'Spanish', label:'Spanish' , type:'department'},
                { code:'Arabic', label:'Arabic' , type:'department'},
                { code:'Mandarin', label:'Mandarin' , type:'department'},
                { code:'German', label:'German' , type:'department'},
                { code:'MFL', label:'MFL' , type:'department'},
                { code:'Science', label:'Science' , type:'department'},
                { code:'Chemistry', label:'Chemistry' , type:'department'},
                { code:'Biology', label:'Biology' , type:'department'},
                { code:'Physics', label:'Physics' , type:'department'},
                { code:'English', label:'English' , type:'department'},
                { code:'Maths', label:'Maths' , type:'department'},
                { code:'Media', label:'Media' , type:'department'},
                { code:'Marketing', label:'Marketing' , type:'department'},
                { code:'Business', label:'Business' , type:'department'},
                { code:'Music', label:'Music' , type:'department'},
                { code:'Korean', label:'Korean' , type:'department'},
                { code:'Sociology', label:'Sociology' , type:'department'},
                { code:'Design and Technology', label:'Design and Technology' , type:'department'},
                { code:'Politics', label:'Politics' , type:'department'},
                { code:'Economics', label:'Economics' , type:'department'},
                { code:'PE/Sports', label:'PE/Sports' , type:'department'},
                { code:'Computing/ ICT ', label:'Computing/ ICT' , type:'department'},
                { code:'Art', label:'Art' , type:'department'},
                { code:'Drama', label:'Drama' , type:'department'},
                { code:'History', label:'History' , type:'department'},
                { code:'Geography', label:'Geography' , type:'department'},
                { code:'Psychology', label:'Psychology' , type:'department'},
                { code:'Management', label:'Management' , type:'department'},
                { code:'Administration', label:'Administration' , type:'department'}

                        ]"
                        >



                        </v-select>




                    </div>




                </div>

            </div>
        </header>

    </div>

</template>

<script>

    import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';

    export default {

        name: "SearchComponent",

        components: {VueBootstrapTypeahead},


        props:['fullPath'],


        data(){


            return{

                typeahead: [],

                search_text:'',

                salary_band:'',

                department:'',

                gender:  '',

                school: '',

                icon_search: this.fullPath + 'css/ico/symbol-defs.svg#icon-search',
            }
        },

        watch: {


        },
        methods: {

            selectedSchool( e ){

                this.school = e;

                this.filter_jobs();

            },


            filter_jobs() {

                let withParam =
                    {
                        search_text: this.search_text,

                        salary_band:   '',

                        department: this.department.code,

                        gender: '',

                        school: this.school,
                    };


                this.$parent.filter_jobs( withParam );

            },


            school_type_ahead() {

                axios.post( this.fullPath + 'schools/school_type_ahead', {} )
                    .then( res =>  {

                        res.data.data.forEach( school  => {

                            this.typeahead.push( school.name );
                        });


                    });

            },
        },
        created(){

            this.school_type_ahead();
        }
    }
</script>

<style scoped>

</style>