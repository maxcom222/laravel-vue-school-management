<template>

    <div id="searchBox" class="searchBox ">

        <div class="row  row-header">

            <div  class="col-12"><h2 >Find the right job and shape your career.</h2>


                <button

                        @click="resetFilters"

                        class="btn reset-network"
                >

                    <svg class="icon icon-go_back">
                        <use :xlink:href="icon_back"></use>
                    </svg>

                    Reset Filters

                </button>


            </div>


            <div class="col-12 col-md-4 justify-content-center text-center">



                <form class="search">

                    <input type="search" class="form-control" v-model="search_text" placeholder="Search topic...">

                    <button class="btn" @click="searchText" type="button">

                        <svg class="icon icon-search">

                            <use :xlink:href="icon_search"></use>

                        </svg>

                    </button>

                </form>






            </div>


            <div class="col-12 col-md-4 justify-content-center text-center">


                <button @click="scrollFilter" class="btn filter-network" type="button">

                    <svg class="icon icon-filter">

                        <use :xlink:href="icon_filter"></use>
                    </svg>

                    Filters

                </button>


            </div>


            <div class="col-12 col-md-4 justify-content-center text-center ">


                <autocomplete

                        ref="autocomplete"

                        placeholder="Filter by School Name"

                        :source="schoolModal"

                        input-class="form-control search-friend-input"

                        results-property="data"

                        results-display="code"

                        @selected="filterDiff"

                >
                </autocomplete>


            </div>


        </div>

        <transition name="slide">


            <div class="row row-header" v-if="showFilters">




                <div class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 id="filterHead" class="filter-header"> Department</h2>


                    <v-select

                            @input="ajaxLoadJobs"
                            v-model="department"
                            :close-on-select="true"
                            placeholder="Select position"

                            :options="[

                     {code:'Headteacher',  label:'Headteacher'},
    { code:'Deputy Headteacher',  label:'Deputy Headteacher'},
    { code:'Director/Principal',  label:'Director/Principal'},
    { code:'Leadership/Excellence Teacher',  label:'Leadership/Excellence Teacher'},
    { code:'Assistant Headteacher',  label:'Assistant Headteacher'},
    { code:'Deputy Director/Vice Principal',  label:'Deputy Director/Vice Principal'},
    { code:'Excutive Assistant',  label:'Excutive Assistant'},
    { code:'Counsellor',  label:'Counsellor'},
    { code:'School Administration',  label:'School Administration'},
    { code:'Learning Support',  label:'Learning Support'},
    { code:'Office Manager',  label:'Office Manager'},
    { code:'Advisor/Consultant',  label:'Advisor/Consultant'},
    { code:'Secretary/Receptionist',  label:'Secretary/Receptionist'},
    { code:'Specialist',  label:'Specialist'},
    { code:'Librarian',  label:'Librarian'},
    { code:'Careers Advisor',  label:'Careers Advisor'},
    { code:'Housemaster/Housemistress',  label:'Housemaster/Housemistress'},
    { code:'Business Manager/Bursar',  label:'Business Manager/Bursar'},
    { code:'Educational Psychologist',  label:'Educational Psychologist'},
    { code:'Premises Manager/Housekeeper',  label:'Premises Manager/Housekeeper'},
    { code:'Teacher',  label:'Teacher'},
    { code:'Leader/Co-ordinator',  label:'Leader/Co-ordinator'},
    { code:'Head of Department',  label:'Head of Department'},
    { code:'Assessment Co-ordinator',  label:'Assessment Co-ordinator'},
    { code:'Teaching Assistant',  label:'Teaching Assistant'},
    { code:'Advanced Skills Teacher',  label:'Advanced Skills Teacher'},
    { code:'Special Educational Needs',  label:'Special Educational Needs'},
    { code:'Tutor',  label:'Tutor'},
    { code:'Lecturer',  label:'Lecturer'},
    { code:'Head of Year',  label:'Head of Year'},
    { code:'Director of Faculty/Department',  label:'Director of Faculty/Department'},
    { code:'Subject Leadership/Excellence Teacher',  label:'Subject Leadership/Excellence Teacher'},
    { code:'Manager',  label:'Manager'},
    { code:'Principal Teacher',  label:'Principal Teacher'},
    { code:'Admissions Assistant/Manager',  label:'Admissions Assistant/Manager'},
    { code:'Marketing Assistant/Manager',  label:'Marketing Assistant/Manager'},
    { code:'Communications Assistant/Manager',  label:'Communications Assistant/Manager'},
    { code:'Office Assistant/Manager',  label:'Office Assistant/Manager'},
    { code:'Finance Assistant/Manager',  label:'Finance Assistant/Manager'},
    { code:'Premises Assistant/Manager',  label:'Premises Assistant/Manager'},
    { code:'IT Assistant/Manager',  label:'IT Assistant/Manager'},
    { code:'Procurement Assistant/Manager',  label:'Procurement Assistant/Manager' }





                    ]"
                    >

                    </v-select>


                </div>

                <div class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header"> City (coming soon) </h2>

                    <v-select


                            placeholder="Filter by City"

                            v-model="city"

                            :options="[{ code:'dubai' , label: 'dubai'  }]">

                    </v-select>

                </div>



                <div class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header"> Contract Type</h2>

                    <v-select

                            @input="ajaxLoadJobs"
                            v-model="contract_type"
                            :close-on-select="true"
                            placeholder="Select Contract Type"

                            :options="[
                        {code:'Full Time', label:'Full Time' },
                           {code:'Part Time', label:'Part Time' },
                           {code:'Overseas', label:'Overseas'  },
                           {code:'Local', label:'Local'},
                           {code:'Maternity Cover', label:'Maternity Cover'   },
                           {code:'Supply Teaching', label:'Supply Teaching' },
                           {code:'other', label:'other'},

                    ]"
                    >

                    </v-select>


                </div>




                <div class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header"> Benefits</h2>


                        <v-select

                                @input="ajaxLoadJobs"
                                v-model="benefits"
                                :close-on-select="true"
                                placeholder="Select Benefit"

                                :options="[

                        { code:'Visa Provided', label:'Visa Provided' },
                        { code:'Housing Benefit' , label:'Housing Benefit' },
                        { code:'Medical Insurance for self', label:'Medical Insurance for self' },
                        { code:'Medical Insurance for self and family', label:'Medical Insurance for self and family' },
                        { code:'School Fee\'s Assistance', label:'School Fee\'s Assistance' },
                        { code:'Return flights home for self', label:'Return flights home for self' },
                        { code:'Return flights home for self and family members', label:'Return flights home for self and family members' },
                        { code:'Furniture allowance provide', label:'Furniture allowance provide' },
                        { code:'School Places Offered for Teachers Children', label:'School Places Offered for Teachers Children' },
                        { code:'other'  , label:'other' },


                            ]"
                        >

                        </v-select>

                </div>



                <div class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header"> Position</h2>


                    <v-select

                            @input="ajaxLoadJobs"
                            v-model="position"
                            :close-on-select="true"
                            placeholder="Select position"

                            :options="[

                     {code:'Headteacher',  label:'Headteacher'},
    { code:'Deputy Headteacher',  label:'Deputy Headteacher'},
    { code:'Director/Principal',  label:'Director/Principal'},
    { code:'Leadership/Excellence Teacher',  label:'Leadership/Excellence Teacher'},
    { code:'Assistant Headteacher',  label:'Assistant Headteacher'},
    { code:'Deputy Director/Vice Principal',  label:'Deputy Director/Vice Principal'},
    { code:'Excutive Assistant',  label:'Excutive Assistant'},
    { code:'Counsellor',  label:'Counsellor'},
    { code:'School Administration',  label:'School Administration'},
    { code:'Learning Support',  label:'Learning Support'},
    { code:'Office Manager',  label:'Office Manager'},
    { code:'Advisor/Consultant',  label:'Advisor/Consultant'},
    { code:'Secretary/Receptionist',  label:'Secretary/Receptionist'},
    { code:'Specialist',  label:'Specialist'},
    { code:'Librarian',  label:'Librarian'},
    { code:'Careers Advisor',  label:'Careers Advisor'},
    { code:'Housemaster/Housemistress',  label:'Housemaster/Housemistress'},
    { code:'Business Manager/Bursar',  label:'Business Manager/Bursar'},
    { code:'Educational Psychologist',  label:'Educational Psychologist'},
    { code:'Premises Manager/Housekeeper',  label:'Premises Manager/Housekeeper'},
    { code:'Teacher',  label:'Teacher'},
    { code:'Leader/Co-ordinator',  label:'Leader/Co-ordinator'},
    { code:'Head of Department',  label:'Head of Department'},
    { code:'Assessment Co-ordinator',  label:'Assessment Co-ordinator'},
    { code:'Teaching Assistant',  label:'Teaching Assistant'},
    { code:'Advanced Skills Teacher',  label:'Advanced Skills Teacher'},
    { code:'Special Educational Needs',  label:'Special Educational Needs'},
    { code:'Tutor',  label:'Tutor'},
    { code:'Lecturer',  label:'Lecturer'},
    { code:'Head of Year',  label:'Head of Year'},
    { code:'Director of Faculty/Department',  label:'Director of Faculty/Department'},
    { code:'Subject Leadership/Excellence Teacher',  label:'Subject Leadership/Excellence Teacher'},
    { code:'Manager',  label:'Manager'},
    { code:'Principal Teacher',  label:'Principal Teacher'},
    { code:'Admissions Assistant/Manager',  label:'Admissions Assistant/Manager'},
    { code:'Marketing Assistant/Manager',  label:'Marketing Assistant/Manager'},
    { code:'Communications Assistant/Manager',  label:'Communications Assistant/Manager'},
    { code:'Office Assistant/Manager',  label:'Office Assistant/Manager'},
    { code:'Finance Assistant/Manager',  label:'Finance Assistant/Manager'},
    { code:'Premises Assistant/Manager',  label:'Premises Assistant/Manager'},
    { code:'IT Assistant/Manager',  label:'IT Assistant/Manager'},
    { code:'Procurement Assistant/Manager',  label:'Procurement Assistant/Manager' }





                    ]"
                    >

                    </v-select>


                </div>



            </div>


        </transition>


        <transition name="fadeOut">

            <div class="row row-header"  v-if="closeSignBoard &&  showInvite ">


                <div class="col-12 ">

                    <div class="sign-board-container">

                        <h4>

                            Invite a coworker to help you grow

                        </h4>

                        <span class="d-block">

                        Let them help you find, opportunities, classifieds and more .

                    </span>


                        <button class="btn btn-primary invite-coworker" >

                            Invite Coworkers

                        </button>

                        <button @click="closeInvite" class="close times-cancel" >
                            &times;
                        </button>

                    </div>

                </div>

            </div>
        </transition>


    </div>

