<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function headers()
    {
        return [
            'X-Requested-With' => 'XMLHttpRequest',
            'Authorization' => request()->headers->get('Authorization'),
        ];
    }
    public function getUser() : User
    {
        // $headers = $request->headers->all();
        // get token fro cookie
        // $token = $request->cookie('atkn');
        // $headers = [
        //     'Authorization' => 'Bearer ' . $token,
        // ];
        // $response = \Http::withHeaders($headers)->get('http://127.0.0.1:8001/api/user');
        // windows IP address
        $json = \Http::withHeaders($this->headers())->get(env('EndPoint').'/user')->json();
        $user = new User();
        $user->id = $json['id'];
        $user->first_name = $json['first_name'];
        $user->last_name = $json['last_name'];
        $user->email = $json['email'];
        // $user->is_admin = $json['is_admin'];
        $user->is_influencer = $json['is_influencer'];
        return $user;
    }
    public function isAdmin(){
        return \Http::withHeaders($this->headers())->get(env('EndPoint').'/admin')->successful();
    }
    public function isInfluencer(){
        return \Http::withHeaders($this->headers())->get(env('EndPoint').'/influencer')->successful();
    }
    public function allows($ability,$arguments){
       return \Gate::forUser($this->getUser())->authorize($ability, $arguments);
    }
}
