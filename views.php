<?php
require_once "configPDO.php";
?>

<?php

$successful = "";

if ( isset($_POST['email']) && isset($_POST['password'])  ) {
    // echo("<p>Handling POST data...</p>\n");

    if($_POST['email'] == "" || $_POST['password'] == "") {
        echo '<p style="color: red">User name and password are required</p>';   
    }

    elseif (strpos($_POST['email'], '@') == false) {
            $email_validation =  '<p style="color: red">Email must have an at-sign (@)</p>';  
            echo ($email_validation);
    } 

    else {
        $sql = "SELECT name FROM users 
            WHERE email = :em AND password = :pw";

        // echo "<p>$sql</p>\n";
        
        // p' OR '1' = '1
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':em' => $_POST['email'], 
            ':pw' => $_POST['password']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // var_dump($row);

        if ( $row === FALSE ) {
            
            echo "<h1 style='color: red'>Login incorrect.</h1>\n";

            $hash = hash('sha256', $_POST['password']);
            error_log("Login fail ".$_POST['email']." $hash");

        } else { 
            error_log("Login success ".$_POST['email']);
            successful_message();
            sleep(3);
            redirect();
            
            
            exit();
        }
    }
}
?>

<html>

    <head>
        <title>Muhammad Sajid Qureshi</title>
    </head>

    <body>

        <p>Please Login</p>
        <form method="post">
        <p>Email:
        <input type="text" size="40" name="email"></p>
        <p>Password:
        <input type="text" size="40" name="password"></p>
        <p><input type="submit" value="Login"/>
        <a href="<?php echo($_SERVER['PHP_SELF']);?>">Refresh</a></p>
        <?php
            echo $successful;
        ?>
       
        </form>
        <?php
            function successful_message(){
                $successful =  "<h1 style='color: green'>Login Successful.</h1>\n";
                // echo $successful = preg_replace('/<span[^>]+\>/i', '', $email_validation);
                echo $successful;
                echo '<p style="color: red">Email must have an at-sign (@)</p>';  
            }
        ?>

        <?php
            function redirect() {
                echo "Hello world!";
                $header = header("Location: http://localhost/asg/auto.php");
            }

        ?>
      

    </body>
</html
