<?php

namespace App\Controllers;
use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\Expenses;
use \App\Models\Incomes;

class Balance extends Authenticated {

protected $showed;

    protected function before() {
        parent::before();

    }

    protected function showExpenses() {
        $this->expenses = Expenses::getUserExpenses(Auth::getUser());
        $_SESSION['chartData'] = $this->expenses;
        return $this->expenses;

    }

    public function indexAction() {

        $this->showExpenses();

        $expense_sum = array_sum(array_column($this->showExpenses(), 'sum'));
        echo $expense_sum;

        View::renderTemplate('Balance/index.html',[
            'showed' => $this->showed,
        ]);

        $this->showed = false;
    }


    public function form() {
        $this->showed = true;
        $this->index();
    }





}