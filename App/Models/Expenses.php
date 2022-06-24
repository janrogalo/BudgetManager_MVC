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

        $sql = 'INSERT INTO expenses VALUES (NULL, :prep_user_id, :prep_category, :prep_method, :prep_amount, :prep_date, :prep_comment)';
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

}
