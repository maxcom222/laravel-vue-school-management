<template>
<div>


    <main class="schools">




        <div class="container">

            <div class="row js_data_container">


                <div ref="school_listing" class="col-12 col-md-8  col-right" >

                    <filters

                            :full-path="fullPath"
                    >


                    </filters>


                    <div v-if="showSchoolLoader" class="loader" > <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>


                    <div class="map_container" v-if="showMap">

                        <a @click.prevent="showListing" href="" class="btn btn-sm  d-listing btn-primary">

                            View Listing

                        </a>

                        <div class="map_pop" v-if="showPopup">

                            <a class="close_map_box d-none" href="">

                                cancel

                            </a>

                            <div class="map_image"

                                 style="background-repeat: no-repeat;  background-position:0 0; "

                                 v-bind:style="{'background-image': 'url(' + markerPop.image + ')' }"


                            >

                            </div>
                            <div class="map_text">

                                <h2>{{ markerPop.name }}</h2>

                                <p class="rating">Rating: {{ markerPop.rating  }}</p>

                                <p class="address">{{ markerPop.address }}</p>

                            </div>

                            <div class="map_address">

                                <a href="" class="btn " @click.prevent="showPopup = !showPopup"
                                   style="float:  left;"
                                >
                                    Close
                                </a>

                                <a :href="markerPop.url" target="_blank" class="btn btn-outline-secondary">
                                    View

                                </a>

                            </div>

                        </div>




                        <div ref="mapgraphic" id="map-graphic" style="height:500px;"></div>

                    </div>


                    <div v-if="!showMap">
                        <div v-for="indexData in schools">

                            <div v-for="school in indexData" :key="school.id">

                                <item-component  :full-path="fullPath" :user-following="userFollowing" :school="school"  >

                                </item-component>
                            </div>

                        </div>

                    </div>



                </div>

                <div class="col-12 col-md-3 close-map">

                    <div class="map">

                        <img src="https://maps.googleapis.com/maps/api/staticmap?center=Dubai&zoom=13&size=637x440&maptype=roadmap&markers=color:red%7Clabel:S%7C25.135958,55.196242&key=AIzaSyB_O3eana1MbjibnAWKwIg7cPCHXQ-8fN4" class="img-fluid" alt="google map">

                        <p><a href="" @click.prevent="createMap">Map View</a></p>

                    </div>

                </div>


            </div>

        </div>





    </main>



</div>









</template>

