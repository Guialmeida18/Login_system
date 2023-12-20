<?php

namespace App\Domain\Entities;

class Login
{
    public string|null $username;
    public string|null $password;

    public function getUsername(): string|null
    {
        return $this->username;
    }

    public function setUsername(string|null $username)
    {
        $this->username = $username;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function setPassword(string|null $password)
    {
        $this->password = $password;
    }
    public function toArrey()
    {
        return [
            'username' => $this->getUsername(),
            'password'=> $this->getPassword()
        ];
    }

}