</template>

<script>

    import {eventBus} from '../../app.js';


    import Autocomplete from 'vuejs-auto-complete'

    let VueScrollTo = require('vue-scrollto');


    export default {


        name: "filters",

        props: ['fullPath'],

        components:  {

            Autocomplete

        },

        data(){



            return{


                icon_search: this.fullPath + 'css/ico/symbol-defs.svg#icon-search',

                icon_square_o: this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-square-o',

                icon_check_square_o:  this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-check-square-o',

                icon_menu:   this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-menu',


                icon_filter:   this.fullPath + 'css/ico/symbol-defs.svg#icon-filter',

                icon_back:   this.fullPath + 'css/ico/symbol-defs.svg#icon-go_back',


                city:'',

                search_text: '',

                page: 0,

                closeSignBoard: true,

                schoolModal: [],

                school: '',

                department: {code: ''},

                gender:  '',

                showFilters: false,

                position: {code: ''},

                benefits:{code: ''},

                contract_type: {code: ''},



            }
        },

        methods: {


            scrollFilter(){

                this.showFilters = !this.showFilters;

                if(this.showFilters === true ){

                    setTimeout(() => {

                        let options = {

                            container: '#searchBox',

                            easing: 'ease-in',

                            y: true,
                        };

                        VueScrollTo.scrollTo('#filterHead', 300, options);

                    }, 200);


                }

            },

            resetFilters(){



                this.page = 0;

                this.school = 0;

                this.school = '';

                this.$refs.autocomplete.value = '';

                this.$refs.autocomplete.display = '';




                this.department = {code:''};

                this.contract_type =  {code:  ''};

                this.position    =  {code:  ''};

                this.search_text = '';

                this.benefits  =  {code:  ''};

                this.showFilters  = false;

                let withParam =
                    {
                        contract_type: this.contract_type.code,

                        city:  '',

                        benefits: this.benefits.code,

                        position: this.position.code,

                        school: this.school,

                        search_text: this.search_text,

                        page: this.page,

                        department: this.department.code,

                    };
                this.$parent.ajaxLoadJobs( withParam );



            },

            filterDiff(e){


                this.page = 0;

                this.school = e.selectedObject.code;

                this.$refs.autocomplete.value = this.school;



                let withParam =
                    {
                        contract_type: this.contract_type.code,

                        city:  '',

                        benefits: this.benefits.code,

                        position: this.position.code,

                        school: this.school,

                        search_text: this.search_text,

                        page: this.page,

                        department: this.department.code,

                    };
                this.$parent.ajaxLoadJobs( withParam );



            },
            searchText(){


                this.page = 0;

                let withParam =
                    {
                        contract_type: this.contract_type.code,

                        city:  '',

                        benefits: this.benefits.code,

                        position: this.position.code,

                        school: this.school,

                        search_text: this.search_text,

                        page: this.page,

                        department: this.department.code,

                    };
                this.$parent.ajaxLoadJobs( withParam );

            },



            ajaxLoadJobs() {


                this.page = 0;


                let withParam =
                    {
                        contract_type: this.contract_type.code,

                        city:  '',

                        benefits: this.benefits.code,

                        position: this.position.code,

                        school: this.school,

                        search_text: this.search_text,

                        page: this.page,

                        department: this.department.code,

                    };
                this.$parent.ajaxLoadJobs( withParam );

            },



            closeInvite(){

                this.closeSignBoard =  !this.closeSignBoard;

                lscache.set('showInviteNews', false );

            },



            load_schools(){

                axios.post( this.fullPath + 'schools/school_type_ahead', {} )
                    .then( res =>  {

                        res.data.data.forEach( school  => {

                            this.schoolModal.push({ code:school.name, label:school.name});
                        });


                    });

            },


        },

        created() {




            this.load_schools();


            lscache.get('showInviteNews')  === null  ? this.showInvite  = true :  this.showInvite  =  lscache.get('showInviteNews') ;


        }

    }
