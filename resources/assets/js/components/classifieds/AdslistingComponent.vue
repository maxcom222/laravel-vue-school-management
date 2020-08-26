<template>
<div>

    <div class="loader"  :class="loader===true? '': 'd-none' "> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>

    <main class="two-cloumn ads-live">

        <div class="only-mobile">

            <div class="text-center mg-bottom-20">

                <button class="btn btn-sm  js_slide_c_filters btn-primary" type="button"><span class="glyphicon  glyphicon-filter"></span>  Filters</button>

                <a class="btn btn-sm  js_show_map_ads btn-primary" type="button"><span class="glyphicon  glyphicon glyphicon-map-marker"></span> Map</a>

            </div>

        </div>

        <div class="container">


            <div class="row">




                <div class="col-12 col-md-8">

                <filter-component :full-path="fullPath">


                </filter-component>


                    <div class="row mg-bottom-20">

                        <div class="col-12 text-right">

                            <a :href="post_ad_url" @click.prevent="postAdUrl" class="btn btn-primary js_post_ad">Post your Ad</a>

                        </div>

                    </div>

                    <div ref="js_ads_listing">


                        <transition
                                enter-active-class="fadeIn"
                                leave-active-class="fadeOut"

                        >


                            <div v-if="!showMap">



                                <div


                                        v-for="(ad_item,index) in all_ads"

                                        :key="index"
                                >




                                    <aditem-component


                                            :full-path="fullPath"

                                            :ad_item="ad_item"

                                            :page_on="page_on"

                                    ></aditem-component>


                                </div>


                            </div>



                        </transition>


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
                                            Send a Message
                                        </a>
                                    </div>
                                </div>




                                <div ref="mapgraphic" id="map-graphic" style="height:500px;"></div>

                            </div>

                        </transition>






                    </div>


                </div>

                <div class="col-12 col-md-3 close-map col-right">

                    <div class="map">

                        <img :src="map_png" class="img-fluid" alt="">

                        <p><a href="" @click.prevent="createMap" class="">Map View</a></p>

                    </div>

                    <div class="frame recommendations ">

                        <div class="footer">

                            <a :href="about_url">About</a> <span>·</span>

                            <a :href="help_url">Help Center</a> <span>·</span>

                            <a :href="privacy_url">Privacy Policy</a> <span>·</span>

                            <a :href="terms_url">Term &amp; Conditions</a> <span>·</span>

                            <small>© {{  current_date    }} All Rights Reserved.</small>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </main>


    <div v-if="adPostModal">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">

                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="uiContactLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uiContactLabel">Flag an item</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                </div>
                                <div class="modal-body">
                                    <p class="lead">Provide as much information you can.</p>
                                    <div class="form-group  row">
                                        <label for="" class="col-12 col-form-label">Ad title</label>
                                        <div class="col-12">
                                            <input type="text" value=""  class="form-control" id="report_ad_title" readonly="readonly" >
                                            <input type="hidden" id="report_ad_id" />
                                        </div>
                                    </div>

                                    <div class="form-group  row">
                                        <label for="" class="col-12 col-form-label">Describe why this ad is inappropriate</label>
                                        <div class="col-12">
                                            <textarea style="height:200px;" class="form-control" id="report_reason"></textarea>
                                        </div>
                                    </div>




                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default modal-btn" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-default modal-btn ">Submit Report</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </transition>
    </div>




</div>








</template>

