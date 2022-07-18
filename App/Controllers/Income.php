<?php

namespace App\Controllers;
use \Core\View;
use \App\Auth;
use \App\Models\User;
use \App\Models\Incomes;

class Income extends Authenticated {

    protected $added_income;

    protected function before() {
        parent::before();
        $this->added_income = false;
    }

    public function newAction() {

        $incomeCategories = User::getIncomeCategory(Auth::getUser());

        View::renderTemplate('Income/new.html', [
            'incomeCategories' => $incomeCategories,
            'incomeAdded' => $this->added_income
        ]);
    }


    public function addAction() {
        $incomes = new Incomes($_POST);

        if($incomes->addIncome(Auth::getUser())) {
            $this->added_income = true;
            $this->newAction();
        }

        else {
            $this->new();
        }
    }



}