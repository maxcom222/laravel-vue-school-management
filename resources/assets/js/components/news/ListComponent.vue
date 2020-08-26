<template>

    <div class="network-listing" ref="school_listing">


        <ul class="users" v-if="showPostModule===false">

            <li>

                <a href="" @click.prevent="switchModule('article')" class="article-anchor">

                    <svg class="icon icon-article icon-top">

                        <use :xlink:href="icon_article">

                        </use>

                    </svg>


                    <span>Post Article</span>

                </a>

            </li>

            <li>

                <a href=""  @click.prevent="switchModule('question')" class="question-anchor">

                    <svg class="icon icon-question icon-top">

                        <use :xlink:href="icon_question">

                        </use>

                    </svg>


                    <span>Post Question</span>

                </a>

            </li>

            <li>

                <a href=""  @click.prevent="switchModule('event')" class="event-anchor">

                    <svg class="icon icon-event icon-top">

                        <use :xlink:href="icon_event">

                        </use>

                    </svg>


                    <span>Post Event</span>

                </a>

            </li>

        </ul>


        <p v-if="showPostModule===true">

            <a  style="font-size:2em"  @click.prevent="goBack" href="">

                <svg class="icon icon-back icon-top">

                    <use :xlink:href="icon_back">

                    </use>

                </svg>

                <span>Back</span>

            </a>
        </p>

        <post-article

                v-if="moduleEnabled==='article'"

                :full-path="fullPath"

        >


        </post-article>

        <post-question

                v-if="moduleEnabled==='question'"

                :full-path="fullPath"

        >


        </post-question>

        <post-event

                v-if="moduleEnabled==='event'"

                :full-path="fullPath"

        >


        </post-event>



        <div v-for="indexData in posts">

            <div v-for="post in indexData" :key="post.id">

                <post-component

                        :full-path="fullPath"



                        :post="post"  >

                </post-component>

            </div>

        </div>


    </div>

</template>

<script>





    import PostComponent from  './PostComponent';

    import PostArticle from  './PostArticle';

    import PostQuestion from  './PostQuestion';

    import PostEvent from  './PostEvent';



    import {eventBus} from '../../app.js';

    export default {

        name: "ListComponent",

        props:['fullPath'],

        components: {

            PostArticle,

            PostQuestion,

            PostEvent,

            PostComponent

        },
        

        data(){

            return{

                reloadData: true,

                posts: [],

                page : 0 ,

                userFollowing:  lscache.get('user_follower'),

                icon_male:  '',

                icon_question: this.fullPath + 'css/ico/symbol-defs.svg#icon-question',

                icon_like  : this.fullPath + 'css/ico/symbol-defs.svg#icon-thumb_up',

                icon_fav: this.fullPath + 'css/ico/symbol-defs.svg#icon-favorite',

                icon_share:   this.fullPath + 'css/ico/symbol-defs.svg#icon-share',

                icon_send: this.fullPath + 'css/ico/symbol-defs.svg#icon-send',

                icon_del: this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

                icon_edit: this.fullPath + 'css/ico/symbol-defs.svg#icon-edit',

                icon_article: this.fullPath + 'css/ico/symbol-defs.svg#icon-article',

                icon_event: this.fullPath + 'css/ico/symbol-defs.svg#icon-event',

                icon_question: this.fullPath + 'css/ico/symbol-defs.svg#icon-question',

                icon_back: this.fullPath + 'css/ico/symbol-defs.svg#icon-back',

                withParam:  {

                    faq: 0,

                    article: 0,

                    event: 0,

                    favourites: 0,

                    search_text: '',

                    school: '',

                    city: '',

                },

                showPostModule: false,

                moduleEnabled: '',

            }

        },
        methods:{

            switchModule( type ) {

                this.showPostModule =  true;

                this.moduleEnabled = type;

            },

            scroll () {

                window.onscroll = (event) => {

                    let scrollY      =  window.scrollY ;

                    let wh           =  window.innerHeight;

                    let offsetTop    = this.$refs.school_listing.offsetTop;

                    let offsetH      = this.$refs.school_listing.offsetHeight;

                    if(scrollY >=  offsetTop +  offsetH  - wh && this.reloadData === true  ) {

                        this.page ++;

                        this.withParam.page = this.page;

                        this.withParam.scroll = 1;

                        this.ajaxLoadNews( this.withParam );

                    }
                }
            },


            ajaxLoadNews( withParam ) {


                this.reloadData         = false;

                if( withParam.scroll === 1 )
                {

                }
                else
                {
                    this.posts  = [];
                }

                withParam.load_data = 1;

                axios.post( this.fullPath + 'news/get_posts', withParam )

                    .then( res =>  {



                        if( parseInt(   res.data.result ) === 1)
                        {
                            this.posts.push( res.data.data.post );

                            this.reloadData = true;
                        }

                        console.log( this.posts );



                    });

            },

            searchData() {

                this.page = 0;

                let withParam = {'param':  this.filters, page:this.page };

                this.ajaxLoadNews( withParam );

            },
            
            
            filterData( filter, sub_filter, i ) {

                parseInt(filter.data[i].status)   === 0 ? filter.data[i].status = 1  : filter.data[i].status = 0;

                this.page = 0;


                this.page = 0;

                withParam.page = this.page;

                this.ajaxLoadNews( withParam );

            },


            goBack( type ){

                this.moduleEnabled = false;

                this.showPostModule = false;

                if(  type ===  'post'){

                    let withParam = { page: this.page };

                    this.ajaxLoadNews( withParam );

                }

            }


        },
        
        created()  {


            let withParam = { page: this.page };

            this.ajaxLoadNews( withParam );

            Echo.channel( 'coffee.shop' )

                .listen('CoffeepostEvent', (e) => {


                    let withParam = { page: this.page };

                    this.ajaxLoadNews( withParam );

                });

            eventBus.$on('filterNews', (message) => {

                this.withParam = message ;

                this.page = 0;

                this.withParam.page = this.page;

                this.ajaxLoadNews( this.withParam );


            });

        },

        mounted() {

            this.scroll();


        }

    }
</script>

<style scoped>

    .network-listing{

        margin-top: 30px;

    }
    .feed{

         box-shadow: 0 1px 6px rgba(57,73,76,0.35);
    }


    .users li i {

        font-size: 4em;
    }


    .activity-active svg {
        color: #01ae79 !important;
        font-weight: bold;
    }
    .icon-top{ margin-top: 0; }

    .users .icon {
        font-size: 2em;
        color: #fff !important;
        position: relative;
        z-index: 1;
        -webkit-transition: 0.3s ease;
        transition: 0.3s ease;
        margin-top: 10px;
    }


    .users a:hover .icon{ color:#000 !important;  }
</style>