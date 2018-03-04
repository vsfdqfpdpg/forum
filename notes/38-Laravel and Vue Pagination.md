1. Install moment
```html
npm install moment --save

import moment from 'moment';
ago(){
    return moment(this.data.created_at).fromNow() + '...';
}
```

2. [Mixins](../resources/assets/js/mixins/collection.js) mostly like trait in php.
```html
import collection from '../mixins/collection';

mixins : [collection],
```

3. Update url in address bar 
```html
updateUrl(){
    history.pushState(null,null,'?page=' + this.page);
}
```