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
protected $range;

    protected function before() {
        parent::before();
        $this->range = false;
    }

    protected function showExpenses() {
        $this->expenses = Expenses::getUserExpenses(Auth::getUser(),$this->date_start, $this->date_end);
     return $this->expenses;
    }

    protected function encodeChartDataAction() {
        $this->chartData = Expenses::getExpensesByCategory(Auth::getUser(), $this->date_start, $this->date_end);
        return $this->chartData;
    }



    public function indexAction() {

        $this ->date_start = date('Y-m').'-01';
        $this-> date_end = date('Y-m-d');

        $this->checkDates();
        $this->showExpenses();
        $this->encodeChartDataAction();
        $this->range = filter_input(INPUT_POST, 'range');


        $expense_sum = array_sum(array_column($this->showExpenses(), 'amount'));
        $expense_sum_format = number_format($expense_sum ,2, '.' );

        View::renderTemplate('Balance/index.html',[
            'display' => $this->display,
            'expenses' => $this->expenses,
            'expense_sum' => $expense_sum_format,
            'chart_data' =>json_encode($this->chartData),
            'range' => $this->range,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ]);

        $this->display = false;
    }


    public function checkDates() {
        $this->date_start = filter_input(INPUT_POST, 'date_start');
        $this->date_end = filter_input(INPUT_POST, 'date_end');

        if(($this->date_start) > ($this->date_end))	{
            Flash::addMessage('Incorrect dates!', Flash::WARNING);
        }
    }




    public function form() {
        $this->display = true;
        $this->index();
    }





}