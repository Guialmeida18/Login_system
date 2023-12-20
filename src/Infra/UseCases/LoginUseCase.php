<?php

namespace App\Infra\UseCases;

use App\Domain\Entities\Login;
use App\Infra\Database\Connector;
use PDO;

class LoginUseCase
{
    private Connector $connector;

    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    public function create($values)
    {
        $Login = new Login();
        $Login->setUsername($values['username'] ?? null);
        $Login->setPassword($values['password'] ?? null);
        return $this->connector->create($Login->toarray());

    }

    public function find($id)
    {
        return $this->connector->find($id)
            ->
            fetchObject();
    }

    public function list()
    {
        return $this->connector->list()
            ->
            fetchALL(PDO::FETCH_CLASS);
    }

    public function edit($id, $values)
    {

        $Login = new Login();
        $Login->setUsername($values['username'] ?? null);
        $Login->setPassword($values['password'] ?? null);

        return $this->connector->edit($id, $Login->toArrey());
    }

    public function delete($id)
    {
        return $this->connector->delete($id);
    }
}