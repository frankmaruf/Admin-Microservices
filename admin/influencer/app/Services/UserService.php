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
    public function request()
    {
        return \Http::withHeaders($this->headers());
    }
    public function parseUser($json): User
    {
        $user = new User();
        $user->id = $json['id'];
        $user->first_name = $json['first_name'];
        $user->last_name = $json['last_name'];
        $user->email = $json['email'];
        $user->is_influencer = $json['is_influencer'] ?? 0;
        return $user;
    }
    public function getUser(): User
    {
        $json = $this->request()->get(env('EndPoint') . '/user')->json();
        return $this->parseUser($json);
    }
    public function isAdmin()
    {
        return $this->request()->get(env('EndPoint') . '/admin')->successful();
    }
    public function isInfluencer()
    {
        return $this->request()->get(env('EndPoint') . '/influencer')->successful();
    }
    public function allows($ability, $arguments)
    {
        return \Gate::forUser($this->getUser())->authorize($ability, $arguments);
    }


    public function all($page)
    {
        return $this->request()->get(env('EndPoint') . '/users?page=' . $page)->json();
    }

    public function get($id): User
    {
        $json = $this->request()->get(env('EndPoint') . "/users" . "/" . $id)->json();
        return $this->parseUser($json);
    }
    public function create($data): User
    {
        $json = $this->request()->post(env('EndPoint') . "/users", $data)->json();
        return $this->parseUser($json);
    }
    public function update($id, $data): User
    {
        $json = $this->request()->put(env('EndPoint') . "/users" . "/" . "$id", $data)->json();
        return $this->parseUser($json);
    }
    public function delete($id)
    {
        return $this->request()->delete(env('EndPoint') . "/users" . "/" . "$id")->successful();
    }
}
