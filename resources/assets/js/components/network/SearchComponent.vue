<template>

<div id="searchBox" class="searchBox ">

    <div class="row  row-header">

        <div  class="col-12"><h2 >Grow your network. Connect with awesome people</h2>


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

                <input type="search" class="form-control" v-model="search_text" placeholder="Search...">

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


            <p class="sort-paragraph">Sort</p>

            <v-select
                    placeholder="Sort"

                    v-model="sort" name="sort"

                    :options="[

                     {code:'new', label:'Newest members'},

                     {code:'old', label:'Oldest members'},

                     {code:'etc', label:'ETC members'}

                     ]">

            </v-select>


        </div>


    </div>

    <transition name="slide">


          <div class="row row-header" v-if="showFilters">

            <div class="filters  col-12 col-md-4">

                <h2  id="filterHead"  class="filter-header"> Type </h2>

                <a href=""  :class=" teacher  === 1 ? 'active':  '' " @click.prevent="filterType('teacher')"  class="new-checkbox ">
                    <span>

                        <svg class="icon icon-square-o">

                            <use :xlink:href="icon_square_o">

                            </use>

                        </svg>

                        <svg class="icon icon-check-square-o">

                            <use :xlink:href="icon_check_square_o">

                            </use>

                        </svg>

                    </span>

                    <em>Teachers</em>

                </a>

                <a href=""  :class=" tutor  === 1 ? 'active':  '' " @click.prevent="filterType('tutor')"  class="new-checkbox ">
                    <span>

                        <svg class="icon icon-square-o">

                            <use :xlink:href="icon_square_o">

                            </use>

                        </svg>

                        <svg class="icon icon-check-square-o">

                            <use :xlink:href="icon_check_square_o">

                            </use>

                        </svg>

                    </span>

                    <em>Tutors</em>

                </a>

                <a href=""  :class=" parent  === 1 ? 'active':  '' " @click.prevent="filterType('parent')"    class="new-checkbox ">
                    <span>

                        <svg class="icon icon-square-o">

                            <use :xlink:href="icon_square_o">

                            </use>

                        </svg>

                        <svg class="icon icon-check-square-o">

                            <use :xlink:href="icon_check_square_o">

                            </use>

                        </svg>

                    </span>

                    <em>Parent</em>

                </a>

            </div>

            <div class="col-12 col-md-4">

                <h2 class="filter-header"> School </h2>


                <v-select

                        @input="filterData"

                        placeholder="Filter by School Name"

                        v-model="school"

                        :options="schoolModal">

                </v-select>

            </div>

            <div class="col-12 col-md-4">

                <h2 class="filter-header"> Specialism </h2>

                <v-select
                        @input="filterData"

                        placeholder="Filter by Specialism"

                        v-model="spec"

                        :options="specModal">

                </v-select>

            </div>


    </div>


    </transition>


    <transition name="fadeOut">

        <div class="row row-header"  v-if="closeSignBoard  &&  showInvite">


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


    export default {


        name: "SearchComponent",

        props: ['fullPath'],

        data(){



            return{


                icon_search: this.fullPath + 'css/ico/symbol-defs.svg#icon-search',

                icon_square_o: this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-square-o',

                icon_check_square_o:  this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-check-square-o',

                icon_filter:   this.fullPath + 'css/ico/symbol-defs.svg#icon-filter',

                icon_back:   this.fullPath + 'css/ico/symbol-defs.svg#icon-go_back',

                sort:'',

                city:'',

                search_text: '',

                teacher: 0,

                tutor: 0,

                parent: 0,

                closeSignBoard: true,

                schoolModal: [],

                school: '',

                specModal: [],

                spec:'',

                showFilters: false,

                showInvite: true,



            }
        },

        methods: {

            closeInvite(){

                this.closeSignBoard =  !this.closeSignBoard;

                lscache.set('showInviteNews', false );

            },

            resetFilters(){

                this.teacher = 0;

                this.parent = 0;

                this.tutor = 0;

                this.search_text = '';

                this.school = '';

                this.spec = '';

                this.sort = '';

                let param =
                    {
                        teacher: this.teacher,

                        parent: this.parent,

                        tutor: this.tutor,

                        search_text: this.search_text,

                        school: '',

                        spec: '',

                        sort: '',

                    };

                eventBus.$emit('filterStaff', param );

                this.showFilters = false;



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



            searchText()  {

                if( this.search_text === '' ){

                    return;
                }

                this.filterData();
            },

            filterType( type ) {

                if( type  === 'teacher') {

                    this.teacher =  1 - this.teacher;
                }
                if( type  === 'tutor') {

                    this.tutor = 1  -  this.tutor;
                }
                if( type  === 'parent') {

                    this.parent = 1 - this.parent;
                }


                this.filterData();


            },

            filterData() {

                let school_code = '';

                let spec_code = '';

                if( typeof this.school !== 'undefined' &&  this.school !==  null  &&  this.school !==  '' ) {

                    school_code = this.school.code;
                }


                if( typeof  this.spec !== 'undefined' &&  this.spec !==  null  &&  this.spec !==  '' ) {

                    console.log( this.school + '===' +  spec_code);

                    spec_code = this.spec.code;

                }


                    console.log( this.school + '===' +  spec_code);


                let param =
                    {
                        teacher: this.teacher,

                        parent: this.parent,

                        tutor: this.tutor,

                        search_text: this.search_text,

                        school: school_code,

                        spec: spec_code,

                    }

                eventBus.$emit('filterStaff', param );





            },
            load_schools(){

                    axios.post( this.fullPath + 'schools/school_type_ahead_original', {} )
                        .then( res =>  {

                            res.data.data.forEach( school  => {

                                this.schoolModal.push({ code:school.name, label:school.name});
                            });


                        });

            },

            load_spec(){

                axios.post( this.fullPath + 'network/specialization', {} )

                    .then( res =>  {

                        res.data.data.forEach( school  => {

                            this.specModal.push({ code:school.title, label:school.title});
                        });


                    });

            },



        },

        created() {


            this.load_schools();

            this.load_spec();

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



</style>