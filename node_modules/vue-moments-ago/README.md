# vue-moments-ago

A Vue.js component for updating human readable time format.

eg:

```
posted 2 minutes ago
```

this is automatically updated without any refresh. Checkout this [Live Demo](https://codesandbox.io/s/m4x9kw090p)

### Install

```
npm install vue-moments-ago
```

and in your component file script tag,

```
import VueMomentsAgo from 'vue-moments-ago'

export default{
  components: {
    VueMomentsAgo
  }
}
```

in the template, use:

```
<vue-moments-ago prefix="posted" suffix="ago" date="2018-05-02T20:22:22.285Z" lang="en"></vue-moments-ago>
```

result:

```
 posted 2 minutes ago
```

### Props

| Props    | Required | Type   | Definition                                            |
| :------- | :------- | :----- | :---------------------------------------------------- |
| prefix   | false    | String | Any prefix string you want to add to the output       |
| suffix   | false    | String | Any suffix string you want to add to the output       |
| date     | true     | String | The date is in ISO 8601 (default format of moment.js) |
| language | false    | String | default is "en"                                       |

### Support Language

We support English, Korean and Japanese. y Language options are available. default value is "en".

```
en kr jp
```
