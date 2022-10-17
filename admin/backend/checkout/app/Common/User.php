<?php

namespace App\Common;

class User
{
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $is_influencer;

    public function __construct($json)
    {
        $this->id = $json['id'];
        $this->first_name = $json['first_name'];
        $this->last_name = $json['last_name'];
        $this->email = $json['email'];
        $this->is_influencer = $json['is_influencer'] ?? 0;
    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function isAdmin() : bool
    {
        return $this->is_influencer === 0;
    }
    public function isInfluencer() : bool
    {
        return $this->is_influencer === 1;
    }
    public function fullName(){
        return "{$this->first_name} {$this->last_name}";
    }
}
