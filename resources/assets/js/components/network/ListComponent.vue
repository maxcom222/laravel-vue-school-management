<template>

    <div class="network-listing" ref="school_listing">

        <div v-for="indexData in staffs">

            <div v-for="staff in indexData" :key="staff.id">

                <staff-component

                        :full-path="fullPath"



                        :staff="staff"  >

                </staff-component>

            </div>

        </div>

    </div>
</template>

<script>

    import StaffComponent from  './StaffComponent';

    import {eventBus} from '../../app.js';

    export default {

        name: "ListComponent",

        props:['fullPath'],

        components: {

            StaffComponent

        },
        
        props:['fullPath'],
        
        data(){



            return{


                reloadData: true,

                staffs: [],

                page : 0 ,

                userFollowing:  lscache.get('user_follower'),

                withParam:  {

                    teacher: 0,

                    parent: 0,

                    tutor: 0,

                    search_text: '',

                    school: '',

                    spec: '',
                }



            }

        },
        methods:{



            scroll () {

                window.onscroll = (event) => {

                    let scrollY      =  window.scrollY ;

                    let wh           =  window.innerHeight;

                    if(  typeof this.$refs.school_listing  !== 'undefined'  ){

                        let offsetTop    = this.$refs.school_listing.offsetTop;

                        let offsetH      = this.$refs.school_listing.offsetHeight;

                        if(scrollY >=  offsetTop +  offsetH  - wh && this.reloadData === true  ) {

                            this.page ++;

                            this.withParam.page = this.page;

                            this.withParam.scroll = 1;

                            this.ajaxLoadStaff( this.withParam );

                        }

                    }



                }
            },


            ajaxLoadStaff( withParam ) {


                this.reloadData         = false;

                if( withParam.scroll === 1 )
                {

                }
                else
                {
                    this.staffs  = [];
                }

                withParam.load_data = 1;


                axios.post( this.fullPath + 'network/get_staffs', withParam )

                    .then( res =>  {

                        console.log( res.data.result );

                        if( parseInt(   res.data.result ) === 1)
                        {
                            this.staffs.push( res.data.data );

                            this.reloadData = true;
                        }


                        // this.$emit('updateLoader', false);

                    });



            },

            searchData() {

                this.page = 0;

                let withParam = {'param':  this.filters, page:this.page };

                this.ajaxLoadStaff( withParam );

            },
            
            
            filterData( filter, sub_filter, i ) {

                parseInt(filter.data[i].status)   === 0 ? filter.data[i].status = 1  : filter.data[i].status = 0;

                this.page = 0;


                this.page = 0;

                withParam.page = this.page;

                this.ajaxLoadStaff( withParam );


            },



        },
        
        created()  {


            let withParam = { page: this.page };

            this.ajaxLoadStaff( withParam );

            eventBus.$on('filterStaff', (message) => {


                this.withParam = message ;

                this.page = 0;

                this.withParam.page = this.page;

                this.ajaxLoadStaff( this.withParam );


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




</style>