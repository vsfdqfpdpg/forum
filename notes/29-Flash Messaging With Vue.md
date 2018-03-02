1. Flash message to session.
```php
return back()
            ->with('flash','Your reply has been left.');

return redirect($thread->path())
            ->with('flash','Your thread has been published.');
```

2. Fire and listen event.
```vue
// window.events, window.flush are declared as global functions helper.
window.events = new Vue();

window.flush = function (message) {
    window.events.$emit('flush',message); // Fire an event.
}

window.events.$on('flash',message => this.flash(message)); //Listening on an event.
```

3. Vue component
```vue
Vue.component('flash', require('./components/Flash.vue'));
```
[Flash.vue](../resources/assets/js/components/Flash.vue)
```vue
<template>
    <div class="alert alert-success alert-flash" role="alert" v-show="show">
        <strong>Success!</strong>　{{ body }}
    </div>
</template>

<script>
    export default {
        props : ['message'], // component's property
        data(){ // component's filed
            return { body : '', show : false }
        },
        created() {
            if(this.message){
                this.flash(this.message);
            }
            window.events.$on('flash',message => this.flash(message));
        },
        methods :{
            flash(message){
                this.body = message;
                this.show = true;
                this.hide();
            },
            hide(){
                setTimeout(()=>{
                   this.show = false;
                },3000);
            }
        }
    }
</script>

<style>
    .alert-flash{
        position: fixed;
        bottom: 25px;
        right: 25px;
    }
</style>
```

4. Get message from session
```php
session('flash')
``` 

5. Npm commands
```php
npm install
npm run dev
npm run watch
```