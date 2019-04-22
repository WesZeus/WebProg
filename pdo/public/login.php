<?php 
require "../config.php";
require "../common.php";
?>
<?php
//SUBMIT EVENT DATA TO DB
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $connection = new PDO($dsn, $username, $password, $options);
        // capture email and password sent from form 
        $email = $_POST['email'];
        $password = $_POST['password'];

        //$sql = "SELECT id FROM users WHERE email = '$email' and password = '$password'";
        $sql = "SELECT * FROM users WHERE email = '$email' and password = '$password'";
        $results = $connection->query($sql)->fetchAll();
        echo  $results[0]['email'];

        $msg = '';
        if (
            isset($_POST['loginsubmit']) && !empty($_POST['email'])
            && !empty($_POST['password'])
        ) {
            $_SESSION['name'] =  $results[0]['name'];
            $_SESSION['email'] =  $results[0]['email'];
        } else {
            $msg = 'You have entered valid use name and password';
        }
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

?>



<div class="container">
    <div class="row">
        <div align="center">
            <div>
                <header><b>Login</b></header>
                <div>
                    <form action="login.php" method="post">
                        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
                        <input type="email" name="email" class="box" placeholder="Email" required><br />
                        <input type="password" name="password" class="box" placeholder="Password" required><br />
                        <input name="loginsubmit" type="submit" value=" Submit " /><br />
                    </form>

                    <div style="font-size:11px; color:#cc0000; margin-top:10px">
                        <?php if (isset($error)) {
                            echo $error;
                        } ?></div>

                </div>

            </div>
        </div>
    </div>
</div>
<?php include "templates/footer.php"; ?>