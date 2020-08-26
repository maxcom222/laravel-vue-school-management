<template>

<div>

    <main class="two-cloumn">

        <div class="container">

            <div class="row">

                <div class="col-12 col-md-3 settings-left col-left">

                    <div class="frame cafe-sort filters desktop-filters">



                        <settingleft

                                :full-path="fullPath"
                        >


                        </settingleft>

                    </div>

                </div>

                <div class="col-12 col-md-6">

                    <!-- <SchoolFollowing

                            :full-path="fullPath"

                            :user="user"
                    >

                    </SchoolFollowing>  -->

                    <router-view >

                    </router-view>


                </div>

                <div class="col-12 col-md-3 col-right">

                    <settingright

                            :full-path="fullPath"
                    >


                    </settingright>


                </div>


            </div>

        </div>


    </main>

    <div v-if="noticeModal">
        <transition name="modal">
            <div class="modal-mask" @click="noticeModal = false">
                <div class="modal-wrapper">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ noticeHeader }}</h5>
                                <button type="button"  class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" @click="adFavModal = false">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>{{ noticeMsg }}</p>
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

    import Settingright from  './Settingright.vue';

    import Settingleft from  './Settingleft.vue';

    //import Settingbasic from  './Settingbasic.vue';

   // import Settingsecurity from  './Settingsecurity.vue';


   // import UserFollowing from  './UserFollowing.vue';

   // import SchoolFollowing from  './SchoolFollowing.vue'

    export default {

        name: "SettingComponent",

        props:['fullPath', ],

        components: {


            Settingright,

            Settingleft,

        },

        data() {


            return{

                noticeModal: false,

                noticeMsg: '',

                noticeHeader:'',

                user: lscache.get('user_data'),


            }
        },
    }
</script>

<style >


    .settings-left .frame  {

        padding: 0px;
    }

    .settings-left .frame > div  {

        box-shadow: 0 1px 6px rgba(57,73,76,0.35);
    }
    .settings li {

        padding: 10px;

        border-bottom: 1px solid rgba(0, 0, 0, 0.1);

        margin-bottom: 1px;
    }

    ul.settings a .icon {

        font-size: 2em;

    }
    ul.settings a {

        font-size:1em;
        border-bottom:0;
    }

    ul.settings li:hover {

        background: #f2f2f2;

    }
    ul.settings a .icon {

        font-size: 2em;

        vertical-align: middle;

        margin: 0 5px 0 0;

        color: #01ae79;
    }

    .feed{box-shadow: 0 1px 6px rgba(57,73,76,0.35); }
    .feed span {
        display: inline-block;
        margin: 0 0 0px;
    }
</style>