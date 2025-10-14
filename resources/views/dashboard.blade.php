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
    @elseif(session('delete'))
        <div class="alert alert-danger">
            {{ session('delete') }}
        </div>
    @endif
    <h4 style="text-align: center">Bugs/issues</h4>
    <!-- {{ auth()->user()->name}} -->
    @can('isAdmin',arguments: auth()->user())
    <a href="{{route('add.issue')}}" class="btn btn-info float-end">Add Issue</a>
    @endcan
    @can('istester',arguments: auth()->user())
    <a href="{{route('add.issue')}}" class="btn btn-info float-end">Add Issue</a>
    @endcan
    @can('isAdmin',auth()->user())
    <a href="{{route('statuslog')}}" class="btn btn-secondary float-end">Status Log</a>
    @endcan
    <form action="{{ route('logout') }}" method="post" style="display:inline;float:end">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
    </form>

    <table class="table table-bordered table-striped display" width="100%" id="issueTable">
        <thead>
            <tr>
                <th>NO.</th>
                <th>issue</th>
                <!-- <th width="10%">comment</th> -->
                <th>Assigned To</th>
                <th>Start Date</th>
                <th width="10%">Hours For Completion</th>
                <th>status</th>
                <th>Priority</th>
                <th>actions</th>
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
            // {data: 'comment'},
            {data:'assigned_to',
                render:function(data,type,row){
                    if (data === 1) {
                        return '<td >Test User</td>';
                    } else if (data === 2) {
                        return '<td >Admin</td >';
                    } else if (data === 3) {
                        return '<td >Developer</td >';
                    } else {
                        return '<td >Tester</td >';
                    }
                }
            },
            {data:'start_date'},
            {data:'hours'},
            {data: 'status',
                render:function(data,type,row){
                    if (data === 'open') {
                        return '<td ><span style="color: green;">Open</span></td>';
                    } else if (data === 'in_progress') {
                        return '<td ><span style="color: orange;">In Progress</span></td >';
                    } else if (data === 'closed') {
                        return '<td ><span style="color: red;">Closed</span></td >';
                    } else {
                        return '<span>' + data + '</span>';
                    }
                }

            },
            {data:'priority'},
            {data:'id',
              name:'action',
              orderable:false,
              searchable:false,
              render:function(data,type,row){
                let buttons = '';
                // if(row.file != null){
                //     buttons += `
                //         <img src="{{ asset('storage/uploads/'.'${row.file}') }}" alt="img" height="50px" width="50px" 
                //         data-bs-toggle="modal" data-bs-target="#imageModal" class="img-thumbnail" style="cursor:pointer" onclick="viewAttachment('{{ asset('storage/uploads/'.'${row.file}') }}')">`
                //     }
                buttons += `<a href="edit/${data}" class="btn btn-secondary">Edit</a>&nbsp`
                buttons += `<a href="comment/${data}" class="btn btn-secondary">comments</a>`
                buttons +=`@can('isAdmin',auth()->user()->name)
                <form action="delete/${data}" method="POST" style="display:inline-block">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('are you sure you want to delete?')">Delete</button>
                </form>
                @endcan
                `
                
                return buttons
              }
            },
            
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
  });
   
</script>
 <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-body text-center">
            <img id="modalImage" src="" alt="Issue Photo" height="100px" width="100px" class="img-fluid">
        </div>
        </div>
    </div>
</div>
<script>
    function viewAttachment(url){
    // alert(url);
    document.getElementById('modalImage').src = url;
    // $('#imageModal').attr('src')
    }
</script>
</body>
</html>