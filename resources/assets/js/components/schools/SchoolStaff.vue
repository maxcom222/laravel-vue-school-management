<template>

<div>

    <div class="frame" id="staff">

        <div class="loader" v-if="showLoadingBar"  > <div class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>


        <div class="requested">

            <h3>Staff</h3>

            <div class="requests row">

                <div v-for="tech in staff " class="item col-md-4 col-sm-6 col-xs-12">

                    <staff-component

                            :full-path="fullPath"


                            :tech="tech"
                    >

                    </staff-component>




                </div>


            </div>

        </div>

    </div>


</div>

</template>

<script>

    import StaffComponent  from  './StaffComponent.vue';


    var VueScrollTo = require('vue-scrollto');

    export default {

        name: "SchoolStaff",

        props:['fullPath', 'schoolProfile' ],

        components: {

            StaffComponent
        },

        data() {


            return {

                name: '',


                showLoadingBar:true,

                privacy_url:  this.fullPath + 'privacy',

                term_url:  this.fullPath + 'terms',

                request_sent_status: false,

                school_id: '',

                submit_progress: false,

                staff: [],



            };

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

            scrollTo(){



                VueScrollTo.scrollTo('#contact-buyer', 300)

            },



            sendRequest() {



                this.validateBeforeSubmit().then(data => {

                    if(  data === true   ) {

                        this.submit_progress = true;


                        let param = {

                            name: this.name,

                            email: this.email,

                            child_name: this.child_name,

                            message: this.message,

                            email_sent:this.email_sent,

                            school_id: this.school_id,

                            enquiry: 1,


                        };


                        axios.post( this.fullPath + 'schools/post/enquiry_school', param )

                            .then(res => {



                                this.submit_progress    = false;

                                this.request_sent_status = true;

                                this.name = '';

                                this.email = '';

                                this.child_name = '';

                                this.message = '';




                            });

                    }
                });

            },

            loadStaff(domain, name){


                axios.post( this.fullPath + 'schools/post/staff', {domain: domain, name:name } )

                    .then(res => {

                        this.staff = res.data.data

                        this.showLoadingBar = false;
                    });

            },
            follow_user() {

                this.followProgress = true;

                let status  = this.followStatus ;

                if( this.followStatus === 'Following') {

                    this.followStatus = 'Follow';

                } else {

                    this.followStatus = 'Following';

                }

                let param = { school_id: this.staff.id , type:'person', status:status };


                axios.post( this.fullPath +'schools/follow',  param )
                    .then( res => {

                        this.followProgress = false;

                        this.followStatus === 'Following' ? this.staff.followers  ++  :  this.staff.followers  --;

                        let user_follower = res.data.data;

                        lscache.set('user_follower', user_follower );


                    });
            }


        },

        created() {

            this.school_id  = this.schoolProfile.id;

            this.loadStaff( this.schoolProfile.domain_email , this.schoolProfile.name );

        },


    }


</script>

<style scoped>


    .user-card > a {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: block;
        width: 200px;
        color: #3e3d95;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .item.col-md-6.col-sm-6.col-xs-12 {
        margin-bottom: 20px;
    }
    .user-card{    box-shadow: 0 1px 6px rgba(57,73,76,0.35);}

    .user-card .btn {
        margin: 10px 0 0;
        padding: 0;
        background: none;
        color: #019567;
        background: rgba(0,0,0,0.1);
        width: 105px;
        font-size: 1.2em;
        border-radius: 0;
    }
    .user-card .btn:hover{

        background:#019567;
        color:#FFF;
    }
</style>