<?php
    require_once 'includes/dbh.inc.php';

    $statusMsg = '';
    $msgClass = 'errordiv';

    // if (isset($_SESSION['user'])) {
    //     echo "<script>window.location = 'index.php';</script>";
    // }

    if (isset($_REQUEST['login_btn'])) {
        $postData = $_POST;
        $username = strtolower($_REQUEST['username']);
        $password = strip_tags($_REQUEST['password']);

        if (empty($username)) {
            $statusMsg = "Please enter username.<br>";
        }
        else if (empty($password)) {
            $statusMsg = "Please enter password.<br>";
        }
        else {
            try {
                $sqlSelect = $db->prepare("SELECT * FROM Users WHERE Username = :user LIMIT 1");
                $sqlSelect->execute([':user' => $username]);
                $row = $sqlSelect->fetch(PDO::FETCH_ASSOC);
    
                if ($sqlSelect->rowCount() > 0) {
                    if (password_verify($password, $row["Password"])) {
                        $_SESSION['user']['id'] = $row["Id"];
                        $_SESSION['user']['firstName'] = $row["FirstName"];
                        $_SESSION['user']['lastName'] = $row["LastName"];
                        $_SESSION['user']['username'] = $row["Username"];
                        $_SESSION['user']['email'] = $row["Email"];
                        $_SESSION['user']['roleId'] = $row["RoleId"];

                        // Successful login. Redirect user to Home page
                        echo "<script>window.location = 'index.php';</script>";
                    }
                    else {
                        $statusMsg = "Wrong Username or Password";
                    }
                }
                else {
                    $statusMsg = "Wrong Username or Password";
                }
            } catch (PDOException $ex) {
                echo $ex->getMessage();
            }
        }
    }

?>