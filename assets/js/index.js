$(document).ready(function () {
    const videoCallBtn = $("#videoCallBtn");
    const callReceiveBtn = $("#callReceiveBtn");
    const callDeclineBtn = $("#callDeclineBtn");
    const callHangupBtn = $("#callHangupBtn");

    const videoOverlay = $("#video-overlay");
    const callTimer = $("#videoDuration");
    const remoteVideo = document.querySelector("#remoteVideo");
    const localVideo = document.querySelector("#localVideo");



    let peerConn;
    let sendTo = videoCallBtn.data("user");
    let localStream;


    const mediaAccess = {
        video: true,
        audio: true
    }

    // for audio (setup stun server)
    const config = {
        iceServers: [
            { urls: 'stun:stun1.l.google.com:19302' },
        ]
    }

    // to get the media from remote client
    const mediaOptions = {
        offerToReceiveVideo: 1,
        offerToReceiveAudio: 1
    }

    function getConnection() {
        if (!peerConn) {
            peerConn = new RTCPeerConnection(config);
        }
    }

    // show the video time while playing
    function showCallTimer() {
        callTimer.timer({ format: '%H:%M:%S' });
    }

    // get the camera permission
    async function getCameraAccess() {
        let mediaStream;
        try {
            if (!peerConn) {
                await getConnection();
            }

            mediaStream = await navigator.mediaDevices.getUserMedia(mediaAccess);
            localVideo.srcObject = mediaStream;
            localStream = mediaStream;
            localStream.getTracks().forEach(track => peerConn.addTrack(track, localStream));
            // setInterval(() => {
            // setVideoDuration(localVideo);
            // }, 400);

        } catch (error) {
            console.log(error);
        }
    }

    // request for connecting to remote client
    async function createOffer(sendTo) {
        await sendIceCandidate(sendTo);
        await peerConn.createOffer(mediaOptions);
        await peerConn.setLocalDescription(peerConn.localDescription);

        send("client-offer", peerConn.localDescription, sendTo);
    }

    // receive Incomming Call
    async function createAnswser(sendTo, data) {
        if (!peerConn) {
            await getConnection();
        }
        if (!localStream) {
            await getCameraAccess();
        }

        await sendIceCandidate(sendTo);
        await peerConn.setRemoteDescription(data);
        await peerConn.createAnswer();
        await peerConn.setLocalDescription(peerConn.localDescription);
        send("client-answer", peerConn.localDescription, sendTo);
    }


    function callHangup() {
        send("client-hangup", null, sendTo);
        peerConn.close();
        peerConn = null;
    }

    // send information about remote client to connect
    function sendIceCandidate(sendTo) {
        peerConn.onicecandidate = e => {
            if (e.candidate !== null) {
                // send ice candidate to remote client
                send("client-candidate", e.candidate, sendTo)
            }
        }

        // set the remote video
        peerConn.ontrack = e => {
            remoteVideo.srcObject = e.streams[0];
        }
    }

    // start a video call
    videoCallBtn.on("click", () => {
        videoCallBtn.prop("disabled", true);
        makeVideoCallCSS();
        $("#calling-type").text("Calling...");
        getCameraAccess();
        send("is-client-ready", null, sendTo);
    })

    // hangup on going call
    callHangupBtn.click(() => {
        callHangupBtn.prop("disabled", true);
        callHangup();
        hideCallScreen;
        location.reload();
    });

    conn.onopen = e => {
        console.log("connected to websocket");
    }

    conn.onmessage = async e => {
        let message = JSON.parse(e.data);

        let by = message.by;
        let data = message.data;
        let type = message.type;
        let profileImg = message.profileImg;
        let username = message.username;

        switch (type) {
            case "is-client-ready":
                if (!peerConn) {
                    await getConnection();
                }

                if (peerConn.iceConnectionState === "connected") {
                    send("client-already-oncall", null, by);
                } else {
                    // display incoming call alert
                    $("#remote-username").text(username);
                    $("#remote-profileImg").attr("src", `assets/images/users/${profileImg}`);
                    $("#calling-type").text("Incoming Call...");

                    displayCallScreen();

                    // checking username exist in url (if user chat is open )
                    if (location.href.indexOf(username) > -1) {

                        // receive incoming call
                        callReceiveBtn.click((e) => {
                            e.stopPropagation();
                            callReceiveCSS();
                            send("client-is-ready", null, sendTo);
                        });
                    } else {
                        // receive incoming call
                        callReceiveBtn.click((e) => {
                            e.stopPropagation();
                            callReceiveCSS();
                            redirectToCallScreen(username, by);
                        });
                    }



                    // reject incoming call
                    callDeclineBtn.click((e) => {
                        e.stopPropagation();
                        videoOverlay.fadeIn(500);
                        send("client-rejected", null, sendTo);
                        // location.reload();
                    });

                }
                break;

            case "client-answer":
                $("#calling-type").text("On going...");

                setTimeout(() => {
                    videoOverlay.fadeOut(500);
                }, 3000);

                if (peerConn.localDescription) {
                    await peerConn.setRemoteDescription(data);
                    showCallTimer();
                }
                break;

            // established video call
            case "client-candidate":
                if (peerConn.localDescription) {
                    await peerConn.addIceCandidate(new RTCIceCandidate(data));
                }
                break;

            case "client-offer":
                $("#calling-type").text("On going...");
                createAnswser(sendTo, data);
                showCallTimer();
                break;

            case "client-is-ready":
                createOffer(sendTo);
                break;

            case "client-already-oncall":
                videoOverlay.fadeIn();
                $("#calling-type").text("User is on another Call");
                refreshPage(3000);
                break;

            case "client-rejected":
                callHangupBtn.prop("disabled", true);
                videoOverlay.fadeIn();
                $("#calling-type").text("Call Rejected");
                refreshPage(3000);
                break;

            case "client-hangup":
                callHangupBtn.prop("disabled", true);
                videoOverlay.fadeIn();
                $("#calling-type").text("Call Disconnected");
                callTimer.timer('pause');
                refreshPage(3000);
                break;

        }
    }


    callDeclineBtn.click(function () {
        hideCallScreen();
    });

    function refreshPage(milliseconds) {
        setTimeout(() => {
            location.reload();
        }, milliseconds);
    }

    function displayCallScreen() {
        $("#videocallModal").modal("show");
        incomingCallCSS();
    }

    function displayRunningCall() {
        $("#videocallModal").modal("show");
        callReceiveCSS();
    }

    function redirectToCallScreen(username, sendTo) {
        if (location.href.indexOf(username) == -1) {
            sessionStorage.setItem("redirect", true);
            sessionStorage.setItem("sendTo", sendTo);
            location.href = "/callme/" + username;
        }
    }


    if (sessionStorage.getItem("redirect")) {
        sendTo = sessionStorage.getItem("sendTo");
        let waitForWebSocket = setInterval(() => {
            if (conn.readyState === 1) {
                send("client-is-ready", null, sendTo);
                clearInterval(waitForWebSocket);
            }
        }, 500);
        sessionStorage.removeItem("redirect");
        sessionStorage.removeItem("sendTo");
        displayRunningCall();
    }

    function hideCallScreen() {
        $("#videocallModal").modal("hide");
    }

    function send(type, data, sendTo) {
        conn.send(JSON.stringify({
            sendTo: sendTo,
            type: type,
            data: data
        }));

    }

    send("is-client-ready", null, sendTo);

    function makeVideoCallCSS() {
        callReceiveBtn.hide();
        callDeclineBtn.hide();
        callHangupBtn.show();
        callHangupBtn.removeClass("me-2");
    }


    function incomingCallCSS() {
        callReceiveBtn.show();
        callDeclineBtn.show();
        callHangupBtn.hide();
    }

    function callReceiveCSS() {
        callReceiveBtn.hide();
        callDeclineBtn.hide();
        callHangupBtn.show();
        callHangupBtn.removeClass("me-2");
        setTimeout(() => {
            videoOverlay.fadeOut(500);
        }, 3000);
    }

});



