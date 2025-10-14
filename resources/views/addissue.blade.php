<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <title>Document</title>
</head>
<body>
<div class="row justify-content-center">
<div class="col-md-6">
<div class="card">
<article class="card-body">
<form action="{{route("create")}}" method="POST" enctype="multipart/form-data" class="border p-4 rounded">
@csrf
<h3 style="text-align:center">Add Issue</h3>
  <div class="form-group">
    <label for="inputname" class="col-sm-2 col-form-label">bug/issue</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="bug" name="bug">
        @error('bug')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
    </div>
  </div>
  <div class="form-group">
    <label for="comment" class="col-sm-2 col-form-label">Comment</label>
    <div class="col-sm-10">
      <textarea name="comment" id="comment" cols="30" rows="5"></textarea>
      @error('comment')
        <div class="alert alert-danger">{{$message}}</div>
      @enderror
    </div>
   
  </div>
  <div class="form-group">
    <label for="file">attachment</label>
        <input type="file" class="form-control" id="file" name="file">
        @error('file')
        <div class="alert alert-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group">
      
        <p>Status:</p>
        <label class="form-check form-check-inline">
        <input type="radio" id="open" name="status" value="open">
        <span class="form-check-label"> Open </span>
        </label>
  
        <label class="form-check form-check-inline">
        <input type="radio" id="in_progress" name="status" value="in_progress">
        <span class="form-check-label"> in progress </span>
        </label>
  
        <label class="form-check form-check-inline">
        <input type="radio" id="closed" name="status" value="closed">
        <span class="form-check-label">Closed </span>
        </label>
        @error('status')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        {{-- In progress<input type="radio" class="form-control" name="issue" id="in_progress"> --}}
        {{-- closed<input type="radio" class="form-control" name="issue" id="closed"> --}}
    </div>
    <div class="form-group col-md-6">
        <label for="priority">Priority:</label>
        <select id="priority" name="priority" class="form-control">
          <option>Select</option>
          <option value="low">low</option>
          <option value="medium">medium</option>
          <option value="critical">critical</option>
        </select>
    </div>
    <div class="form-group col-md-6">
      <label for="hours">Hours for completion</label>
      <input type="number" id="hours" name="hours" class="form-control">
      @error('hours')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <label for="assign">Assign:</label>
        <select id="assigned_to" name="assigned_to" class="form-control">
        @foreach($users as $user)
        <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
      <label for="start_date"> Select starting date</label>
      <input type="text" class="form-control" id="start_date" name="start_date" placeholder="select a date">
      @error('start_date')
        <div class="alert alert-danger">{{$message}}</div>
      @enderror
    </div>
    
    <div class="form-group row" style="text-align:center">
        <button type="submit" class="btn btn-primary btn-block">ADD</button>
    </div>
</form>
</article> <!-- card-body end .// -->
</div> <!-- card.// -->
</div> <!-- col.//-->
</div> <!-- row.//-->
</div> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
 <script>
  flatpickr('#start_date',
    {
      dateFormat:"Y-m-d",
    }
  );
 </script>
</body>
</html>