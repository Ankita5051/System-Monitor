{{-- <canvas id="metricsChart"></canvas>
<script>
fetch('/api/metrics').then(response => response.json()).then(data => {
    new Chart(document.getElementById("metricsChart"), {
        type: 'line',
        data: {
            labels: ['CPU', 'Memory', 'Disk'],
            datasets: [{
                data: [data.cpu, data.memory, data.disk],
                backgroundColor: ['red', 'blue', 'green']
            }]
        }
    });
});
</script> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Metrics Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        .charts-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        canvas {
            width: 400px !important;
            height: 300px !important;
        }
    </style>
</head>
<body>

    <h2>System Metrics Dashboard</h2>
    <div class="charts-container">
        <div>
            <h3>CPU Usage</h3>
            <canvas id="cpuChart"></canvas>
        </div>
        <div>
            <h3>Memory Usage</h3>
            <canvas id="memoryChart"></canvas>
        </div>
        <div>
            <h3>Disk Usage</h3>
            <canvas id="diskChart"></canvas>
        </div>
    </div>

    <script>
        let cpuChart, memoryChart, diskChart;

        function createChart(ctx, label, color) {
            return new Chart(ctx, {
                type: "line",
                data: {
                    labels: [],
                    datasets: [{
                        label: label,
                        data: [],
                        borderColor: color,
                        borderWidth: 2,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true, max: 100 }
                    }
                }
            });
        }

        function fetchMetrics() {
            $.ajax({
                url: "/api/metrics",
                method: "GET",
                success: function(data) {
                    const time = new Date().toLocaleTimeString();

                    addData(cpuChart, time, data.cpu_usage);
                    addData(memoryChart, time, data.memory_usage);
                    addData(diskChart, time, data.disk_usage);
                },
                error: function() {
                    console.error("Failed to fetch metrics.");
                }
            });
        }

        function addData(chart, label, value) {
            if (chart.data.labels.length > 10) {
                chart.data.labels.shift();
                chart.data.datasets[0].data.shift();
            }
            chart.data.labels.push(label);
            chart.data.datasets[0].data.push(value);
            chart.update();
        }

        $(document).ready(function () {
            cpuChart = createChart(document.getElementById("cpuChart"), "CPU Usage (%)", "red");
            memoryChart = createChart(document.getElementById("memoryChart"), "Memory Usage (%)", "blue");
            diskChart = createChart(document.getElementById("diskChart"), "Disk Usage (%)", "green");

            fetchMetrics();  // Fetch initially
            setInterval(fetchMetrics, 5000);  // Update every 5 seconds
        });
    </script>

</body>
</html>
