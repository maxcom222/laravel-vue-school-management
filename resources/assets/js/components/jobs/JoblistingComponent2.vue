<template>
<div>


    <div v-if="showLoader" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>



    <search-component :full-path="fullPath">

    </search-component>

    <main class="job_list">

        <div class="only-mobile">

            <div class="text-center mg-bottom-20">

                <button class="btn btn-sm  js_slide_j_filters btn-primary" type="button"><span class="glyphicon  glyphicon-filter"></span>  Filters</button>

                <a class="btn btn-sm  js_show_map_job btn-primary" type="button"><span class="glyphicon  glyphicon glyphicon-map-marker"></span> Map</a>

            </div>

        </div>

        <div class="container">

            <div class="row">

                <div class="col-12 col-md-3 col-left">

                    <div class="frame cafe-sort desktop-filters accordion filters ">

                        <h2>Filters</h2>

                        <filter-component

                                :full-path="fullPath"

                        >

                        </filter-component>

                    </div>

                </div>


                <div ref="js_job_listing" class="col-12 col-md-6    col-right">


                    <div
                            v-if="!showMap"
                            v-for="jobindex in job_list"
                            :key="jobindex.id + Math.random()"
                         >
                        <div

                                v-for="jobItem in jobindex"
                                :key="jobItem.id + Math.random()"
                        >



                            <jobitem-component


                                :full-path="fullPath"

                                :jobItem="jobItem"
                            >

                            </jobitem-component>


                        </div>


                    </div>




                    <transition
                            enter-active-class="fadeIn"
                            leave-active-class="fadeOut"

                    >




                        <div class="map_container" v-if="showMap">
                            <a @click.prevent="showMap=!showMap" href="" class="btn btn-sm  d-listing btn-primary">
                                View Listing
                            </a>

                            <div class="map_pop" v-if="showPopup">
                                <a class="close_map_box d-none" href="">
                                    cancel
                                </a>
                                <div class="map_image"

                                     style="background-repeat: no-repeat;  background-position:0 0; "

                                     v-bind:style="{'background-image': 'url(' + markerPop.image + ')' }"


                                ></div>
                                <div class="map_text">
                                    <h2>{{ markerPop.name }}</h2>
                                    <p class="rating">{{ markerPop.text  }}</p>
                                    <p class="address">{{ markerPop.address }}</p>
                                </div>
                                <div class="map_address">
                                    <a href="" class="btn " @click.prevent="showPopup = !showPopup"
                                       style="float:  left;"
                                    >
                                        Close
                                    </a>
                                    <a :href="markerPop.url" target="_blank" class="btn btn-outline-secondary">
                                        Apply
                                    </a>
                                </div>
                            </div>




                            <div ref="mapgraphic" id="map-graphic" style="height:500px;"></div>

                        </div>

                    </transition>














                </div>



                <div class="col-12 close-map-job  col-md-3">

                    <div class="map"> <img :src="map_png" class="img-fluid" alt="View Map">

                        <p><a href="" @click.prevent="createMap" class="">Map View</a></p>


                    </div>

                </div>

            </div>

        </div>
    </main>



</div>








</template>

