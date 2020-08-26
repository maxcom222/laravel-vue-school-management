<template>


    <div>


        <div v-if="selfView===1">

            <div v-if="twitterName !==  ''">

                <div v-ripple.mouseover="'rgba(1,123,86, 0.35 )'"   class="alert alert-success about-alert text-center" >

                    You are authenticated as {{  twitterName }}

                    <a @click.prevent="removeTwitter" href="">Remove your twitter account</a></div>

                <div class="alert alert-danger about-alert text-center">

                    Update twitter feed

                    <a href="https://www.expatsschools.com/oauth_callback/twitter?login=1">

                        click here

                    </a>

                    to authorize your twitter profile to get your twitter feed.

                </div>


            </div>


            <div
                    v-else
                    class="alert alert-success about-alert text-center">

                Click

                <a href="https://www.expatsschools.com/oauth_callback/twitter?login=1">

                    here

                </a>

                to authorize your twitter profile to get your twitter feed.

            </div>




        </div>




        <div v-show="twitterModal">

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog modal-md" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title" >  Twitter Feed</h5>

                                    <button type="button"  @click="closePop" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>

                                </div>

                                <div class="modal-body">

                                    <div v-if="twitterName!== ''">


                                        <div id="twitter-widget-holder">

                                            <a
                                                    class="twitter-timeline"

                                                    :href="twitterLink">

                                                Tweets by

                                            </a>

                                        </div>


                                    </div>


                                    <div
                                            v-else
                                            class="alert alert-success about-alert text-center">

                                       <div  v-if="selfView===1">

                                           Click

                                           <a href="https://www.expatsschools.com/oauth_callback/twitter?login=1">

                                               here

                                           </a>

                                           to authorize your twitter profile to get your twitter feed.
                                       </div>





                                    </div>







                                </div>



                                <div class="modal-footer"   >


                                    <button type="button" @click="closePop"   class="btn btn-default modal-btn" data-dismiss="modal">Close</button>


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

    import {eventBus} from '../../app.js'

    export default {

    name: "ProfileTwitter",

    props: ['fullPath', 'user', 'selfView', 'twitterName'],


    data()  {


        return{

            education:[],

            icon_add: this.fullPath + 'css/ico/symbol-defs.svg#icon-add',

            icon_edit: this.fullPath + 'css/ico/symbol-defs.svg#icon-mode_edit',

            icon_del:   this.fullPath + 'css/ico/symbol-defs.svg#icon-delete',

            edit_id: 0,

            twitterLink: 'https://twitter.com/' +  this.twitterName + '?ref_src=twsrc%5Etfw',

            twitterModal      : false,

            showDegree: false,


            progress:   0,

            yearModal: [],


            isDone: 0,



        }
    },

    computed: {




    },

    watch:{



    },

    methods:{

        validateBeforeSubmit() {

            return this.$validator.validateAll().then((result) => {

                if (result  ===  true ) {

                    return true;

                } else {

                    this.scrollTo();

                    return false;

                }


            });
        },



        saveContact()  {

            let q_code =  '';

            if( typeof this.qualification !== 'undefined' ) {

                q_code =    this.qualification.code;
            }


            let param = {

                email: this.email,

                first_name: this.first_name,

                last_name: this.last_name,

                contact_number: this.contact_number,

                skype: this.skype,

                dob: this.year + '-'  + this.month.code + '-' +  this.day ,

                add_edu: 1,

                edit_id: this.edit_id,

                contact_public: this.contact_public,

                mobile_number_public: this.mobile_number_public,


            };




        },



        scrollTo(){



            VueScrollTo.scrollTo('body', 300)

        },

        showContact() {

            document.body.classList.add("modal-open");

            this.twitterModal = true;

        },

        closePop() {

            document.body.classList.remove("modal-open");

            this.twitterModal = false;


        },




    },

    created() {


        eventBus.$on('twitterDialogLeftMenu', (message) => {

            this.showContact();

        });



    }
}
</script>

<style>
    @media (min-width: 576px)
    {
        .modal-dialog {

            max-width: 600px

        }
    }

    .modal-body {


        height: 400px;

        overflow-y: scroll;

        overflow-x: hidden;

    }


    #twitter-widget-holder {
        max-height: 400px;
        max-width: 100%;
        overflow-y: scroll;
        -webkit-overflow-scrolling: touch;
        padding: 20px;
        background: #fff;
    }

</style>