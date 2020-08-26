<template>


    <div>

        <main class="landing partner">


             <section class="page-title epc-join title-blue">

            <div class="container">

                <div class="row row-eq-height">

                    <div class="col-12 col-lg-6 align-self-center">

                        <h3>Friends of <span>Expats Schools</span></h3>

                        <span>Change the world for teachers</span>

                    </div>


                    <div class="col-12 col-lg-6 align-self-center">

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item">

                                    <a  @click.prevent="homeUrl" :href="home">

                                        <svg class="icon icon-home">

                                            <use :xlink:href="icon_home"></use>

                                         </svg>

                                      </a>

                                </li>

                                <li class="breadcrumb-item active" aria-current="page">Friends</li>

                            </ol>

                        </nav>

                    </div>


                </div>
            </div>
        </section>



            <section class="plan">



                <div class="container">
                    <div class="row">



                        <div class="col-12 col-sm-4 col-md-3 col-xl-3">

                            <div class="diet-logo bg-wellness">

                                <img :src="coverImage()" />

                            </div>
                        </div>


                        <div class="col-12 col-sm-8 col-md-9 col-xl-6">

                            <h2>{{ expats_friends.company_name }}</h2>

                            <p  v-html="expats_friends.intro "></p>

                            <p class="lead">Discounts</p>



                            <h3>Deal Details</h3>

                            <p v-html="expats_friends.deal_details "></p>


                        </div>



                        <div class="col-12 col-sm-8 offset-sm-4 offset-md-3 offset-xl-0 col-xl-3">

                            <ul class="list-unstyled checkmark">

                                <li><h4>Offers</h4></li>

                                <li><label><strong>SwissQuote<span></span></strong></label></li>

                                <li><label><strong>My Dental Clinic<span></span></strong></label></li>

                                <li><label><strong>Up and running<span></span></strong></label></li>

                                <li><span>

                                    <button

                                            type="button"

                                            class="btn  btn-cta"
                                    >
                                        Join us today

                                    </button>

                                </span></li>

                            </ul>

                        </div>


                    </div>

                    <div class="break"></div>


                </div>


            </section>


        </main>


    </div>

</template>

<script>


    export default {

        props: ['fullPath'],

        name: "FriendComponent",

        data(){

            return {

                logo_anim:  this.fullPath + 'css/img/logo_anim.png',

                home: this.fullPath,

                icon_home: this.fullPath  + 'js/plugins/menu/symbol-defs.svg#icon-home',

                expats_friends: 0,

            }
        },

        methods:{

            homeUrl(){

                console.log('done');

                this.$router.push('/');

            },
            coverImage(){

                return  'https://www.expatsschools.com/secure_admin/media/images/home_gallery/' +

                    this.expats_friends.cover_image;

            },

        },

        created(){

            let  url = this.$route.params.url;

            let param = { url: url };

            axios.post( this.fullPath + 'sp/friends/detail', param )
                .then( res => {

                    this.expats_friends = res.data.data;

                    this.expats_friends  = this.expats_friends[0];


                });

        },
    }


</script>

<style scoped>

    .highlight-box {color: #FFE082 !important;}
    .friends_expats img{width:100%; height:300px;}
    .offers_text{font-weight: 700;font-family: "Roboto", sans-serif;    border: 3px solid #fff;    background: #01ae79;background: linear-gradient(135deg, #01ae79 0%, #97db6f 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#01ae79', endColorstr='#97db6f',GradientType=1 );color: #fff;font-size: 1.2em;width: auto;    text-align: center;padding: 10px;}

    .highlight-box:before {background: -moz-linear-gradient(top, rgba(255,224,130,0.8) 0%, rgba(251,221,129,0.8) 1%, rgba(44,62,80,0.7) 60%, rgba(44,62,80,1) 80%) !important;background: -webkit-linear-gradient(top, rgba(255,224,130,0.8) 0%,rgba(251,221,129,0.8) 1%,rgba(44,62,80,0.7) 60%,rgba(44,62,80,1) 80%) !important;background: linear-gradient(to bottom, rgba(255,224,130,0.8) 0%,rgba(251,221,129,0.8) 1%,rgba(44,62,80,0.7) 60%,rgba(44,62,80,1) 80%) !important; filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ccffe082', endColorstr='#2c3e50',GradientType=0 ) !important;}



    .title-blue {
        background-color: #f2f9fe;
        padding: 30px 0;height: auto;
    }

    .title-blue div:first-of-type {
        text-align: left;
    }


    .title-blue div:last-of-type {
        text-align: right;
    }


    .page-title h1 + span {
        color: rgba(0, 0, 0, 0.5);
        font-size: 0.875rem;
        display: block;
    }


    .title-blue .breadcrumb {
        margin: 20px 0 0;
        padding: 0;
        background: none;
        font-size: 0.875rem;
    }
    @media (min-width: 992px)
    {


        .title-blue .breadcrumb {
            margin: 0;
        }
        .breadcrumb {
            font-size: 0.875rem;
            float: right;
        }

    }

    .breadcrumb {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
        list-style: none;
        background-color: #e9ecef;
        border-radius: 0.25rem;
    }

    .breadcrumb .icon{font-size:1.4em;}
    .plan {
        padding: 30px 0 0;
    }


    .bg-wellness {
    }


    .diet-logo {
        width: 140px;
        height: 140px;
        position: relative;
        margin: 0 auto 20px;    border: 1px solid #ccc;
    }

    @media (min-width: 768px)
    {
        .diet-logo {
            width: 90%;
            height: auto;
            padding-top: 90%;
            margin: 0;
        }
    }

    .diet-logo img {
        width: 90%;
        height: 90%;
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    .checkmark {
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 14px;
        margin: 20px 0 30px 0;
        border-radius: 4px;
    }
    .checkmark h4 {
        text-align: center;
        color: rgba(0, 0, 0, 0.5);
        background-color: #fff;
        padding: 0 10px;
        margin: -30px auto 10px;
        display: table;
    }
    @media (min-width: 1200px)
    {
        .checkmark {margin: 60px 0 30px 0;}
        .checkmark li > span {margin: 20px auto -32px;}

    }
    .checkmark .btn-primary {
        line-height: 24px;
        height: 36px;
        margin: 0;
    }

    .checkmark li > span {
        background-color: #fff;
        display: table;
        padding: 0 10px;
        margin: 14px auto -32px;
    }
    .break {
        margin-bottom: 10px;
        clear: both;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .checkmark label {
        padding: 10px 13px 7px 38px;
        margin: 0;
        color: #3e3d95;
        background-color: #fff;
        position: relative;
        width: 100%;
    }

    .checkmark label strong {
        font-weight: normal;
    }

    .checkmark label span {
        color: #01ae79;
        float: right;
    }

    .checkmark  label::after {
        content: url('https://www.expatsschools.com/public/css/img/check-white.svg');
        font-size: 32px;
        position: absolute;
        top: 6px;
        left: 0;
        height: 32px;
        width: 32px;
        line-height: 32px;
        text-align: center;
        background: #b0bec5;
        border-radius: 50%;
        -webkit-transform: scale(0.8, 0.8);
        transform: scale(0.8, 0.8);
    }

    .partner h2,h3,h4{color:#3e3d95;}

</style>