// calling screen control
$(document).ready(function () {
    let videoOverlay = $("#video-overlay");
    videoOverlay.click(function (e) {
        e.stopPropagation();
        videoOverlay.fadeOut(500);
    });
    $("#remoteVideo").click(function (e) {
        e.stopPropagation();
        videoOverlay.fadeIn(500);
    });

    // hide site loader
    $("#siteLoader").fadeOut();
});


// ajax manage message
$(document).ready(function () {


    // check theme 
    localStorage.getItem("darkMode") === "dark" ? document.body.setAttribute("data-bs-theme", "dark") : document.body.setAttribute("data-bs-theme", "light");

    // detect fromUser is online or not  
    function checkMyNetwork() {
        if (navigator.onLine) {
            $("#isThisUserOnline").html(`<i class="ri-checkbox-blank-circle-fill font-size-10 status-success me-1 ms-0 d-inline-block"></i> Active`);
        }
        else {
            $("#isThisUserOnline").html(`<i class="ri-checkbox-blank-circle-fill font-size-10 me-1 ms-0 d-inline-block"></i> No Internet`);
        }

        window.addEventListener("online", () => {
            $("#isThisUserOnline").html(`<i class="ri-checkbox-blank-circle-fill font-size-10 status-success me-1 ms-0 d-inline-block"></i> Active`);
            location.reload();
        });
        window.addEventListener("offline", () => {
            $("#isThisUserOnline").html(`<i class="ri-checkbox-blank-circle-fill font-size-10 me-1 ms-0 d-inline-block"></i> No Internet`);
        });
    }

    checkMyNetwork();


    //    user local time 
    setInterval((() => {
        $("#currentLocalTime").text(new Date().toLocaleTimeString());
    }), 1000);



    // copy to clipboard
    $(document).on("click", ".js-copy-link", function (e) {
        e.preventDefault();
        navigator.clipboard.writeText(this.href)
            .then(() => { })
            .catch((error) => { console.error(error) });
    })

    function deleteMessageById(messageId) {
        $.ajax({
            url: "send-receive.php",
            type: "GET",
            cache: false,
            data: { messageId: messageId },
            success: function (res) {
                if (res === "false") {
                    alert("Message can't be delete!");
                }
            }
        });
    }


    // delete message with file
    $(document).on("click", ".js-delete-message", function (e) {
        deleteMessageById($(this).attr("data-deleteid"))
    });


    // let user know to file is attach
    $("#showFileAttached").hide();
    $("#uploading-status").hide();
    $('#attachment').change(function (e) {
        if ($('#attachment').val()) {
            $("#showFileAttached").show();
        } else {
            $("#showFileAttached").hide();
        }
    });



    $("#chatForm").submit(function (e) {
        submitBtn.prop('disabled', true);
        $("#uploading-status").show();
        e.preventDefault();
        $.ajax({
            url: "send-receive.php",
            type: "POST",
            contentType: false,
            processData: false,
            cache: false,
            data: new FormData(this),
            beforeSend: function () {
                submitBtn.prop('disabled', true);
                $("#submitBtn").html(`
                                    <div class="spinner-grow spinner-grow-sm" role="status">
                                        <span class="visually-hidden">sending...</span>
                                </div>`);
            },
            success: function (res) {
                if (res === "1") {
                    $("#submitBtn").html('<i class="ri-send-plane-2-fill"></i>');
                    $("#chatForm").trigger("reset");
                    $("#uploading-status").hide();
                    $("#showFileAttached").hide();
                }
            }
        });
    });

    var refreshMessage, updateStatusInterval, updateLastSeenInterval;
    var fromUser = $("#fromUser").val();
    var sendToUser = $("#sendToUser").val();
    var messageInputArea = $("#message");
    var submitBtn = $("#submitBtn");
    var remoteUserStatus = $("#remoteUserStatus");
    var remoteUserStatusColor = $("#remoteUserStatusColor");
    var lastSeenArr = Array();
    var activities = null;
    let refreshMsgTimeout = null;



    if (sendToUser) {
        RTfetchMessages();
        setLastSeen();
    }

    RTUpdateStatus(null);


    //===================== get remote user from db ====================
    // if chat is opened
    function RTfetchMessages() {
        if (refreshMessage) {
            clearInterval(refreshMessage);
        }
        if (sendToUser) {
            refreshMessage = setInterval(() => {
                getMessage();
                if ($("#chatMessages")[0])
                    $("#chatMessages")[0].scrollIntoView(false); // show the recent messages
            }, 500);
        }
    }


    // get the message
    function getMessage() {
        $.ajax({
            url: "send-receive.php",
            type: "GET",
            cache: false,
            data: { fromUser: fromUser, sendToUser: sendToUser, fetch: true },
            success: function (res) {
                let messages = JSON.parse(res);

                let htmlStr = "";
                if (typeof (messages) === "object") {
                    messages.forEach(message => {


                        if (message.fromUser == fromUser) {


                            if (message.message.mimetype) {
                                // html head 
                                htmlStr += `
                                        <li class="right">
                                            <div class="conversation-list">
                                                <div class="user-chat-content">
                                                    <div class="ctext-wrap">
                                                    `;


                                // html body Image or String 
                                if (message.message.mimetype.startsWith("image/")) {

                                    htmlStr += ` <div class="ctext-wrap-content p-2">
                                                <div class="d-flex align-items-start position-relative">
                                                    <!-- attach image  -->
                                                    <a class="popup-img d-inline-block" href="${message.message.dirname + "/" + message.message.basename}" title="Project 1">
                                                        <img src="${message.message.dirname + "/" + message.message.basename}" alt="" class="attach-img rounded">
                                                    </a>

                                                    <!-- attach image dropdown menu  -->
                                                    <div class="message-img-link d-flex justify-content-center align-items-center left-0">
                                                        <a class="dropdown-toggle dropdown-toggle-btn p-2 py-1 border rounded" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ri-more-2-fill"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" download="${message.message.basename.slice(message.message.basename.indexOf("_") + 1)}" href="${message.message.dirname + "/" + message.message.basename}" class="fw-medium"> Download
                                                                <i class="ri-download-2-line float-end text-muted"></i>
                                                            </a>
                                                            <a class="dropdown-item js-copy-link" href="${message.message.dirname + "/" + message.message.basename}">Copy link<i class="ri-file-copy-line float-end text-muted"></i></a>
                                                            <div class="dropdown-divider my-1"></div>
                                                            <a class="dropdown-item js-delete-message text-danger" data-deleteId="${message.id}" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-danger"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="chat-time mb-0">
                                                     <span class="text-trancate"> ${message.message.extension} : ${message.message.filesize} </span>
                                                     <span><i class="ri-time-line align-middle"></i> ${sqlToJSFormat(message.created_on)} </span>
                                                </p>
                                            </div>`;

                                } else {
                                    htmlStr += ` <div class="ctext-wrap-content p-2">
                                                <div class="card mb-1">
                                                    <div class="d-flex flex-wrap align-items-start p-2 py-1">
                                                        <!-- attach file  -->
                                                        <div class="text-start flex-grow-1 overflow-hidden">
                                                            <h3> <i class="ri-file-2-fill"></i> </h3>
                                                            <h5 class="font-size-14 text-truncate mb-1">${message.message.basename.slice(message.message.basename.indexOf("_") + 1)}</h5>
                                                            <p class="text-muted text-truncate font-size-13 mb-0"> ${message.message.filesize} </p>
                                                        </div>

                                                        <div class="ms-4">
                                                            <a download="${message.message.basename.slice(message.message.basename.indexOf("_") + 1)}" href="${message.message.dirname + "/" + message.message.basename}" class="p-2 font-size-20 fw-medium">
                                                                <i class="ri-download-2-line"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="message-img-link d-flex justify-content-center align-items-center">
                                                        <a class="dropdown-toggle dropdown-toggle-btn p-2 py-1 border rounded" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ri-more-2-fill"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" download="${message.message.basename.slice(message.message.basename.indexOf("_") + 1)}" href="${message.message.dirname + "/" + message.message.basename}"> Download
                                                                <i class="ri-download-2-line float-end text-muted"></i>
                                                            </a>
                                                            <a class="dropdown-item js-copy-link" href="${message.message.dirname + "/" + message.message.basename}">Copy link<i class="ri-file-copy-line float-end text-muted"></i></a>
                                                            <div class="dropdown-divider my-1"></div>
                                                            <a class="dropdown-item js-delete-message text-danger" data-deleteId="${message.id}" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-danger"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="chat-time mb-0">
                                                    <span class="text-trancate"> ${message.message.extension} : ${message.message.filesize} </span>
                                                     <span><i class="ri-time-line align-middle"></i> ${sqlToJSFormat(message.created_on)} </span>
                                                 </p>
                                            </div>`;
                                }
                                // html foot 
                                htmlStr += `
                                                 </div>
                                                </div>
                                            </div>
                                        </li>`;

                            }


                            // message 
                            htmlStr += `
                                    <li class="right">
                                        <div class="conversation-list">

                                            <div class="dropdown-menu message-menu">
                                                <a class="dropdown-item js-copy-message" data-copyid="${message.id}" href="javascript:void()">Copy <i class="ri-file-copy-line float-end text-muted"></i></a>
                                                <div class="dropdown-divider my-1"></div>
                                                <a class="dropdown-item js-delete-message text-danger" data-deleteid="${message.id}" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-danger"></i></a>
                                            </div>

                                            <div class="user-chat-content">
                                                <div class="ctext-wrap">
                                                    <div class="ctext-wrap-content p-2">
                                                        <p class="mb-0" id="copyMessage${message.id}">${message.message.message}</p>
                                                        <p class="chat-time mb-0">
                                                        <small></small>
                                                        <small> <i class="ri-time-line align-middle"></i> ${sqlToJSFormat(message.created_on)}</small>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                     `;

                        } else {


                            if (message.message.mimetype) {

                                // html head 
                                htmlStr += `<li>
                                            <div class="conversation-list mt-2">
                                                <div class="user-chat-content">
                                                    <div class="ctext-wrap">`;

                                // html body Image or String 
                                if (message.message.mimetype.startsWith("image/")) {
                                    htmlStr += ` <div class="ctext-wrap-content p-2">
                                                            <div class="d-flex align-items-start position-relative">
                                                                <!-- attach image  -->
                                                                <a class="popup-img d-inline-block" href="${message.message.dirname + "/" + message.message.basename}" title="Project 1">
                                                                    <img src="${message.message.dirname + "/" + message.message.basename}" alt="" class="attach-img rounded">
                                                                </a>

                                                                <!-- attach image dropdown menu  -->
                                                                <div class="message-img-link d-flex justify-content-center align-items-center">
                                                                    <a class="dropdown-toggle dropdown-toggle-btn p-2 py-1 border rounded" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="ri-more-2-fill"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" download="${message.message.basename.slice(message.message.basename.indexOf("_") + 1)}" href="${message.message.dirname + "/" + message.message.basename}" class="fw-medium"> Download
                                                                            <i class="ri-download-2-line float-end text-muted"></i>
                                                                        </a>
                                                                        <a class="dropdown-item js-copy-link" href="${message.message.dirname + "/" + message.message.basename}">Copy link<i class="ri-file-copy-line float-end text-muted"></i></a>
                                                                        <div class="dropdown-divider my-1"></div>
                                                                        <a class="dropdown-item js-delete-message text-danger" data-deleteId="${message.id}" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-danger"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <p class="chat-time mb-0">
                                                            <span class="text-trancate"> ${message.message.extension} : ${message.message.filesize} </span>
                                                            <span><i class="ri-time-line align-middle"></i> ${sqlToJSFormat(message.created_on)} </span>
                                                            </p>
                                                        </div>
                                                    </div>`;
                                } else {
                                    htmlStr += `<div class="ctext-wrap-content p-2">
                                                        <div class="card mb-1">
                                                            <div class="d-flex flex-wrap align-items-start p-2 py-1">
                                                                <!-- attach file  -->
                                                                <div class="text-start flex-grow-1 overflow-hidden">
                                                                    <h3> <i class="ri-file-2-fill"></i> </h3>
                                                                    <h5 class="font-size-14 text-truncate mb-1">${message.message.basename.slice(message.message.basename.indexOf("_") + 1)}</h5>
                                                                    <p class="text-muted text-truncate font-size-13 mb-0"> ${message.message.filesize} </p>
                                                                </div>

                                                                <div class="ms-4">
                                                                    <a download="${message.message.basename.slice(message.message.basename.indexOf("_") + 1)}" href="${message.message.dirname + "/" + message.message.basename}" class="p-2 font-size-20 fw-medium">
                                                                        <i class="ri-download-2-line"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <div class="message-img-link d-flex justify-content-center align-items-center">
                                                                <a class="dropdown-toggle dropdown-toggle-btn p-2 py-1 border rounded" href="javascript: void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </a>
                                                                <div class="dropdown-menu">
                                                                    <a class="dropdown-item" download="${message.message.dirname + "/" + message.message.basename}" href="${message.message.dirname + "/" + message.message.basename}"> Download
                                                                        <i class="ri-download-2-line float-end text-muted"></i>
                                                                    </a>
                                                                    <a class="dropdown-item js-copy-link" href="${message.message.dirname + "/" + message.message.basename}">Copy link<i class="ri-file-copy-line float-end text-muted"></i></a>
                                                                    <div class="dropdown-divider my-1"></div>
                                                                    <a class="dropdown-item js-delete-message text-danger" data-deleteId="${message.id}" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-danger"></i></a>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <p class="chat-time mb-0">
                                                            <span class="text-trancate"> ${message.message.extension} : ${message.message.filesize} </span>
                                                            <span><i class="ri-time-line align-middle"></i> ${sqlToJSFormat(message.created_on)} </span>
                                                        </p>
                                                    </div>`;
                                }

                                // html foot 
                                htmlStr += ` </div>
                                       </div>
                                    </div>
                                </li>`;
                            }



                            //    message 
                            htmlStr += `
                                                    <li>
                                                        <div class="conversation-list mt-2">

                                                            <div class="dropdown-menu message-menu">
                                                                <a class="dropdown-item js-copy-message" data-copyid="${message.id}" href="javascript:void()">Copy <i class="ri-file-copy-line float-end text-muted"></i></a>
                                                                <div class="dropdown-divider my-1"></div>
                                                                <a class="dropdown-item js-delete-message text-danger" data-deleteid="${message.id}" href="javascript: void(0);">Delete <i class="ri-delete-bin-line float-end text-danger"></i></a>
                    
                                                            </div>

                                                            <div class="user-chat-content">
                                                                <div class="ctext-wrap">
                                                                    <div class="ctext-wrap-content p-2">
                                                                        <p class="mb-0" id="copyMessage${message.id}">${message.message.message}</p>
                                                                        <p class="chat-time mb-0">
                                                                        <small> <i class="ri-time-line align-middle"></i>  ${sqlToJSFormat(message.created_on)} </small>
                                                                        <small></small>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    `;
                        }


                    });
                }

                $("#chatMessages").html(htmlStr);
            }
        });
    }

    // get updated parameters
    if (sendToUser) {
        setInterval(() => {
            getRemoteActivities();
        }, 500);
    }

    // get activity from db
    function getRemoteActivities() {
        $.ajax({
            url: "send-receive.php",
            type: "GET",
            cache: false,
            data: { fromUser: fromUser, sendTo: sendToUser, getActivity: true },
            success: function (res) {
                if (res !== "false") {
                    activities = JSON.parse(res);

                    if (activities) {
                        if (activities.status)
                            localStorage.setItem("remoteUserStatus", activities.status);

                        if (lastSeenArr.length > 5) {
                            lastSeenArr.splice(0, 2);
                        }
                        lastSeenArr.push(activities.last_seen);
                        localStorage.setItem("last_seen", activities.last_seen);
                    }

                } else {
                    localStorage.setItem("last_seen", "Active");
                }
            }
        });
    }


    function setLastSeen() {
        setInterval(() => {
            if (isSameElements(lastSeenArr)) {
                localStorage.setItem("remoteUserStatus", activities.last_seen);
                remoteUserStatusColor.css("color", "#495057");
            } else {
                localStorage.setItem("remoteUserStatus", "Online");
                remoteUserStatusColor.css("color", "#06d6a0");

            }
        }, 1000);
    }

    if (sendToUser) {
        setInterval(() => {
            let datetime = localStorage.getItem("remoteUserStatus").split(" ");
            if (datetime.length === 2) {
                remoteUserStatus.text(sqlToJSFormat(localStorage.getItem("remoteUserStatus")));
            } else {
                remoteUserStatus.text(localStorage.getItem("remoteUserStatus"));
            }
        }, 500);
    }


    //===================== save current user to db =====================
    // set lastseen
    function updateLastSeen(fromUser) {
        let currentTimestamp = (new Date((new Date((new Date(new Date())).toISOString())).getTime() - ((new
            Date()).getTimezoneOffset() * 60000))).toISOString().slice(0, 19).replace('T', ' ');
        $.ajax({
            url: "send-receive.php",
            type: "GET",
            cache: false,
            data: { fromUser: fromUser, timeStamp: currentTimestamp },
            success: function (res) {
                // do nothing
            }
        });
    }


    // set last seen default this user
    updateLastSeenInterval = setInterval(() => {
        updateLastSeen(fromUser);
    }, 500);

    // set Realtime Update this user
    function updateStatus(status) {

        $.ajax({
            url: "send-receive.php",
            type: "GET",
            cache: false,
            data: { fromUser: fromUser, sendTo: sendToUser, status: status },
            success: function (res) {
                // do nothing
            }
        });
    }


    //  set status for remote user
    function setRemoteUserStatus() {
        let status = null;
        setInterval(() => {
            $.ajax({
                url: "send-receive.php",
                type: "GET",
                cache: false,
                data: { fromUser: sendToUser, sendTo: fromUser, status: status },
                success: function (res) {
                    // do nothing
                }
            });
        }, 5000);
    }

    setRemoteUserStatus();


    function RTUpdateStatus(status) {
        if (updateStatusInterval) {
            clearInterval(updateStatusInterval);
        }
        updateStatusInterval = setInterval(() => {
            updateStatus(status);
        }, 500);
    }



    //===================== Utility funcs =====================

    // format datetime
    function sqlToJSFormat(sqlDateTime) {
        let Y = m = d = null;
        let datetime = sqlDateTime.split(" ");
        let date = datetime[0];
        let time = datetime[1];
        [Hr, Min, Sec] = time.split(":");
        [Y, m, d] = date.split("-");

        if (m.startsWith() == "0") {
            m = parseInt(m);
        }

        if (d.startsWith() == "0") {
            d = parseInt(d);
        }

        let formatedDate = d + "/" + m + "/" + Y;
        let formatedTime = Hr + ":" + Min;

        let todayObj = new Date();
        let today = todayObj.getDate() + "/" + (todayObj.getMonth() + 1) + "/" + todayObj.getFullYear();


        let yestardayObj = new Date((new Date()).valueOf() - 1000 * 60 * 60 * 24);
        let yestarday = yestardayObj.getDate() + "/" + (yestardayObj.getMonth() + 1) + "/" + yestardayObj.getFullYear();


        if (today === formatedDate) {
            return ` ${"Today " + formatedTime}`;
        } else if (yestarday === formatedDate) {
            return ` ${"Yestarday " + formatedTime}`;
        }

        return formatedTime + " " + formatedDate;
    }


    // if array elements are same
    function isSameElements(array) {
        var firstElement = array[0];
        return array.every(function (element) {
            return element === firstElement;
        });
    }


    // disable btn if input box empty
    function isEmptyInputArea() {
        if (messageInputArea.val().trim().length === 0) {
            submitBtn.prop('disabled', true);
        } else {
            submitBtn.prop('disabled', false);
        }
    }

    // textarea event
    messageInputArea.keyup((e) => {

        if ((e.ctrlKey || e.metaKey) && (e.keyCode == 13 || e.keyCode == 10)) {
            $("#chatForm").submit();
            messageInputArea.focusout();
        }
        isEmptyInputArea();
    });

    // when user write -textarea is active
    messageInputArea.focusin(() => {
        if (refreshMessage)
            clearInterval(refreshMessage);
        if (updateLastSeenInterval)
            clearInterval(updateStatusInterval);
        RTUpdateStatus("Typing...");
    })

    messageInputArea.focusout(() => {
        RTfetchMessages();
        RTUpdateStatus(null);
        console.log("focus out");
    })



    // on scroll chat div 
    $(".chat-conversation").scroll(function () {
        stopRefreshMsg();
        startRefreshMsg();
    })



    // stop getting live msg 
    function stopRefreshMsg() {

        if (refreshMsgTimeout) {
            clearTimeout(refreshMsgTimeout);
        }

        if (refreshMessage)
            clearInterval(refreshMessage);

        if (updateLastSeenInterval)
            clearInterval(updateStatusInterval);

        RTUpdateStatus("Reading...");
    }

    // restart fetch message 
    function startRefreshMsg() {
        refreshMsgTimeout = setTimeout(() => {
            RTfetchMessages();
            if (updateLastSeenInterval)
                clearInterval(updateStatusInterval);
            RTUpdateStatus(null);
        }, 3000);
    }


    // when message file attchment dropdown menu show 
    $(document).on('click', '.dropdown-toggle-btn', function (e) {
        e.stopPropagation();
        document.querySelectorAll(".dropdown-menu").forEach(function (e) {
            if (e.className === "dropdown-menu show") {
                stopRefreshMsg();
            }
        })

    });

    // // when message file attchment dropdown menu close 
    $("a.dropdown-toggle-btn").each(this.addEventListener('hide.bs.dropdown', event => {
        startRefreshMsg();
    }));




    // message dropdown menu event handling
    $(document).on("click", "#chatMessages > li", (function (e) {
        e.stopPropagation();
        let currentMsgDropdownMenu = null;


        if (!$(this).find(".message-img-link").length) {
            stopRefreshMsg();
            $(this).toggleClass("active");

            // when li click and done nothing operation 
            if (!$(this).hasClass("active")) {
                startRefreshMsg();
            }

            // show the dropdown menu 
            currentMsgDropdownMenu = $(this).find(".conversation-list > .message-menu");
            currentMsgDropdownMenu.toggle();

            // close other dropdown menu 
            $(this).siblings().removeClass("active");
            $("#chatMessages > li").find(function () {
                $(".conversation-list > .message-menu").not(currentMsgDropdownMenu).each(function () {
                    $(this).hide();
                });
                $(this).show();
            })


            // message menu button click copy event 
            $(document).on("click", ".js-copy-message", function (et) {
                et.stopPropagation();

                navigator.clipboard.writeText($("#copyMessage" + $(this).data("copyid")).text())
                    .then(() => {
                    }).catch((error) => {
                        console.error(error)
                    })

                $(this).parents("#chatMessages > li").removeClass("active");
                currentMsgDropdownMenu.hide();
                startRefreshMsg();
            })


            // message menu button click delete event 
            $(document).on("click", ".js-delete-message", function (ed) {
                ed.stopPropagation();
                $(this).parents("#chatMessages > li").html(
                    `<div class="conversation-list mt-2">
                        <div class="user-chat-content">
                            <div class="ctext-wrap">
                                <div class="ctext-wrap-content p-2">
                                    <em class='small text-muted'>Message deleted!</em>
                                </div>
                            </div>
                        </div>
                    </div>`);
                startRefreshMsg();
            });
        }


    }));

});


