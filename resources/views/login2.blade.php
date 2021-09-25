
{{ $errors }}
@if($errors->any())
    error?
    <div class="alert alert-danger" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

            <span aria-hidden="true">×</span>

        </button>

 

        @foreach($errors->all() as $error)

            {{ $error }}<br/>

        @endforeach

    </div>
@else
no error?
@endif

@if (Session::has('errors'))
    errors
@else
    no errors 2
@endif
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Log in</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="login2">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="text" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>            
</div>