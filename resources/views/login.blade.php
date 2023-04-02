<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Northen Stock</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    </head>
    <body style="background-color: #E2DFCC;">
        <div class="container-fluid">
            <div class="row justify-content-center" style="margin-top: 100px; margin-bottom: 100px;">
            <div class="title text-center fw-bolder fs-1 my-5" style="color: #FF9029;">
                Northern <span style="color: #000000">Stock</span> 
            </div>
            <div class="col-12 col-md-6">
            @if(session('errmsg') != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('errmsg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card shadow" style="background :#1B1717">
                <div class="card-header text-center text-white fs-3">Login Form</div>
                <div class="card-body fw-bold">
                    <form action="{{ route('login.post') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="email" class="form-label text-white">Email</label>
                                <input type="email" id="email" class="form-control text-white" name="email" style="background: #FF9029; border-color: #FF9029" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-3">
                                <label for="password" class="form-label text-white">Password</label>
                                <input type="password" id="password" class="form-control text-white" name="password" style="background: #FF9029; border-color: #FF9029" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 fw-bold" style="background: #FF9029; border-color: #FF9029">Login</button>
                    </form>
                </div>
            </div>
            </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>