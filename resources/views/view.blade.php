<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container vh-100">
        <label for="file">Attachment</label>
        <img src="{{ asset('storage/uploads/'.$issue->file) }}" alt="img" height="50px" width="50px" 
        data-bs-toggle="modal" data-bs-target="#imageModal" class="img-thumbnail" style="cursor:pointer" onclick="viewAttachment('{{ asset('storage/uploads/'.$issue->file) }}')">
    </div>
    <script
  src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        
    </script>
</body>
</html>