<script>



    var VueScrollTo = require('vue-scrollto');

    import JobitemComponent from './JobitemComponent.vue';

    import FilterComponent from './FilterComponent.vue';

    import SearchComponent from './SearchComponent.vue';

    import moment from 'moment';

    require('vue2-animate/dist/vue2-animate.min.css');



    export default {

        components: {


            JobitemComponent,

            FilterComponent,

            SearchComponent,




        },




        props: ['fullPath' ],
        data() {

            return {

                showLoader:true,

                page_on: 'detail',

                about_url: this.fullPath + 'about',

                help_url: this.fullPath + 'help',

                privacy_url: this.fullPath + 'privacy',

                terms_url: this.fullPath + 'terms',

                map_png:  this.fullPath + 'css/img/map.png',

                post_ad_url: this.fullPath + 'classifieds/post',

                showMap: false,

                current_date: new Date().getFullYear(),

                reloadData: false,

                adPostModal: false,

                loader: true,

                job_list: [],

                params: {},

                markerPop: [],

                showPopup:false,

                progressWidth: 0,

                openSub: null,

                sidebar: 'd-none',

                lead_trail : 'trv-sidebar__content--trailing',

                style_sidebar: 0,

                dialogWithFooter: false,

                userFollowing :  lscache.get('user_follower'),

                icon_square_o: this.fullPath +  'js/plugins/menu/symbol-defs.svg#icon-square-o',

                icon_check_square_o: this.fullPath +  'js/plugins/menu/symbol-defs.svg#icon-check-square-o',

                adFlagModal: false,


            }


        },

        computed: {




        },
        watch:{


        },
        methods: {

            formate_date (date){

                return moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY');


            },

            url( url, school_url ){

              return this.fullPath + 'jobs/' + school_url + '/' + url;
            },

            logo( logo_image )  {

                return 'https://d2heijv3bffmsx.cloudfront.net/' + logo_image;
            },


            scrollTo(){



                VueScrollTo.scrollTo('body', 300)

            },

            assignPop( item_number ) {


                this.markerPop.image             = this.logo( item_number.logo );

                this.markerPop.id                = item_number.id;

                this.markerPop.address           = item_number.address;

                this.markerPop.name              = item_number.title;

                this.markerPop.text              = item_number.school_name;

                this.markerPop.url               = this.url( item_number.url, item_number.school_url );

                this.markerPop.followers         = '';

            },

            createMap() {

                this.showMap  = true;

                setTimeout( () => {

                    let lat = this.job_list[0][0].latitude;

                    let lng = this.job_list[0][0].longitude;

                    let map_options = { zoom: 10,

                        center: new google.maps.LatLng(lat, lng),

                        scaleControl: true,

                        mapTypeId: google.maps.MapTypeId.ROADMAP,

                        icon: map_ico ,

                        zoomControlOptions: {position: google.maps.ControlPosition.LEFT_CENTER},

                        mapTypeControlOptions: { mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']}
                    }

                    let map = new google.maps.Map( document.getElementById('map-graphic'), map_options  );

                    let marker = new google.maps.Marker({ map: map, superElement:this, item_number:this.job_list[0][0], draggable: true,position:  new google.maps.LatLng(lat, lng),visible: true,icon: map_ico,});

                    marker.setMap(map);

                    if( window.width > 768 )
                    {
                        new google.maps.event.trigger( marker, 'click' );
                    }


                    google.maps.event.addListener(marker, 'click', function(e)
                    {
                        let item_number     = this.item_number;

                        let superElement    = this.superElement;

                        superElement.assignPop(item_number);

                        superElement.showPopup = true;

                    });

                    this.otherMarkers( map );

                }, 400);




            },

            otherMarkers( map ) {

                this.job_list.forEach( (indexSchool,index) =>  {

                    indexSchool.forEach( (job, index2) => {

                        let lat = job.latitude;

                        let lng = job.longitude;

                        let marker = new google.maps.Marker({ map: map, superElement:this, item_number:this.job_list[index][index2], draggable: true,position:  new google.maps.LatLng(lat, lng),visible: true,icon: map_ico,});

                        let overlay = new google.maps.OverlayView();

                        overlay.draw = function () {};

                        overlay.setMap(map);

                        google.maps.event.addListener(marker, 'click', function (e)
                        {
                            let item_number     = this.item_number;

                            let superElement    = this.superElement;

                            superElement.assignPop(item_number);

                            superElement.showPopup = true;

                        });


                    });


                });



            },


            filter_jobs(withParam) {


                this.params = withParam;

                this.params.page = 0;

                this.ajaxLoadJobs( withParam );


            },

            ajaxLoadJobs( withParam ) {


                this.reloadData         = false;

                if( withParam.scroll === 1 ) {




                }
                else
                {
                    this.job_list  = [];
                }

                    withParam.search_text = this.params.search_text;

                    withParam.salary_band = this.params.salary_band;

                    withParam.department = this.params.department;

                    withParam.gender = this.params.gender;

                    withParam.contract_type = this.params.contract_type;

                    withParam.city = this.params.city;

                    withParam.benefits = this.params.benefits;

                    withParam.position = this.params.position;

                    withParam.page      = this.params.page;

                    withParam.school      = this.params.school;





                axios.post( this.fullPath + 'list_jobs/post', withParam )
                    .then( res =>  {

                        this.showLoader = false;

                        if( parseInt(   res.data.result ) === 1)
                        {
                            this.job_list.push( res.data.data ) ;

                            this.reloadData = true;
                        }

                    });



            },

            scroll () {

                window.onscroll = (event) => {



                    let scrollY      =  window.scrollY ;
                    let wh           =  window.innerHeight;
                    let offsetTop    = this.$refs.js_job_listing.offsetTop;
                    let offsetH      = this.$refs.js_job_listing.offsetHeight;

                    if(scrollY >=  offsetTop +  offsetH  - wh && this.reloadData === true  ) {



                        this.params.page ++;

                        this.params.scroll = 1;

                        this.ajaxLoadJobs( this.params );



                    }
                }
            },






        },

        created()  {


            setTimeout(() => {

                this.loader = false;
            }, 200)



        },
        mounted() {

                this.params =
                            {
                                search_text: '',

                                salary_band:   '',

                                department: '',

                                gender:'',

                                contract_type:'',

                                city:'',

                                benefits:  '',

                                position: '',

                                page: 0,

                            };

                this.ajaxLoadJobs( this.params );

                this.scroll();

        }



    }


</script>



<style scoped>


    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }



</style>
