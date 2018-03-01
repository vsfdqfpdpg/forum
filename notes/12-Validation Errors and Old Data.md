1. Check errors from session
```php
@if(count($errors))
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
```

2. Get old data from session
```php
<div class="form-group">
    <label for="channel_id">Choose a Channel:</label>
    <select name="channel_id" id="channel_id" class="form-control" required>
        <option value="">Choose one ...</option>
        @foreach(App\Channel::all() as $channel)
            <option value="{{ $channel->id }}" {{old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
        @endforeach
    </select>
</div>
```