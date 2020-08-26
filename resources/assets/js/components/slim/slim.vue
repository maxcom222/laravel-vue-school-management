/*
 * Slim v5.2.1 - Image Cropping Made Easy
 * Copyright (c) 2019 Rik Schennink - https://pqina.nl/slim
 */
<template>
    <div class="slim">
        <slot></slot>
    </div>
</template>

<script>
  // Slim (place slim CSS and slim.module.js file in same folder as this file)
  import Slim from './slim.module.js'

  var instance = null

  export default {
    props: ['options'],
    name: 'slim-cropper',
    mounted: function () {
      if (this.options.initialImage) {
        var img = document.createElement('img')
        img.setAttribute('alt', '')
        img.src = this.options.initialImage
        this.$el.appendChild(img)
      }
      instance = new Slim(this.$el, this.options)
    },
    beforeDestroy: function () {
      instance.destroy()
    }
  }
</script>
<style lang="css">
    @import "./slim.min.css";
</style>
