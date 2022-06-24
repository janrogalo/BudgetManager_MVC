<?php

namespace App\Controllers;
use \Core\View;
use \App\Auth;
use \App\Models\Expenses;

class Expense extends Authenticated {

    protected $added_expense;

    protected function before() {
        parent::before();
        $this->added_expense = false;
    }

    public function newAction() {
        View::renderTemplate('Expense/new.html');
    }

    public function addAction() {
        $expenses = new Expenses($_POST);

        if($expenses->addExpense(Auth::getUser())) {
            //dodanie wydatku do bazy
            $this->added_expense = true;
            $this->newAction();
        }

        else {
            $this->newAction();
        }
    }







}