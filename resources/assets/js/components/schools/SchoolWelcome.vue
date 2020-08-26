<template>
    <div>

        <div class="frame" id="welcome">

            <h2>Welcome</h2>

            <div class="short-desc" v-if="!showLongText">

                {{ short_desc() }}

            </div>
            <div class="long-desc"

                 v-if="showLongText"

                 v-html="desc()"

            >



            </div>

            <p class="text-center more-text">

                <a v-if="!showLongText" @click.prevent="scrollTo('more')" href="" ><span>More </span>

                       <svg class="icon icon-arrow_downward2">
                        <use :xlink:href="icon_downward"></use>
                    </svg>
                </a>

                <a v-if="showLongText"  @click.prevent="scrollTo('less')"  href="" ><span>Less </span>
                    <svg class="icon icon-arrow_up">
                        <use :xlink:href="icon_upward"></use>
                    </svg>

                </a>

            </p>



        </div>



    </div>
</template>

<script>

    var VueScrollTo = require('vue-scrollto');


    export default {

        name: "SchoolWelcome",

        props:['fullPath', 'schoolProfile'],

        data(){


            return{

                showLongText: false,

                icon_downward: this.fullPath + 'css/ico/symbol-defs.svg#icon-arrow_downward2',

                icon_upward: this.fullPath + 'css/ico/symbol-defs.svg#icon-arrow_up',


            }
        },

        methods:{


            scrollTo( m ){

                this.showLongText=!  this.showLongText;

                if( m ===  'more'){

                    VueScrollTo.scrollTo( '#video' , 400)

                }  else {

                    VueScrollTo.scrollTo( '#welcome' , 400)
                }



            },


            stripHtml(  html ) {

                var temporalDivElement = document.createElement("div");

                temporalDivElement.innerHTML = html;

                return temporalDivElement.textContent || temporalDivElement.innerText || "";
            },

            short_desc(){

                let  desc  =  this.stripHtml( this.schoolProfile.description  );

                return desc.substr(0, 300) ;

            },

            desc(){

                return this.schoolProfile.description;
            }
        }
    }
</script>

<style scoped>

</style>