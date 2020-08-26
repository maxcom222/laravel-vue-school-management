/**
 * vue-on-clickout v1.0.8
 * (c) 2019 Mu-Tsun Tsai
 * Released under the MIT License.
 */

!function(e,n){"function"==typeof define&&define.amd?define([],n):"object"==typeof exports?module.exports=n():e.VueOnClickout=n()}(this,function(){const e={install(e){const n="clickout";let t=[],i=[],o=!1;function c(e,n){return n.contains(e)?-1:e.contains(n)?1:0}e.directive(n,{bind(e){t.unshift(e),o=!0,e.addEventListener(n,n=>{n.cancelBubble&&i.push(e)})},unbind(e){t.splice(t.indexOf(e),1)}}),document.addEventListener("click",e=>{o&&(t.sort(c),o=!1);for(let o of t)o.contains(e.target)||i.some(e=>o.contains(e))||o.dispatchEvent(new Event(n));i=[]}),e.mixin({beforeCreate(){let e=this._c;this._c=function(t,i,o,c){return i&&i.on&&i.on[n]&&(i.directives=i.directives||[],i.directives.some(e=>e.name==n)||i.directives.push({name:n,rawName:"v-"+n})),e(t,i,o,c)}}})}};return"undefined"!=typeof window&&window.Vue&&window.Vue.use(e),e});