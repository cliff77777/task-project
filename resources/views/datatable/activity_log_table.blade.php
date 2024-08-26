<div class="mt-5">
    <table id="activityLog" class="table-bordered table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Subject Type</th>
                <th>Subject ID</th>
                <th>Causer Type</th>
                <th>Causer ID</th>
                <th>User Name</th>
                <th>Properties</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <!-- DataTables 自動處理 -->
        </tbody>
    </table>
</div>
<script>
    $('#activityLog').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('getActivityTable') }}",
        columns: [{
                data: 'id',
                name: 'id',
                orderable: true
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'subject_type',
                name: 'subject_type'
            },
            {
                data: 'subject_id',
                name: 'subject_id'
            },
            {
                data: 'causer_type',
                name: 'causer_type'
            },
            {
                data: 'causer_id',
                name: 'causer_id'
            },
            {
                data: 'name',
                name: 'user.name'
            },
            {
                data: 'properties',
                name: 'properties'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
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
