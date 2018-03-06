1.Button click event will not trigger input required validation. Only form submit.
```html
<form @submit="update">
    <div class="form-group">
        <textarea name="" id="" class="form-control" v-model="body" required></textarea>
    </div>
    <button class="btn btn-xs btn-primary" type="submit">Update</button>
    <button class="btn btn-xs btn-link" @click="editing = false" type="button">Cancel</button>
</form>
```