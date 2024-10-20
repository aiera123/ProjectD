<?php
session_start();
//require_once "connection.php";
if($_SERVER['REQUEST_METHOD']==='POST') {
    //handle login submit
    $email=$_POST['email'];
    $password=md5($_POST['password']);
    $position=$_POST['role'];
    
    if($position === 'pharmacist') {
        $sql="select * from pharmacist where Email='$email' and Password='$password'";
        $loginStmt=$con->prepare($sql);
        $loginStmt->execute();

        $loginUser=$loginStmt->fetch(PDO::FETCH_ASSOC);
        if ($loginUser) {
            $_SESSION['pharmacist_login']=true;
            $_SESSION['email']=$loginUser['email'];
            $_SESSION['pharmacistid']=$loginUser['id'];  //stores employee id in session
            header("Location:Pharmacists/dashboard.php");
            die;
        } else {
            header("Location:login.php?error=Your entered credintials do not match our records.");
            die;
        }
    } 
    elseif($position === ' Inventory manager') {
        $sql="select * from Inventory manager where Email='$email' and Password='$password'";
        $loginStmt=$con->prepare($sql);
        $loginStmt->execute();

        $loginUser=$loginStmt->fetch(PDO::FETCH_ASSOC);
        if ($loginUser) {
            $_SESSION['manager_login']=true;
            $_SESSION['email']=$loginUser['email'];
            $_SESSION['managerid']=$loginUser['id'];  //stores manager id in session
            header("Location:manager/dashboard.php");
            die;
        } else {
            header("Location:login.php?error=Your entered credintials do not match our records.");
            die;
        }
    } 
    else {
        header("Location:login.php?error=Please enter your position first.");
        die;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>HR Management System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if(isset($_GET['error'])) { ?>
            <div class="alert alert-danger">
                <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>
        <form action="" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input required type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div> <br>
            
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input required type="password" name="password" class="form-control" id="password">
            </div> <br>

            <div class="form-group">
                <label for="role">Role:</label>
                <select name="role" id="role" class="form-control">
                    <option value="">Select Role</option>
                    <option value="pharmacist">Pharmacist</option>
                    <option value="inventory">Inventory</option>
                    <option value="account">Account</option>
                </select>
            </div>

            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="rememberme">
              <label class="form-check-label" for="rememberme">Remember Me</label>
            </div> <br>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>