<template>

<div  id="searchBox" class="searchBox ">

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


            <p class="sort-paragraph">Sort</p>

            <v-select

                    @input="filterData"

                    placeholder="Sort"

                    v-model="sort" name="sort"

                    :options="[

                     {code:'new', label:'Newest post'},

                     {code:'old', label:'Oldest post'},

                     {code:'etc', label:'Post from members'}

                     ]">

            </v-select>


        </div>


    </div>

    <transition name="slide">


          <div class="row row-header" v-if="showFilters">

            <div class="filters  col-12 col-md-4">

                <h2 id="filterHead" class="filter-header"> Type </h2>

                <a href=""  :class=" faq  === 1 ? 'active':  '' " @click.prevent="filterType('faq')"  class="new-checkbox ">
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

                    <em>Faqs</em>

                </a>

                <a href=""  :class=" article  === 1 ? 'active':  '' " @click.prevent="filterType('article')"  class="new-checkbox ">
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

                    <em>Article</em>

                </a>

                <a href=""  :class=" event  === 1 ? 'active':  '' " @click.prevent="filterType('event')"    class="new-checkbox ">
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

                    <em>Event</em>

                </a>


                <a href=""  :class=" favourites  === 1 ? 'active':  '' " @click.prevent="filterType('favourites')"  class="new-checkbox ">
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

                    <em>Favourites</em>

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

                <h2 class="filter-header"> City </h2>

                <v-select
                        @input="filterData"

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

    export default {


        name: "SearchComponent",

        props: ['fullPath'],

        data(){



            return{


                icon_search: this.fullPath + 'css/ico/symbol-defs.svg#icon-search',

                icon_square_o: this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-square-o',

                icon_check_square_o:  this.fullPath + 'js/plugins/menu/symbol-defs.svg#icon-check-square-o',



                city:'',

                search_text: '',

                faq: 0,

                article: 0,

                event: 0,

                favourites: 0,

                closeSignBoard: true,

                schoolModal: [],

                school: '',

                specModal: [],

                spec:'',

                showFilters: false,

                sort: {code:'new', label:'Newest post'},


                icon_filter:   this.fullPath + 'css/ico/symbol-defs.svg#icon-filter',

                icon_back:   this.fullPath + 'css/ico/symbol-defs.svg#icon-go_back',





            }
        },

        methods: {

            searchText()  {

                if( this.search_text === '' ){

                    return;
                }

                this.filterData();
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

                this.faq = 0;

                this.article = 0;

                this.event = 0;

                this.favourites = 0;

                this.search_text = '';

                this.city = '';

                this.sort = '';

                this.school = '';


                let param =
                    {

                        faq: this.faq,

                        article: this.article,

                        event: this.event,

                        favourites: this.favourites,

                        search_text: this.search_text,

                        school: '',

                        city: '',

                        sort: '',

                    }

                eventBus.$emit('filterNews', param );


                this.showFilters = false;
            },


            sortData(){




            },
            filterType( type ) {


                if( type  === 'faq') {

                    this.faq =  1 - this.faq;
                }
                if( type  === 'article') {

                    this.article = 1  -  this.article;
                }
                if( type  === 'event') {

                    this.event = 1 - this.event;
                }
                if( type  === 'favourites') {

                    this.favourites = 1 - this.favourites;
                }



                this.filterData();


            },

            filterData() {

                let school_code = '';

                let city_code = '';

                if( typeof this.school !== 'undefined' &&  this.school !==  null  &&  this.school !==  '' ) {

                    school_code = this.school.code;
                }


                if( typeof  this.city !== 'undefined' &&  this.city !==  null  &&  this.city !==  '' ) {


                    city_code = this.city.code;

                }




                let param =
                    {

                        faq: this.faq,

                        article: this.article,

                        event: this.event,

                        favourites: this.favourites,

                        search_text: this.search_text,

                        school: school_code,

                        city: city_code,

                        sort: this.sort.code,

                    }

                eventBus.$emit('filterNews', param );





            },
            load_schools(){

                    axios.post( this.fullPath + 'schools/school_type_ahead', {} )
                        .then( res =>  {

                            res.data.data.forEach( school  => {

                                this.schoolModal.push({ code:school.name, label:school.name});
                            });


                        });

            },


            closeInvite(){

                this.closeSignBoard =  !this.closeSignBoard;

                lscache.set('showInviteNews', false );

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



</style>