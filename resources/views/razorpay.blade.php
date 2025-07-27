
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay payment</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center ">
            <div class="col-md-6 ">
                <form action="{{ route('razorpay-payment') }}" method="post">
@csrf 
                    <div class="">
                        
                        <h3 class="py-3 ">Razorpay payment</h3>
                        
                        <input type="text" name="amount" placeholder="Amount" class="control-form">

                        <button type="submit">save</button>
                        
                        <div class="cord-body">
                            <a href="{{ route('contact') }}">Back to home</a>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <!-- Bootstrap JS & dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>