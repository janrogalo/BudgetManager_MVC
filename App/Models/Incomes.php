<?php

namespace App\Models;
use PDO;
use \Core\View;

class Incomes extends \Core\Model {

    public function addIncome($user) {
        $amount = filter_input(INPUT_POST, 'amount');
        $date = filter_input(INPUT_POST, 'date');
        $category = filter_input(INPUT_POST, 'incomeCategory');
        $comment = filter_input(INPUT_POST, 'comment');

        $sql = 'INSERT INTO incomes VALUES (NULL, :user_id, :category, :amount, :date, :comment)';
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user->id, PDO::PARAM_INT);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindValue(':date', $date , PDO::PARAM_STR);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);

        return $stmt->execute();
    }


    public static function getUserIncomes($user, $date_start, $date_end) {

        $sql = 'SELECT i.id, i.amount, i.date_of_income, i.income_comment, c.name AS category
FROM incomes AS i
INNER JOIN incomes_category_assigned_to_users AS c ON i.income_category_assigned_to_user_id = c.id
     WHERE i.user_id = :user_id
                AND c.user_id = i.user_id
                AND c.id = i.income_category_assigned_to_user_id
                AND i.date_of_income BETWEEN :startDate AND :endDate';
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user->id, PDO::PARAM_INT);
        $stmt->bindValue(':startDate', $date_start, PDO::PARAM_STR);
        $stmt->bindValue(':endDate', $date_end, PDO::PARAM_STR);


        $stmt->execute();

        return $stmt->fetchAll();
    }


    public static function getIncomesByCategory($user, $date_start, $date_end ){

        $sql = 'SELECT incomes_category_assigned_to_users.name, SUM(incomes.amount) AS "amountSum"
FROM incomes, incomes_category_assigned_to_users
WHERE incomes.user_id = :user_id
AND incomes_category_assigned_to_users.user_id = incomes.user_id
AND incomes_category_assigned_to_users.id = incomes.income_category_assigned_to_user_id
AND incomes.date_of_income BETWEEN :startDate AND :endDate
GROUP BY incomes_category_assigned_to_users.name ORDER BY amountSum DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user->id, PDO::PARAM_INT);
        $stmt->bindValue(':startDate', $date_start, PDO::PARAM_STR);
        $stmt->bindValue(':endDate', $date_end, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll();
    }







}