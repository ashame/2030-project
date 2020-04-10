<?php session_start();
    include 'database.php';

    $pdo = db_connect();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['logout'])) {
            unset($_SESSION['user']);
            echo json_encode(array('code' => 1));
        } 
        else if (isset($_POST['email'])) {
            $user = $_POST['username'];
            $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $email = $_POST['email'];
            
            try {
                $ps = $pdo->prepare("SELECT user, email FROM accounts WHERE user = ? OR email = ?");
                $ps->execute([$user, $email]);
                $row = $ps->fetch();
    
                if ($row['user'] == $user) {
                    $errors["user"] = "Username already exists";
                } 
                if ($row['email'] == $email) {
                    $errors["email"] = "Email already exists";
                }
    
                if (!isset($errors)) {
                    $ps = $pdo->prepare("INSERT INTO accounts (user, pass, email) VALUES (?, ?, ?)");
                    $ps->execute([$user, $pass, $email]);
    
                    $ps = $pdo->prepare("SELECT * FROM accounts WHERE user = ?");
                    $ps->execute([$user]);
                    $row = $ps->fetch();
                    $_SESSION['user'] = array(
                        'uname' => $user,
                        'id' => $row['id']
                    );    
                    echo json_encode(array('code' => 1));
                } else {
                    echo json_encode(array('errors' => $errors));
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        else if (isset($_POST['username']) && isset($_POST['password'])) {
            $user = $_POST['username'];

            $result = $pdo->prepare("SELECT * FROM accounts WHERE user = ?");
            $result->execute([$user]);
            $row = $result->fetch();
    
            if (password_verify($_POST['password'], $row['pass'])) {
                $_SESSION['user'] = array(
                    'uname' => $row['user'], //use fetched username for capitalization consistency 
                    'id' => $row['id']
                );
                echo json_encode(array('code' => 1));
            } else {
                $errors["login"] = "Invalid credentials. Please try again.";
                echo json_encode(array('errors' => $errors));
            }
        }
    }
?>
