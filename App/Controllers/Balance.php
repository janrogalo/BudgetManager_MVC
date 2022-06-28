<?php

namespace App\Controllers;
use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\Expenses;
use \App\Models\Incomes;
use function MongoDB\BSON\toJSON;

class Balance extends Authenticated {

protected $display;

    protected function before() {
        parent::before();

    }

    protected function showExpenses() {
        $this->expenses = Expenses::getUserExpenses(Auth::getUser());
     return $this->expenses;
    }

    protected function encodeChartDataAction() {
        $this->chartData = Expenses::getExpensesAjax(Auth::getUser());
        $_SESSION['chartData'] = $this->chartData;
        echo json_encode($_SESSION['chartData']);
    }



    public function indexAction() {

        $this->showExpenses();

        $expense_sum = array_sum(array_column($this->showExpenses(), 'amount'));
        $expense_sum_format = number_format($expense_sum ,2, '.' );

        View::renderTemplate('Balance/index.html',[
            'display' => $this->display,
            'expenses' => $this->expenses,
            'expense_sum' => $expense_sum_format,
        ]);

        $this->display = false;
    }


    public function form() {
        $this->display = true;
        $this->index();
    }





}