<script>



    var VueScrollTo = require('vue-scrollto');

    import AditemComponent from './AditemComponent.vue';

    import FilterComponent from './FilterComponent.vue';

    import moment from 'moment';

    require('vue2-animate/dist/vue2-animate.min.css');



    export default {

        name: 'AdslistingComponent',

        components: {


            AditemComponent,

            FilterComponent,




        },




        props: [],
        data() {

            return {

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

                all_ads: [],

                params: {},

                fullPath: '',

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

            postAdUrl(){

              this.$router.push('classifieds/post');

            },
            formate_date (date){

                return moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY');


            },

            url( url ){

              return this.fullPath + 'classifieds/' + url;
            },


            scrollTo(){



                VueScrollTo.scrollTo('body', 300)

            },

            assignPop( item_number ) {


                this.markerPop.image             = '';//this.logo( item_number.logo );

                this.markerPop.id                = item_number.id;

                this.markerPop.address           = item_number.address;

                this.markerPop.name              = item_number.title;

                this.markerPop.text              = item_number.text;

                this.markerPop.url               = this.url( item_number.url );

                this.markerPop.followers         = '';

            },

            createMap() {

                this.showMap  = true;

                setTimeout( () => {

                    let lat = this.all_ads[0].latitude;

                    let lng = this.all_ads[0].longitude;

                    let map_options = { zoom: 10,

                        center: new google.maps.LatLng(lat, lng),

                        scaleControl: true,

                        mapTypeId: google.maps.MapTypeId.ROADMAP,

                        icon: map_ico ,

                        zoomControlOptions: {position: google.maps.ControlPosition.LEFT_CENTER},

                        mapTypeControlOptions: { mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']}
                    }

                    let map = new google.maps.Map( document.getElementById('map-graphic'), map_options  );

                    let marker = new google.maps.Marker({ map: map, superElement:this, item_number:this.all_ads[0], draggable: true,position:  new google.maps.LatLng(lat, lng),visible: true,icon: map_ico,});

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

                this.all_ads.forEach( (ad_item_lo,index) =>  {


                        let lat = ad_item_lo.latitude;

                        let lng = ad_item_lo.longitude;

                        let marker = new google.maps.Marker({ map: map, superElement:this, item_number:this.all_ads[index], draggable: true,position:  new google.maps.LatLng(lat, lng),visible: true,icon: map_ico,});

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




            },


            filter_classifieds(withParam) {


                this.params = withParam;

                this.params.page = 0;

                this.ajaxLoadAds( withParam );


            },

            ajaxLoadAds( withParam ) {


                this.reloadData         = false;

                if( withParam.scroll === 1 ) {


                }
                else
                {
                    this.all_ads  = [];
                }

                withParam.usage          = this.params.usage;

                withParam.warranty       = this.params.warranty;

                withParam.condition      = this.params.condition;

                withParam.age            = this.params.age;

                withParam.search_text    = this.params.search_text;

                withParam.favourite      = this.params.favourite;

                withParam.category       = this.params.category;

                withParam.sub_category   = this.params.sub_category;

                withParam.level_3        = this.params.level_3;

                withParam.level_4        = this.params.level_4;

                withParam.page           = this.params.page;




                axios.post( this.fullPath + 'list_ads/get', withParam )
                    .then( res =>  {

                        console.log( res.data.result );

                        if( parseInt(   res.data.result ) === 1)
                        {
                            this.all_ads =  res.data.data ;
                            this.reloadData = true;
                        }

                    });



            },

            scroll () {

                window.onscroll = (event) => {



                    let scrollY      =  window.scrollY ;
                    let wh           =  window.innerHeight;
                    let offsetTop    = this.$refs.js_ads_listing.offsetTop;
                    let offsetH      = this.$refs.js_ads_listing.offsetHeight;

                    if(scrollY >=  offsetTop +  offsetH  - wh && this.reloadData === true  ) {

                        this.page ++;

                        this.params.page ++;

                        this.params.scroll = 1;

                        this.ajaxLoadAds( this.params );



                    }
                }
            },






        },
        beforeCreate(){

            this.fullPath = this.$parent.fullPath;

            console.log( this.fullPath );

        },

        created()  {



            setTimeout(() => {

                this.loader = false;
            }, 200)



        },
        mounted() {

                this.params =
                            {
                                usage : '',
                                warranty : '',
                                condition: '',
                                age: '',
                                search_text: '',
                                favourite : '',
                                category: '',
                                sub_category:'',
                                level_3: '',
                                level_4: '',
                                page: 0,
                            };

                this.ajaxLoadAds( this.params );

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
