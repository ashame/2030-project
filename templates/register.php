<!DOCTYPE html>
<html>

<head>
    <title>
        <?php echo TITLE ?> | Register
    </title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.validate({
                modules: 'security'
            });
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
        });
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
            <form class="lr-form" name="register" method="post">
                <?php
                if (isset($errors)) {
                ?>
                    <div class="errors">
                        <?php
                        foreach ($errors as $error) {
                        ?>
                            <strong><?php echo $error; ?></strong>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if (isset($success)) {
                ?>
                    <div class="success">
                        <strong>Account successfully created</strong>
                    </div>
                <?php
                }
                ?>
                <label for="username">Username
                    <input name="username" type="text" data-validation="length" data-validation-length="min4">
                </label>
                <label for="password">Password (at least 8 characters)
                    <input name="password" type="password" data-validation="length" data-validation-length="min8">
                </label>
                <label for="password2">Confirm Password
                    <input name="password2" type="password" data-validation="confirmation" data-validation-confirm="password">
                </label>
                <label for="email">Email
                    <input name="email" type="email" data-validation="email">
                </label>
                <div>
                    <button type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>