<div class="mt-5">
    <table id="taskFlowTable" class="table-bordered table table-striped table-hover">
        <thead>
            <tr>
                <th>流程名稱</th>
                <th>創建人</th>
                <th>流程步驟</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <!-- DataTables 自動處理 -->
        </tbody>
    </table>
</div>
<script>
    $('#taskFlowTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('getTaskFlowTable') }}", // 從後端 API 加載數據
        columns: [{
                data: 'task_flow_name',
                name: 'task_flow_name'
            },
            {
                data: 'creator.name',
                name: 'creator.name'
            }, // 創建者名稱
            {
                data: 'steps_count',
                name: 'steps_count'
            }, // 步驟數量
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            } // 操作列，不排序也不搜索
        ],
        language: {
            "processing": "處理中...",
            "lengthMenu": "顯示 _MENU_ 項結果",
            "zeroRecords": "沒有匹配結果",
            "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "infoFiltered": "(從 _MAX_ 項結果過濾)",
            "infoPostFix": "",
            "search": "搜尋:",
            "paginate": {
                "first": "首頁",
                "previous": "上一頁",
                "next": "下一頁",
                "last": "末頁"
            },
            "aria": {
                "sortAscending": ": 升序排列",
                "sortDescending": ": 降序排列"
            }
        }
    });
</script>
