<!doctype html>
<html lang="en">
<head>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1,height=device-height,  minimum-scale=1.0, user-scalable=no, shrink-to-fit=no">

    <meta name="description" content="Welcome to the one stop home for international education. Enjoy big savings from our Education Professionals Club. Browse international schools and get tips, FAQs and comprehensive answers from the people who know. Connect with colleagues, parents and schools, read and write about the latest news and opinions, build your CV and apply for the latest jobs with our simple to use application process.">

    <meta name="author" content="expatsschools">

    <meta name="keywords" content="education, expats, international schools, teachers, special offers, jobs, tutors, community, deals, parents, cheap, discounts">

    <title><?php echo e($title); ?></title>


    <link href="<?php echo e(asset('js/plugins/bootstrap/bootstrap.min.css')); ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e(asset('js/plugins/owl.css')); ?>">

    <link href="<?php echo  url('css/es.css?t='. time() );?>" media="all" rel="stylesheet" type="text/css" />


    <script src="<?php echo e(asset('js/jquery-latest.min.js')); ?>"></script>


    <meta name="google-site-verification" content="OvqM-soyy3ToUoivtKbFx90NtDZo8_6FgD3hBqfdmjM" />


    <link rel="shortcut icon" href="<?php echo e(asset('css/img/favicon.ico')); ?>">



  <?php if(  $page  ==  'main' || $page == 'single_main' ): ?>

    <link href="<?php echo  url('css/home.css?t='. time() );?>" media="all" rel="stylesheet" type="text/css" />


  <?php endif; ?>




  <?php if(  $page  ==  'login' ||  $page == 'teachers/profile_wizard'  ): ?>


    <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />

  <?php endif; ?>


<?php if(   $page == 'search'  ): ?>


    <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />

    <link href="<?php echo e(asset('css/plugins/dropzone.min.css')); ?>" rel="stylesheet" />


<?php endif; ?>


  <?php if(  $page  ==  'classified/place_ad' ||  $page == 'classified/edit_place_ad' ): ?>

    <link href="<?php echo e(asset('css/plugins/dropzone.min.css')); ?>" rel="stylesheet" />

  <?php endif; ?>


  <?php if(  $page  ==  'classified' ): ?>


    <link href="<?php echo e(asset('css/plugins/dropzone.min.css')); ?>" rel="stylesheet" />

  <?php endif; ?>

<?php if(  $page  ==  'classified/detail' ): ?>
<link href="<?php echo e(asset('css/plugins/dropzone.min.css')); ?>" rel="stylesheet" />

<?php endif; ?>

<?php if(  $page  ==  'teachers/profile_wizard' ): ?>
<link href="<?php echo e(asset('css/profile_wizard.css')); ?>" rel="stylesheet" />
<?php endif; ?>

<?php if(  $page  ==  'reset_password' ): ?>
<link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />
<?php endif; ?>

