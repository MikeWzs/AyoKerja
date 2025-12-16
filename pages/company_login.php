<!DOCTYPE html>
<html>
<head>
    <title>Company Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<div class="container mt-5">
    <div class="col-md-4 mx-auto">
        <div class="card p-4 bg-black">
            <h4 class="text-center mb-3">Company Login</h4>

            <form action="company_login_process.php" method="POST">
                <input type="email" name="email" placeholder="Email Company" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>