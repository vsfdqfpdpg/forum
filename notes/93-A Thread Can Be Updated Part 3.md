1. v-model will not take input's value as value. It takes from vue's data.
```html
<input type="text" class="form-control" v-model="form.title">
<textarea name="" id="" class="form-control" v-model="form.body"></textarea>
```