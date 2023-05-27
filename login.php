<?php
require_once "core/init.php";

if ($userObject->isLoggedIn()) {
    $userObject->redirect(ROOT_URL);
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (isset($_POST)) {
        $username = trim(stripcslashes(htmlentities($_POST['username'])));
        $password = $_POST['password'];

        if (!empty($username) && !empty($password)) {

            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {

                if ($user = $userObject->emailExist($username)) {

                    if (password_verify($password, $user->password)) {
                        session_regenerate_id();
                        $_SESSION['userId'] = $user->id;
                        $userObject->redirect(ROOT_URL);
                    } else {
                        $msg = "Incorrect Username or Password";
                    }
                } else {
                    $msg = "username is not exist!";
                }
            } else {
                $msg = "Invalid Email format!";
            }
        } else {
            $msg = "Please enter username and password!";
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Log in | <?php echo SITE_NAME; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Login to <?php echo SITE_NAME; ?> to Enjoy FREE Online Video/ Audio Callig to friends and Family. " name="description" />
    <meta content="Pandit Programmer" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- remixicon  -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
</head>

<body>

    <div class="account-pages pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center mb-4">
                        <a href="<?php echo ROOT_URL; ?>" class="auth-logo mb-5 d-block">
                            <img src="assets/images/logo-dark.png" alt="" height="30" class="logo logo-dark">
                            <img src="assets/images/logo-light.png" alt="" height="30" class="logo logo-light">
                        </a>

                        <h4>Sign in</h4>
                        <p class="text-muted mb-4">Sign in to continue to <?php echo SITE_NAME; ?>.</p>
                        <?php
                        if (isset($msg))
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ' . $msg . '
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                        ?>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <div class="p-3">
                                <form action="" method="post">

                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <div class="input-group mb-3 bg-light-subtle rounded-3">
                                            <span class="input-group-text text-muted" id="basic-addon3">
                                                <i class="ri-user-2-line"></i>
                                            </span>
                                            <input type="text" name="username" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Username" aria-label="Enter Username" aria-describedby="basic-addon3">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="float-end">
                                            <a href="reset-password.php" class="text-muted font-size-13">Forgot password?</a>
                                        </div>
                                        <label class="form-label">Password</label>
                                        <div class="input-group mb-3 bg-light-subtle rounded-3">
                                            <span class="input-group-text text-muted" id="basic-addon4">
                                                <i class="ri-lock-2-line"></i>
                                            </span>
                                            <input type="password" name="password" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Password" aria-label="Enter Password" aria-describedby="basic-addon4">
                                        </div>
                                    </div>

                                    <div class="form-check mb-4">
                                        <input type="checkbox" class="form-check-input" id="remember-check">
                                        <label class="form-check-label" for="remember-check">Remember me</label>
                                    </div>

                                    <div class="d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Sign in</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <p>Don't have an account ? <a href="register.php" class="fw-medium text-primary"> Signup now </a> </p>
                        <p>©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> <a href="http://panditprogrammer.com" target="blank">Pandit Programmer</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <script src="assets/js/app.js"></script>

</body>

</html>