<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.header')
    <title>Document</title>
</head>
<body>
    <table class="table table-bordered table-striped display" width="100%" id="LogsTable">
        <thead>
            <tr>
                <th>NO.</th>
                <th>issue</th>
                <th>user</th>
                <th>Assigned To</th>
                <th>old status</th>
                <th>new status</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    @include('layouts.footer');
    <script>
        $('#LogsTable').DataTable({
            processing:true,
            serverSide:false,
            ajax:"{{ route('logs.getdata') }}",
            responsive:true,
            columns:[
            { 
                data: null, 
                name: 'serial_no',
                render: function (data, type, row, meta) {
                    return meta.row + 1; // serial number (starts from 1)
                }
            },
            {data:'issue'},
            {data:'user'},
            {data:'assignedto'},
            {data:'old_status'},
            {data:'new_status'}
            ],
            dom: 'Brtip',
            buttons: [
                'excel',
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible' // export only visible columns
                    }
                },
                'print',
                // 'colvis' // column visibility toggle
            ],
            pageLength: 6,
                "pagingType": "simple_numbers",
            language: {
                emptyTable: "No logs available" // message when empty
            }
        });
    </script>
</body>
</html>

