<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <section style="background-color: #eee;">
    <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-md-6 col-lg-6 col-xl-6">
        <div class="card">
          <div class="card-body">
                
                    @foreach($comments as $comment)
                        <div>
                            <h6 class="fw-bold text-primary mb-1">{{ strtoupper($comment->user->name) }} </h6><i class="bi bi-pencil" style="font-size: 0.8em;cursor:pointer" data-bs-toggle="modal" data-bs-target="#commentModal" onclick="viewComment({{ $comment->id }})"></i>
                            <p class="text-muted small mb-0">
                            {{ $comment->created_at->diffForHumans() }}
                            </p>
                        </div>
                
                        <div>
                            <p class="m-3">
                                {{$comment->comment}}
                            </p>
                        </div>
                    <div>
                    @if($comment->image != '')
                    <img src="{{asset('/storage/uploads/'.$comment->image ) }}" alt="image" width="100px" height="50px" data-bs-toggle="modal" data-bs-target="#imageModal" class="img-thumbnail" 
                    style="cursor:pointer" onclick="viewImage('{{asset('/storage/uploads/'.$comment->image ) }}')">
                    @endif
                </div><br>
                @endforeach
                <div>
                    <form action="{{ route('comment.add',$id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div data-mdb-input-init class="form-outline w-100">
                            <textarea class="form-control" name="comment" id="textAreaExample" rows="4"
                            style="background: #fff;" placeholder="comment" ></textarea>
                            <!-- <label class="form-label" for="textAreaExample">Comment</label> -->
                        </div><br>
                        <div class="form-group">
                            <input type="file" class="form-control" id="file" name="file">
                            @error('file')
                            <div class="alert alert-danger">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="float-end mt-2 pt-1">
                            <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-sm">Post</button>
                            <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary btn-sm">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
  </div>
</section>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-body text-center">
            <img id="modalImage" src="" alt="Photo" height="100px" width="100px" class="img-fluid">
        </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('comment.update') }}">
        @csrf
        <input type="hidden" name="id" id="commentId">
        <div class="modal-header">
          <h5 class="modal-title" id="formModalLabel">change comment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <!-- Form Fields -->
          <div class="mb-3">
            <textarea name="comment" id="comment" cols="30" rows="5" placeholder="comment"></textarea>
          </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script>
    
    function viewComment(id){
        document.getElementById('commentId').value=id;
    }
    function viewImage(url){
        document.getElementById('modalImage').src = url;
    }function viewImage(url){
        document.getElementById('modalImage').src = url;
    }
</script>
</body>
</html>
