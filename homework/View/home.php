<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1>Home</h1>
        <button id="logoutBtn" class="btn"> Đăng xuất </button>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '#logoutBtn', function () {
            $.ajax({
                url: 'index.php/logout',
                method: 'POST',
                success: function () {
                    alert(`Logout successfully`);
                    window.location.href = '';
                },
                error: function (xhr, status, error) {
                    alert(`Failed to logout!`);
                }
            })
        })
    </script>
</body>

</html>