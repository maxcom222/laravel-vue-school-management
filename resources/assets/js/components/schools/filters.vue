<template>

    <div ref="searchBox" id="searchBox" :class="heightForSearch===1? 'searchHeight':''" class="searchBox ">

        <div class="row  row-header">

            <div  class="col-12"><h2 >Find the right school for your children.</h2>

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



                <autocomplete

                        ref="autocomplete"

                        placeholder="Filter by School Name"

                        :source="load_schools"

                        input-class="form-control search-friend-input"

                        results-property="data"

                        results-display="code"

                        @selected="filterDiff"

                        @input="formattedDisplay"

                        @clear="clear"




                >
                </autocomplete>





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


                <v-select
                        @input="filterArea"

                        placeholder="Filter by area"

                        v-model="selected_area"

                        :options="areas">

                </v-select>


            </div>


        </div>

        <transition name="slide">




            <div class="row row-header" v-if="showFilters">




                <div  class="filters  mg-bottom-col-10   col-12 col-md-4"  v-for="(filter,i) in filters" :key="filter.index">


                        <h2 id="filterHead" class="filter-header"> {{ filter.headline }} </h2>

                        <a href=""

                           v-for="(sub_filter,index) in filter.data"

                           @click.prevent="filterData(filter,  sub_filter, index )"

                           :key="sub_filter.index"

                           :class="parseInt(sub_filter.status)   === 1 ? 'active' : ''"

                           class="new-checkbox"

                        >

                                  <span>

                                    <svg class="icon icon-square-o">

                                         <use :xlink:href="icon_square_o"></use>

                                    </svg>

                                      <svg class="icon icon-check-square-o">';

                                          <use :xlink:href="icon_check_square_o"></use>

                                     </svg>

                                  </span>

                            <em>{{ sub_filter.value }}</em>
                        </a>

                </div>


                <div class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header"> City (coming soon) </h2>

                    <v-select


                            placeholder="Filter by City"

                            v-model="city"

                            :options="[{ code:'dubai' , label: 'dubai'  }]">

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

    let VueScrollTo = require('vue-scrollto');

    import Autocomplete from 'vuejs-auto-complete'

    export default {


        name: "filters",

        props: ['fullPath'],

        components:  {

            Autocomplete

        },

        data(){



            return{

                heightForSearch: 0,

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

                selected_area: '',

                specModal: [],

                spec:'',

                showFilters: false,

                sort: {code:'new', label:'Newest post'},

                areas: [],



                filters: [

                    {
                        type: 'school_type',
                        headline: 'School Type / Age Group',
                        data: [ {value: '18 months - 5 years', key:'18 months - 5', status: 0  },
                            {value: '3-11 years', key:'3-11', status: 0  }, //
                            {value: '11-18 years', key:'11-18', status: 0 },
                            {value: '3-18 years', key:'3-18', status: 0 },
                            {value: '18+ years', key:'18+', status: 0 }]

                    },
                    {
                        type: 'ages_taught',
                        headline: 'Ages Taught',
                        data: [
                            {value :'Nursery/Pre-School',  key:'Nursery' , status: 0 },
                            {value :'FS1/Pre-School',  key:'Fs 1' , status: 0 },
                            {value :'FS2/Pre-Kindergarten',  key:'Fs 2', status: 0  },
                            {value :'Year 1/Kindergarten',  key:'Kindergarten', status: 0  },
                            {value :'Year 2/Grade 1',  key:'Grade 1', status: 0  },
                            {value :'Year 3/Grade 2',  key:'Grade 2', status: 0  },
                            {value :'Year 4/Grade 3',  key:'Grade 3', status: 0  },
                            {value :'Year 5/Grade 4',  key:'Grade 4', status: 0  },
                            {value :'Year 6/Grade 5',  key:'Grade 5', status: 0  },
                            {value :'Year 7/Grade 6',  key:'Grade 6', status: 0  },
                            {value :'Year 8/Grade 7',  key:'Grade 7', status: 0  },
                            {value :'Year 9/Grade 8',  key:'Grade 8', status: 0  },
                            {value :'Year 10/Grade 9',  key:'Grade 9' , status: 0 },
                            {value :'Year 12/Grade 10',  key:'Grade 10', status: 0  },
                            {value :'Year 12/Grade 11',  key:'Grade 11', status: 0  },
                            {value :'Year 13/Grade 12',  key:'Grade 12', status: 0  },
                        ],
                    },
                    {
                        type: 'curriculums',
                        headline: 'Curriculums',
                        data: [
                            {value: 'British/UK', key: 'UK', status: 0 },
                            {value: 'USA', key: 'USA', status: 0 },
                            {value: 'French', key: 'French', status: 0 },
                            {value: 'German', key: 'German', status: 0 },
                            {value: 'Spanish', key: 'Spanish', status: 0 },
                            {value: 'Greek', key: 'Greek', status: 0 },
                            {value: 'Islamic', key: 'Islamic', status: 0 },
                            {value: 'Arabic', key: 'Arabic', status: 0 },
                            {value: 'Canadian', key: 'Canadian', status: 0 },
                            {value: 'Japanese', key: 'Japanese', status: 0 },
                            {value: 'Chinese', key: 'Chinese', status: 0 },
                            {value: 'Iranian', key: 'Iranian', status: 0 },
                            {value: 'Russian', key: 'Russian', status: 0 },
                            {value: 'UAE', key: 'UAE', status: 0 },
                            {value: 'Australia', key: 'Australia', status: 0 },

                            {value: 'Pakistan', key: 'Pakistan', status: 0 },
                            {value: 'Indians', key: 'Indians', status: 0 },
                            {value: 'Bangladeshi', key: 'Bangladeshi', status: 0 },
                            {value: 'Philippines', key: 'Philippines', status: 0 },
                            {value: 'International', key: 'International', status: 0 },
                            {value: 'Special Needs', key: 'Special Needs', status: 0 },
                        ],

                    },
                    {

                        type: 'boarding',
                        headline: 'DayBoarding',
                        data: [
                            { value: 'Day School', key:'Day School', status: 0   },
                            { value: 'Boarding School', key:'Boarding School' , status: 0 }
                        ],
                    },
                    {
                        type: 'provide_food',
                        headline: 'School Canteen?',
                        data:[
                            { value: 'School Canteen/Provides food', key:'provide_food', status: 0 }
                        ],
                    },
                    {
                        type: 'featured',
                        headline: 'Featured School',
                        data: [  {value:' Select Featured Schools', key: 'featured', status: 0  } ],
                    },




                ],






            }
        },

        methods: {


            formattedDisplay( e ){

               // console.log('s')
            },


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

                this.filters.forEach(  type_filter => {

                   type_filter.data.forEach( data =>  {

                        data.status = 0;
                    })

                });

                this.city = '';

                this.selected_area = '';

                this.search_text = '';

                this.showFilters = false;

                this.page = 0;

                this.school = '';

                this.$refs.autocomplete.value = '';

                this.$refs.autocomplete.display = '';


                let withParam = {'param':  this.filters, school: this.school, area: this.selected_area, page:this.page };

                this.$parent.ajaxLoadSchool( withParam );



            },

            filterData( filter, sub_filter, i ) {


                parseInt(filter.data[i].status)   === 0 ? filter.data[i].status = 1  : filter.data[i].status = 0;

                this.page = 0;

                let withParam = {'param':  this.filters, school: this.school, area: this.selected_area, page:this.page };

                this.$parent.ajaxLoadSchool( withParam );

            },

            clear(){

                this.page = 0;

                this.school = '';

                let withParam = {'param':  this.filters, school: this.school, area: this.selected_area,  page:this.page };

                this.$parent.ajaxLoadSchool( withParam );
            },

            filterDiff(e){


                this.page = 0;

                this.school = e.selectedObject.code;

                this.$refs.autocomplete.value =    this.school;

                let withParam = {'param':  this.filters, school: this.school, area: this.selected_area,  page:this.page };

                this.$parent.ajaxLoadSchool( withParam );



            },
            filterArea(e){


                this.page = 0;

                //this.selected_area = e.selectedObject.code;

                let withParam = {'param':  this.filters, area: this.selected_area.code,  school: this.school, page:this.page };

                this.$parent.ajaxLoadSchool( withParam );

            },







            closeInvite(){

                this.closeSignBoard =  !this.closeSignBoard;

                lscache.set('showInviteNews', false );

            },

            loadAreas() {

                axios.post( this.fullPath + 'schools/load_areas', {} )
                    .then( res =>  {


                        res.data.data.forEach( area_data  => {

                            this.areas .push({ code:area_data.area, label:area_data.area});
                        });


                    })
            },



            load_schools(input) {

                return this.fullPath + 'schools/school_type_ahead?query=' + input;


                /*axios.post( this.fullPath + 'schools/school_type_ahead', {} )
                    .then( res =>  {

                        res.data.data.forEach( school  => {

                            this.schoolModal.push({ code:school.name, label:school.name});
                        });


                    });*/

            },

            addHeight(e){

                this.heightForSearch  = 1;
            },

            removeHeight(e){

                this.heightForSearch  = 0;
            },




        },

        created() {


            setTimeout(() =>  {

                let field =  document.getElementsByClassName('search-friend-input')[0];

                field.addEventListener("focusin", this.addHeight );

                field.addEventListener("blur", this.removeHeight );


            }, 400  );

            this.loadAreas(  );

            this.load_schools();


            lscache.get('showInviteNews')  === null  ? this.showInvite  = true :  this.showInvite  =  lscache.get('showInviteNews') ;


        }

    }




</script>

<style scoped>

    .searchBox{

        box-shadow: 0 1px 6px rgba(57,73,76,0.35);

        padding:10px;

        height: 200px;

        overflow-y:auto; margin-bottom: 30px;

    }



    .search {

        box-shadow: 0 1px 6px rgba(57,73,76,0.35);
    }
    .searchHeight{ height: 400px; }

    .filter-network {

        box-shadow: 0 1px 6px rgba(57,73,76,0.35);

        color:#FFF;

        background:#01ae79;

    }
    .reset-network{
        box-shadow: 0 1px 6px rgba(57,73,76,0.35);
        color: #FFF;
        background: #01ae79;
        margin-bottom: 12px;
        float: right;
    }
    .filter-network .icon{color:#FFF;}

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

        margin-bottom:20px;
        margin-top:40px;
    }
    .autocomplete .form-control  {padding-left:2px !important;}
    .close-filter {

        position: absolute;

        right: 5px;


        top: 10px;

        z-index:9;

        text-align: center;

        cursor: pointer;

    }
    .slide-fade-enter-active {
        transition: all 100ms ease;
    }
    .row-header{position:relative;}
</style>