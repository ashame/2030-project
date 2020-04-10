<!DOCTYPE html>
<html>

<head>
    <title>
        <?php echo TITLE; ?> | Login
    </title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.lr-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "database/ajax.php",
                    data: $(this).serialize(),
                    success: function(response) {
                        let json = JSON.parse(response);
                        if (json.code == "1") {
                            location.href = "index.php";
                        } else {
                            if (document.querySelectorAll(".errors").length == 0) {
                                $('.lr-form').prepend("<div class='errors'></div>");
                            }
                            var html = '';
                            for (let i = 0; i < Object.keys(json.errors).length; i++) {
                                html += `<strong>${Object.values(json.errors)[i]}</strong>`;
                            }
                            $('.errors').html(html);
                        }
                    }
                })
            })
        })
    </script>
</head>

<body>
    <div id="root">
        <div id="container">
            <nav>
                <a href="index.php">Home</a>
                <a href="refs.html">Sources</a>
                <a href="docs.html">Documentation</a>
            </nav>
            <form class="lr-form" name="login" method="post" action="index.php">
                <label for="username">Username
                    <input name="username" type="text" data-validation="length" data-validation-length="min4">
                </label>
                <label for="password">Password
                    <input name="password" type="password" data-validation="length" data-validation-length="min8">
                </label>
                <div>
                    <button type="submit">Login</button>
                    <button type="button" onclick="window.location.href='register.php'">Register</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>