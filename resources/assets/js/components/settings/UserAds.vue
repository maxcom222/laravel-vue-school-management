<template>


    <div>

        <h2>Your classifieds ads</h2>

        <div class="alert alert-dark" v-if="showNoticeMessage">

            You have <strong>not</strong> posted any classifieds. <a  @click.prevent="postAdUrl" class="text-success" :href="post_ad_url">Starting posting ads</a>
        </div>


        <div
                v-for="(ads,index) in user_ads"

                :key="index + '_ads' "
                >

            <div class="feed ad my-ad">

                <div>

                    <h2><a  @click.prevent="adLinkUrl(ads.url)"    :href="adLink(ads.url)">{{ ads.title }}</a></h2>

                    <span class="text-muted">in</span> <span class="posted-in">{{ ads.text }}</span>

                    <small class="text-muted">{{ ads.dated }}</small>

                </div>

                <p>{{ads.description}}</p>

                <ul class="fav-actions">

                    <li><a href=""><svg class="icon icon-mode_edit"><use :xlink:href="icon_edit"></use></svg> Edit</a></li>

                    <li><a @click.prevent="deleteModal(ads.id)" href=""    ><svg class="icon icon-delete"><use :xlink:href="icon_delete"></use></svg> Remove</a></li>

                    <li><a @click.prevent="adLinkUrl(ads.url)" :href="adLink(ads.url)" target="_blank"  ><svg class="icon icon-open_in_new"><use :xlink:href="icon_new_tab"></use></svg> View</a></li>

                </ul>

            </div>



        </div>

        <div v-if="userAdDelete"   >

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">Delete Ad</h5>


                                </div>

                                <div class="modal-body" >

                                    <p>Are you sure to delete this ad?</p>

                                </div>

                                <div class="modal-footer "  >

                                    <button type="button" class="btn  btn-primary" @click="userAdDelete=false">Cancel</button>


                                    <button type="button" class="btn  btn-primary btn-continue" @click="deleteAd">

                                        Delete

                                        <span  v-if="deleteProgress===1"  class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

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

        name: "UserAds",


        data() {


            return {

                user_ads : [],

                name: '',

                position: '',

                user: this.$parent.user,

                fullPath: this.$parent.fullPath,

                userAdDelete: false,

                icon_people: this.$parent.fullPath +  'css/ico/symbol-defs.svg#icon-people',

                icon_remove_circle: this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-remove_circle',

                icon_new_tab:  this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-open_in_new',

                icon_delete:  this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

                icon_edit:  this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-mode_edit',

                unFollowProgress: 0,

                cid: '',

                deleteProgress: 0,

                showNoticeMessage: false,

                post_ad_url:  this.$parent.fullPath + 'classifieds/post',







            }
        },

        computed: {



        },

        methods: {

            adLink( profile ) {

                return this.fullPath + 'classifieds/' +  profile;

            },

            adLinkUrl( profile ) {

                this.$router.push( '/classifieds/' +  profile  );

            },

            postAdUrl(){

                this.$router.push( '/classifieds/post'  );
            },

            deleteModal(  cid   ){

              this.userAdDelete = true;

              this.cid = cid;
            },

            deleteAd(){

                this.deleteProgress = 1;

                axios.post( this.fullPath + 'post/user/user_ads', {delete:1, cid: this.cid } )

                    .then( res => {

                        if( parseInt( res.data.result )  === 0  ){

                            this.showNoticeMessage = true;
                        } else {

                            this.user_ads = res.data.data;
                        }


                        this.cid =  '';

                        this.deleteProgress = 0;

                        this.userAdDelete = false;

                    })

            },

            user_profile_photo( photo ) {

                return 'https://d2heijv3bffmsx.cloudfront.net/' +  photo;

            },



            loadAds() {

                axios.post( this.fullPath + 'post/user/user_ads', {} )

                    .then( res => {

                        if( parseInt( res.data.result )  === 0  ){

                            this.showNoticeMessage = true;
                        } else {

                            this.user_ads = res.data.data;
                        }



                    })
            }


        },


        created() {

            this.loadAds();

        }
    }
</script>

<style scoped>


    .feed{box-shadow: 0 1px 6px rgba(57,73,76,0.35); }
    .feed span {
        display: inline-block;
        margin: 0 0 0px;
    }

    .modal-wrapper  .btn-primary {

        font-size: 12px;
        border-radius: 0;
        padding: 4px 12px 4px 9px;
        font-weight: bold;
    }

</style>