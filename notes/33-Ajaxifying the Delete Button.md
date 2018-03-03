1. Axios delete request. $el
```vue
destroy(){
    axios.delete('/replies/'+this.attributes.id);
    $(this.$el).fadeOut(300, ()=>{
        flash('Your reply has been deleted.')
    });
}
```