google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);


function drawChart() {

    let dataRequest = new XMLHttpRequest();
     dataRequest.open('GET','/balance/encodeChartData');

    dataRequest.onload = function(){
        if(dataRequest.status >= 200 && dataRequest.status < 400){
            let fetchedData = JSON.parse(dataRequest.responseText);
            const data = new google.visualization.DataTable();

            data.addColumn('string', 'Category');
            data.addColumn('number', 'Amount');
             for (const datas of fetchedData) {
                data.addRows([
                    [datas.name, Number(datas.amountSum)]
                ]);
            };

           const options = {
                backgroundColor:'#88bdbc',
            };

            let chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
        else {
            console.log("Server Error");
        }
    };
    dataRequest.send();
}