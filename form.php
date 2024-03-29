
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <title>溫濕度圖表</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 包含 Chart.js 库 -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="shortcut icon" href="images/favicon.ico">
    
    
    <style>
        /* 調整表格的寬度 */
        #myChart {
            max-width: 800px; /* 設定最大寬度 */
            margin: 0 auto; /* 將圖表置中 */
        }
    </style>




</head>
<body>
    <div class="jumbotron">
      <div class="container">
        <!-- 建立第一個 row 空間，裡面準備放格線系統 -->
        <div class="row">
          <!-- 在 xs 尺寸，佔12格，可參考 http://getbootstrap.com/css/#grid 說明-->
          <div class="col-xs-12">
            <!--網站標題-->
            <h1 class="text-center">溫溼度感測</h1>
            <h5 class="text-center">
                <p id="datetime"></p>
                    <script>
                        document.getElementById('datetime').textContent = new Date().toLocaleString();
                    </script>
            </h5>

            <!-- 選單 -->
            <ul class="nav nav-pills">
              <li role="presentation" class="active"><a href="index.php">首頁</a></li>
              <li role="presentation"><a href="form.php">折線圖</a></li>
              <li role="presentation"><a href="about.php">about</a></li>
              </ul>
          </div>
        </div>
      </div>
    </div>





    <!-- 在這裡插入你的圖表 -->
    <canvas id="myChart" width="1200" height="500"></canvas>

    <script src="data.js"></script>

    <script>
        // 原始溫濕度資料
        const rawData = myData;

        // 分割資料為陣列
        const dataArray = rawData.split(" ");

        // 創建空陣列以存儲處理後的資料
        const data = [];

        // 處理每條原始資料
        dataArray.forEach(entry => {
            // 匹配溫度和濕度數據
            const tempMatch = entry.match(/t=(\d+)/);
            const humidMatch = entry.match(/h=(\d+)/);

            // 如果匹配成功，則提取溫度和濕度數據
            if (tempMatch) {
                const temp = parseInt(tempMatch[1]);
                // 添加到 data 陣列中
                data.push({ temperature: temp });
            }

            if (humidMatch) {
                const humid = parseInt(humidMatch[1]);
                // 添加到 data 陣列中
                data.push({ humidity: humid });
            }
        });

        // 提取溫度和濕度數據
        const temperatures = data.filter(entry => entry.temperature !== undefined).map(entry => entry.temperature);
        const humidities = data.filter(entry => entry.humidity !== undefined).map(entry => entry.humidity);

        // 創建圖表
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Array.from({ length: temperatures.length }, (_, i) => i), // 生成連續數字標籤
                datasets: [
                    {
                        label: '溫度',
                        data: temperatures,
                        borderColor: 'rgb(255, 99, 132)',
                        fill: false
                    },
                    {
                        label: '濕度',
                        data: humidities,
                        borderColor: 'rgb(54, 162, 235)',
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
