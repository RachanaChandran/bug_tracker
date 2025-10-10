<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="{{route('update',$issue->id)}}" method="POST" class="border p-4 rounded" enctype="multipart/form-data">
    @csrf
<h3 style="text-align:center">Edit Issue</h3>
  <div class="form-group row">
    <label for="inputname" class="col-sm-2 col-form-label">bug/issue</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="bug" name="bug" value="{{$issue->bug}}">
        @error('bug')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
    </div>
  </div>
  <div class="form-group row">
    <label for="comment" class="col-sm-2 col-form-label">Comment</label>
    <div class="col-sm-10">
      <textarea name="comment" id="comment" cols="30" rows="5">{{$issue->comment}}</textarea>
       @error('comment')
        <div class="alert alert-danger">{{$message}}</div>
    @enderror
    </div>
   
  </div>
  <div class="form-group row">
    <label for="file" class="col-sm-2 col-form-label">attachment</label>
    <div class="col-sm-10">
        <input type="file" class="form-control" id="file" name="file">
    </div>
  </div>
    <div>
        <p>Status:</p>
  
        <input type="radio" id="open" name="status" value="open" {{$issue->status === 'open'?'checked':''}}>
        <label for="open">open</label><br>
  
        <input type="radio" id="in_progress" name="status" value="in_progress" {{$issue->status === 'in_progress'?'checked':''}}>
        <label for="in_progress">in_progress</label><br>
  
        <input type="radio" id="closed" name="status" value="closed" {{$issue->status === 'closed'?'checked':''}}>
        <label for="closed">closed</label>
        @error('status')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
        {{-- In progress<input type="radio" class="form-control" name="issue" id="in_progress"> --}}
        {{-- closed<input type="radio" class="form-control" name="issue" id="closed"> --}}
    </div>
    <div class="form-group">
      <label for="hours">Hours for completion</label>
      <input type="number" id="hours" name="hours" value="{{ $issue->hours }}">
      @error('hours')
            <div class="alert alert-danger">{{$message}}</div>
        @enderror
    </div>
    <div>
        <label for="assign">Assign:</label>
        <select id="assigned_to" name="assigned_to">
        @foreach($users as $user)
          <option value="{{$user->id}}" {{$user->id=== $issue->assigned_to? 'selected':''}}>{{$user->name}}</option>
        @endforeach
        </select>
    </div>
     <div class="form-group">
      <label for="start_date"> Select starting date</label>
      <input type="text" id="start_date" name="start_date" placeholder="select a date" value="{{ $issue->start_date }}">
      @error('start_date')
        <div class="alert alert-danger">{{$message}}</div>
      @enderror
    </div>
    <div class="form-group row">
    <div class="col-sm-10" style="text-align:center">
      <button type="submit" class="btn btn-primary">EDIT</button>
    </div>
  </div>
</form>
 <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr('#start_date',{
      dateFormat:'Y-m-d'
    });
  </script>
</body>
</html>
