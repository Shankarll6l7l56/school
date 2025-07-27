<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Form Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('mail.send') }}" method="POST" onsubmit="return showAlert()">
                    @csrf
                    <label class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" required><br>
                    <label class="form-label">Phone:</label>
                    <input type="number" class="form-control" name="phone" placeholder="Phone" ><br>
                    <label class="form-label">City:</label>
                    <input type="text" class="form-control" name="city" placeholder="City" required><br>
                    <button type="submit" class="btn btn-success px-5">Send</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    function showAlert() {
        alert("Form submitted! Email is being sent.");
        return true; 
    }
</script>

</html>