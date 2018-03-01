```php
public function apply($builder)
{
    $this->builder = $builder;
    foreach ($this->filters as $filter){
        if (method_exists($this,$filter) && $this->request->has($filter)){
            $this->$filter($this->request->$filter);
        }
    }

    return $builder;
}
```

* Filter
```php
namespace App\Filter;


use Illuminate\Http\Request;

abstract class Filter
{

    /**
     * @var Request
     */
    protected $request;
    protected $builder;
    protected $filters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;
        foreach ($this->getFilters() as $filter => $value){
            if (method_exists($this,$filter)){
                $this->$filter($value);
            }
        }
        return $builder;
    }

    /**
     * @return array
     */
    public function getFilters(){
        return $this->request->intersect($this->filters);
    }
}
```

* ThreadFilter
```php
namespace App\Filter;


use App\User;

class ThreadFilter extends Filter
{
    protected $filters = ['by'];
    /**
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
}
```

* Thread
```php
public function scopeFilter($query,$filters){
    return $filters->apply($query);
}
```

* invoke
```php
protected function getThreads(Channel $channel, ThreadFilter $filters)
{
    $threads = Thread::latest()->filter($filters);
    if ($channel->exists) {
        $threads = $threads->where('channel_id', $channel->id);
    }
    $threads = $threads->get();
    return $threads;
}
```