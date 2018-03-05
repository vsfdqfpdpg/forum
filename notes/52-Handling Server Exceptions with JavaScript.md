1. Check npm installed model list.
```html
npm list --depth=0
```

2. Change flash component
```html
<div class="alert alert-flash" :class="'alert-'+level" role="alert" v-show="show" v-text="body"></div>
```