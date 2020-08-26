# Vue-On-Clickout

> Add `v-on:clickout` event to elements in [Vue.js](https://www.npmjs.com/package/vue).

[![npm version](https://img.shields.io/npm/v/vue-on-clickout.svg)](https://www.npmjs.com/package/vue-on-clickout)

There are many packages [<sup>1</sup>](#1) that uses custom directives to capture and
handles the "click outside" event of an element. Majority of them have the same common
problem: they do not accept directly writing expression in the custom directive, as in the
case of the `v-on` event handlers. This creates inconsistency in the coding style and
is really bothering to me. There are a few existing packages that manage
to evaluate the given expression, but still the syntax looks different, with all other
events uses `v-on:` or `@` syntax, while only the clickout event being the exception.

Therefore I created Vue-On-Clickout which is different from all of them.
It actually creates the "clickout" event and you simply write `v-on:clickout="..."`
or `@clickout="..."` as in any other events.

<a class="anchor" id="1"><sup>1</sup></a> Such as
[vue-clickaway](https://www.npmjs.com/package/vue-clickaway),
[vue-clickout](vue-clickout),
[vue-directive-clickout](https://github.com/LinusBorg/vue-directive-clickout),
[vue-click-outside](https://www.npmjs.com/package/vue-click-outside),
[v-click-outside](https://www.npmjs.com/package/v-click-outside),
[vue-v-clickoutside](https://www.npmjs.com/package/vue-v-clickoutside),
[vue-on-click-outside](https://www.npmjs.com/package/vue-on-click-outside),
[vue-outside-click](https://www.npmjs.com/package/vue-outside-click),
[vue-clickoutside](https://github.com/freeze-component/vue-clickoutside),
to name a few.

## License

MIT License

## Install

You can get Vue-On-Clickout as an NPM package by running:
```bash
npm install vue-on-clickout --save
```
Or, simply download `vue-on-clickout.js`.


## Usage

Vue-On-Clickout can be used both with or without modules.

### With modules

```javascript
import VueOnClickout from 'vue-on-clickout';

Vue.use(VueOnClickout);
...
```

### Without modules

```html
<!-- place this after loading vue.js -->
<script src="vue-on-clickout.js"></script>
<!-- no need to call Vue.use(); it does that automatically -->
```

And then in your template, on any element, use `v-on:clickout="..."` or `@clickout="..."` and watch the magic happen. You can also use the `.stop` modifier. The following example demonstrates it all.

```html
<div id="app">
	<div style="padding:20px; background:blue;" v-on:clickout="color='white'">
		<div style="padding:20px; background:red;" @clickout.stop="color='blue'" v-if="showRed">
			<div style="padding:20px; background:yellow;" v-on:clickout="color='red'" v-on:click="color='yellow'">{{color}}
			</div>
		</div>
		<div v-else style="color:white;" v-on:click="color='blue'">{{color}}</div>
	</div>
</div>
<script>
	var app = new Vue({
		el: "#app",
		data: {
			color: 'yellow',
			showRed: true
		}
	});
</script>
```
In this example, you would not see the word 'white' showing up, because the clickout event stops at the red `<div>`. But once you run `app.showRed=false` in the console, the clickout event of the blue `<div>` works again.