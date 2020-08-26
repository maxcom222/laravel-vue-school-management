<template>


<div>



    <div class="frame item-opt">

        <em>{{ adItem.price}}</em>

        <p class="ph"  v-if="showPhone">{{ adItem.phone_number  }}</p>

        <a href="" class="btn btn-sm btn-primary" @click.prevent="showPhone=true">

            <svg class="icon icon-phone">

                <use :xlink:href="icon_phone">

                </use>
            </svg>

            Show Phone

        </a>

        <a href="" class="btn btn-sm btn-outline-primary js_fav  d-none ">

            <svg class="icon icon-favorite">

                <use :xlink:href="icon_fav"></use>

            </svg>

            Watchlist

        </a>

        <a href="" @click.prevent="adFlagModal=!adFlagModal"  class="btn btn-sm btn-outline-secondary">

            <svg class="icon icon-flag">

                <use :xlink:href="icon_flag"></use>

            </svg> Report Ad

        </a>

    </div>

    <div class="frame recommendations">

        <div class="footer">
            <a :href="about_url">About</a> <span>·</span>
            <a :href="help_url">Help Center</a> <span>·</span>
            <a :href="privacy_url">Privacy Policy</a> <span>·</span>
            <a :href="terms_url">Term &amp; Conditions</a> <span>·</span>
            <small>© {{ new Date().getFullYear()}}. All Rights Reserved.</small>
        </div>
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
                            <div class="modal-body" style="height: 500px;">
                                <p class="lead">Provide as much information as you can.</p>
                                <div class="form-group  row">
                                    <label for="" class="col-12 col-form-label">Ad title</label>
                                    <div class="col-12">
                                        <input type="text" :value="adItem.title"  class="form-control" ref="report_ad_title"  readonly="readonly" >

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
                                <button type="button"  v-if="report_submitted===0"    @click="report_ad" class="btn btn-default modal-btn ">

                                    Submit Report

                                    <span :class="submit_report_progress===1? '': 'd-none'" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>


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


    export default {

        name: "detail_side",

        props:['fullPath','adItem'],

        data(){


            return {


                adFlagModal: false,

                report_submitted: 0,

                submit_report_progress: 0,

                report_reason: '',

                showPhone: false,

                about_url:  this.fullPath + 'about',

                help_url:    this.fullPath + 'help',

                privacy_url: this.fullPath + 'privacy',

                terms_url:   this.fullPath + 'terms',

                icon_phone:  this.fullPath + 'css/ico/symbol-defs.svg#icon-phone',

                icon_flag:   this.fullPath + 'css/ico/symbol-defs.svg#icon-flag',

                icon_fav:this.fullPath + 'css/ico/symbol-defs.svg#icon-favorite',


            }
        },

        methods: {




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


        },

        created(){


        }
    }
</script>

<style scoped>

</style>