<script>

    import ItemComponent from './ItemComponent'

    import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';

    import filters from './filters'



    export default {

        components: {

            ItemComponent,

            VueBootstrapTypeahead,

            filters

        },

        props: [],
        data() {

            return {

                schools: [],

                window_width: window.innerWidth,

                bottomOfWindow : false,

                page : 0,

                reloadData: false,

                showMap: false,

                markers: [],

                query:'',

                center: {
                    lat: 10.0,
                    lng: 10.0
                },

                areas : [],

                markerPop: {},

                typeahead: [],

                showPopup:false,

                openSub: null,

                sidebar: 'd-none',

                lead_trail : 'trv-sidebar__content--trailing',

                style_sidebar: 0,

                userFollowing :  lscache.get('user_follower'),

                icon_square_o: this.fullPath +  'js/plugins/menu/symbol-defs.svg#icon-square-o',

                icon_check_square_o: this.fullPath +  'js/plugins/menu/symbol-defs.svg#icon-check-square-o',

                showSchoolLoader: true,

                fullPath: '',

                school: '',



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
        watch: {

            scrolledToBottom( value ) {

                if( value ===  true) {

                    console.log( value + 'scrolledToBottom');

                }
            }

        },

        computed:{



        },
        methods: {

            ajaxLoadSchool( withParam ) {


                this.reloadData         = false;

                if( withParam.scroll === 1 )
                {
                    withParam.page =  this.page;

                }
                else
                {
                    this.schools  = [];

                    this.page = withParam.page;
                }

                this.school = withParam.school;

                console.log( withParam  );
                this.showSchoolLoader = true;
                axios.post( this.fullPath + 'get_schools', withParam )
                    .then( res =>  {

                        if( parseInt(   res.data.result ) === 1)
                        {
                            this.schools.push( res.data.data );
                            this.reloadData = true;
                        }

                        this.showSchoolLoader = false;

                        // this.$emit('updateLoader', false);

                    });



            },


            url( school_url ) {

                return this.fullPath +  'school/' + school_url;
            },
            logo( image )  {

                return 'https://d2heijv3bffmsx.cloudfront.net/' + image;
            },
            showListing() {

                this.showMap  = false;
            },

            create_pos(lat, lng) {

               return  new google.maps.LatLng(lat, lng);
            },




            assignPop( item_number ) {


                this.markerPop.image             = this.logo( item_number.logo );
                this.markerPop.id                = item_number.id;
                this.markerPop.address           = item_number.address;
                this.markerPop.name              = item_number.name;
                this.markerPop.rating            = item_number.rating;
                this.markerPop.url               = this.url( item_number.url );
                this.markerPop.followers         = item_number.followers;

            },

            createMap() {

                this.showMap  = true;

                setTimeout( () => {

                    let lat = this.schools[0][0].latitude;

                    let lng = this.schools[0][0].longitude;

                    let map_options = { zoom: 10,

                        center: new google.maps.LatLng(lat, lng),

                        scaleControl: true,

                        mapTypeId: google.maps.MapTypeId.ROADMAP,

                        icon: this.fullPath + '/css/img/marker.png',

                        zoomControlOptions: {position: google.maps.ControlPosition.LEFT_CENTER},

                        mapTypeControlOptions: { mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']}
                    }



                    let map = new google.maps.Map( document.getElementById('map-graphic'), map_options  );

                    let marker = new google.maps.Marker({ map: map, superElement:this, item_number:this.schools[0][0], draggable: true,position:  new google.maps.LatLng(lat, lng),visible: true,icon: map_ico,});

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

                this.schools.forEach( (indexSchool,index) =>  {

                    indexSchool.forEach( (school, index2) => {

                        let lat = school.latitude;

                        let lng = school.longitude;

                        let marker = new google.maps.Marker({ map: map, superElement:this, item_number:this.schools[index][index2], draggable: true,position:  new google.maps.LatLng(lat, lng),visible: true,icon: map_ico,});

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

            school_type_ahead() {

                axios.post( this.fullPath + 'schools/school_type_ahead', {} )
                    .then( res =>  {

                        res.data.data.forEach( school  => {

                            this.typeahead.push( school.name );
                        });


                    });

            },


            scroll () {

                window.onscroll = (event) => {


                    if(this.showMap === true ){

                        return;
                    }



                    let scrollY      =  window.scrollY ;
                    let wh           =  window.innerHeight;

                    if( typeof this.$refs.school_listing !== 'undefined' ){


                        let offsetTop    = this.$refs.school_listing.offsetTop;
                        let offsetH      = this.$refs.school_listing.offsetHeight;

                        if(scrollY >=  offsetTop +  offsetH  - wh && this.reloadData == true  ) {

                            this.page ++;

                            let withParam = {'param':  this.filters, school: this.school,  page:this.page, scroll:1  };

                            this.ajaxLoadSchool( withParam );



                        }

                    }


                }
            },


        },
        created()  {

            this.fullPath = this.$parent.fullPath;

            let withParam = { page: this.page };

            this.ajaxLoadSchool( withParam );


        },
        mounted() {

            this.scroll();

            this.showSchoolLoader = false;



        }



    }





</script>

<style scoped>

    .accordion .submenu {
        cursor: pointer;
        display: block;}

    .trv-sidebar__content
    {
        overflow-y:scroll;
    }
    @media (max-width: 980px)
    {
        .input-group-append{
            height: 38px; margin-top: 10px;width:10% !important;
        }
        .input-group > div {

            width:79%;
        }


    }

    </style>