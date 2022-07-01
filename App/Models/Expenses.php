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


    public static function getUserExpenses($user, $date_start, $date_end) {

        $sql = 'SELECT e.id, e.amount, e.date_of_expense, e.expense_comment, c.name AS category, m.name AS method
FROM expenses AS e
INNER JOIN expenses_category_assigned_to_users AS c ON e.expense_category_assigned_to_user_id = c.id
INNER JOIN payment_methods_assigned_to_users AS m ON e.payment_method_assigned_to_user_id = m.id
     WHERE e.user_id = :user_id 
                AND c.user_id = e.user_id 
                AND c.id = e.expense_category_assigned_to_user_id 
                AND m.id = e.payment_method_assigned_to_user_id
                AND e.date_of_expense BETWEEN :startDate AND :endDate';
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user->id, PDO::PARAM_INT);
        $stmt->bindValue(':startDate', $date_start, PDO::PARAM_STR);
        $stmt->bindValue(':endDate', $date_end, PDO::PARAM_STR);


        $stmt->execute();

return $stmt->fetchAll();
    }


    public static function getExpensesByCategory($user, $date_start, $date_end){

        $sql = 'SELECT expenses_category_assigned_to_users.name, SUM(expenses.amount) AS "amountSum" 
FROM expenses, expenses_category_assigned_to_users 
WHERE expenses.user_id = :user_id 
AND expenses_category_assigned_to_users.user_id = expenses.user_id 
AND expenses_category_assigned_to_users.id = expenses.expense_category_assigned_to_user_id
AND expenses.date_of_expense BETWEEN :startDate AND :endDate
GROUP BY expenses_category_assigned_to_users.name ORDER BY amountSum DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user->id, PDO::PARAM_INT);

        $stmt->bindValue(':startDate', $date_start, PDO::PARAM_STR);
        $stmt->bindValue(':endDate', $date_end, PDO::PARAM_STR);

        $stmt->execute();
//        var_dump($stmt->fetchAll());
//        echo $date_start.'----->'.$date_end;
        return $stmt->fetchAll();
    }









}
