<?php

namespace tests\models;

use app\models\Client;
use app\models\Contract;
use app\models\forms\LoginForm;
use PHPUnit\Framework\TestResult;

class ContractTest extends \Codeception\Test\Unit
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

    public function testCreateContract()
    {
        $this->model = new Contract([
            'number' => 'NO-123',
            'date' => '2018-5-30',
            'amount' => 1000.25,
            'buyer_id' => Client::findOne(1)->id,// we already put at least 2 clients in our fixture
            'seller_id' => Client::findOne(2)->id, // we already put at least 2 clients in our fixture
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tincidunt, mi tempor dignissim ullamcorper, metus lacus dictum purus, sed consectetur purus odio non tellus. Praesent iaculis sem rutrum, luctus metus ut, varius urna. Fusce id arcu sem. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam blandit nunc aliquet massa tempus mattis. In non enim sit amet ligula aliquam viverra. In eu suscipit nibh. Sed dictum, leo eu cursus posuere, tortor lacus mattis nisi, sit amet volutpat magna sem ultrices metus. Aliquam erat volutpat. Phasellus turpis mauris, egestas quis metus non, scelerisque mattis augue. Etiam blandit ligula eu sem finibus molestie. Ut a nisl metus. Fusce vel faucibus elit.'
        ]);

        expect($this->model->save())->equals(true);
    }

    public function testCreateContractWithoutBuyer()
    {
        $this->model = new Contract([
            'number' => 123,
            'date' => date('yyyy-m-dd'),
            'amount' => 1000.25,
            'seller_id' => Client::findOne(2)->id, // we already put at least 2 clients in our fixture
        ]);

        expect($this->model->save())->equals(false);
        expect($this->model->errors)->hasKey('buyer_id');
    }
}
