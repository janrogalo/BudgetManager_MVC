
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    const data = google.visualization.arrayToDataTable([
        ['Category', 'Amount'],
        <?php

    $stmt = $db->prepare("SELECT name, SUM(amount) FROM expenses INNER JOIN expenses_category_default ON expenses.expense_category_assigned_to_user_id = expenses_category_default.id
    WHERE user_id = '$loggedId' AND date_of_expense BETWEEN '$start' AND '$finish' GROUP BY expenses_category_default.id");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $line) {
        echo "['" . $line['name'] . "' ," . $line['SUM(amount)'] . "],";
    }
        ?>]);

    const options = {
        backgroundColor: '#88bdbc',
    };

    const chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
}