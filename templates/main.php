<!DOCTYPE html>
<html>

<head>
    <title>
        <?php echo TITLE; ?>
    </title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="scripts/api.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.logout-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "database/ajax.php",
                    data: "logout=true",
                    success: function(response) {
                        let json = JSON.parse(response);
                        json.code == "1" && (location.href = "index.php");
                    }
                })
            })
        });
    </script>
</head>

<body>
    <div id="root">
        <div class="container">
            <nav>
                <a href="index.php">Home</a>
                <a href="refs.html">Sources</a>
                <a href="docs.html">Documentation</a>
            </nav>
            <form class="logout-form" action="index.php" method="post">
                <span><?php echo $_SESSION['user']['uname']; ?></span>
                <button class="icon-exit" name="logout"></button>
            </form>
            <form class="lr-form" action="#">
                <label for="query">Query: 
                    <input type="text" name="query">
                </label>
                <label for="location">Location:
                    <input type="text" name="location">
                </label>
                <button class="submit" name="submit">Search!</button>
            </form>
        </div>
    </div>
</body>

</html>