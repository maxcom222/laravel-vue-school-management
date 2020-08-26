<template>
<div>

                        <div class="form-group row">


                            <label for=""   class="col-12 col-form-label" >
                                Keyword
                            </label>

                            <form class="search col-12">

                                <input

                                        type="search" class="form-control" v-model="search_text"

                                        placeholder="Item name...">

                                <button class="btn" @click="filter_classifieds" type="button">
                                    <svg class="icon icon-search">

                                        <use :xlink:href="icon_search">

                                        </use>
                                    </svg>
                                </button>
                            </form>

                        </div>

                        <div class="form-group row ">

                            <label for="" class="col-12 col-form-label">Category</label>
                            <div class="col-12">


                                <v-select name="category"

                                          placeholder="Select Top Category"

                                          :close-on-select="true"

                                          @input="load_next_level($event,1)"

                                          v-model="model_category"

                                          :options="category"></v-select>


                            </div>

                        </div>



                        <div class="form-group row sub_cat" v-if="cat_level > 1">
                            <label for="" class="col-12 col-form-label">Sub Category</label>
                            <div class="col-12">

                                <v-select

                                        placeholder="Select Sub Category"

                                        :close-on-select="true"

                                        @input="load_next_level($event,2)"


                                        v-model="model_sub_category"

                                        :options="sub_category"></v-select>




                            </div>
                        </div>


                        <div class="form-group row level_3"    v-if="cat_level>2">
                            <label for="" class="col-12 col-form-label">Level 3 Category</label>
                            <div class="col-12">

                                <v-select   class="level_3"

                                            placeholder="Select Sub Category"

                                            :close-on-select="true"

                                            @input="load_next_level($event,3)"

                                            v-model="model_level_cat_3"

                                            :options="level_cat_3"></v-select>


                            </div>
                        </div>


                        <div class="form-group row level_4"   v-if="cat_level>3 ">
                            <label for="" class="col-12 col-form-label">Model</label>
                            <div class="col-12">


                                <v-select   class="level_3" ref="js_cars_modals"

                                            placeholder="Select Model"

                                            :close-on-select="true"

                                            @input="load_next_level($event,4)"

                                            v-model="model_level_cat_4"

                                            :options="level_cat_4"></v-select>

                            </div>
                        </div>

                        <div class="form-group row level_5"   v-if="cat_level>4">
                            <label for="" class="col-12 col-form-label">Year</label>
                            <div class="col-12">


                                <v-select   class="level_5" ref="js_year"

                                            :close-on-select="true"

                                            placeholder="Select year"

                                            @input="load_next_level($event,4)"


                                            v-model="years"

                                            :options="yearModal"></v-select>


                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="" class="col-12 col-form-label">Age</label>
                            <div class="col-12">

                                <v-select

                                        @input="filter_classifieds"
                                        v-model="age"
                                        :close-on-select="true"
                                        placeholder="Select age"

                                        :options="[

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


                        <div class="form-group row ">
                            <label for="" class="col-12 col-form-label">Usage</label>
                            <div class="col-12">
                                <v-select
                                        @input="filter_classifieds"
                                        :close-on-select="true"
                                        placeholder="Select usage"
                                        v-model="usage"


                                        :options="[{ code:1, label:'Still in original packaging'},
                        { code:2, label: 'Out of original packaging, but only used once'} ,
                        { code:3, label: 'Used only a few times'} ,
                        { code:4, label: 'Used an average amount, as frequently as would be expected'} ,
                        { code:5, label: 'Used an above average amount since purchased'} ]"

                                >


                                </v-select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-12 col-form-label">Condition</label>
                            <div class="col-12">

                                <v-select
                                        @input="filter_classifieds"
                                        :close-on-select="true"
                                        placeholder="Select condition"
                                        v-model="condition"

                                        :options="[
                        { code: 5, label:'Perfect inside and out'},
                        { code: 4, label:'Almost no noticeable problems or flaws'},
                        { code: 3, label:'A bit of wear and tear, but in good working condition'},
                        { code: 2, label:'Normal wear and tear for the age of the item, a few problems here and there'},
                        { code: 1, label:'Above average wear and tear.  The item may need a bit of repair to work properly'}]"


                                >

                                </v-select>



                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="" class="col-12 col-form-label">Warranty</label>
                            <div class="col-12">

                                <v-select

                                        @input="filter_classifieds"
                                        :close-on-select="true"
                                        placeholder="Select warranty"

                                        v-model="warranty"
                                        :options="[
                        {code:'Yes', label: 'Yes'  },
                        {code:'No', label: 'No'  },
                        {code:'Does not apply', label: 'Does not apply'  }

                        ]"
                                >


                                </v-select>



                            </div>
                        </div>

    <div class="form-group row">
        <div class="col-12">
            <a href="" @click="reset_filter" class="btn btn-primary reset-filters ">Reset Filters</a>
        </div>
    </div>



</div>








</template>

<script>






    export default {

       name:'FilterlistingComponent',


        props: ['fullPath' ],
        data() {

            return {

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
                search_text : '',
                level_3     : '',
                level_4     : '',

                icon_search: this.fullPath + 'css/ico/symbol-defs.svg#icon-search',




                yearModal: [],


            }



        },



        methods: {

            reset_filter(){


                    this.model_sub_category = '';

                    this.model_category =  '';

                    this.model_level_cat_3 = '';

                    this.model_level_cat_4 = '';

                    this.age          = '';

                    this.warranty     = '';

                    this.condition    = '';

                    this.usage        = '';

                    this.favourite    = '';

                    this.search_text  = '';

                    this.level_3      = '';

                    this.level_4      = '';

                    this.filter_classifieds();


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
                withParam.usage          = this.usage;
                withParam.warranty       = this.warranty;
                withParam.condition      = this.condition;
                withParam.age            = this.age;
                withParam.search_text    = this.search_text;
                withParam.favourite      = this.favourite;


                withParam.category      = this.model_category;
                withParam.sub_category  = this.model_sub_category;
                withParam.level_3       = this.model_level_cat_3;
                withParam.level_4       = this.model_level_cat_4;



                this.$parent.filter_classifieds( withParam );



                //this.$emit( 'filter_classifieds', this.withParam );

            }


        },

        created()  {

             this.get_cats(  );

        },
        mounted() {

        }



    }


</script>



<style scoped>





</style>
