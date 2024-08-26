<style>
    canvas {
        width: 100% !important;
        height: auto !important;
        max-height: 400px;
        /* 根據需要調整最大高度 */
    }
</style>

<h1 class="d-flex justify-content-center">任務分布</h1>
<div class="d-flex justify-content-center">
    <div class="w-100">
        <canvas id="lineChart"></canvas>
    </div>
</div>
@push('scripts')
    <script>
        var chart_data = @json($get_chart_data); // 從 Laravel 傳遞的 PHP 陣列轉換為 JS 陣列
        var labels = chart_data.labels; // 橫軸標籤
        var datasets = []; // 初始化數據集

        // 函數來隨機生成顏色
        function getRandomColor() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return 'rgba(' + r + ',' + g + ',' + b + ', 0.2)'; // 生成帶有透明度的顏色
        }

        // 遍歷 chart_data.data，生成多個數據集並應用隨機顏色
        var n = 1;
        $.each(chart_data.data, function(key, value) {
            var backgroundColor = getRandomColor();
            var borderColor = backgroundColor.replace('0.2', '1'); // 將透明度改為 1，作為邊框顏色
            datasets.push({
                label: chart_data.cableName['cableName' + n], // 每條折線的名稱
                backgroundColor: backgroundColor, // 隨機生成的背景顏色
                borderColor: borderColor, // 相應的邊框顏色
                data: value, // 對應的數據
                fill: false
            });
            n++;
        });

        var ctx = document.getElementById('lineChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line', // 設置圖表類型為折線圖
            data: {
                labels: labels, // 設置橫軸標籤
                datasets: datasets // 設置生成的數據集
            },
            options: {
                responsive: true, // 自適應
                scales: {
                    y: {
                        beginAtZero: true // Y 軸從 0 開始
                    }
                }
            }
        });
    </script>
@endpush
