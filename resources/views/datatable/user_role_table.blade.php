<div class="mt-5">
    <table id="userManageTable" class="table-bordered table table-striped table-hover">
        <thead>
            <tr>
                <th>權限名稱</th>
                <th>創建人</th>
                <th>創建時間</th>
                {{-- <th>權限</th> --}}
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <!-- DataTables 自動處理 -->
        </tbody>
    </table>
</div>
<script>
    $('#userManageTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('getUserRoleTable') }}",
        columns: [{
                data: 'role_name',
                name: 'role_name'
            },
            {
                data: 'username.name',
                name: 'creator'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            // {
            //     data: 'role_control',
            //     name: 'role_control'
            // },
            {
                data: 'active',
                name: 'active',
                orderable: false,
                searchable: false
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
