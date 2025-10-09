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
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <h4 style="text-align: center">Bugs/issues</h4>
    <a href="{{route('add.issue')}}" class="btn btn-info float-end">Add Issue</a>
    <table class="table table-bordered table-striped display" width="100%" id="issueTable">
        <thead>
            <tr>
                <th>NO.</th>
                <th>issue</th>
                <th>comment</th>
                <th>status</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    @include('layouts.footer');
<script>
  $(document).ready(function(){
    $('#issueTable').DataTable({
      processing:true,
      serverSide:false,
      ajax:"{{route('dashboard.getdata')}}",
      responsive:true,
      columns: [
            // {data: 'id'},
            { 
            data: null, 
            name: 'serial_no',
            render: function (data, type, row, meta) {
                return meta.row + 1; // serial number (starts from 1)
            }
            },
            {data: 'bug'},
            {data: 'comment'},
            {data: 'status'},
            {data:'id',
              name:'action',
              orderable:false,
              searchable:false,
              render:function(data,type,row){
                return `<a href="edit/${data}" class="btn btn-secondary">Edit</a>
                <form action="delete/${data}" method="POST" style="display:inline-block">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('are you sure you want to delete?')">Delete</button>
                </form>`
              }
            }
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
        emptyTable: "No issues available" // message when empty
        }
    });
  })
</script>
</body>
</html>