</script>

<style scoped>

    .searchBox{

        box-shadow: 0 1px 6px rgba(57,73,76,0.35);

        padding:10px;

    }

    .search {

        box-shadow: 0 1px 6px rgba(57,73,76,0.35);
    }

    .filter-network {

        box-shadow: 0 1px 6px rgba(57,73,76,0.35);
        color:#FFF;
        background:#01ae79;
    }

    .filter-network:hover{

        background-color: #019567;

        border-color: #019567;

        color:#FFF;
    }

    .search input[type=search] + .btn {

        background-color: #01ae79;
        height:38px;
    }

    .search input[type=search] {

        height: 38px;
    }
    .search .btn .icon{

        color:#FFF;
    }

    .sort-paragraph{

        float: left;

        width: 42px;

        line-height:38px;
    }

    .sign-board{

        position:relative;

        border-top: 1px solid #ccc;

        background: #f5f5f5;

    }



    .sign-board-container{

        padding: 20px;

    }

    .times-cancel{

        position: absolute;
        top: 0;
        right: 10px;
        color: #000;
    }

    .row-header{

        border-bottom: 1px solid #ccc;
        padding: 10px;
        margin-left: 0;
        margin-right: 0;
        padding-top: 20px;
    }

    .filter-header{

        color:#01ae79;

        border-bottom: 1px solid #ccc;

        padding: 4px;

        margin-bottom: 6px;

    }
    .invite-coworker{

        margin-top: 15px;
    }

    .mg-bottom-col-10 {

        margin-bottom:40px;
    }
    .autocomplete .form-control  {padding-left:2px !important;}
    .close-filter {

        position: absolute;

        right: 5px;


        top: 0;

        z-index:9;

        text-align: center;

        cursor: pointer;

    }
    .slide-fade-enter-active {
        transition: all 100ms ease;
    }
    .row-header{position:relative;}
</style>