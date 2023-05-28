<?php
require_once "core/init.php";

if ($userObject->isLoggedIn()) {
    $userObject->redirect(ROOT_URL);
}

$email = $username = null ;
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (isset($_POST)) {
        $email = trim(stripcslashes(htmlentities($_POST['email'])));
        $username = trim(stripcslashes(htmlentities($_POST['username'])));
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        if ($password === $cpassword) {

            if (!empty($username) && !empty($password)) {

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    if ($userObject->emailExist($email)) {
                        $msg = "Email already exist!";
                    } else {
                        if ($userObject->registerUser($email, $username, $password)) {
                            $userObject->redirect("login.php");
                        } else {
                            $msg = "Unable to Register! Please try again.";
                        }
                    }
                } else {
                    $msg = "Invalid Email format!";
                }
            } else {
                $msg = "Please fill the required fields!";
            }
        } else {
            $msg = "Password Missmatch!";
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Register | <?php echo SITE_NAME; ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Register in <?php echo SITE_NAME; ?> to make Video/Audio Call For FREE without installing any third party apps on your devices. " name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo ROOT_URL; ?>assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo ROOT_URL; ?>assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo ROOT_URL; ?>assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo ROOT_URL; ?>assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo ROOT_URL; ?>assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo ROOT_URL; ?>assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo ROOT_URL; ?>assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo ROOT_URL; ?>assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo ROOT_URL; ?>assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo ROOT_URL; ?>assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo ROOT_URL; ?>assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo ROOT_URL; ?>assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo ROOT_URL; ?>assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo ROOT_URL; ?>assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo ROOT_URL; ?>assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

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
                    <div class="text-center">
                        <a href="<?php echo ROOT_URL; ?>" class="auth-logo mb-5 d-block">
                            <img src="assets/images/logo-dark.png" alt="" height="30" class="logo logo-dark">
                            <img src="assets/images/logo-light.png" alt="" height="30" class="logo logo-light">
                        </a>

                        <h4>Sign up</h4>
                        <p class="text-muted mb-4">Get your <?php echo SITE_NAME; ?> account now.</p>
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
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <div class="input-group bg-light-subtle rounded-3  mb-3">
                                            <span class="input-group-text text-muted" id="basic-addon5">
                                                <i class="ri-mail-line"></i>
                                            </span>
                                            <input type="email" name="email" class="form-control form-control-lg bg-light-subtle border-light" placeholder="Enter Email" aria-label="Enter Email" aria-describedby="basic-addon5" value="<?php echo $email; ?>">

                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <div class="input-group bg-light-subtle mb-3 rounded-3">
                                            <span class="input-group-text border-light text-muted" id="basic-addon6">
                                                <i class="ri-user-3-line"></i>
                                            </span>
                                            <input type="text" name="username" class="form-control form-control-lg bg-light-subtle border-light" placeholder="Enter Username" aria-label="Enter Username" aria-describedby="basic-addon6" value="<?php echo $username; ?>">

                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <div class="input-group bg-light-subtle mb-3 rounded-3">
                                            <span class="input-group-text border-light text-muted" id="basic-addon7">
                                                <i class="ri-lock-2-line"></i>
                                            </span>
                                            <input type="password" name="password" class="form-control form-control-lg bg-light-subtle border-light" placeholder="Enter Password" aria-label="Enter Password" aria-describedby="basic-addon7">

                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group bg-light-subtle mb-3 rounded-3">
                                            <span class="input-group-text border-light text-muted" id="basic-addon7">
                                                <i class="ri-lock-2-line"></i>
                                            </span>
                                            <input type="password" name="cpassword" class="form-control form-control-lg bg-light-subtle border-light" placeholder="Confirm Password" aria-describedby="basic-addon7">

                                        </div>
                                    </div>


                                    <div class="d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Sign up</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <p class="text-muted mb-0">By registering you agree to the <?php echo SITE_NAME; ?> <a href="#" class="text-primary">Terms of Use</a></p>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <p>Already have an account ? <a href="login.php" class="fw-medium text-primary"> Signin </a> </p>
                        <p>© <script>
                                document.write(new Date().getFullYear())
                            </script> <a href="http://panditprogrammer.com" target="blank">PanditProgrammer.com</a> </p>
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