1. Group by date
```php
return $user->activity()->latest()->with('subject')->take(50)->get()->groupBy(function ($activity) {
    return $activity->created_at->format('Y-m-d');
});
```
2.Polymorphic include partial of blade template. The second parameter of Include directive will pass date to blade template. 
```php
@include("profiles.activities.{$record->type}",['activity' => $record])
```
3. Create a component and setup component variable.
```php
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <span class="flex">
                {{ $heading }}
            </span>
        </div>
    </div>
    <div class="panel-body">
        {{ $body }}
    </div>
</div>
```

4. Implement component
```php
@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} replied to <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
```