<template>

    <div id="overlay" class="hover_ease_5">

        <div class="load-progress-wrapper">

            <img class="load-progress-logo" :src="logo_anim">

            <div id="load-progress">

                <span id="load-progress-in"></span>

            </div>

            <div style="opacity: 0;" id="progstat"></div>

        </div>

        <span class="circle"></span>


    </div>

</template>

<script>
    export default {

        name: "LoadAnim",

        data(){


            return {

                logo_anim:  this.fullPath + 'css/img/logo_anim.png',
            }
        }
    }
</script>

<style scoped>

</style>