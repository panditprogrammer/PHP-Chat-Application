<?php
require_once "core/init.php";
if (!$userObject->isLoggedIn()) {
    $userObject->redirect("login.php");
}

$userObject->updateSession();
$user = $userObject->getUserById();
$userProfileData = null;
if (isset($_GET['username']) && !empty($_GET['username'])) {
    $currentUser = $_GET['username'];
    $userProfileData = $userObject->getUserByUsername($_GET['username']);

    if (!$userProfileData) {
        $userObject->redirect("index.php/$currentUser");
    } else if ($userProfileData->username === $user->username) {
        $userObject->redirect("index.php");
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo SITE_NAME; ?> | Online Free Video/Audio Calling </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="Video/Audio Calling Website (<?php echo SITE_NAME; ?>) is Free for Everyone who want to make HD video call to their friends and family without any third party Apps. This Website is created for Only Education Purpose such as Online Teaching , Training , Consulting, Support for remote user to Chat Online Absolutely FREE." name="description" />
    <meta content="Pandit Programmer (Chandan Prajapati)" name="author" />
    <meta name="keywords" content="Free Video/Audio Calling, Make video call using website online, free voice calling website, video calling Web Application. Free Online Chatting Apps, Online Video Chatting, Online HD Voice Calling, ">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- magnific-popup css -->
    <link href="assets/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />

    <!-- owl.carousel css -->
    <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.theme.default.min.css">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- remixicon  -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">

    <!-- fontawesome   -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css  -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<style>
    /* site loader  */
    #siteLoader {
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 999999999999 !important;
        background-color: #00000080 !important;

    }
</style>

<body>

    <div id="siteLoader">
        <div class="spinner-border text-white" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="layout-wrapper d-lg-flex">

        <!-- Start left sidebar-menu -->
        <div class="side-menu flex-lg-column me-lg-1 ms-lg-0">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="<?php echo ROOT_URL; ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo.svg" alt="" height="30">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo.svg" alt="" height="30">
                    </span>
                </a>
            </div>
            <!-- end navbar-brand-box -->

            <!-- Start side-menu nav -->
            <div class="flex-lg-column my-auto">
                <ul class="nav nav-pills side-menu-nav justify-content-center" role="tablist">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Profile">
                        <a class="nav-link" id="pills-user-tab" data-bs-toggle="pill" href="#pills-user" role="tab">
                            <i class="ri-account-circle-line"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Chats">
                        <a class="nav-link active" id="pills-chat-tab" data-bs-toggle="pill" href="#pills-chat" role="tab">
                            <i class="ri-chat-1-line"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Groups">
                        <a class="nav-link" id="pills-groups-tab" data-bs-toggle="pill" href="#pills-groups" role="tab">
                            <i class="ri-group-line"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Contacts">
                        <a class="nav-link" id="pills-contacts-tab" data-bs-toggle="pill" href="#pills-contacts" role="tab">
                            <i class="ri-contacts-book-line"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Settings">
                        <a class="nav-link" id="pills-setting-tab" data-bs-toggle="pill" href="#pills-setting" role="tab">
                            <i class="ri-settings-2-line"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown profile-user-dropdown d-inline-block d-lg-none">
                        <a class="nav-link dropdown-toggle" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="assets/images/users/<?php isset($user->profileImg) ?  print($user->profileImg) : print("default-user.png"); ?>" alt="" class="profile-user rounded-circle">
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript: void(0);">Profile <i class="ri-account-circle-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Setting <i class="ri-settings-3-line float-end text-muted"></i></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Log out <i class="ri-logout-circle-r-line float-end text-danger"></i></a>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- end side-menu nav -->

            <div class="flex-lg-column d-none d-lg-block">
                <ul class="nav side-menu-nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link light-dark-mode" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" title="Dark / Light Mode">
                            <i class="ri-contrast-2-line"></i>
                        </a>
                    </li>

                    <li class="nav-item btn-group dropup profile-user-dropdown">
                        <a class="nav-link dropdown-toggle" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="assets/images/users/<?php isset($user->profileImg) ? print($user->profileImg) : print("default-user.png"); ?>" alt="" class="profile-user rounded-circle">
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript: void(0);">Profile <i class="ri-account-circle-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Setting <i class="ri-settings-3-line float-end text-muted"></i></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php">Log out <i class="ri-logout-circle-r-line float-end text-danger"></i></a>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- Side menu user -->
        </div>
        <!-- end left sidebar-menu -->

        <!-- start chat-leftsidebar -->
        <div class="chat-leftsidebar me-lg-1 ms-lg-0">

            <div class="tab-content">
                <!-- Start Profile tab-pane -->
                <div class="tab-pane" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                    <!-- Start profile content -->
                    <div>
                        <div class="px-4 pt-4">
                            <div class="user-chat-nav float-end">
                                <div class="dropdown">
                                    <a href="javascript: void(0);" class="font-size-18 text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ri-more-2-fill"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="javascript: void(0);">Edit</a>
                                        <a class="dropdown-item" href="javascript: void(0);">Action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="javascript: void(0);">Another action</a>
                                    </div>
                                </div>
                            </div>
                            <h4 class="mb-0">My Profile</h4>
                        </div>

                        <div class="text-center p-4 border-bottom">
                            <div class="mb-4">
                                <img src="assets/images/users/<?php if (isset($user->profileImg)) echo $user->profileImg;
                                                                else echo "default-user.png"; ?>" class="rounded-circle avatar-lg img-thumbnail" alt="">
                            </div>

                            <h5 class="font-size-16 mb-1 text-truncate"><?php $user->name ? print($user->name) : print($user->username); ?></h5>
                            <p class="text-muted text-truncate mb-1"><i class="ri-record-circle-fill font-size-10 text-success me-1 ms-0 d-inline-block"></i> Active</p>
                        </div>
                        <!-- End profile user -->

                        <!-- Start user-profile-desc -->
                        <div class="p-4 user-profile-desc" data-simplebar>
                            <div class="text-muted">
                                <p class="mb-4">If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual.</p>
                            </div>


                            <div id="tabprofile" class="accordion">
                                <div class="accordion-item card border mb-2">
                                    <div class="accordion-header" id="about2">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#about" aria-expanded="true" aria-controls="about">
                                            <h5 class="font-size-14 m-0">
                                                <i class="ri-user-2-line me-2 ms-0 ms-0 align-middle d-inline-block"></i> About
                                            </h5>
                                        </button>
                                    </div>
                                    <div id="about" class="accordion-collapse collapse show" aria-labelledby="about2" data-bs-parent="#tabprofile">
                                        <div class="accordion-body">
                                            <div>
                                                <p class="text-muted mb-1">Name</p>
                                                <h5 class="font-size-14"><?php $user->name ? print($user->name) : print($user->username); ?></h5>
                                            </div>

                                            <div class="mt-4">
                                                <p class="text-muted mb-1">Email</p>
                                                <h5 class="font-size-14"><?php echo $user->email; ?></h5>
                                            </div>

                                            <div class="mt-4">
                                                <p class="text-muted mb-1">Time</p>
                                                <h5 class="font-size-14">11:40 AM</h5>
                                            </div>

                                            <div class="mt-4">
                                                <p class="text-muted mb-1">Location</p>
                                                <h5 class="font-size-14 mb-0">California, USA</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End About card -->

                                <div class="card accordion-item border">
                                    <div class="accordion-header" id="attachfile2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#attachfile" aria-expanded="false" aria-controls="attachfile">
                                            <h5 class="font-size-14 m-0">
                                                <i class="ri-attachment-line me-2 ms-0 ms-0 align-middle d-inline-block"></i> Attached Files
                                            </h5>
                                        </button>
                                    </div>
                                    <div id="attachfile" class="accordion-collapse collapse" aria-labelledby="attachfile2" data-bs-parent="#tabprofile">
                                        <div class="accordion-body">
                                            <div class="card p-2 border mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3 ms-0">
                                                        <div class="avatar-title bg-primary-subtle text-primary rounded font-size-20">
                                                            <i class="ri-file-text-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="text-start">
                                                            <h5 class="font-size-14 mb-1">Admin-A.zip</h5>
                                                            <p class="text-muted font-size-13 mb-0">12.5 MB</p>
                                                        </div>
                                                    </div>

                                                    <div class="ms-4 me-0">
                                                        <ul class="list-inline mb-0 font-size-18">
                                                            <li class="list-inline-item">
                                                                <a href="javascript: void(0);" class="text-muted px-1">
                                                                    <i class="ri-download-2-line"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item dropdown">
                                                                <a class="dropdown-toggle text-muted px-1" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="ri-more-fill"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="javascript: void(0);">Action</a>
                                                                    <a class="dropdown-item" href="javascript: void(0);">Another action</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="javascript: void(0);">Delete</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card p-2 border mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3 ms-0">
                                                        <div class="avatar-title bg-primary-subtle text-primary rounded font-size-20">
                                                            <i class="ri-image-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="text-start">
                                                            <h5 class="font-size-14 mb-1">Image-1.jpg</h5>
                                                            <p class="text-muted font-size-13 mb-0">4.2 MB</p>
                                                        </div>
                                                    </div>

                                                    <div class="ms-4 me-0">
                                                        <ul class="list-inline mb-0 font-size-18">
                                                            <li class="list-inline-item">
                                                                <a href="javascript: void(0);" class="text-muted px-1">
                                                                    <i class="ri-download-2-line"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item dropdown">
                                                                <a class="dropdown-toggle text-muted px-1" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="ri-more-fill"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="javascript: void(0);">Action</a>
                                                                    <a class="dropdown-item" href="javascript: void(0);">Another action</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="javascript: void(0);">Delete</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card p-2 border mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3 ms-0">
                                                        <div class="avatar-title bg-primary-subtle text-primary rounded font-size-20">
                                                            <i class="ri-image-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="text-start">
                                                            <h5 class="font-size-14 mb-1">Image-2.jpg</h5>
                                                            <p class="text-muted font-size-13 mb-0">3.1 MB</p>
                                                        </div>
                                                    </div>

                                                    <div class="ms-4 me-0">
                                                        <ul class="list-inline mb-0 font-size-18">
                                                            <li class="list-inline-item">
                                                                <a href="javascript: void(0);" class="text-muted px-1">
                                                                    <i class="ri-download-2-line"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item dropdown">
                                                                <a class="dropdown-toggle text-muted px-1" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="ri-more-fill"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="javascript: void(0);">Action</a>
                                                                    <a class="dropdown-item" href="javascript: void(0);">Another action</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="javascript: void(0);">Delete</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card p-2 border mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3 ms-0">
                                                        <div class="avatar-title bg-primary-subtle text-primary rounded font-size-20">
                                                            <i class="ri-file-text-fill"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="text-start">
                                                            <h5 class="font-size-14 mb-1">Landing-A.zip</h5>
                                                            <p class="text-muted font-size-13 mb-0">6.7 MB</p>
                                                        </div>
                                                    </div>

                                                    <div class="ms-4 me-0">
                                                        <ul class="list-inline mb-0 font-size-18">
                                                            <li class="list-inline-item">
                                                                <a href="javascript: void(0);" class="text-muted px-1">
                                                                    <i class="ri-download-2-line"></i>
                                                                </a>
                                                            </li>
                                                            <li class="list-inline-item dropdown">
                                                                <a class="dropdown-toggle text-muted px-1" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="ri-more-fill"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="javascript: void(0);">Action</a>
                                                                    <a class="dropdown-item" href="javascript: void(0);">Another action</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="javascript: void(0);">Delete</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Attached Files card -->
                            </div>
                            <!-- end profile-user-accordion -->

                        </div>
                        <!-- end user-profile-desc -->
                    </div>
                    <!-- End profile content -->
                </div>
                <!-- End Profile tab-pane -->

                <!-- Start chats tab-pane -->
                <div class="tab-pane fade show active" id="pills-chat" role="tabpanel" aria-labelledby="pills-chat-tab">
                    <!-- Start chats content -->
                    <div>
                        <div class="px-4 pt-4">
                            <h4 class="mb-4">Chats</h4>
                            <div class="search-box chat-search-box">
                                <div class="input-group mb-3 rounded-3">
                                    <span class="input-group-text text-muted bg-light pe-1 ps-3" id="basic-addon1">
                                        <i class="ri-search-line search-icon font-size-18"></i>
                                    </span>
                                    <input type="text" class="form-control bg-light" placeholder="Search messages or users" aria-label="Search messages or users" aria-describedby="basic-addon1">
                                </div>
                            </div> <!-- Search Box-->
                        </div> <!-- .p-4 -->

                        <!-- Start user status -->
                        <div class="px-4 pb-4" dir="ltr">

                            <div class="owl-carousel owl-theme" id="user-status-carousel">
                                <div class="item">
                                    <a href="javascript: void(0);" class="user-status-box">
                                        <div class="avatar-xs mx-auto d-block chat-user-img online">
                                            <img src="assets/images/users/avatar-2.jpg" alt="user-img" class="img-fluid rounded-circle">
                                            <span class="user-status"></span>
                                        </div>

                                        <h5 class="font-size-13 text-truncate mt-3 mb-1">Patrick</h5>
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="javascript: void(0);" class="user-status-box">
                                        <div class="avatar-xs mx-auto d-block chat-user-img online">
                                            <img src="assets/images/users/avatar-4.jpg" alt="user-img" class="img-fluid rounded-circle">
                                            <span class="user-status"></span>
                                        </div>

                                        <h5 class="font-size-13 text-truncate mt-3 mb-1">Doris</h5>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="javascript: void(0);" class="user-status-box">
                                        <div class="avatar-xs mx-auto d-block chat-user-img online">
                                            <img src="assets/images/users/avatar-5.jpg" alt="user-img" class="img-fluid rounded-circle">
                                            <span class="user-status"></span>
                                        </div>

                                        <h5 class="font-size-13 text-truncate mt-3 mb-1">Emily</h5>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="javascript: void(0);" class="user-status-box">
                                        <div class="avatar-xs mx-auto d-block chat-user-img online">
                                            <img src="assets/images/users/avatar-6.jpg" alt="user-img" class="img-fluid rounded-circle">
                                            <span class="user-status"></span>
                                        </div>

                                        <h5 class="font-size-13 text-truncate mt-3 mb-1">Steve</h5>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="javascript: void(0);" class="user-status-box">
                                        <div class="avatar-xs mx-auto d-block chat-user-img online">
                                            <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                T
                                            </span>
                                            <span class="user-status"></span>
                                        </div>

                                        <h5 class="font-size-13 text-truncate mt-3 mb-1">Teresa</h5>
                                    </a>
                                </div>

                            </div>
                            <!-- end user status carousel -->
                        </div>
                        <!-- end user status -->

                        <!-- Start chat-message-list -->
                        <div class="">
                            <h5 class="mb-3 px-3 font-size-16">Recent</h5>

                            <div class="chat-message-list px-2" data-simplebar>

                                <ul class="list-unstyled chat-list chat-user-list">
                                    <?php $userObject->getAllUsers(); ?>

                                    <!--
                                         <li>
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img online align-self-center me-3 ms-0">
                                                    <img src="assets/images/users/avatar-2.jpg" class="rounded-circle avatar-xs" alt="">
                                                    <span class="user-status"></span>
                                                </div>

                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">Patrick Hendricks</h5>
                                                    <p class="chat-user-message text-truncate mb-0">Hey! there I'm available</p>
                                                </div>
                                                <div class="font-size-11">05 min</div>
                                            </div>
                                        </a>
                                    </li>
                                 -->


                                    <!-- <li class="unread">
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img away align-self-center me-3 ms-0">
                                                    <img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-xs" alt="">
                                                    <span class="user-status"></span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">Mark Messer</h5>
                                                    <p class="chat-user-message text-truncate mb-0"><i class="ri-image-fill align-middle me-1 ms-0"></i> Images</p>
                                                </div>
                                                <div class="font-size-11">12 min</div>
                                                <div class="unread-message">
                                                    <span class="badge badge-soft-danger rounded-pill">02</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img align-self-center me-3 ms-0">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                            G
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">General</h5>
                                                    <p class="chat-user-message text-truncate mb-0">This theme is awesome!</p>
                                                </div>
                                                <div class="font-size-11">20 min</div>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="active">
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img online align-self-center me-3 ms-0">
                                                    <img src="assets/images/users/avatar-4.jpg" class="rounded-circle avatar-xs" alt="">
                                                    <span class="user-status"></span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">Doris Brown</h5>
                                                    <p class="chat-user-message text-truncate mb-0">Nice to meet you</p>
                                                </div>
                                                <div class="font-size-11">10:12 AM</div>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="unread">
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img align-self-center me-3 ms-0">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                            D
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">Designer</h5>
                                                    <p class="chat-user-message text-truncate mb-0">Next meeting tomorrow 10.00AM</p>
                                                </div>
                                                <div class="font-size-11">12:01 PM</div>
                                                <div class="unread-message">
                                                    <span class="badge badge-soft-danger rounded-pill">01</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img away align-self-center me-3 ms-0">
                                                    <img src="assets/images/users/avatar-6.jpg" class="rounded-circle avatar-xs" alt="">
                                                    <span class="user-status"></span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">Steve Walker</h5>
                                                    <p class="chat-user-message text-truncate mb-0"><i class="ri-file-text-fill align-middle me-1 ms-0"></i> Admin-A.zip</p>
                                                </div>
                                                <div class="font-size-11">03:20 PM</div>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="typing">
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img align-self-center online me-3 ms-0">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                            A
                                                        </span>
                                                    </div>
                                                    <span class="user-status"></span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">Albert Rodarte</h5>
                                                    <p class="chat-user-message text-truncate mb-0">typing<span class="animate-typing">
                                                            <span class="dot"></span>
                                                            <span class="dot"></span>
                                                            <span class="dot"></span>
                                                        </span></p>
                                                </div>
                                                <div class="font-size-11">04:56 PM</div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img align-self-center online me-3 ms-0">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                            M
                                                        </span>
                                                    </div>
                                                    <span class="user-status"></span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">Mirta George</h5>
                                                    <p class="chat-user-message text-truncate mb-0">Yeah everything is fine</p>
                                                </div>
                                                <div class="font-size-11">12/07</div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img away align-self-center me-3 ms-0">
                                                    <img src="assets/images/users/avatar-7.jpg" class="rounded-circle avatar-xs" alt="">
                                                    <span class="user-status"></span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">Paul Haynes</h5>
                                                    <p class="chat-user-message text-truncate mb-0">Good morning</p>
                                                </div>
                                                <div class="font-size-11">12/07</div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img align-self-center online me-3 ms-0">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                            J
                                                        </span>
                                                    </div>
                                                    <span class="user-status"></span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">Jonathan Miller</h5>
                                                    <p class="chat-user-message text-truncate mb-0">Hi, How are you?</p>
                                                </div>
                                                <div class="font-size-11">12/07</div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img away align-self-center me-3 ms-0">
                                                    <img src="assets/images/users/avatar-8.jpg" class="rounded-circle avatar-xs" alt="">
                                                    <span class="user-status"></span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">Ossie Wilson</h5>
                                                    <p class="chat-user-message text-truncate mb-0">I've finished it! See you so</p>
                                                </div>
                                                <div class="font-size-11">11/07</div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);">
                                            <div class="d-flex">
                                                <div class="chat-user-img align-self-center online me-3 ms-0">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                            S
                                                        </span>
                                                    </div>
                                                    <span class="user-status"></span>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15 mb-1">Sara Muller</h5>
                                                    <p class="chat-user-message text-truncate mb-0">Wow that's great</p>
                                                </div>
                                                <div class="font-size-11">11/07</div>
                                            </div>
                                        </a>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                        <!-- End chat-message-list -->
                    </div>
                    <!-- Start chats content -->
                </div>
                <!-- End chats tab-pane -->

                <!-- Start groups tab-pane -->
                <div class="tab-pane" id="pills-groups" role="tabpanel" aria-labelledby="pills-groups-tab">
                    <!-- Start Groups content -->
                    <div>
                        <div class="p-4">
                            <div class="user-chat-nav float-end">
                                <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Create group">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-link text-decoration-none text-muted font-size-18 py-0" data-bs-toggle="modal" data-bs-target="#addgroup-exampleModal">
                                        <i class="ri-group-line me-1 ms-0"></i>
                                    </button>
                                </div>

                            </div>
                            <h4 class="mb-4">Groups</h4>

                            <!-- Start add group Modal -->
                            <div class="modal fade" id="addgroup-exampleModal" tabindex="-1" role="dialog" aria-labelledby="addgroup-exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-size-16" id="addgroup-exampleModalLabel">Create New Group</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form>
                                                <div class="mb-4">
                                                    <label for="addgroupname-input" class="form-label">Group Name</label>
                                                    <input type="text" class="form-control" id="addgroupname-input" placeholder="Enter Group Name">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label">Group Members</label>
                                                    <div class="mb-3">
                                                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#groupmembercollapse" aria-expanded="false" aria-controls="groupmembercollapse">
                                                            Select Members
                                                        </button>
                                                    </div>

                                                    <div class="collapse" id="groupmembercollapse">
                                                        <div class="card border">
                                                            <div class="card-header">
                                                                <h5 class="font-size-15 mb-0">Contacts</h5>
                                                            </div>
                                                            <div class="card-body p-2">
                                                                <div data-simplebar style="max-height: 150px;">
                                                                    <div>
                                                                        <div class="p-3 fw-bold text-primary">
                                                                            A
                                                                        </div>

                                                                        <ul class="list-unstyled contact-list">
                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck1" checked>
                                                                                    <label class="form-check-label" for="memberCheck1">Albert Rodarte</label>
                                                                                </div>
                                                                            </li>

                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck2">
                                                                                    <label class="form-check-label" for="memberCheck2">Allison Etter</label>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>

                                                                    <div>
                                                                        <div class="p-3 fw-bold text-primary">
                                                                            C
                                                                        </div>

                                                                        <ul class="list-unstyled contact-list">
                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck3">
                                                                                    <label class="form-check-label" for="memberCheck3">Craig Smiley</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>

                                                                    <div>
                                                                        <div class="p-3 fw-bold text-primary">
                                                                            D
                                                                        </div>

                                                                        <ul class="list-unstyled contact-list">
                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck4">
                                                                                    <label class="form-check-label" for="memberCheck4">Daniel Clay</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>

                                                                    <div>
                                                                        <div class="p-3 fw-bold text-primary">
                                                                            I
                                                                        </div>

                                                                        <ul class="list-unstyled contact-list">
                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck5">
                                                                                    <label class="form-check-label" for="memberCheck5">Iris Wells</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>

                                                                    <div>
                                                                        <div class="p-3 fw-bold text-primary">
                                                                            J
                                                                        </div>

                                                                        <ul class="list-unstyled contact-list">
                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck6">
                                                                                    <label class="form-check-label" for="memberCheck6">Juan Flakes</label>
                                                                                </div>
                                                                            </li>

                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck7">
                                                                                    <label class="form-check-label" for="memberCheck7">John Hall</label>
                                                                                </div>
                                                                            </li>

                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck8">
                                                                                    <label class="form-check-label" for="memberCheck8">Joy Southern</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>

                                                                    <div>
                                                                        <div class="p-3 fw-bold text-primary">
                                                                            M
                                                                        </div>

                                                                        <ul class="list-unstyled contact-list">
                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck9">
                                                                                    <label class="form-check-label" for="memberCheck9">Michael Hinton</label>
                                                                                </div>
                                                                            </li>

                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck10">
                                                                                    <label class="form-check-label" for="memberCheck10">Mary Farmer</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>

                                                                    <div>
                                                                        <div class="p-3 fw-bold text-primary">
                                                                            P
                                                                        </div>

                                                                        <ul class="list-unstyled contact-list">
                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck11">
                                                                                    <label class="form-check-label" for="memberCheck11">Phillis Griffin</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>

                                                                    <div>
                                                                        <div class="p-3 fw-bold text-primary">
                                                                            R
                                                                        </div>

                                                                        <ul class="list-unstyled contact-list">
                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck12">
                                                                                    <label class="form-check-label" for="memberCheck12">Rocky Jackson</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>

                                                                    <div>
                                                                        <div class="p-3 fw-bold text-primary">
                                                                            S
                                                                        </div>

                                                                        <ul class="list-unstyled contact-list">
                                                                            <li>
                                                                                <div class="form-check">
                                                                                    <input type="checkbox" class="form-check-input" id="memberCheck13">
                                                                                    <label class="form-check-label" for="memberCheck13">Simon Velez</label>
                                                                                </div>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="addgroupdescription-input" class="form-label">Description</label>
                                                    <textarea class="form-control" id="addgroupdescription-input" rows="3" placeholder="Enter Description"></textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Create Groups</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End add group Modal -->

                            <div class="search-box chat-search-box">
                                <div class="input-group rounded-3">
                                    <span class="input-group-text text-muted bg-light pe-1 ps-3" id="basic-addon1">
                                        <i class="ri-search-line search-icon font-size-18"></i>
                                    </span>
                                    <input type="text" class="form-control bg-light" placeholder="Search groups..." aria-label="Search groups..." aria-describedby="basic-addon1">
                                </div>
                            </div> <!-- Search Box-->
                        </div>

                        <!-- Start chat-group-list -->
                        <div class="p-4 chat-message-list chat-group-list" data-simplebar>


                            <ul class="list-unstyled chat-list">
                                <li>
                                    <a href="javascript: void(0);">
                                        <div class="d-flex align-items-center">
                                            <div class="chat-user-img me-3 ms-0">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                        G
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-0">#General</h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="javascript: void(0);">
                                        <div class="d-flex align-items-center">
                                            <div class="chat-user-img me-3 ms-0">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                        R
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-0">#Reporting <span class="badge badge-soft-danger rounded-pill float-end">+23</span></h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="javascript: void(0);">
                                        <div class="d-flex align-items-center">
                                            <div class="chat-user-img me-3 ms-0">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                        D
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-0">#Designers</h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="javascript: void(0);">
                                        <div class="d-flex align-items-center">
                                            <div class="chat-user-img me-3 ms-0">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                        D
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-0">#Developers <span class="badge badge-soft-danger rounded-pill float-end">New</span></h5>
                                            </div>
                                        </div>

                                    </a>
                                </li>

                                <li>
                                    <a href="javascript: void(0);">
                                        <div class="d-flex align-items-center">
                                            <div class="chat-user-img me-3 ms-0">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                        P
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-0">#Project-alpha</h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                                <li>
                                    <a href="javascript: void(0);">
                                        <div class="d-flex align-items-center">
                                            <div class="chat-user-img me-3 ms-0">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                        B
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-0">#Snacks</h5>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End chat-group-list -->
                    </div>
                    <!-- End Groups content -->
                </div>
                <!-- End groups tab-pane -->

                <!-- Start contacts tab-pane -->
                <div class="tab-pane" id="pills-contacts" role="tabpanel" aria-labelledby="pills-contacts-tab">
                    <!-- Start Contact content -->
                    <div>
                        <div class="p-4">
                            <div class="user-chat-nav float-end">
                                <div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add Contact">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-link text-decoration-none text-muted font-size-18 py-0" data-bs-toggle="modal" data-bs-target="#addContact-exampleModal">
                                        <i class="ri-user-add-line"></i>
                                    </button>
                                </div>
                            </div>
                            <h4 class="mb-4">Contacts</h4>

                            <!-- Start Add contact Modal -->
                            <div class="modal fade" id="addContact-exampleModal" tabindex="-1" role="dialog" aria-labelledby="addContact-exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-size-16" id="addContact-exampleModalLabel">Add Contact</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form>
                                                <div class="mb-3">
                                                    <label for="addcontactemail-input" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="addcontactemail-input" placeholder="Enter Email">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="addcontact-invitemessage-input" class="form-label">Invatation Message</label>
                                                    <textarea class="form-control" id="addcontact-invitemessage-input" rows="3" placeholder="Enter Message"></textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Invite Contact</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Add contact Modal -->

                            <div class="search-box chat-search-box">
                                <div class="input-group bg-light  input-group-lg rounded-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-link text-decoration-none text-muted pe-1 ps-3" type="button">
                                            <i class="ri-search-line search-icon font-size-18"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control bg-light" placeholder="Search users..">
                                </div>
                            </div>
                            <!-- End search-box -->
                        </div>
                        <!-- end p-4 -->

                        <!-- Start contact lists -->
                        <div class="p-4 chat-message-list chat-group-list" data-simplebar>

                            <div>
                                <div class="p-3 fw-bold text-primary">
                                    A
                                </div>

                                <ul class="list-unstyled contact-list">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Albert Rodarte</h5>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Allison Etter</h5>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- end contact list A -->

                            <div class="mt-3">
                                <div class="p-3 fw-bold text-primary">
                                    C
                                </div>

                                <ul class="list-unstyled contact-list">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Craig Smiley</h5>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- end contact list C -->

                            <div class="mt-3">
                                <div class="p-3 fw-bold text-primary">
                                    D
                                </div>

                                <ul class="list-unstyled contact-list">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Daniel Clay</h5>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Doris Brown</h5>
                                            </div>

                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <!-- end contact list D -->

                            <div class="mt-3">
                                <div class="p-3 fw-bold text-primary">
                                    I
                                </div>

                                <ul class="list-unstyled contact-list">

                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Iris Wells</h5>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- end contact list I -->

                            <div class="mt-3">
                                <div class="p-3 fw-bold text-primary">
                                    J
                                </div>

                                <ul class="list-unstyled contact-list">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Juan Flakes</h5>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">John Hall</h5>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Joy Southern</h5>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- end contact list J -->

                            <div class="mt-3">
                                <div class="p-3 fw-bold text-primary">
                                    M
                                </div>

                                <ul class="list-unstyled contact-list">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Mary Farmer</h5>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Mark Messer</h5>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Michael Hinton</h5>
                                            </div>

                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <!-- end contact list M -->

                            <div class="mt-3">
                                <div class="p-3 fw-bold text-primary">
                                    O
                                </div>

                                <ul class="list-unstyled contact-list">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Ossie Wilson</h5>
                                            </div>
                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <!-- end contact list O -->

                            <div class="mt-3">
                                <div class="p-3 fw-bold text-primary">
                                    P
                                </div>

                                <ul class="list-unstyled contact-list">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Phillis Griffin</h5>
                                            </div>

                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Paul Haynes</h5>
                                            </div>

                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <!-- end contact list P -->

                            <div class="mt-3">
                                <div class="p-3 fw-bold text-primary">
                                    R
                                </div>

                                <ul class="list-unstyled contact-list">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Rocky Jackson</h5>
                                            </div>

                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <!-- end contact list R -->

                            <div class="mt-3">
                                <div class="p-3 fw-bold text-primary">
                                    S
                                </div>

                                <ul class="list-unstyled contact-list">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Sara Muller</h5>
                                            </div>

                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Simon Velez</h5>
                                            </div>

                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-14 m-0">Steve Walker</h5>
                                            </div>

                                            <div class="dropdown">
                                                <a href="javascript: void(0);" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                                    <a class="dropdown-item" href="javascript: void(0);">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <!-- end contact list S -->
                        </div>
                        <!-- end contact lists -->
                    </div>
                    <!-- Start Contact content -->
                </div>
                <!-- End contacts tab-pane -->

                <!-- Start settings tab-pane -->
                <div class="tab-pane" id="pills-setting" role="tabpanel" aria-labelledby="pills-setting-tab">
                    <!-- Start Settings content -->
                    <div>
                        <div class="px-4 pt-4">
                            <h4 class="mb-0">Settings</h4>
                        </div>

                        <div class="text-center border-bottom p-4">
                            <div class="mb-4 profile-user">
                                <img src="assets/images/users/<?php if (isset($user->profileImg)) echo $user->profileImg;
                                                                else echo "default-user.png"; ?>" class="rounded-circle avatar-lg img-thumbnail" alt="">
                                <button type="button" class="btn btn-light bg-light avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <i class="ri-pencil-fill"></i>
                                </button>
                            </div>

                            <h5 class="font-size-16 mb-1 text-truncate"><?php $user->name ? print($user->name) : print($user->username); ?></h5>
                            <div class="dropdown d-inline-block mb-1">
                                <a class="text-muted dropdown-toggle pb-1 d-block" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Available <i class="mdi mdi-chevron-down"></i>
                                </a>

                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript: void(0);">Available</a>
                                    <a class="dropdown-item" href="javascript: void(0);">Busy</a>
                                </div>
                            </div>
                        </div>
                        <!-- End profile user -->

                        <!-- Start User profile description -->
                        <div class="p-4 user-profile-desc" data-simplebar>
                            <div id="settingprofile" class="accordion">
                                <div class="accordion-item card border mb-2">
                                    <div class="accordion-header" id="personalinfo1">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#personalinfo" aria-expanded="true" aria-controls="personalinfo">
                                            <h5 class="font-size-14 m-0">Personal Info</h5>
                                        </button>
                                    </div>
                                    <div id="personalinfo" class="accordion-collapse collapse show" aria-labelledby="personalinfo1" data-bs-parent="#settingprofile">
                                        <div class="accordion-body">
                                            <div class="float-end">
                                                <button type="button" class="btn btn-light btn-sm"><i class="ri-edit-fill me-1 ms-0 align-middle"></i> Edit</button>
                                            </div>

                                            <div>
                                                <p class="text-muted mb-1">Name</p>
                                                <h5 class="font-size-14"> <?php $user->name ? print($user->name) : print($user->username); ?></h5>
                                            </div>

                                            <div class="mt-4">
                                                <p class="text-muted mb-1">Email</p>
                                                <h5 class="font-size-14"><?php echo $user->email; ?></h5>
                                            </div>

                                            <div class="mt-4">
                                                <p class="text-muted mb-1">Time</p>
                                                <h5 class="font-size-14">11:40 AM</h5>
                                            </div>

                                            <div class="mt-4">
                                                <p class="text-muted mb-1">Location</p>
                                                <h5 class="font-size-14 mb-0">California, USA</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end personal info card -->

                                <div class="accordion-item card border mb-2">
                                    <div class="accordion-header" id="privacy1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacy" aria-expanded="false" aria-controls="privacy">
                                            <h5 class="font-size-14 m-0">Privacy</h5>
                                        </button>
                                    </div>
                                    <div id="privacy" class="accordion-collapse collapse" aria-labelledby="privacy1" data-bs-parent="#settingprofile">
                                        <div class="accordion-body">
                                            <div class="py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="font-size-13 mb-0 text-truncate">Profile photo</h5>
                                                    </div>
                                                    <div class="dropdown ms-2 me-0">
                                                        <button class="btn btn-light btn-sm dropdown-toggle w-sm" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Everyone <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="javascript: void(0);">Everyone</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">selected</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Nobody</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="py-3 border-top">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="font-size-13 mb-0 text-truncate">Last seen</h5>

                                                    </div>
                                                    <div class="ms-2 me-0">
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input" id="privacy-lastseenSwitch" checked>
                                                            <label class="form-check-label" for="privacy-lastseenSwitch"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="py-3 border-top">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="font-size-13 mb-0 text-truncate">Status</h5>
                                                    </div>
                                                    <div class="dropdown ms-2 me-0">
                                                        <button class="btn btn-light btn-sm dropdown-toggle w-sm" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Everyone <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="javascript: void(0);">Everyone</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">selected</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Nobody</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="py-3 border-top">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="font-size-13 mb-0 text-truncate">Read receipts</h5>
                                                    </div>
                                                    <div class="ms-2 me-0">
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input" id="privacy-readreceiptSwitch" checked>
                                                            <label class="form-check-label" for="privacy-readreceiptSwitch"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="py-3 border-top">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="font-size-13 mb-0 text-truncate">Groups</h5>

                                                    </div>
                                                    <div class="dropdown ms-2 me-0">
                                                        <button class="btn btn-light btn-sm dropdown-toggle w-sm" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Everyone <i class="mdi mdi-chevron-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="javascript: void(0);">Everyone</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">selected</a>
                                                            <a class="dropdown-item" href="javascript: void(0);">Nobody</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end privacy card -->

                                <div class="accordion-item card border mb-2">
                                    <div class="accordion-header" id="security1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#security" aria-expanded="false" aria-controls="security">
                                            <h5 class="font-size-14 m-0"></i> Security</h5>
                                        </button>
                                    </div>
                                    <div id="security" class="accordion-collapse collapse" aria-labelledby="security1" data-bs-parent="#settingprofile">
                                        <div class="accordion-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="font-size-13 mb-0 text-truncate">Show security notification</h5>

                                                </div>
                                                <div class="ms-2 me-0">
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input" id="security-notificationswitch">
                                                        <label class="form-check-label" for="security-notificationswitch"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end security card -->

                                <div class="accordion-item card border mb-2">
                                    <div class="accordion-header" id="help1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <h5 class="font-size-14 m-0"></i> Help</h5>
                                        </button>
                                    </div>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="help1" data-bs-parent="#settingprofile">
                                        <div class="accordion-body">
                                            <div class="py-3">
                                                <h5 class="font-size-13 mb-0"><a href="javascript: void(0);" class="text-body d-block">FAQs</a></h5>
                                            </div>
                                            <div class="py-3 border-top">
                                                <h5 class="font-size-13 mb-0"><a href="javascript: void(0);" class="text-body d-block">Contact</a></h5>
                                            </div>
                                            <div class="py-3 border-top">
                                                <h5 class="font-size-13 mb-0"><a href="javascript: void(0);" class="text-body d-block">Terms & Privacy policy</a></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end profile-setting-accordion -->
                        </div>
                        <!-- End User profile description -->
                    </div>
                    <!-- Start Settings content -->
                </div>
                <!-- End settings tab-pane -->
            </div>
            <!-- end tab content -->

        </div>
        <!-- end chat-leftsidebar -->

        <!-- Start User Conversation  -->
        <div class="user-chat <?php $userProfileData ? print("user-chat-show") : ""; ?> w-100 overflow-hidden">
            <div class="d-lg-flex">

                <!-- start chat conversation section -->
                <div class="w-100 overflow-hidden position-relative">
                    <div class="p-3 p-lg-4 border-bottom user-chat-topbar">
                        <div class="row align-items-center">
                            <div class="col-sm-4 col-8">
                                <div class="d-flex align-items-center">
                                    <div class="d-block d-lg-none me-2 ms-0">
                                        <a href="<?php echo ROOT_URL; ?>" class="user-chat-remove text-muted font-size-16 p-2"><i class="ri-arrow-left-s-line"></i></a>
                                    </div>
                                    <div class="me-3 ms-0">
                                        <img src="assets/images/users/<?php isset($userProfileData->profileImg) ? print($userProfileData->profileImg) : print("default-user.png"); ?>" class="rounded-circle avatar-xs" alt="">
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-0 text-truncate">
                                            <a href="javascript:void(0)" class="text-reset user-profile-<?php $userProfileData ? print("show") : print(""); ?>"><?php $userProfileData ? print($userProfileData->username) : print(""); ?></a>
                                            <i class="ri-record-circle-fill font-size-10 text-<?php $userProfileData ? print("success") : print("secondary"); ?> d-inline-block ms-1"></i>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-4">
                                <ul class="list-inline user-chat-nav text-end mb-0">
                                    <!-- <li class="list-inline-item">
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle <?php if (!isset($userProfileData)) echo "disabled"; ?>" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-search-line"></i>
                                            </button>
                                            <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-md">
                                                <div class="search-box p-2">
                                                    <input type="text" class="form-control bg-light border-0" placeholder="Search..">
                                                </div>
                                            </div>
                                        </div>
                                    </li> -->

                                    <li class="list-inline-item d-lg-inline-block me-2 ms-0" title="Voice Call">
                                        <button type="button" class="btn nav-btn <?php if (!isset($userProfileData)) echo "disabled"; ?>" data-bs-toggle="modal" data-bs-target="#audiocallModal">
                                            <i class="ri-phone-line"></i>
                                        </button>
                                    </li>

                                    <li class="list-inline-item d-lg-inline-block me-2 ms-0" title="Video Call">
                                        <button type="button" class="btn nav-btn <?php if (!isset($userProfileData)) echo "disabled"; ?>" data-bs-toggle="modal" id="videoCallBtn" data-user="<?php if (isset($userProfileData)) echo $userProfileData->id; ?>" data-bs-target="#videocallModal">
                                            <i class="ri-vidicon-line"></i>
                                        </button>
                                    </li>

                                    <li class="list-inline-item d-none d-lg-inline-block me-2 ms-0">
                                        <button type="button" class="btn nav-btn user-profile-show <?php if (!isset($userProfileData)) echo "disabled"; ?>">
                                            <i class="ri-user-line"></i>
                                        </button>
                                    </li>

                                    <li class="list-inline-item">
                                        <div class="dropdown">
                                            <button class="btn nav-btn dropdown-toggle <?php if (!isset($userProfileData)) echo "disabled"; ?>" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item d-block d-lg-none user-profile-show" href="javascript: void(0);">View profile <i class="ri-user-1-line float-end text-muted"></i></a>
                                                <a class="dropdown-item" href="javascript: void(0);">Archive <i class="ri-archive-line float-end text-muted"></i></a>
                                                <a class="dropdown-item" href="javascript: void(0);">Muted <i class="ri-volume-mute-line float-end text-muted"></i></a>
                                                <a class="dropdown-item" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- end chat user head -->

                    <!-- start chat conversation -->
                    <div class="chat-conversation p-3 p-lg-4 " data-simplebar="init">
                        <?php
                        if ($userProfileData) {
                        ?>

                            <ul class="list-unstyled mb-0" id="chatMessages">
                                <!-- dynamic messages  -->
                            </ul>
                        <?php
                        } else {
                        ?>
                            <style>
                                .chat-conversation .simplebar-content {
                                    display: flex;
                                    height: 100%;
                                    justify-content: center;
                                    align-items: center;
                                }
                            </style>
                            <h5 class="text-secondary">Select a user to start Conversation!</h5>

                        <?php
                        }
                        ?>
                    </div>
                    <!-- end chat conversation end -->

                    <!-- start chat input section -->
                    <div class="chat-input-section p-3 p-lg-4 border-top mb-0">

                        <form method="post" id="chatForm" class="row g-0">

                            <div class="col">
                                <input type="hidden" name="fromUser" id="fromUser" value="<?php echo $user->id; ?>">
                                <input type="hidden" name="sendToUser" id="sendToUser" value="<?php isset($userProfileData) ? print($userProfileData->id) : ""; ?>">
                                <textarea autofocus name="message" id="message" title="Press CTRL + ENTER to send" style="resize: none;" rows="2" class="form-control form-control-lg bg-light border-light" <?php if (!isset($userProfileData)) echo "disabled"; ?> placeholder="Write Message..."></textarea>
                            </div>
                            <div class="col-auto">
                                <div class="chat-input-links ms-md-2 me-md-0 h-100">
                                    <ul class="list-inline mb-0 h-100">
                                        <!-- <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Emoji">
                                            <button type="button" class="btn btn-link text-decoration-none font-size-16 btn-lg waves-effect <?php if (!isset($userProfileData)) echo "disabled"; ?>">
                                                <i class="ri-emotion-happy-line"></i>
                                            </button>
                                        </li> -->
                                        <!-- <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Attached File">
                                            <button type="button" class="btn btn-link text-decoration-none font-size-16 btn-lg waves-effect <?php if (!isset($userProfileData)) echo "disabled"; ?>">
                                                <i class="ri-attachment-line"></i>
                                            </button>
                                        </li> -->
                                        <li class="list-inline-item h-100">
                                            <button type="submit" id="submitBtn" class="btn btn-primary font-size-16 h-100 btn-lg chat-send waves-effect waves-light <?php if (!isset($userProfileData)) echo "disabled"; ?>">
                                                <i class="ri-send-plane-2-fill"></i>
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </form>
                    </div>
                    <!-- end chat input section -->
                </div>
                <!-- end chat conversation section -->

                <!-- start User profile detail sidebar -->
                <div class="user-profile-sidebar">
                    <div class="px-3 px-lg-4 pt-3 pt-lg-4">
                        <div class="user-chat-nav text-end">
                            <button type="button" class="btn nav-btn" id="user-profile-hide">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-4 border-bottom">
                        <div class="mb-4">
                            <img src="assets/images/users/<?php $userProfileData ? print($userProfileData->profileImg) : print("default-user.png"); ?>" class="rounded-circle avatar-lg img-thumbnail" alt="">
                        </div>

                        <h5 class="font-size-16 mb-1 text-truncate"><?php $userProfileData ? print($userProfileData->username) : print(""); ?></h5>
                        <p class="text-muted text-truncate mb-1"><i class="ri-record-circle-fill font-size-10 text-success me-1 ms-0"></i> Active</p>
                    </div>
                    <!-- End profile user -->

                    <!-- Start user-profile-desc -->
                    <div class="p-4 user-profile-desc" data-simplebar>
                        <div class="text-muted">
                            <p class="mb-4">If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual.</p>
                        </div>

                        <div class="accordion" id="myprofile">

                            <div class="accordion-item card border mb-2">
                                <div class="accordion-header" id="about3">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#aboutprofile" aria-expanded="true" aria-controls="aboutprofile">
                                        <h5 class="font-size-14 m-0">
                                            <i class="ri-user-2-line me-2 ms-0 align-middle d-inline-block"></i> About
                                        </h5>
                                    </button>
                                </div>
                                <div id="aboutprofile" class="accordion-collapse collapse show" aria-labelledby="about3" data-bs-parent="#myprofile">
                                    <div class="accordion-body">
                                        <div>
                                            <p class="text-muted mb-1">Name</p>
                                            <h5 class="font-size-14"><?php $userProfileData ? print($userProfileData->name) : print(""); ?></h5>
                                        </div>

                                        <div class="mt-4">
                                            <p class="text-muted mb-1">Email</p>
                                            <h5 class="font-size-14"><?php $userProfileData ? print($userProfileData->email) : print(""); ?></h5>
                                        </div>

                                        <div class="mt-4">
                                            <p class="text-muted mb-1">Time</p>
                                            <h5 class="font-size-14">11:40 AM</h5>
                                        </div>

                                        <div class="mt-4">
                                            <p class="text-muted mb-1">Location</p>
                                            <h5 class="font-size-14 mb-0">California, USA</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card border">
                                <div class="accordion-header" id="attachfile3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#attachprofile" aria-expanded="false" aria-controls="attachprofile">
                                        <h5 class="font-size-14 m-0">
                                            <i class="ri-attachment-line me-2 ms-0 align-middle d-inline-block"></i> Attached Files
                                        </h5>
                                    </button>
                                </div>
                                <div id="attachprofile" class="accordion-collapse collapse" aria-labelledby="attachfile3" data-bs-parent="#myprofile">
                                    <div class="accordion-body">
                                        <div class="card p-2 border mb-2">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3 ms-0">
                                                    <div class="avatar-title bg-primary-subtle text-primary rounded font-size-20">
                                                        <i class="ri-file-text-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="text-start">
                                                        <h5 class="font-size-14 mb-1">admin_v1.0.zip</h5>
                                                        <p class="text-muted font-size-13 mb-0">12.5 MB</p>
                                                    </div>
                                                </div>

                                                <div class="ms-4 me-0">
                                                    <ul class="list-inline mb-0 font-size-18">
                                                        <li class="list-inline-item">
                                                            <a href="javascript: void(0);" class="text-muted px-1">
                                                                <i class="ri-download-2-line"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item dropdown">
                                                            <a class="dropdown-toggle text-muted px-1" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="ri-more-fill"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" href="javascript: void(0);">Action</a>
                                                                <a class="dropdown-item" href="javascript: void(0);">Another action</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="javascript: void(0);">Delete</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card p-2 border mb-2">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3 ms-0">
                                                    <div class="avatar-title bg-primary-subtle text-primary rounded font-size-20">
                                                        <i class="ri-image-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="text-start">
                                                        <h5 class="font-size-14 mb-1">Image-1.jpg</h5>
                                                        <p class="text-muted font-size-13 mb-0">4.2 MB</p>
                                                    </div>
                                                </div>

                                                <div class="ms-4 me-0">
                                                    <ul class="list-inline mb-0 font-size-18">
                                                        <li class="list-inline-item">
                                                            <a href="javascript: void(0);" class="text-muted px-1">
                                                                <i class="ri-download-2-line"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item dropdown">
                                                            <a class="dropdown-toggle text-muted px-1" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="ri-more-fill"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" href="javascript: void(0);">Action</a>
                                                                <a class="dropdown-item" href="javascript: void(0);">Another action</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="javascript: void(0);">Delete</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card p-2 border mb-2">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3 ms-0">
                                                    <div class="avatar-title bg-primary-subtle text-primary rounded font-size-20">
                                                        <i class="ri-image-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="text-start">
                                                        <h5 class="font-size-14 mb-1">Image-2.jpg</h5>
                                                        <p class="text-muted font-size-13 mb-0">3.1 MB</p>
                                                    </div>
                                                </div>

                                                <div class="ms-4 me-0">
                                                    <ul class="list-inline mb-0 font-size-18">
                                                        <li class="list-inline-item">
                                                            <a href="javascript: void(0);" class="text-muted px-1">
                                                                <i class="ri-download-2-line"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item dropdown">
                                                            <a class="dropdown-toggle text-muted px-1" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="ri-more-fill"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" href="javascript: void(0);">Action</a>
                                                                <a class="dropdown-item" href="javascript: void(0);">Another action</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="javascript: void(0);">Delete</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card p-2 border mb-2">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3 ms-0">
                                                    <div class="avatar-title bg-primary-subtle text-primary rounded font-size-20">
                                                        <i class="ri-file-text-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="text-start">
                                                        <h5 class="font-size-14 mb-1">Landing-A.zip</h5>
                                                        <p class="text-muted font-size-13 mb-0">6.7 MB</p>
                                                    </div>
                                                </div>

                                                <div class="ms-4 me-0">
                                                    <ul class="list-inline mb-0 font-size-18">
                                                        <li class="list-inline-item">
                                                            <a href="javascript: void(0);" class="text-muted px-1">
                                                                <i class="ri-download-2-line"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item dropdown">
                                                            <a class="dropdown-toggle text-muted px-1" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="ri-more-fill"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" href="javascript: void(0);">Action</a>
                                                                <a class="dropdown-item" href="javascript: void(0);">Another action</a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="javascript: void(0);">Delete</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end profile-user-accordion -->
                        </div>
                        <!-- end user-profile-desc -->
                    </div>
                    <!-- end User profile detail sidebar -->
                </div>
            </div>
            <!-- End User chat -->

            <!-- end modal -->
        </div>


        <!-- audiocall Modal -->
        <div class="modal fade" id="audiocallModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center p-4">
                            <div class="avatar-lg mx-auto mb-4">
                                <img src="assets/images/users/avatar-4.jpg" alt="" class="img-thumbnail rounded-circle">
                            </div>

                            <h5 class="text-truncate">Doris Brown</h5>
                            <p class="text-muted">Start Audio Call</p>

                            <div class="mt-5">
                                <ul class="list-inline mb-1">
                                    <li class="list-inline-item px-2 me-2 ms-0">
                                        <button type="button" class="btn btn-danger avatar-sm rounded-circle" data-bs-dismiss="modal">
                                            <span class="avatar-title bg-transparent font-size-20">
                                                <i class="ri-close-fill"></i>
                                            </span>
                                        </button>
                                    </li>
                                    <li class="list-inline-item px-2">
                                        <button type="button" class="btn btn-success avatar-sm rounded-circle">
                                            <span class="avatar-title bg-transparent font-size-20">
                                                <i class="ri-phone-fill"></i>
                                            </span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- audiocall Modal -->

        <!-- videocall Modal -->
        <div class="modal fade" id="videocallModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content m-0 video-container">
                    <div class="modal-body d-flex justify-content-center align-items-center p-0">
                        <video id="remoteVideo" autoplay></video>
                        <video id="localVideo" autoplay></video>

                        <div class="video-overlay" id="video-overlay">
                            <div class="avatar-lg mx-auto my-2">
                                <img src="assets/images/users/<?php $userProfileData ? print($userProfileData->profileImg) : print("default-user.png"); ?>" id="remote-profileImg" alt="remoteUser" class="img-fluid rounded-circle">
                            </div>

                            <h5 class="text-truncate text-white my-1" id="remote-username"> <?php $userProfileData ? print($userProfileData->username) : print("Unknown"); ?> </h5>
                            <div class="d-flex justify-content-center align-items-center text-white mb-0">
                                <i class="ri-vidicon-fill fs-5 px-2"></i>
                                <span id="calling-type"></span>
                            </div>

                            <div class="text-white text-center videoDuration p-2">
                                <span class="p-2 rounded" id="videoDuration">00:00</span>
                            </div>

                            <div class="my-4 d-flex justify-content-center align-items-center">
                                <button type="button" id="callDeclineBtn" class="btn btn-danger rounded px-5 py-2 me-2 me-md-4">
                                    <i class="fa-solid fa-phone-slash"></i>
                                </button>
                                <button type="button" id="callHangupBtn" class="btn btn-danger rounded px-5 py-2 me-2 me-md-4">
                                    <i class="fa-solid fa-phone-slash"></i>
                                </button>
                                <button type="button" id="callReceiveBtn" class="btn btn-success rounded px-5 py-2 ms-2 ms-md-4">
                                    <i class="fa-sharp fa-solid fa-phone-volume"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- end  layout wrapper -->

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- Magnific Popup-->
        <script src="assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>

        <!-- owl.carousel js -->
        <script src="assets/libs/owl.carousel/owl.carousel.min.js"></script>

        <!-- page init -->
        <script src="assets/js/pages/index.init.js"></script>
        <script src="assets/js/app.js"></script>


        <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>

        <!-- jquery timer  -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/timer.jquery/0.7.0/timer.jquery.js"></script>
        <!-- custom js  -->
        <script>
            const conn = new WebSocket("ws://localhost:8090/?token=<?php echo $userObject->sessionId; ?>");
        </script>
        <script src="assets/js/index.js"></script>
</body>

</html>