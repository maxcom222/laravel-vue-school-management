<template>



    <div class="frame item-opt">
        <em>{{ adItem.price}}</em>
        <p class="d-none ph"><?php echo $result -> phone_number;?></p>
        <a href="" class="btn btn-sm btn-primary show_phone_number"><svg class="icon icon-phone"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-phone"></use></svg> Show Phone</a>
        <a href="" class="btn btn-sm btn-outline-primary js_fav  d-none "><svg class="icon icon-favorite"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-favorite"></use></svg> Watchlist</a>
        <a href="" data-id="<?php echo $result -> id;?>" data-title="<?php echo $result -> title;?>" class="btn btn-sm btn-outline-secondary js_ad_flag  report_ad"><svg class="icon icon-flag"><use xlink:href="{{ asset('css/ico/symbol-defs.svg') }}#icon-flag"></use></svg> Report Ad</a>
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


</template>

<script>
    export default {
        name: "detail_side",

        data(){


            return {

                about_url: this.fullPath + 'about',

                help_url: this.fullPath + 'help',

                privacy_url: this.fullPath + 'privacy',

                terms_url: this.fullPath + 'terms',



            }
        }
    }
</script>

<style scoped>

</style>