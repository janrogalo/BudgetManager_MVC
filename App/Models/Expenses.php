<?php

namespace App\Models;
use PDO;
use \Core\View;

class Expenses extends \Core\Model {

    public function addExpense($user) {
        $amount = filter_input(INPUT_POST, 'amount');
        $date = filter_input(INPUT_POST, 'date');
        $category = filter_input(INPUT_POST, 'category');
        $comment = filter_input(INPUT_POST, 'comment');
        $method = filter_input(INPUT_POST, 'method');

        $sql = 'INSERT INTO expenses VALUES (NULL, :user_id, :category, :method, :amount, :date, :comment)';
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user->id, PDO::PARAM_INT);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->bindValue(':method', $method, PDO::PARAM_STR);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindValue(':date', $date , PDO::PARAM_STR);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);

        return $stmt->execute();
    }



    public static function getUserExpenses($user) {

        $sql = 'SELECT expenses_category_assigned_to_users.name,
                SUM(expenses.amount) AS "sum" 
                FROM expenses, expenses_category_assigned_to_users 
                WHERE expenses.user_id = :user_id 
                AND expenses_category_assigned_to_users.user_id = expenses.user_id 
                AND expenses_category_assigned_to_users.id = expenses.expense_category_assigned_to_user_id 
                GROUP BY expenses_category_assigned_to_users.name 
                ORDER BY sum DESC';
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user->id, PDO::PARAM_INT);


        $stmt->execute();

return $stmt->fetchAll();
    }






}
