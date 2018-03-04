<?php


namespace App\Filter;


use App\User;

class ThreadFilter extends Filter
{
    protected $filters = ['by','popular','unanswered'];
    /**
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    protected function popular(){
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count','DESC');
    }

    protected function unanswered(){
        return $this->builder->where('replies_count',0);
    }
}