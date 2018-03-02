<?php


namespace App;


trait RecordsActivity
{
    protected static function bootRecordsActivity(){
        if (auth()->guest()) return;
        foreach (static::getActivityToRecord() as $event){
            static::$event(function($model) use($event){
                $model->recordActivity($event);
            });
        }

        static::deleting(function($model){
            $model->activity()->delete();
        });
    }

    protected static function getActivityToRecord(){
        return ['created'];
    }

    /**
     * @param $event
     * @throws \ReflectionException
     */
    protected function recordActivity($event)
    {
        /*Activity::create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
            'subject_id' => $this->id,
            'subject_type' => get_class($this)
        ]);*/
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event)
        ]);
    }

    public function activity(){
        return $this->morphMany('App\Activity','subject');
    }

    /**
     * @param $event
     * @return string
     * @throws \ReflectionException
     */
    protected function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }
}