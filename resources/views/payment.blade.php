
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
                <h3 class="py-3 ">Processing...</h3>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "{{env('RAZORPAY_KEY')}}", // Enter the Key ID generated from the Dashboard
    "amount": "{{$amount}}", // Amount is in currency subunits. 
    "currency": "INR",
    "name": "Acme Corp", //your business name
    "description": "Test Transaction",
    "handler":function(response){
        var payId = response.razorpay_payment_id;
        var orderId = response.razorpay_order_id;
        var sign = response.razorpay_signature;

        window.location.href = "{{ route('razorpay-payment') }}" + 
        "?payId=" + encodeURIComponent(payId) + 
        "&orderId=" + encodeURIComponent(orderId) + 
        "&sign=" + encodeURIComponent(sign);
        
    },
    "order_id": "{{$orderId}}", // This is a sample Order ID. Pass the `id` obtained in the response of Step 1
   
    "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
        "name": "Gaurav Kumar", //your customer's name
        "email": "gaurav.kumar@example.com",
        "contact": "+919876543210" //Provide the customer's phone number for better conversion rates 
    },
    "notes": {
        "address": "Razorpay Corporate Office"
    },
    "theme": {
        "color": "#3399cc"
    }
};
var rzp1 = new Razorpay(options);
  rzp1.open();
</script>

</body>

</html>