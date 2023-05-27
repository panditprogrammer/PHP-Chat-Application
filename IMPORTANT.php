<ul class="list-unstyled mb-0">
    <li>
        <div class="conversation-list">
            <div class="chat-avatar">
                <img src="assets/images/users/avatar-4.jpg" alt="">
            </div>

            <div class="user-chat-content">
                <div class="ctext-wrap">
                    <div class="ctext-wrap-content">
                        <p class="mb-0">
                            Good morning
                        </p>
                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:00</span></p>
                    </div>
                    <div class="dropdown align-self-start">
                        <a class="dropdown-toggle" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript: void(0);">Copy <i class="ri-file-copy-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Save <i class="ri-save-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Forward <i class="ri-chat-forward-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-muted"></i></a>
                        </div>
                    </div>
                </div>
                <div class="conversation-name">Doris Brown</div>
            </div>
        </div>
    </li>

    <li class="right">
        <div class="conversation-list">
            <div class="chat-avatar">
                <img src="assets/images/users/<?php if (isset($userProfileData)) echo $user->profileImg;
                                                else echo "default-user.png"; ?>" alt="">
            </div>

            <div class="user-chat-content">
                <div class="ctext-wrap">
                    <div class="ctext-wrap-content">
                        <p class="mb-0">
                            Good morning, How are you? What about our next meeting?
                        </p>
                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:02</span></p>
                    </div>

                    <div class="dropdown align-self-start">
                        <a class="dropdown-toggle" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript: void(0);">Copy <i class="ri-file-copy-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Save <i class="ri-save-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Forward <i class="ri-chat-forward-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-muted"></i></a>
                        </div>
                    </div>
                </div>

                <div class="conversation-name"><?php if (isset($userProfileData)) echo $user->name; ?></div>
            </div>
        </div>
    </li>

    <li>
        <div class="chat-day-title">
            <span class="title">Today</span>
        </div>
    </li>

    <li>
        <div class="conversation-list">
            <div class="chat-avatar">
                <img src="assets/images/users/avatar-4.jpg" alt="">
            </div>

            <div class="user-chat-content">

                <div class="ctext-wrap">
                    <div class="ctext-wrap-content">
                        <p class="mb-0">
                            Yeah everything is fine
                        </p>
                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:05</span></p>
                    </div>
                    <div class="dropdown align-self-start">
                        <a class="dropdown-toggle" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript: void(0);">Copy <i class="ri-file-copy-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Save <i class="ri-save-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Forward <i class="ri-chat-forward-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-muted"></i></a>
                        </div>
                    </div>
                </div>

                <div class="ctext-wrap">
                    <div class="ctext-wrap-content">
                        <p class="mb-0">
                            & Next meeting tomorrow 10.00AM
                        </p>
                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:05</span></p>
                    </div>
                    <div class="dropdown align-self-start">
                        <a class="dropdown-toggle" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript: void(0);">Copy <i class="ri-file-copy-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Save <i class="ri-save-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Forward <i class="ri-chat-forward-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-muted"></i></a>
                        </div>
                    </div>
                </div>

                <div class="conversation-name">Doris Brown</div>
            </div>

        </div>
    </li>

    <li class="right">
        <div class="conversation-list">
            <div class="chat-avatar">
                <img src="assets/images/users/<?php if (isset($userProfileData)) echo $user->profileImg;
                                                else echo "default-user.png"; ?>" alt="">
            </div>

            <div class="user-chat-content">
                <div class="ctext-wrap">
                    <div class="ctext-wrap-content">
                        <p class="mb-0">
                            Wow that's great
                        </p>
                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:06</span></p>
                    </div>
                    <div class="dropdown align-self-start">
                        <a class="dropdown-toggle" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript: void(0);">Copy <i class="ri-file-copy-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Save <i class="ri-save-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Forward <i class="ri-chat-forward-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-muted"></i></a>
                        </div>
                    </div>
                </div>

                <div class="conversation-name"><?php if (isset($userProfileData)) echo $user->name; ?></div>
            </div>

        </div>
    </li>

    <li>
        <div class="conversation-list">
            <div class="chat-avatar">
                <img src="assets/images/users/avatar-4.jpg" alt="">
            </div>

            <div class="user-chat-content">
                <div class="ctext-wrap">

                    <div class="ctext-wrap-content">
                        <ul class="list-inline message-img  mb-0">
                            <li class="list-inline-item message-img-list me-2 ms-0">
                                <div>
                                    <a class="popup-img d-inline-block m-1" href="assets/images/small/img-1.jpg" title="Project 1">
                                        <img src="assets/images/small/img-1.jpg" alt="" class="rounded border">
                                    </a>
                                </div>
                                <div class="message-img-link">
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            <a download="img-1.jpg" href="assets/images/small/img-1.jpg" class="fw-medium">
                                                <i class="ri-download-2-line"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item dropdown">
                                            <a class="dropdown-toggle" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-more-fill"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript: void(0);">Copy <i class="ri-file-copy-line float-end text-muted"></i></a>
                                                <a class="dropdown-item" href="javascript: void(0);">Save <i class="ri-save-line float-end text-muted"></i></a>
                                                <a class="dropdown-item" href="javascript: void(0);">Forward <i class="ri-chat-forward-line float-end text-muted"></i></a>
                                                <a class="dropdown-item" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="list-inline-item message-img-list">
                                <div>
                                    <a class="popup-img d-inline-block m-1" href="assets/images/small/img-2.jpg" title="Project 2">
                                        <img src="assets/images/small/img-2.jpg" alt="" class="rounded border">
                                    </a>
                                </div>
                                <div class="message-img-link">
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            <a download="img-2.jpg" href="assets/images/small/img-2.jpg" class="fw-medium">
                                                <i class="ri-download-2-line"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item dropdown">
                                            <a class="dropdown-toggle" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-more-fill"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="javascript: void(0);">Copy <i class="ri-file-copy-line float-end text-muted"></i></a>
                                                <a class="dropdown-item" href="javascript: void(0);">Save <i class="ri-save-line float-end text-muted"></i></a>
                                                <a class="dropdown-item" href="javascript: void(0);">Forward <i class="ri-chat-forward-line float-end text-muted"></i></a>
                                                <a class="dropdown-item" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:09</span></p>
                    </div>

                    <div class="dropdown align-self-start">
                        <a class="dropdown-toggle" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript: void(0);">Copy <i class="ri-file-copy-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Save <i class="ri-save-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Forward <i class="ri-chat-forward-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-muted"></i></a>
                        </div>
                    </div>

                </div>

                <div class="conversation-name">Doris Brown</div>
            </div>

        </div>
    </li>

    <li class="right">
        <div class="conversation-list">
            <div class="chat-avatar">
                <img src="assets/images/users/<?php if (isset($userProfileData)) echo $user->profileImg;
                                                else echo "default-user.png"; ?>" alt="">
            </div>

            <div class="user-chat-content">
                <div class="ctext-wrap">

                    <div class="ctext-wrap-content">
                        <div class="card p-2 mb-2">
                            <div class="d-flex flex-wrap align-items-center attached-file">
                                <div class="avatar-sm me-3 ms-0 attached-file-avatar">
                                    <div class="avatar-title bg-primary-subtle text-primary rounded font-size-20">
                                        <i class="ri-file-text-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="text-start">
                                        <h5 class="font-size-14 text-truncate mb-1">admin_v1.0.zip</h5>
                                        <p class="text-muted text-truncate font-size-13 mb-0">12.5 MB</p>
                                    </div>
                                </div>
                                <div class="ms-4 me-0">
                                    <div class="d-flex gap-2 font-size-20 d-flex align-items-start">
                                        <div>
                                            <a download="admin_v1.0.zip" href="assets/images/small/admin_v1.0.zip" class="fw-medium">
                                                <i class="ri-download-2-line"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-muted" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ri-more-fill"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="javascript: void(0);">Share <i class="ri-share-line float-end text-muted"></i></a>
                                                <a class="dropdown-item" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-muted"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <span class="align-middle">10:16</span></p>
                    </div>

                    <div class="dropdown align-self-start">
                        <a class="dropdown-toggle" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript: void(0);">Copy <i class="ri-file-copy-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Save <i class="ri-save-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Forward <i class="ri-chat-forward-line float-end text-muted"></i></a>
                            <a class="dropdown-item" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-muted"></i></a>
                        </div>
                    </div>

                </div>

                <div class="conversation-name"><?php if (isset($userProfileData)) echo $user->name; ?></div>
            </div>

        </div>
    </li>

    <li>
        <div class="conversation-list">
            <div class="chat-avatar">
                <img src="assets/images/users/avatar-4.jpg" alt="">
            </div>

            <div class="user-chat-content">
                <div class="ctext-wrap">
                    <div class="ctext-wrap-content">
                        <p class="mb-0">
                            typing
                            <span class="animate-typing">
                                <span class="dot"></span>
                                <span class="dot"></span>
                                <span class="dot"></span>
                            </span>
                        </p>
                    </div>
                </div>

                <div class="conversation-name">Doris Brown</div>
            </div>

        </div>
    </li>

</ul>