<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart.js</title>
    <style>
        body {
            background-color: #f0f0f0;
            margin: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .canvas-container50 {
            width: 50%;
            height: 400px;
        }
        .canvas-container100 {
            width: 100%;
            height: 400px;
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <input type="checkbox" id="toggleCheckbox1" onchange="toggleChartVisibility('myChartDiv1')" checked>
        <label for="toggleCheckbox1">Chart1</label>
        <input type="checkbox" id="toggleCheckbox2" onchange="toggleChartVisibility('myChartDiv2')" checked>
        <label for="toggleCheckbox2">Chart2</label>
        <input type="checkbox" id="toggleCheckbox3" onchange="toggleChartVisibility('myChartDiv3')" checked>
        <label for="toggleCheckbox3">Chart3</label>
        <button onclick="saveCharts()">Save Charts as Image</button>
    </div>

    <div class="container" id="parentCanvas">
        <div class="canvas-container50" id="myChartDiv1">
            <canvas id="myChart1"></canvas>
        </div>
        <div class="canvas-container50" id="myChartDiv2">
            <canvas id="myChart2"></canvas>
        </div>
    </div>
    <div class="container">
        <div class="canvas-container100" id="myChartDiv3">
            <canvas id="myChart3"></canvas>
        </div>
    </div>
    <div class="container" id="parentCanvas">
        <div class="canvas-container50" id="myChartDiv4">
            <canvas id="myChart4"></canvas>
        </div>
        <div class="canvas-container50" id="myChartDiv5">
            <canvas id="myChart5"></canvas>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        const ctx1 = document.getElementById('myChart1').getContext('2d');
        const chart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1,
                }]
            },
            plugins: [
                ChartDataLabels,
                {
                    beforeDraw: (chart, args, options) => {
                        const {ctx} = chart;
                        ctx.save();
                        // 枠線
                        ctx.lineWidth = 2;
                        ctx.strokeStyle = 'gray';
                        ctx.strokeRect(0, 0, chart.width, chart.height);
                        // 背景色
                        ctx.globalCompositeOperation = 'destination-over';
                        ctx.fillStyle = 'white';
                        ctx.fillRect(0, 0, chart.width, chart.height);
                        ctx.restore();
                    }
                }
            ],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    datalabels: {
                        color: '#36A2EB',
                        backgroundColor: 'rgba(255,255,255,0.5)',
                        formatter: function(value) {
                            return value + "件";
                        }
                    },
                    title: {
                        display: true,
                        text: 'title'
                    }                    
                }
            }
        });

        const ctx2 = document.getElementById('myChart2').getContext('2d');
        const chart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Red', 'Orange', 'Yellow', 'Green', 'Blue', 'A', 'B', 'C', 'D', 'E', 'F', 'J'],
                datasets: [
                    {
                        label: 'Dataset 1',
                        data: [10, 30, 20, 40, 60],
                    }
                ]
            },
            plugins: [
                ChartDataLabels,
                {
                    beforeDraw: (chart, args, options) => {
                        const {ctx} = chart;
                        ctx.save();
                        // 枠線
                        ctx.lineWidth = 2;
                        ctx.strokeStyle = 'gray';
                        ctx.strokeRect(0, 0, chart.width, chart.height);
                        // 背景色
                        ctx.globalCompositeOperation = 'destination-over';
                        ctx.fillStyle = 'white';
                        ctx.fillRect(0, 0, chart.width, chart.height);
                        ctx.restore();
                    }
                }
            ],
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        const ctx3 = document.getElementById('myChart3').getContext('2d');
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: ['Category 1', 'Category 2', 'Category 3'],
                datasets: [
                    {
                        label: 'Dataset 1',
                        data: [10, 20, 30],
                        // backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    },
                    {
                        label: 'Dataset 2',
                        data: [15, 25, 35],
                        // backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    },
                    {
                        label: 'Dataset 3',
                        data: [20, 30, 40],
                        // backgroundColor: 'rgba(255, 206, 86, 0.7)',
                    },
                ]
            },
            plugins: [
                ChartDataLabels,
                {
                    beforeDraw: (chart, args, options) => {
                        const {ctx} = chart;
                        ctx.save();
                        // 枠線
                        ctx.lineWidth = 2;
                        ctx.strokeStyle = 'gray';
                        ctx.strokeRect(0, 0, chart.width, chart.height);
                        // 背景色
                        ctx.globalCompositeOperation = 'destination-over';
                        ctx.fillStyle = 'white';
                        ctx.fillRect(0, 0, chart.width, chart.height);
                        ctx.restore();
                    }
                }
            ],
            options: {
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                    }
                }
            }
        });

        const ctx4 = document.getElementById('myChart4').getContext('2d');
        new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: ['Category 1', 'Category 2', 'Category 3'],
                datasets: [
                    {
                        label: 'Dataset 1',
                        data: [10, 20, 30],
                        // backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        stack: 'stack-1',
                    },
                    {
                        label: 'Dataset 2',
                        data: [15, 25, 35],
                        // backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        stack: 'stack-1',
                    },
                    {
                        label: 'Dataset 3',
                        data: [20, 30, 40],
                        // backgroundColor: 'rgba(255, 206, 86, 0.7)',
                        stack: 'stack-1',
                    },
                ],
            },
            plugins: [
                ChartDataLabels,
                {
                    beforeDraw: (chart, args, options) => {
                        const {ctx} = chart;
                        ctx.save();
                        // 枠線
                        ctx.lineWidth = 2;
                        ctx.strokeStyle = 'gray';
                        ctx.strokeRect(0, 0, chart.width, chart.height);
                        // 背景色
                        ctx.globalCompositeOperation = 'destination-over';
                        ctx.fillStyle = 'white';
                        ctx.fillRect(0, 0, chart.width, chart.height);
                        ctx.restore();
                    }
                }
            ],
            options: {
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                    }
                }
            }
        });

        // チェックボックスでのグラフの表示切替
        function toggleChartVisibility(divId) {
            var checkbox = document.getElementById('toggleCheckbox' + divId.slice(-1));
            var myDiv = document.getElementById(divId);
            // チェックボックスがチェックされている場合はdivを表示、それ以外は非表示にする
            myDiv.style.display = checkbox.checked ? 'block' : 'none';
        }

        // 表示しているグラフの画像を保存
        function saveCharts() {
            var parentCanvas = document.getElementById('parentCanvas');
            var childCanvas1 = document.getElementById('myChart1');
            var childCanvas2 = document.getElementById('myChart2');
            var childCanvas3 = document.getElementById('myChart3');

            // 新しいCanvasを作成
            var mergedCanvas = document.createElement('canvas');
            mergedCanvas.width = parentCanvas.offsetWidth;
            // mergedCanvas.width = childCanvas1.width + childCanvas2.width;
            // mergedCanvas.width = childCanvas3.width;
            mergedCanvas.height = childCanvas1.height + childCanvas3.height;
            var mergedContext = mergedCanvas.getContext('2d');

            // 1つ目のCanvasを描画
            mergedContext.drawImage(childCanvas1, 0, 0);
            // 1つ目のCanvasを描画（1つだけ真ん中に表示）
            // mergedContext.drawImage(childCanvas1, parentCanvas.offsetWidth/4, 0);

            // 2つ目のCanvasを描画
            mergedContext.drawImage(childCanvas2, childCanvas1.width, 0);

            // 3つ目のCanvasを描画
            mergedContext.drawImage(childCanvas3, 0, childCanvas1.height);

            // 画像として保存または表示できます
            // var img = new Image();
            // img.src = mergedCanvas.toDataURL('image/png');

            // 例: 画像を表示
            // document.body.appendChild(img);

            mergedCanvas.toBlob(function (blob){
                var item = new ClipboardItem({ 'image/png': blob });
                navigator.clipboard.write([item]).then(function () {
                    console.log('画像がクリップボードにコピーされました。');
                    alert('表示されているすべてのグラフの画像をクリップボードにコピーしました。');
                }).catch(function (error) {
                    console.error('クリップボードへのコピーに失敗しました:', error);
                });
            });
        }

        
            //https://flatuicolors.com/
    </script>
</body>
</html>
