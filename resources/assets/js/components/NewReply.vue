<template>
    <div v-if="signedIn">
            <div class="form-group">
                <wysiwyg name="body" v-model="body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg>
            </div>
            <button type="submit" class="btn btn-default" @click="addReply">Post</button>
    </div>
    <div v-else>
        <p class="text-center">Please <a href="/login">sign in</a> to participate in this
            discussion.</p>
    </div>
</template>

<script>
    import 'jquery.caret';
    import 'at.js';
    export default {
        data(){
            return { body : "", completed : false};
        },
        mounted(){
          $('#body').atwho({
              at : "@",
              delay : 750,
              callbacks : {
                  remoteFilter : function (query, callback) {
                      $.getJSON('/api/users',{ name : query}, function (username) {
                          callback(username);
                      })
                  }
              }
          })
        },
        methods : {
            addReply(){
                axios.post(location.pathname + '/replies',{ body : this.body})
                    .catch(error =>{
                        flash(error.response.data,'danger');
                    })
                    .then(({data})=> {
                       this.body = '';
                       /*this.$refs.trix.$refs.trix.value = '';*/
                       this.completed = true;
                       flash('Your reply has been posted.');
                       this.$emit('created',data);
                    });
            }
        }
    }
</script>
