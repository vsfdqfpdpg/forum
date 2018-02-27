1. Check user if login and add csrf_field
```php
@if(auth()->check())
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ $thread->path().'/replies' }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" id="body" cols="30" rows="5" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-default">Post</button>
            </form>
        </div>
    </div>
@else
    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
@endif
```