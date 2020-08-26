<template>


<div>

    <div v-if="loader" class="loader"> <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>


    <main   v-if="loader === false " class="two-cloumn">

        <div class="container">

            <div class="row">

                <div class="col-12 col-md-3 col-left">

                    <div class="map">

                        <img :src="map_url()" class="img-fluid" alt="google map">

                        <p><strong>Location</strong>{{ result.address }}</p>

                        <p><a href="https://www.google.com/maps/dir/?api=1&origin=<?php echo str_replace(' ','+', $result -> address  );?>" target="_blank">Get Directions</a></p>

                    </div>

                </div>

                <div class="col-12 col-md-6">

                    <div class="feed ad">

                        <a href="" class="dp"><img :src="profile_photo()" :alt="result.first_name + '  '+ result.last_name "></a>

                        <div>

                            <a href="" class="publisher">{{ result.first_name  }} {{ result.last_name  }}</a>

                            <span class="text-muted"> posted</span>

                            <h2><a href="">{{ result.title  }}</a></h2>

                            <span class="text-muted">in</span> <span class="posted-in">{{ result.text  }}</span>

                            <small class="text-muted">{{ result.dated  }}</small>

                        </div>

                        <p>{{ result.description  }}</p>

                        <div class="item-detail">

                            <p><strong>Age</strong> <span>{{ result.ages  }}</span></p>

                            <p><strong>Usage</strong> <span>{{ result.usage  }}</span></p>

                            <p><strong>Condition</strong> <span>{{ result.conditions  }}</span></p>

                            <p><strong>Warranty</strong> <span>{{ result.warranty  }}</span></p>

                        </div>

                        <a href="" class="featured"><img :src="coverImage" alt="" class="img-fluid"></a>

                    </div>



                    <adreply-component

                            v-if="loader===false"

                            :ad-item="result"

                            :full-path="fullPath">

                    </adreply-component>



                </div>


                <div class="col-12 col-md-3 col-right">

                    <detailside-component

                            v-if="loader===false"

                            :ad-item="result"

                            :full-path="fullPath">

                        >
                    </detailside-component>



                </div>
            </div>

        </div>
    </main>










</div>

</template>

<script>

    import AdreplyComponent  from  './AdreplyComponent';

    import DetailsideComponent  from  './DetailsideComponent';




    export default {

        name: "DetailComponent",

        props:['fullPath'],

        components:{

            DetailsideComponent,

            AdreplyComponent

        },

        data(){


            return {

                result: '',

                adFlagModal: false,

                report_submitted: 0,

                submit_report_progress: 0,

                report_reason: '',

                showPhone: false,

                loader: true,

                icon_fav:this.fullPath + 'css/ico/symbol-defs.svg#icon-favorite',


            }
        },

        methods: {


            profile_photo(){

                if( this.result.profile_photo !== '' ) {

                   return  'https://d2heijv3bffmsx.cloudfront.net/'  +  this.result.profile_photo  ;

                } else {

                    return  this.fullPath +  '/css/img/user-img.png' ;
                }

            },

            map_url(){

                let icon = this.fullPath + '/css/img/12mpicon.png';

                return 'http://maps.googleapis.com/maps/api/staticmap?zoom=15&size=637x440&maptype=roadmap&markers=icon:'+

                    icon + '|' +  this.result.latitude + ','+  this.result.longitude + '&key=AIzaSyB_O3eana1MbjibnAWKwIg7cPCHXQ-8fN4'

            },

            coverImage(){


                return this.fullPath + '/classifieds/' + this.result.cover_image ;

            },

            report_ad(){

                this.submit_report_progress = 1;

                let param = {report:1, cid: this.adItem.id,  report_reason:  this.report_reason, ad_title: this.adItem.title };

                axios.post( this.fullPath + 'classifieds/flag_item/post', param )
                    .then( res => {

                        this.report_submitted = 1;

                        this.report_reason = '';

                        this.submit_report_progress = 0;





                    });


            },

            get_ad(){

                let  url = this.$route.params.url;

                let param = { url: url };

                axios.post( this.fullPath + 'sp/classifieds/detail', param )
                    .then( res => {

                        this.result = res.data.data.result;

                        this.loader =  false;
                    });
            },
        },

        created(){

            console.log('tesst');
            this.get_ad();
        }
    }
</script>

<style scoped>

</style>