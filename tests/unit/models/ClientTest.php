<?php

namespace tests\models;

use app\models\Client;
use app\models\forms\LoginForm;
use PHPUnit\Framework\TestResult;

class ClientTest extends \Codeception\Test\Unit
{
    private $model;

    protected function _before()
    {
        $login = new LoginForm([
            'username' => 'admin',
            'password' => 'admin',
        ]);

        $login->login();
    }

    public function testCreateClient()
    {
        $this->model = new Client([
            'name' => 'test_name',
            'surname' => 'test_surname',
            'email' => uniqid().'@gmail.com'
        ]);
        expect($this->model->save())->equals(true);
    }

    public function testCreateClientWrongEmail()
    {
        $this->model = new Client([
            'name' => 'test_name',
            'surname' => 'test_surname',
            'email' => 'test_email',
            'created_at' => 123,
            'updated_at' => 123,
            'created_by' => 100,
            'updated_by' => 100,
        ]);

        expect($this->model->save())->equals(false);
        expect($this->model->errors)->hasKey('email');
    }
}
