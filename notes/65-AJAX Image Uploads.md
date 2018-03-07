1. Form data
```html
let data = new FormData();
data.append('avatar',avatar);
axios.post(`/api/users/${this.user.name}/avatar`,data)
    .then(()=>flash('Avatar uploaded!'));
```

2. File reader
```html
if(!e.target.files.length) return;
let file = e.target.files[0];
let reader = new FileReader();
reader.readAsDataURL(file);
reader.onload = e => {
    // when file input changed and read the file and change the image src address.
    // this.avatar = e.target.result;
    
    this.$emit('loaded',{
        src : e.target.result,
        file : file
    });
}
```