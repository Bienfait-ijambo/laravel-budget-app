<?php

namespace Tests\Feature;

class FakeUser
{
    public $id;

    public $name;

    public $email;

    public $role;

    public function __construct($id, $name, $email, $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }
}
