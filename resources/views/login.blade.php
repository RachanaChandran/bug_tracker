<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="{{asset('css/main.css')}}"> --}}
    <title>Document</title>
</head>
<body>
    <div class="bg-custom d-flex justify-content-center align-items-center">
        <form action="{{route('login')}}" method="POST" class=" p-4 mb-3 border shadow-sm bg-white mx-auto" style="width:500px">
            @csrf
            <h2 class="text-primary text-center">Login Here</h2>
                <div>
                    <label for="emailInput" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Email" value="{{old('email')}}">
                    {{-- @error('email')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror --}}
                </div>
                <div>
                    <label for="emailInput" class="form-label">Password</label>
                    <input type="text" class="form-control" name="password" placeholder="Password">
                    {{-- @error('password')
                        <div class="alert alert-danger">{{$message}}</div>
                    @enderror --}}
                </div>
                <div class="text-center text-primary mt-2">
                    <button type="submit" class="bg-primary text-white">LOGIN</button>
                </div>
        </form>
    </div>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script> --}}
</body>
</html>