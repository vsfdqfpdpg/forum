1. Every single reply instance will listen this best-reply-selected event.
```html
created(){
    window.events.$on('best-reply-selected',id=>{
        this.isBest = ( id == this.id);
    });
}
```