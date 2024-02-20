<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bar Graph Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <canvas id="myBarChart" width="500px" height="500px"></canvas>

    <script>
        // Sample data for the bar graph
        var data = {
            labels: ['Category 1', 'Category 2', 'Category 3'],
            datasets: [{
                label: 'Values',
                data: [50, 30, 70], // Values for each category
                backgroundColor: ['#3498db', '#2ecc71', '#e74c3c'], // Colors for each category
                borderColor: '#fff', // Border color for the bars
                borderWidth: 1, // Border width for the bars
            }]
        };

        // Get the canvas element and create a bar chart
        var ctx = document.getElementById('myBarChart').getContext('2d');
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                indexAxis: 'y', // Bar chart will be horizontal
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>
</html>
