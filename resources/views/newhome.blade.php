<link href="{{ asset('css/plugins/aos.css') }}" rel="stylesheet" />
<link href="<?php echo url( 'css/slick.css?t='. time() ) ?> }}" rel="stylesheet" />
<link href="{{ asset('css/glyphicons.css') }}" rel="stylesheet" />

<style type="text/css">
    #overlay{background: #fff none repeat scroll 0 0; position: fixed; left: 0; right: 0; top:0; bottom: 0; height: 100%; width: 100%; z-index: 55; transition: all 0.5s ease 0s;}
    .load-progress-wrapper .load-progress-logo{width: 80%; margin: 0 auto; display: block; -webkit-animation-name: logo-scale; -webkit-animation-duration: 1s; animation-name: logo-scale; animation-duration: 1s; animation-fill-mode: forwards;}
    @-webkit-keyframes logo-scale{ from{opacity: 0.1; transform: scale(0.2) translateY(-50%);}to{opacity: 1; transform: scale(1) translateY(-50%);}}@keyframes logo-scale{from{opacity: 0.1; transform: scale(0.2) translateY(-50%);}to{opacity: 1; transform: scale(1) translateY(-50%);}}
    .load-progress-wrapper{max-width: 350px; margin: 0 auto; position: absolute; left: 0; right: 0; top: 50%; transform: translateY(-50%);}
    .load-progress-wrapper:after{content: ""; height: 800px; width: 800px; border-radius: 50%; background-color: #66BB6A; position: absolute; margin: -400px -220px 0; transform: scale(0); transform-origin: 50% 40%; z-index: -1; transition: all 0.3s cubic-bezier(0,0,.2,1) 0s; animation: a-h 0.5s 1.25s 1 linear forwards,a-nt .6s 1.25s 1 cubic-bezier(0,0,.2,1);}
    @keyframes a-h{100%{opacity:0}} @keyframes a-nt{100%{transform:none}}
    #load-progress{background: #f1f1f1; position: absolute; left: 0; right: 0; height: 3px; bottom: 0px; transition: all 0.5s ease 0s; animation-name: load-progress-show; animation-duration: 2s; animation-delay: 2s; opacity: 0; animation-fill-mode: forwards;}
    @keyframes load-progress-show{from{opacity: 0;}to{opacity: 1;}}
    #load-progress-in{position: absolute; left: 0; right: 0; background: #66BB6A; content: ""; height: 3px; z-index: 1; animation-name: load-progress-bar; animation-duration: 2s; animation-fill-mode: forwards; animation-delay: 2.2s; width: 0;}
    @keyframes load-progress-bar{from{width: 0;}to{width: 100%;}}
    .epc h2,.epc ul li{font-family:"Roboto", sans-serif; font-size:1.5em; }
    .epc ul .icon{font-size:2em;}
    .epc  .join-now-epc{margin-bottom:30px;}
    .signup-cards .space-free{ margin:30px 0 40px;}
    .home-contents{margin-top:0px;}

    main{padding-top:2px;}
    ul{list-style:none;}
    ul li{padding-left:3px;}
    .home-contents{background-color:transparent !important;}
    @media screen and (min-device-width:1200px)
    {

        .d-md-margin-right{margin-right:24px;}
    }




    .home-slider {
        margin: 0 auto;
        overflow: hidden;
    }


    .home-slider .item div {
        width: 100%;
        min-height: 250px;
        color: #fff;
        padding-bottom: 20px;
        border: 4px solid #fff;
        border-radius: 6px;
        border-bottom-width: 2px;
    }

    .home-slider .item div img {
        width: 60px;
        height: 60px;
        float: left;
        margin: 15px 10px 0 20px;
    }
    .home-slider .item div h3 {
        color: #fff;
        font-size: 1.5rem;
        padding: 20px 0 5px 90px;
    }

    .home-slider .item div p {
        font-family: Quicksand,sans-serif;
        font-size: 1.125rem;
        padding: 0 20px;
        margin: 0; background-color: transparent;
    }
    .home-slider .item div a {
        font-size: 1rem;
        line-height: 28px;
        border: 2px solid #fff;
        width: 36px;
        height: 36px;
        border-radius: 20px;
        color: #fff;
        background: rgba(255,255,255,0);
        display: block;
        text-align: center;
        position: absolute;
        bottom: 20px;
        right: 20px;
    }

    .home-slider .item div a span {
        display: none;
    }

    .bg-fat-burn {

        background: -webkit-gradient(linear,left top,left bottom,from(#01395c),to(#058334));
        background: linear-gradient(to bottom,#01395c 0,#058334 100%);


    }

    .intro {
        padding: 30px 0 0;
    }


    .tile {
        width: 100%;
        padding-top: 100%;
        background-color: #dde7f0;
        position: relative;
        background-repeat: no-repeat;
        background-size: cover;
        display: block;
    }


    .expat-list .tile {
        padding: 0;
        min-height: 232px;
    }

    .expat-list .tile.menu-p1 {
        min-height: 80px;
    }

    .expat-list .tile h2 {
        z-index: 1;
        color: #fff;
        text-align: center;
        width: 100%;
        position: absolute;
        top: 50%;
        -webkit-transform: translateY(-50%);
        -khtml-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .intro h2 {
        font-size: 1.625rem;
        text-align: center;
    }



    .tile>span {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        display: block;
        opacity: .7;
        -webkit-transition: all .3s ease-in-out;
        transition: all .3s ease-in-out;
    }

    .intro h2+span {
        font-size: .875rem;
        display: block;
        margin-bottom: 30px;
        text-align: center;
        color: rgba(0,0,0,.5);
    }

    .menu-p1 span {
        background: #2cd664;
        background: -webkit-gradient(linear,left top,left bottom,from(#01ae79),to(#3e3d95));
        background: linear-gradient(to bottom,#01ae79 0,#3e3d95 100%);
    }


    .expat-list .tile ul {
        margin: 0;
        padding: 0;
        list-style: none;
        color: #fff;
        position: absolute;
        left: 20px;
        top: 70px;
        z-index: 1;
    }
    .expat-list .tile h4 {
        color: #fff;
        position: absolute;
        left: 20px;
        top: 30px;
        z-index: 1;
    }
    .menu-p1 {
        background-image: url('css/img/newhome/tutors.jpg');
    }
    .menu-p2 {
        background-image: url('https://www.expatsschools.com/css/img/home/etc.png');
    }
    .menu-p3 {
        background-image: url('https://www.expatsschools.com/css/img/gallery/jobs.png');
    }
    .menu-p4 {
        background-image: url('https://www.expatsschools.com/css/img/gallery/feratured-school.png');
    }

    .menu-p2 span {
        background: #01395c;
        background: -webkit-gradient(linear,left top,left bottom,from(#01395c),to(#058334));
        background: linear-gradient(to bottom,#01395c 0,#058334 100%);
    }

    .menu-p3 span {
        background: #720c0c;
        background: -webkit-gradient(linear,left top,left bottom,from(#720c0c),to(#d6600f));
        background: linear-gradient(to bottom,#720c0c 0,#d6600f 100%);
    }

    .menu-p4 span {
        background: #080369;
        background: -webkit-gradient(linear,left top,left bottom,from(#3e3d95),to(#7b179f));
        background: linear-gradient(to bottom,#3e3d95 0,#7b179f 100%);
    }
    .expat-list .tile ul a {
        color: #fff;
        display: inline-block;
        padding: 3px 0;
    }
    .food-items {
        padding-bottom: 10px;
    }
    .food-menu {
        text-align: center;
    }
    .food-menu img {
        margin-bottom: 5px;
    }
    .food-menu a {
        color: rgba(0,0,0,.7);
        font-size: .875rem;
        line-height: 1.2;
    }


    .expat-items {
        background-color: #f5f5f5;
        padding-bottom: 30px;
        border-bottom: 1px solid #f5f5f5;
        border-top: 1px solid #f5f5f5;
    }
    .expat-items.intro h2 {
        color: #3e3d95;
    }
    .expat-items p {
        font-size: 1.1em;

    }
    .expat-list {
        background-color: #E5E5E5;
        border-bottom: 1px solid #01ae79;
        border-top: 1px solid #01ae79;
    }
    .expat-friend span {
        font-size: 1.1em !important;
    }
    .home-slider {
         border-bottom:1px solid #EEEBF2;
    }
    .intro h2 {
        font-size: 1.625rem;
        text-align: center;
    }
    .intro h2+span {
        font-size: .875rem;
        display: block;
        margin-bottom: 30px;
        text-align: center;
        color: rgba(0,0,0,.5);
    }

    .tile h3 {
        font-size: 1.125rem;
        margin: 0;
        color: #fff;
        position: absolute;
        left: 20px;
        bottom: 20px;
        z-index: 1;
        -webkit-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    .tile>span {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        display: block;
        opacity: .7;
        -webkit-transition: all .3s ease-in-out;
        transition: all .3s ease-in-out;
    }

    .swiss {
        background-image: url('https://www.expatsschools.com/secure_admin/media/images/home_gallery/1561099097_swissquote.png');
    }

    .uprunning {
        background-image: url('https://www.expatsschools.com/secure_admin/media/images/home_gallery/1561099075_upandrunning.png');
    }

    .dental {
        background-image: url('https://www.expatsschools.com/secure_admin/media/images/home_gallery/1561099085_mydental.png');
    }
    .high-bp {
        background-image: url('css/img/newhome/high-bp.jpg');
    }

    .uprunning span {
        background: #d03b61;
        background: -webkit-gradient(linear,left top,left bottom,from(#d03b61),to(#352424));
        background: linear-gradient(to bottom,#d03b61 0,#352424 100%);
    }
    .swiss span {
        background: #0082d5;
        background: -webkit-gradient(linear,left top,left bottom,from(#0082d5),to(#29d06c));
        background: linear-gradient(to bottom,#0082d5 0,#29d06c 100%);
    }
    .dental span {
        background: #a7b833;
        background: -webkit-gradient(linear,left top,left bottom,from(#a7b833),to(#301b49));
        background: linear-gradient(to bottom,#a7b833 0,#301b49 100%);
    }

    .high-bp span {
        background: #6d636a;
        background: -webkit-gradient(linear,left top,left bottom,from(#6d636a),to(#313fcd));
        background: linear-gradient(to bottom,#6d636a 0,#313fcd 100%);
    }

    @media (min-width: 768px) {
        .home-slider .item div img {
            width: 180px;
            height: 180px;
            margin: 25px 30px 0 20px;
        }
        .home-slider .item div h3 {
            font-size: 2rem;
        }
        .home-slider .item div a {
            width: 40px;
            height: 40px;
            line-height: 32px;
        }

        .expat-list {
            padding: 40px 0;
        }
        .expat-list .tile.menu-p1 {
            min-height: 100%;
        }
        .intro h2 {
            font-size: 2rem;
        }
        .tile h3 {
            font-size: 1.5rem;
        }

    }


    @media (min-width: 992px)  {


        .home-slider .bg-fat-burn {

            background: url('css/img/newhome/L1.jpg') no-repeat;
        }

        .home-slider .bg-fat-burn.two {

            background: url('css/img/newhome/L2.jpg') no-repeat;
        }
        .home-slider .bg-fat-burn.three {

            background: url('css/img/newhome/L3.jpg') no-repeat;
        }




        .home-slider .item div {
            padding: 0 0 0 54%;
            border: none;
            border-radius: 0;
            min-height: 320px;

            }

        .home-slider .item div img {
            display: none;
        }
        .home-slider .item div p {
            padding: 0;
            font-size: 1.4rem;
            color: rgba(0,0,0,.6);
        }
        .home-slider .item div a {
            width: auto;
            height: 36px;
            line-height: 32px;
            padding: 0 20px;
            font-size: .875rem;
        }
        .home-slider .bg-fat-burn h3 {
            color: #3e3d95!important;
        }

        .home-slider .bg-fat-burn a {
            color: #FFF!important;
            border-color: #3e3d95!important;
            background-color: #3e3d95!important;


        }

        .home-slider .item div a span {
            display: inline-block;
            margin-right: 5px;
        }

        .food-items {
            padding: 50px 0 40px 0;
        }


    }








</style>

<div id="overlay" class="hover_ease_5">
    <div class="load-progress-wrapper">
        <img class="load-progress-logo" src="{{ url('/css/img/logo_anim.png')}}">
        <div id="load-progress">
            <span id="load-progress-in"></span>
        </div>
        <div style="opacity: 0;" id="progstat"></div>
    </div>
    <span class="circle"></span>
</div>


<main class="d-none home-contents">





    <section class="home-slider">

        <div class="owl-carousel owl-theme home-slides" style="display: none;">


            <div class="item" data-hash="Teachers+SupportStaff">
                <div class="bg-fat-burn">
                    <img src="https://wellnesskitchen.com.sa/assets/img/icon-fat-burner.svg" alt="Teachers + Support Staff"><h3>Teachers + Support Staff</h3>

                    <p >Expats' Schools is for teachers by teachers. We want to recognise the amazing work you do, by making life a little easier.</p>
                    <a href=""><span>Learn More</span>
                        <svg class="icon icon-arrow_forward"><use xlink:href="{{ url('css/plugins/menu/symbol-defs.svg') }}#icon-arrow_forward"></use></svg></a>
                </div>
            </div>



            <div class="item" data-hash="For-Parents">
                <div class="bg-fat-burn two">
                    <img src="https://wellnesskitchen.com.sa/assets/img/icon-fat-burner.svg" alt="For Schools"><h3>For Parents</h3>

                    <p>
                        Selecting a school away from home can be confusing, fear not Expats' Schools is designed to make. Choosing the best school for your kids that much simpler.
                    </p>
                    <a href=""><span>Learn More</span>
                        <svg class="icon icon-arrow_forward"><use xlink:href="{{ url('css/plugins/menu/symbol-defs.svg') }}#icon-arrow_forward"></use></svg></a>
                </div>
            </div>



            <div class="item" data-hash="For-Schools">
                <div class="bg-fat-burn three">
                    <img src="https://wellnesskitchen.com.sa/assets/img/icon-fat-burner.svg" alt="For Schools"><h3>For Schools</h3>

                    <p>
                        Expats' Schools is an independent platform. Connecting schools, parents and teachers
                    </p>
                    <a href=""><span>Learn More</span>
                        <svg class="icon icon-arrow_forward"><use xlink:href="{{ url('css/plugins/menu/symbol-defs.svg') }}#icon-arrow_forward"></use></svg></a>
                </div>
            </div>







        </div><!-- END home-slides -->

    </section><!-- END home-slider -->
    <section class="intro         expat-items">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Welcome to Expats <span>Schools</span></h2>
                    <p>We are a company built by teachers for teachers and support staff, parents and schools. We have brought together an extensive network of partners, aimed at enhancing your experience of education. So, teachers, support staff, parents and schools, please sign up and explore!</p>
                </div>


            </div>
        </div>

        <div class="owl-carousel owl-theme food-menu d-none">
            <div class="item">
                <a href="">
                    <img src="https://wellnesskitchen.com.sa/assets/img/food/thumbs/Mutabal.png"
                         alt="">Subway </a>
            </div>
            <div class="item">
                <a href="">
                    <img src="https://wellnesskitchen.com.sa/assets/img/food/thumbs/Moringa Coffee.png"
                         alt="">TGI Fridays</a>
            </div>
        </div>


    </section>

    <section class="intro expat-list">
        <div class="container">
            <h2>Expats Schools Offers</h2>
            <div class="row no-gutters">


                <div class="col-12 col-md-6 col-lg-3">
                    <div class="tile menu-p2">
                        <a href="">
                            <h4>Expat Teacher Club</h4>
                        </a>
                        <ul  class="d-none">
                            <li><a href="">Discounts</a></li>
                            <li><a href="">Insurance</a></li>
                            <li><a href="">Grocery</a></li>

                        </ul>
                        <span></span>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="tile menu-p3">
                        <a href="">
                            <h4>Jobs</h4>
                        </a>
                        <ul  class="d-none">
                            <li><a href="">Find Jobs</a></li>
                            <li><a href="">Create Profile</a></li>
                            <li><a href="">Follow School</a></li>
                        </ul>
                        <span></span>
                    </div>
                </div>


                <div class="col-12 col-md-6 col-lg-3">
                    <div class="tile menu-p4">
                        <a href="">
                            <h4>Schools</h4>
                        </a>
                        <ul class="d-none">
                            <li><a href="">Register School</a></li>
                            <li><a href="">Manage Content</a></li>
                            <li><a href="">Integrate Social Media</a></li>
                        </ul>
                        <span></span>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="tile menu-p1">
                        <a href="">
                            <h4>Tutors</h4>
                        </a>
                        <ul class="d-none">
                            <li><a href="">Register School</a></li>
                            <li><a href="">Manage Content</a></li>
                            <li><a href="">Integrate Social Media</a></li>
                        </ul>
                        <span></span>
                    </div>
                </div>




            </div>
        </div>

    </section>

    <section class="intro expat-friend ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Friends of <span>Expats' School</span></h2>
                    <span>Change the world for teachers</span>
                </div>
            </div>


        <div class="row no-gutters">

             <div class="col-6 col-sm-4 col-lg-3">
                <a href="" class="tile swiss">
                    <h3>Swiss Quote</h3>
                    <span></span>
                </a>
             </div>
                <div class="col-6 col-sm-4 col-lg-3">
                <a href="" class="tile uprunning">
                    <h3>Up and running</h3>
                    <span></span>
                </a>
                </div>
                <div class="col-6 col-sm-4 col-lg-3">
                <a href="" class="tile dental">
                    <h3>My Dental Clinic</h3>
                    <span></span>
                </a>
                </div>
                    <div class="col-6 col-sm-4 col-lg-3">
                <a href="" class="tile high-bp">
                    <h3>Careem</h3>
                    <span></span>
                </a>
            </div>




        </div>

        </div>

    </section>

</main>


<script src="{{ asset('js/plugins/aos.js') }}"></script>
<script>

    $(document).on('click', '.go-epc', function()
    {
        document.location = path + '/expat-teachers-club';
    });
    $(document).on('click', '.join-now-epc', function()
    {
        document.location = path + '/login';
    });
    $(document).on('click', '.js_go_parent', function()
    {
        lscache.set('init_choice', 'parent' );
        document.location = path + '/login';
    });

    $(document).on('click', '.js_go_teacher', function()
    {
        lscache.set('init_choice', 'teacher' );
        document.location = path + '/login';
    });




    (function() {

        function id(v) {return document.getElementById(v);}
        function loadbar()
        {

            var ovrl = id("overlay"),
                prog = id("load-progress-in"),
                stat = id("progstat"),
                img = document.images,
                c = 0;
            tot = img.length;

            function imgLoaded()
            {
                c += 1;
                var perc = (((100 / tot) * c) << 0) + "%";
                prog.style.width = perc;
                stat.innerHTML = "Loading " + perc;
                if (c === tot) return doneLoading();
            }



            function doneLoading()
            {
                setTimeout(function()
                {
                    ovrl.classList.add("hideOverlay");
                    $('#overlay').remove();
                    $('main').removeClass('d-none');
                    AOS.init();
                    mainSlider();
                }, 3200);
            }

            for (var i = 0; i < tot; i++)
            {
                var tImg = new Image();
                tImg.onload = imgLoaded;
                tImg.onerror = imgLoaded;
                tImg.src = img[i].src;
            }


        }
        document.addEventListener("DOMContentLoaded", loadbar, false);
    })();

    $(document).ready(function(e) {


        $(".home-slides").owlCarousel({
            loop:true,
            nav:false,
            dots:true,
            autoplay:true,
            autoplayTimeout:5000,
            autoplayHoverPause:true,
            URLhashListener:true,
            startPosition:'URLHash',
            responsive: {

                0:{items:1},
                768:{items:1},
                992:{items:1},
                1200:{items:1}
             }
        });

        $(".expats-slides").owlCarousel({
            loop:true,
            nav:false,
            dots:false,
            autoplay:true,
            autoplayTimeout:5000,
            autoplayHoverPause:true,
            URLhashListener:false,

            responsive: {

                0:{items:1},
                768:{items:1},
                992:{items:1},
                1200:{items:1}
            }
        });

        $('.home-slides, .expats-slides').show();

       /* $(".food-menu").owlCarousel({
            loop:true,
            nav:false,
            autoplayTimeout:5000,
            autoplayHoverPause:true,
            responsive:
                {
                    0:{items:3},768:{items:4},992:{items:5},1200:{items:6},1300:{items:8}
                }
        });*/


        $(".spnsrd-slider").owlCarousel({
            loop: true,
            nav: false,
            center: true,
            margin: 10,
            autoplay:  true,
            autoplayTimeout:5000,
            autoplayHoverPause: true,
            responsive:{
                0:{
                    items:3
                },
                768:{
                    items:6
                },
                992:{
                    items:9
                },
            }
        });
    });

</script>


