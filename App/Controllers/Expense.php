<?php

namespace App\Controllers;
use \Core\View;
use \App\Auth;
use \App\Models\Expenses;
use \App\Models\User;


class Expense extends Authenticated {

    protected $added_expense;

    protected function before() {
        parent::before();
        $this->added_expense = false;
    }

    public function newAction() {
        $paymentMethod = User::getPaymentMethods(Auth::getUser());
        $expensesCategory = User::getExpenseCategory(Auth::getUser());

        View::renderTemplate('Expense/new.html', [
            'paymentMethods' => $paymentMethod,
            'expenseCategories' => $expensesCategory
        ]);
    }

    public function addAction() {
        $expenses = new Expenses($_POST);

        if($expenses->addExpense(Auth::getUser())) {
            $this->added_expense = true;
            $this->newAction();
        }

        else {
            $this->newAction();
        }
    }







}