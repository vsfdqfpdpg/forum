1. Install trix wysiwyg
```html
npm install trix
```

2. Wysiwyg
```html
<wysiwyg v-model="form.body" :value="form.body"></wysiwyg>
<wysiwyg name="body"></wysiwyg>
```

3. When trix text changes, emit input event and pass data to v-model.
```html
this.$refs.trix.addEventLister('trix-change',e=>{
   this.$emit('input',e.target.innerHTML);
});
```