<?php if(  $page  ==  'teachers/profile_teacher' || $page == 'teachers/profile_public_teacher' ): ?>
<link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('css/plugins/dropzone.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('css/profile_teachers.css')); ?>" rel="stylesheet" />
<?php endif; ?>


    <?php if(  $page  ==  'coffe_club/staff_room'   ||   $page  ==  'coffe_club/forum_detail'): ?>

        <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />
        <link href="<?php echo e(asset('css/plugins/dropzone.min.css')); ?>" rel="stylesheet" />

    <?php endif; ?>



  <?php if(  $page  ==  'coffe_club/club'  ): ?>

    <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" />

    <link href="<?php echo e(asset('css/plugins/dropzone.min.css')); ?>" rel="stylesheet" />

    <link href="<?php echo  url('css/club.css?t='. time() );?>" media="all" rel="stylesheet" type="text/css" />

  <?php endif; ?>


  <?php if(  $page  ==  'friends' ||  $page  ==  'single_main'   ): ?>

    <link href="<?php echo e(asset('css/plugins/aos.css')); ?>" rel="stylesheet" />

    <link href="<?php echo  url('css/friends.css?t='. time() );?>" media="all" rel="stylesheet" type="text/css" />

  <?php endif; ?>


<?php if(  $page  ==  'coffe_club/forum_detail' || $page == 'schools/job_detail' || $page == 'jobs/job_detail' || $page == 'classified/detail' || $page == 'schools/school_albums'   ): ?>

<meta property="og:title" content="<?php echo $og_title;?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo $og_url;?>" />
<meta property="og:image" content="<?php echo $og_logo;?>" />
<meta property="og:description" content="<?php echo $og_desc;?>" />
<meta property="fb:app_id" content="561932677537682"/>

<?php endif; ?>

</head>
<script>

    var map_ico = '<?php echo url('/'); ?>' + '/css/img/marker.png';

</script>

<body fullPath="<?php echo e(url('/')); ?>" ><div id="fb-root"></div>


<div id="app">




    <header-component v-if="noHeader!==1"

            :user="authUser" :full-path="fullPath"

            page="<?php echo e($page); ?>"

    >

    </header-component>




   <?php echo $__env->make("{$page}", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        <div id="logoutDialog" class="d-none">

            <transition name="modal">

                <div class="modal-mask">

                    <div class="modal-wrapper">

                        <div class="modal-dialog" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">Logout</h5>


                                </div>

                                <div class="modal-body" style="height:50px;">

                                    <p>Your  session  has expired.</p>

                                </div>

                                <div class="modal-footer "  >

                                    <button type="button" class="btn  btn-primary btn-continue" @click="redirectHome">Continue</button>

                                </div>

                            </div>
                        </div>


                    </div>

                </div>

            </transition>

        </div>


    <footer-component   v-if="noHeader!==1"   :full-path="fullPath">


    </footer-component>






</div>




<style>

#logoutDialog .modal-body { overflow: hidden; }


.profile-ui-page .vs__dropdown-toggle {

    box-shadow: none;
    height: 34px;
    border-left: 0;
    border-radius: 0;
}
.profile-ui-page .modal-body{

    height:500px;
}
#pills-tabContent  .vs__dropdown-toggle
{
    height: 38px;
    box-shadow: none;
}


#pills-step-3 .btn-dark {
    color: #fff;
    background-color: #3e3d95;
    border-color: #3e3d95;
}

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
    .modal-body{ height: 100px;}
    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }



    .owl-theme .owl-nav {
        margin-top: 10px;
        text-align: center;
        -webkit-tap-highlight-color: transparent; }
    .owl-theme .owl-nav [class*='owl-'] {
        color: #FFF;
        font-size: 14px;
        margin: 5px;
        padding: 4px 7px;
        background: #D6D6D6;
        display: inline-block;
        cursor: pointer;
        border-radius: 3px; }
    .owl-theme .owl-nav [class*='owl-']:hover {
        background: #869791;
        color: #FFF;
        text-decoration: none; }
    .owl-theme .owl-nav .disabled {
        opacity: 0.5;
        cursor: default; }

    .owl-theme .owl-nav.disabled + .owl-dots {
        margin-top: 10px; }

    .owl-theme .owl-dots {
        text-align: center;
        -webkit-tap-highlight-color: transparent; }
    .owl-theme .owl-dots .owl-dot {
        display: inline-block;
        zoom: 1;
        *display: inline; }
    .owl-theme .owl-dots .owl-dot span {
        width: 10px;
        height: 10px;
        margin: 5px 7px;
        background: #D6D6D6;
        display: block;
        -webkit-backface-visibility: visible;
        transition: opacity 200ms ease;
        border-radius: 30px; }
    .owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span {
        background: #869791; }

    .v-select{position:relative;font-family:inherit}.v-select,.v-select *{box-sizing:border-box}@-webkit-keyframes vSelectSpinner{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}@keyframes  vSelectSpinner{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}.vs__fade-enter-active,.vs__fade-leave-active{transition:opacity .15s cubic-bezier(1,.5,.8,1)}.vs__fade-enter,.vs__fade-leave-to{opacity:0}.vs--disabled .vs__clear,.vs--disabled .vs__dropdown-toggle,.vs--disabled .vs__open-indicator,.vs--disabled .vs__search,.vs--disabled .vs__selected{cursor:not-allowed;background-color:#f8f8f8}.v-select[dir=rtl] .vs__actions{padding:0 3px 0 6px}.v-select[dir=rtl] .vs__clear{margin-left:6px;margin-right:0}.v-select[dir=rtl] .vs__deselect{margin-left:0;margin-right:2px}.v-select[dir=rtl] .vs__dropdown-menu{text-align:right}.vs__dropdown-toggle{-webkit-appearance:none;-moz-appearance:none;appearance:none;display:flex;padding:0 0 4px;background:none;border:1px solid rgba(60,60,60,.26);border-radius:4px;white-space:normal}.vs__selected-options{display:flex;flex-basis:100%;flex-grow:1;flex-wrap:wrap;padding:0 2px;position:relative}.vs__actions{display:flex;align-items:center;padding:4px 6px 0 3px}.vs--searchable .vs__dropdown-toggle{cursor:text}.vs--unsearchable .vs__dropdown-toggle{cursor:pointer}.vs--open .vs__dropdown-toggle{border-bottom-color:transparent;border-bottom-left-radius:0;border-bottom-right-radius:0}.vs__open-indicator{fill:rgba(60,60,60,.5);-webkit-transform:scale(1);transform:scale(1);transition:-webkit-transform .15s cubic-bezier(1,-.115,.975,.855);transition:transform .15s cubic-bezier(1,-.115,.975,.855);transition:transform .15s cubic-bezier(1,-.115,.975,.855),-webkit-transform .15s cubic-bezier(1,-.115,.975,.855);transition-timing-function:cubic-bezier(1,-.115,.975,.855)}.vs--open .vs__open-indicator{-webkit-transform:rotate(180deg) scale(1);transform:rotate(180deg) scale(1)}.vs--loading .vs__open-indicator{opacity:0}.vs__clear{fill:rgba(60,60,60,.5);padding:0;border:0;background-color:transparent;cursor:pointer;margin-right:8px}.vs__dropdown-menu{display:block;position:absolute;top:calc(100% - 1px);left:0;z-index:1000;padding:5px 0;margin:0;width:100%;max-height:350px;min-width:160px;overflow-y:auto;box-shadow:0 3px 6px 0 rgba(0,0,0,.15);border:1px solid rgba(60,60,60,.26);border-top-style:none;border-radius:0 0 4px 4px;text-align:left;list-style:none;background:#fff}.vs__no-options{text-align:center}.vs__dropdown-option{line-height:1.42857143;display:block;padding:3px 20px;clear:both;color:#333;white-space:nowrap}.vs__dropdown-option:hover{cursor:pointer}.vs__dropdown-option--highlight{background:#5897fb;color:#fff}.vs__selected{display:flex;align-items:center;background-color:#f0f0f0;border:1px solid rgba(60,60,60,.26);border-radius:4px;color:#333;line-height:1.4;margin:4px 2px 0;padding:0 .25em}.vs__deselect{display:inline-flex;-webkit-appearance:none;-moz-appearance:none;appearance:none;margin-left:4px;padding:0;border:0;cursor:pointer;background:none;fill:rgba(60,60,60,.5);text-shadow:0 1px 0 #fff}.vs--single .vs__selected{background-color:transparent;border-color:transparent}.vs--single.vs--open .vs__selected{position:absolute;opacity:.4}.vs--single.vs--searching .vs__selected{display:none}.vs__search::-ms-clear,.vs__search::-webkit-search-cancel-button,.vs__search::-webkit-search-decoration,.vs__search::-webkit-search-results-button,.vs__search::-webkit-search-results-decoration{display:none}.vs__search,.vs__search:focus{-webkit-appearance:none;-moz-appearance:none;appearance:none;line-height:1.4;font-size:1em;border:1px solid transparent;border-left:none;outline:none;margin:4px 0 0;padding:0 7px;background:none;box-shadow:none;width:0;max-width:100%;flex-grow:1}.vs__search::-webkit-input-placeholder{color:inherit}.vs__search:-ms-input-placeholder{color:inherit}.vs__search::-ms-input-placeholder{color:inherit}.vs__search::placeholder{color:inherit}.vs--unsearchable .vs__search{opacity:1}.vs--unsearchable .vs__search:hover{cursor:pointer}.vs--single.vs--searching:not(.vs--open):not(.vs--loading) .vs__search{opacity:.2}.vs__spinner{align-self:center;opacity:0;font-size:5px;text-indent:-9999em;overflow:hidden;border:.9em solid hsla(0,0%,39.2%,.1);border-left-color:rgba(60,60,60,.45);-webkit-transform:translateZ(0);transform:translateZ(0);-webkit-animation:vSelectSpinner 1.1s linear infinite;animation:vSelectSpinner 1.1s linear infinite;transition:opacity .1s}.vs__spinner,.vs__spinner:after{border-radius:50%;width:5em;height:5em}.vs--loading .vs__spinner{opacity:1}


    .v-select {

        position: relative;

        font-family: sans-serif
    }

    .v-select,
    .v-select * {
        box-sizing: border-box
    }

    .v-select.rtl .open-indicator {
        left: 10px;
        right: auto
    }

    .v-select.rtl .selected-tag {
        float: right;
        margin-right: 3px;
        margin-left: 1px
    }

    .v-select.rtl .dropdown-menu {
        text-align: right
    }

    .v-select.rtl .dropdown-toggle .clear {
        left: 30px;
        right: auto
    }

    .v-select .open-indicator {
        position: absolute;
        bottom: 6px;
        right: 10px;
        cursor: pointer;
        pointer-events: all;
        opacity: 1;
        height: 20px
    }

    .v-select .open-indicator,
    .v-select .open-indicator:before {
        display: inline-block;
        transition: all .15s cubic-bezier(1, -.115, .975, .855);
        transition-timing-function: cubic-bezier(1, -.115, .975, .855);
        width: 10px
    }

    .v-select .open-indicator:before {
        border-color: rgba(60, 60, 60, .5);
        border-style: solid;
        border-width: 3px 3px 0 0;
        content: "";
        height: 10px;
        vertical-align: top;
        transform: rotate(133deg);
        box-sizing: inherit
    }

    .v-select.open .open-indicator:before {
        transform: rotate(315deg)
    }

    .v-select.loading .open-indicator {
        opacity: 0
    }

    .v-select.open .open-indicator {
        bottom: 1px
    }

    .v-select .dropdown-toggle {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        display: block;
        padding: 0;
        background: none;
        border: 1px solid rgba(60, 60, 60, .26);
        border-radius: 4px;
        white-space: normal
    }

    .v-select .dropdown-toggle:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0
    }

    .v-select .dropdown-toggle .clear {
        position: absolute;
        bottom: 9px;
        right: 30px;
        font-size: 23px;
        font-weight: 700;
        line-height: 1;
        color: rgba(60, 60, 60, .5);
        padding: 0;
        border: 0;
        background-color: transparent;
        cursor: pointer
    }

    .v-select.searchable .dropdown-toggle {
        cursor: text
    }

    .v-select.unsearchable .dropdown-toggle {
        cursor: pointer
    }

    .v-select.open .dropdown-toggle {
        border-bottom-color: transparent;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0
    }

    .v-select .dropdown-menu {
        display: block;
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        min-width: 160px;
        padding: 5px 0;
        margin: 0;
        width: 100%;
        overflow-y: scroll;
        border: 1px solid rgba(0, 0, 0, .26);
        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, .15);
        border-top: none;
        border-radius: 0 0 4px 4px;
        text-align: left;
        list-style: none;
        background: #fff
    }

    .v-select .no-options {
        text-align: center
    }

    .v-select .selected-tag {
        color: #333;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 4px;
        height: 26px;
        margin: 4px 1px 0 3px;
        padding: 1px .25em;
        float: left;
        line-height: 24px
    }

    .v-select.single .selected-tag {
        background-color: transparent;
        border-color: transparent
    }

    .v-select.single.open .selected-tag {
        position: absolute;
        opacity: .5
    }

    .v-select.single.loading .selected-tag,
    .v-select.single.open.searching .selected-tag {
        display: none
    }

    .v-select .selected-tag .close {
        float: none;
        margin-right: 0;
        font-size: 20px;
        appearance: none;
        padding: 0;
        cursor: pointer;
        background: 0 0;
        border: 0;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: .2
    }

    .v-select.single.searching:not(.open):not(.loading) input[type=search] {
        opacity: .2
    }

    .v-select input[type=search]::-webkit-search-cancel-button,
    .v-select input[type=search]::-webkit-search-decoration,
    .v-select input[type=search]::-webkit-search-results-button,
    .v-select input[type=search]::-webkit-search-results-decoration {
        display: none
    }

    .v-select input[type=search]::-ms-clear {
        display: none
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        line-height: 1.42857143;
        font-size: 1em;
        height: 34px;
        display: inline-block;
        border: none;
        outline: none;
        margin: 0;
        padding: 0 .5em;
        width: 10em;
        max-width: 100%;
        background: none;
        position: relative;
        box-shadow: none
    }

    .v-select.unsearchable input[type=search] {
        opacity: 0
    }

    .v-select.unsearchable input[type=search]:hover {
        cursor: pointer
    }

    .v-select li {
        line-height: 1.42857143
    }

    .v-select li>a {
        display: block;
        padding: 3px 20px;
        clear: both;
        color: #333;
        white-space: nowrap
    }

    .v-select li:hover {
        cursor: pointer
    }

    .v-select .dropdown-menu .active>a {
        color: #333;
        background: rgba(50, 50, 50, .1)
    }

    .v-select .dropdown-menu>.highlight>a {
        background: #5897fb;
        color: #fff
    }

    .v-select .highlight:not(:last-child) {
        margin-bottom: 0
    }

    .v-select .spinner {
        opacity: 0;
        position: absolute;
        top: 5px;
        right: 10px;
        font-size: 5px;
        text-indent: -9999em;
        overflow: hidden;
        border-top: .9em solid hsla(0, 0%, 39%, .1);
        border-right: .9em solid hsla(0, 0%, 39%, .1);
        border-bottom: .9em solid hsla(0, 0%, 39%, .1);
        border-left: .9em solid rgba(60, 60, 60, .45);
        transform: translateZ(0);
        animation: vSelectSpinner 1.1s infinite linear;
        transition: opacity .1s
    }

    .v-select .spinner,
    .v-select .spinner:after {
        border-radius: 50%;
        width: 5em;
        height: 5em
    }

    .v-select.disabled .dropdown-toggle,
    .v-select.disabled .dropdown-toggle .clear,
    .v-select.disabled .dropdown-toggle input,
    .v-select.disabled .open-indicator,
    .v-select.disabled .selected-tag .close {
        cursor: not-allowed;
        background-color: #f8f8f8
    }

    .v-select.loading .spinner {
        opacity: 1
    }

    @-webkit-keyframes vSelectSpinner {
        0% {
            transform: rotate(0deg)
        }
        to {
            transform: rotate(1turn)
        }
    }

    @keyframes  vSelectSpinner {
        0% {
            transform: rotate(0deg)
        }
        to {
            transform: rotate(1turn)
        }
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .15s cubic-bezier(1, .5, .8, 1)
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0
    }

    .vs__dropdown-toggle{

        height:38px;

        box-shadow: 0 1px 6px rgba(57,73,76,0.35);
        background: #FFF;
    }

    .modal-mask{

        overflow-x: hidden;
        overflow-y: scroll;
        display:block;
    }

    .modal-wrapper {

        display:block ;
    }
    @media (min-width: 1200px)
    {
        .pro-edit .btn-edit:last-of-type {
            top: 10px;
            right: 20px;
        }
    }

    .frame {
        border:none ;
        box-shadow: 0 1px 6px rgba(57,73,76,0.35);
        background:linear-gradient(to bottom,#3e3d95,#3e3d95 4px,#fff 4px,#fff);

    }

    .frame .nav-link{color: #3e3d95; font-size: 1.1em;}
    .nav.frame{padding:10px;}

    .vs--single .vs__selected {
        background-color: transparent;
        border-color: transparent;
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        display: inline-block;
        width: 186px;
    }

    .vs--single .vs__selected{

        text-align: left;

        padding-top: 5px;
    }

 .searchBox{

     box-shadow: 0 1px 6px rgba(57,73,76,0.35);

     padding: 10px;

     height: 200px;

     overflow-y: auto;

     overflow-x:hidden;

     margin-bottom: 30px;
 }

.search-frm input{padding-left: 0;font-family: verdana;font-size: 13px;     box-shadow: none;  outline: none;}

.autocomplete__inputs input:focus{    box-shadow: none;}
.mg-bottom-col-10{

    margin-bottom: 40px;  margin-top: 30px;

}


</style>


<script>


    !function(a,b){"function"===typeof define&&define.amd?define([],b):"undefined"!==typeof module&&module.exports?module.exports=b():a.lscache=b()}(this,function(){function a(){var a="__lscachetest__",c=a;if(void 0!==o)return o;try{if(!localStorage)return!1}catch(a){return!1}try{h(a,c),i(a),o=!0}catch(a){o=!(!b(a)||!localStorage.length)}return o}function b(a){return a&&("QUOTA_EXCEEDED_ERR"===a.name||"NS_ERROR_DOM_QUOTA_REACHED"===a.name||"QuotaExceededError"===a.name)}function c(){return void 0===p&&(p=null!=window.JSON),p}function d(a){return a.replace(/[[\]{}()*+?.\\^$|]/g,"\\$&")}function e(a){return a+r}function f(){return Math.floor((new Date).getTime()/t)}function g(a){return localStorage.getItem(q+v+a)}function h(a,b){localStorage.removeItem(q+v+a),localStorage.setItem(q+v+a,b)}function i(a){localStorage.removeItem(q+v+a)}function j(a){for(var b=new RegExp("^"+q+d(v)+"(.*)"),c=localStorage.length-1;c>=0;--c){var f=localStorage.key(c);f=f&&f.match(b),f=f&&f[1],f&&f.indexOf(r)<0&&a(f,e(f))}}function k(a){var b=e(a);i(a),i(b)}function l(a){var b=e(a),c=g(b);if(c){var d=parseInt(c,s);if(f()>=d)return i(a),i(b),!0}}function m(a,b){w&&"console"in window&&"function"==typeof window.console.warn&&(window.console.warn("lscache - "+a),b&&window.console.warn("lscache - The error was: "+b.message))}function n(a){return Math.floor(864e13/a)}var o,p,q="lscache-",r="-cacheexpiration",s=10,t=6e4,u=n(t),v="",w=!1,x={set:function(d,l,n){if(a()&&c()){try{l=JSON.stringify(l)}catch(a){return}try{h(d,l)}catch(a){if(!b(a))return void m("Could not add item with key '"+d+"'",a);var o,p=[];j(function(a,b){var c=g(b);c=c?parseInt(c,s):u,p.push({key:a,size:(g(a)||"").length,expiration:c})}),p.sort(function(a,b){return b.expiration-a.expiration});for(var q=(l||"").length;p.length&&q>0;)o=p.pop(),m("Cache is full, removing item with key '"+d+"'"),k(o.key),q-=o.size;try{h(d,l)}catch(a){return void m("Could not add item with key '"+d+"', perhaps it's too big?",a)}}n?h(e(d),(f()+n).toString(s)):i(e(d))}},get:function(b){if(!a())return null;if(l(b))return null;var d=g(b);if(!d||!c())return d;try{return JSON.parse(d)}catch(a){return d}},remove:function(b){a()&&k(b)},supported:function(){return a()},flush:function(){a()&&j(function(a){k(a)})},flushExpired:function(){a()&&j(function(a){l(a)})},setBucket:function(a){v=a},resetBucket:function(){v=""},getExpiryMilliseconds:function(){return t},setExpiryMilliseconds:function(a){t=a,u=n(t)},enableWarnings:function(a){w=a}};return x});

</script>


<script src="<?php echo  url('js/app.js?t='. time() );?>"></script>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyB_O3eana1MbjibnAWKwIg7cPCHXQ-8fN4&libraries=places"  type="text/javascript"></script>


<script src="<?php echo e(asset('js/popper.min.js')); ?>" ></script>


<script src="<?php echo e(asset('confetti.js')); ?>"></script>


<script src="<?php echo e(asset('js/plugins/plugins.js')); ?>"></script>

<script src="<?php echo e(asset('js/plugins/bootstrap.min.js')); ?>"></script>

<script async="" src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>





<?php if(  $page  ==  'ecp' ): ?>

<script>


    var interval ;
    global_deal_counter = 0;
    function change_deal_color()
    {
        $('.deals a').removeClass('highlight-box');
        $('.deals a:eq('+ global_deal_counter +')').addClass('highlight-box')
        global_deal_counter ++;
        if(global_deal_counter > 8) { clearInterval(interval) ; }
    }



    $(document).on('click', '.js_join', function()
    {
        lscache.set('init_choice', 'teacher' );
        document.location  = path + '/login' ;
    });
    $(document).on('click', '.f-red', function()
    {
        document.location  = $(this).attr('data-url');
    });


    $(document).ready(function(){ interval = setInterval( change_deal_color, 500); });


    $(document).ready(function()
    {

        $(".owl-gallery").owlCarousel({
            loop:true,nav:false,autoplay:true,autoplayTimeout:5000,autoplayHoverPause:true,margin: 20,responsive:
                {
                    0:{items:4}, 768:{items:3}, 992:{items:3},
                }
        });

        $(".owl-main").owlCarousel({
            loop:true,nav:false,autoplay:true,autoplayTimeout:5000,autoplayHoverPause:true,margin: 20,responsive:
                {
                    0:{items:1}, 768:{items:1}, 992:{items:1},
                }
        });
    });

</script>
<?php endif; ?>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/es/resources/views/template.blade.php ENDPATH**/ ?>