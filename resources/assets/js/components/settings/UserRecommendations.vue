<template>


    <div>

        <h2>Recommendations  for you</h2>

        <div class="alert alert-dark" v-if="showNoticeMessage">

            Ask your friend  to write recommendation for you. <a @click.prevent="postNetworkUrl"  class="text-success" :href="post_network_url">Grow your network</a>

        </div>



        <div
                v-for="(recommendations,index) in user_rec"

                :key="index + '_ads' "
                >

            <div class="feed follower" :class="recommendations.approval===1 ? 'activeFeed':  ''" >

                <a @click.prevent="userProfileLink(recommendations.username)"    :href="profile_url(recommendations.username)" class="teachers-card">

                    <img :src="profile_photo(recommendations.profile_photo)" alt="Profile">

                    <span>

                        <strong> {{ recommendations.name  }}</strong>

                         <small> {{ recommendations.recent_job }}</small>


                         <span class="people"><svg class="icon icon-people"><use :xlink:href="icon_people"></use></svg> {{ recommendations.followers }} followers </span>

                    </span>
                </a>

                <p>{{ recommendations.text }}
                </p>


                <ul class="fav-actions">

                    <li >

                        <a @click.prevent="approve( recommendations.rid, recommendations.approval )" class="" href="">



                            <span v-if="approveProgress" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>




                            <svg v-else class="icon icon-block">

                                <use :xlink:href="icon_block"></use>

                            </svg>

                            <span v-if="recommendations.approval===0">Allow on profile</span>

                            <span v-else>Remove from profile</span>

                        </a>

                    </li>

                    <li><a @click.prevent="userProfileLink(recommendations.username)" :href="profile_url(recommendations.username)"><svg class="icon icon-open_in_new"><use :xlink:href="icon_new_tab"></use></svg> View Profile</a></li>

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

                                        Delete   <span v-if="deleteProgress" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

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

        name: "UserRecommendations",


        data() {


            return {

                user_rec : [],

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

                icon_block:  this.$parent.fullPath + 'css/ico/symbol-defs.svg#icon-block',



                approveProgress: false,

                cid: '',

                deleteProgress: 0,

                showNoticeMessage: false,

                post_network_url: this.$parent.fullPath + 'network',







        }
        },

        computed: {



        },

        methods: {

            adLink( profile ) {

                return this.fullPath + 'classifieds/' +  profile;

            },

            profile_url( profile ) {

                return this.fullPath + 'profile/' +  profile;

            },

            userProfileLink( p ){

                this.$router.push( '/profile/'  + p );
            },

            postNetworkUrl(){

                this.$router.push( '/network' );
            },

            deleteModal(  cid   ){

              this.userAdDelete = true;

              this.cid = cid;
            },

            approve( id, status ){

                this.approveProgress = 1;

                status = 1 - status;

                axios.post( this.fullPath + 'post/update_recommendation', {id: id, approve:1, status: status } )

                    .then( res => {

                        if( parseInt(  res.data.result  ) ===  1 ){

                            this.user_rec = res.data.data;

                        } else {

                            this.showNoticeMessage = true;
                        }


                        this.approveProgress = 0;

                    })

            },

            profile_photo( photo ) {

                return 'https://d2heijv3bffmsx.cloudfront.net/' +  photo;

            },

            loadRec() {

                axios.post( this.fullPath + 'settings/get_recommendations', {} )

                    .then( res => {


                        if( parseInt(  res.data.result  ) ===  1 ){

                            this.user_rec = res.data.data;

                        } else {

                            this.showNoticeMessage = true;
                        }

                    })
            }


        },


        created() {

            this.loadRec();

        }
    }
</script>

<style scoped>

    .glyphicon-spin {
        -webkit-animation: spin 500ms infinite linear;
        animation: spin 500ms infinite linear;
    }
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }
    @keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }

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

    .activeFeed{

        border-bottom: #3e3d95 2px solid;
    }

</style>