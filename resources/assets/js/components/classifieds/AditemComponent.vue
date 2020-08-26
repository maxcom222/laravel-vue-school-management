<template>


    <div>

    <div>


        <div class="feed ad">

            <a :href="profile_url" class="dp">

                <img :src="profile_photo" :alt="ad_item.first_name+ ' '+ ad_item.last_name">

            </a>

            <div>
                <a
                        :href="profile_url"  class="publisher">
                    {{ ad_item.first_name }} {{ ad_item.last_name}}

                </a>

                <span class="text-muted"> posted</span>

                <h2>
                    <a :href="detailUri(ad_item.url)" @click.prevent="detail_url_push( ad_item.url )"
                       class="js_name">
                        {{ ad_item.title }}
                    </a>
                </h2>

                <span class="text-muted">in</span>

                <span class="posted-in rating"> {{ ad_item.text }}</span>

                <small class="text-muted"> {{ formate_date_child( ad_item.dated ) }}</small>

            </div>

            <div v-if="page_on  === 'list'">

                 <p>{{ description }}</p>

            </div>

            <div v-else>

                <p>{{ ad_item.description }}</p>

            </div>

            <div class="condition">

                <span><strong>Age</strong> {{ ad_item.ages }}</span>

                <span><strong>Usage</strong> {{ ad_item.usage }}</span>

                <span><strong>Condition</strong> {{ ad_item.condition }}</span>

                <span><strong>Warranty</strong> {{ ad_item.warranty }}</span>

                <span class="js_address">

                    <strong>Located</strong>

                    {{ ad_item.address }}

                </span>
            </div>

            <div class="action">

                <em>{{ ad_item.price }}</em>

                <a href="" @click.prevent="add_to_fav" :class="">

                    <svg class="icon icon-favorite" :class="fav === 1 ? 'active-favorite' : '' ">
                        <use :xlink:href="icon_favorite"></use>
                    </svg>

                </a>
                <a href="" class="" @click.prevent="adFlagModal=!adFlagModal">

                    <svg class="icon icon-flag">

                        <use :xlink:href="icon_flag"></use>

                    </svg>
                </a>

            </div>


            <social-sharing :url="detailUri( ad_item.url )"
                            :title="ad_item.title"
                            :description="description"

                            inline-template>
                <div id="social-share " class="text-center">

                    <network network="email">

                        <i class="fa fa-envelope"></i> Email

                    </network>

                    <network network="facebook">

                        <i class="fa fa-facebook"></i> Facebook

                    </network>


                    <network network="linkedin">

                        <i class="fa fa-linkedin"></i> LinkedIn

                    </network>


                    <network network="twitter">

                        <i class="fa fa-twitter"></i> Twitter

                    </network>

                </div>

            </social-sharing>


            <a :href="detailUri(ad_item.url)" @click.prevent="detail_url_push( ad_item.url )" class="featured ">

                <img :src="ad_image" alt="" class="img-fluid mgtop10">

            </a>
        </div>

    </div>



        <div v-if="adFavModal">
            <transition name="modal">
                <div class="modal-mask" @click="adFavModal = false">
                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Your list</h5>
                                    <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" @click="adFavModal = false">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>{{ modal_msg }}</p>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </transition>
        </div>



        <div v-if="adFlagModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">

                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Flag an item</h5>
                                        <button type="button"  @click="adFlagModal=!adFlagModal" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="lead">Provide as much information as you can.</p>
                                        <div class="form-group  row">
                                            <label for="" class="col-12 col-form-label">Ad title</label>
                                            <div class="col-12">
                                                <input type="text" :value="ad_item.title"  class="form-control" ref="report_ad_title"  readonly="readonly" >

                                            </div>
                                        </div>

                                        <div class="form-group  row">
                                            <label for="" class="col-12 col-form-label">Describe why this ad is inappropriate</label>
                                            <div class="col-12">
                                                <textarea style="height:200px;" v-model="report_reason" class="form-control" ></textarea>
                                            </div>
                                        </div>



                                        <p  v-if="report_submitted===1"   class="alert nice-padding alert-success">Item is reported successfully. Expats school team will be in touch.</p>




                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" @click="adFlagModal=!adFlagModal"   class="btn btn-default modal-btn" data-dismiss="modal">Close</button>
                                        <button type="button"  v-if="report_submitted===0"    @click="submit_report" class="btn btn-primary modal-btn modal-btn-action   go ">

                                            Submit Report

                                            <span :class="submit_report_progress===1? '': 'd-none'" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>


                                        </button>
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

    var SocialSharing = require('vue-social-sharing');

    import AdreplyComponent from './AdreplyComponent.vue';


    export default {

        name: "AditemComponent",

        props: ['fullPath', 'ad_item', 'page_on'],

        components: {

            SocialSharing,

            AdreplyComponent
        },

        data() {

            return {

                adFlagModal: false,

                report_submitted: 0,

                submit_report_progress: 0,

                report_reason: '',

                ad_image : '',

                fav: 0,

                adFavModal: false,

                modal_msg: '',

                action: 'add',

                style_sidebar: 0,

                dialogWithFooter: false,

                icon_flag: this.fullPath +  'css/ico/symbol-defs.svg#icon-flag',

                icon_favorite: this.fullPath +  'css/ico/symbol-defs.svg#icon-favorite',

            }


        },

        computed: {

            description()  {

                let description  = this.stripHtml  ( this.ad_item.description  ) ;

                return description.substring(0, 300 ) + '...';

            },
            profile_url() {

              return this.fullPath + 'profile/' + this.ad_item.username  ;
            },
            profile_photo(){

                return 'https://d2heijv3bffmsx.cloudfront.net/' + this.ad_item.profile_photo;

            }


        },


        methods: {

            formate_date_child( date ) {

                return this.$parent.formate_date (date);
            },
            detailUri( url ) {

                return this.fullPath + 'classifieds/' + url ;
            },

            detail_url_push( url ){

                this.$router.push('classifieds/' + url  );
            },

            add_to_fav() {

                let param =
                        {
                            id : this.ad_item.id,

                            action: this.action,

                            type: 'ads'
                        };

                axios.post( this.fullPath + 'add_to_fav/post', param )
                    .then( res => {


                        if( res.data.action ===  'add') {

                            lscache.set( res.data.data.item_id + ''+ res.data.data.type  , '1');

                            this.fav = 1;

                            this.action = 'remove';

                            this.modal_msg = 'Classified ad is added to your list';

                        }
                        else {

                            lscache.set( res.data.data.item_id + ''+ res.data.data.type  , null );

                            this.fav = 0;

                            this.action = 'add';

                            this.modal_msg = 'Classified ad is removed from your list';
                        }
                         this.adFavModal = true;



                    })
            },

            submit_report(){

                this.submit_report_progress = 1;

                let param = {report:1, cid: this.ad_item.id,  report_reason:  this.report_reason, ad_title: this.ad_item.title };

                axios.post( this.fullPath + 'classifieds/flag_item/post', param )
                    .then( res => {

                        this.report_submitted = 1;

                        this.report_reason = '';



                    });


            },



            stripHtml(  html ) {

                var temporalDivElement = document.createElement("div");

                temporalDivElement.innerHTML = html;

                return temporalDivElement.textContent || temporalDivElement.innerText || "";
            },





        },

        created()  {


        },
        mounted() {


            if( lscache.get( this.ad_item.id + 'ads' ) !== null ) {

                this.fav    = 1;

                this.action = 'remove';
            }

        }



    }








</script>



<style>


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

    .action {
        width: 28%;
    }

 span[data-link] {

    padding: 5px;
    color: #FFF;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    -moz-transition: opacity 0.2s ease-in, top 0.2s ease-in;
    -ms-transition: opacity 0.2s ease-in, top 0.2s ease-in;
    -o-transition: opacity 0.2s ease-in, top 0.2s ease-in;
    -webkit-transition: opacity 0.2s ease-in, top 0.2s ease-in;
    transition: opacity 0.2s ease-in, top 0.2s ease-in;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    display: inline-block;
    font-size: 12px;
    height: 32px;
    line-height: 32px;
    margin-right: 8px;
    padding: 0 10px;
    position: relative;
    text-align: center;
    top: 0;
    vertical-align: top;
    white-space: nowrap;
}

    span[data-link] {

        background-color: #7d7d7d;
    }
    span[data-link="#share-facebook"] {

        background-color: #4267B2;

    }
    span[data-link="#share-twitter"] {

        background-color: #55acee;
    }

    span[data-link="#share-linkedin"] {

        background-color: #0077b5;
    }





</style>
