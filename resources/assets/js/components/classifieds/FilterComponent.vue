<template>

    <div id="searchBox" class="searchBox ">

        <div class="row  row-header">

            <div  class="col-12"><h2 >Find exactly what you are looking for</h2>


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

                    <button class="btn" @click="filter_classifieds" type="button">

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

                <v-select

                        @input="filter_classifieds"
                        v-model="age"
                        :close-on-select="true"
                        placeholder="Select age"

                        :options="[

                        {code:'', label: 'Any'  },

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

        <transition name="slide">


            <div class="row row-header" v-if="showFilters">


                <div class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 id="filterHead" class="filter-header"> Category </h2>

                    <v-select name="category"

                              placeholder="Select Top Category"

                              :close-on-select="true"

                              @input="load_next_level($event,1)"

                              v-model="model_category"

                              :options="category"></v-select>

                </div>

                <div v-if="cat_level > 1" class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header">Sub category </h2>

                    <v-select

                            placeholder="Select Sub Category"

                            :close-on-select="true"

                            @input="load_next_level($event,2)"


                            v-model="model_sub_category"

                            :options="sub_category"></v-select>

                </div>

                <div  v-if="cat_level > 2" class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header">Level 3 category </h2>

                    <v-select   class="level_3"

                                placeholder="Select level3 Category"

                                :close-on-select="true"

                                @input="load_next_level($event,3)"

                                v-model="model_level_cat_3"

                                :options="level_cat_3"></v-select>

                </div>


                <div  v-if="cat_level>3 " class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header">Car Model </h2>

                    <v-select   class="level_3" ref="js_cars_modals"

                                placeholder="Select Model"

                                :close-on-select="true"

                                @input="load_next_level($event,4)"

                                v-model="model_level_cat_4"

                                :options="level_cat_4"></v-select>

                </div>

                <div  v-if="cat_level>4 " class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header">Year </h2>



                <v-select   class="level_5" ref="js_year"

                            :close-on-select="true"

                            placeholder="Select year"

                            @input="load_next_level($event,4)"


                            v-model="years"

                            :options="yearModal"></v-select>

                </div>














                <div class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header"> Usage </h2>

                    <v-select
                            @input="filter_classifieds"
                            :close-on-select="true"
                            placeholder="Select usage"
                            v-model="usage"


                            :options="[

                            {code:'', label: 'Any'  },
                            { code:1, label:'Still in original packaging'},
                        { code:2, label: 'Out of original packaging, but only used once'} ,
                        { code:3, label: 'Used only a few times'} ,
                        { code:4, label: 'Used an average amount, as frequently as would be expected'} ,
                        { code:5, label: 'Used an above average amount since purchased'} ]"

                    >


                    </v-select>

                </div>


                <div class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header"> Condition </h2>

                    <v-select
                            @input="filter_classifieds"
                            :close-on-select="true"
                            placeholder="Select condition"
                            v-model="condition"

                            :options="[
                            {code:'', label: 'Any'  },
                        { code: 5, label:'Perfect inside and out'},
                        { code: 4, label:'Almost no noticeable problems or flaws'},
                        { code: 3, label:'A bit of wear and tear, but in good working condition'},
                        { code: 2, label:'Normal wear and tear for the age of the item, a few problems here and there'},
                        { code: 1, label:'Above average wear and tear.  The item may need a bit of repair to work properly'}]"


                    >

                    </v-select>

                </div>


                <div class="col-12  mg-bottom-col-10   col-md-4">

                    <h2 class="filter-header"> Warranty </h2>

                    <v-select

                            @input="filter_classifieds"
                            :close-on-select="true"
                            placeholder="Select warranty"

                            v-model="warranty"
                            :options="[ {code:'', label: 'Any'  },
                        {code:'Yes', label: 'Yes'  },
                        {code:'No', label: 'No'  },
                        {code:'Does not apply', label: 'Does not apply'  }

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


        name: "FilterComponent",

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

                post_url: this.fullPath +  'classifieds/post',

                cat_level: 1,

                model_sub_category: '',
                model_category: '',
                model_level_cat_3:'',
                model_level_cat_4:'',
                dialog_msg: '',


                category: [],
                sub_category:[],
                level_cat_4:[],
                level_cat_3: [],


                age         : '',
                warranty    : '',
                condition   : '',
                usage       :  '',
                favourite   : '',

                level_3     : '',
                level_4     : '',

                closeSignBoard: false,





                yearModal: [],

                showFilters: false,



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


                this.model_sub_category = {code: ''};

                this.model_category =  {code: ''};

                this.model_level_cat_3 = {code: ''};

                this.model_level_cat_4 = {code: ''};

                this.age          = {code: ''};

                this.warranty     = {code: ''};

                this.condition    = {code: ''};

                this.usage        = {code: ''};

                this.favourite    = '';

                this.search_text  = '';

                this.level_3      = '';

                this.level_4      = '';

                this.filter_classifieds();


            },



            filterData( filter, sub_filter, i ) {


                parseInt(filter.data[i].status)   === 0 ? filter.data[i].status = 1  : filter.data[i].status = 0;

                this.page = 0;

                let withParam = {'param':  this.filters, school: this.school, area: this.selected_area, page:this.page };

                this.$parent.ajaxLoadSchool( withParam );

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



                this.filter_classifieds();

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

            filter_classifieds() {

                let withParam            = {};
                withParam.usage          = this.usage.label;
                withParam.warranty       = this.warranty.code;
                withParam.condition      = this.condition.label;
                withParam.age            = this.age.label;
                withParam.search_text    = this.search_text;
                withParam.favourite      = this.favourite;


                withParam.category      = this.model_category.code;
                withParam.sub_category  = this.model_sub_category.code;
                withParam.level_3       = this.model_level_cat_3.code;
                withParam.level_4       = this.model_level_cat_4.code;



                this.$parent.filter_classifieds( withParam );



                //this.$emit( 'filter_classifieds', this.withParam );

            },



            closeInvite(){

                this.closeSignBoard =  !this.closeSignBoard;

                lscache.set('showInviteNews', false );

            },




        },

        created() {

            this.get_cats(  );
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

        margin-bottom:20px;
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