
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
            //     setVideoDuration(localVideo);
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


// ajax message  
$(document).ready(function () {

    $("#chatForm").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "send-receive.php",
            type: "POST",
            contentType: false,
            processData: false,
            cache: false,
            data: new FormData(this),
            beforeSend: function () {
                $("#submitBtn").html(`
                    <div class="spinner-grow spinner-grow-sm" role="status">
                    <span class="visually-hidden">sending...</span>
                    </div>`);
            },
            success: function (res) {
                if (res === "1") {
                    $("#submitBtn").html('<i class="ri-send-plane-2-fill"></i>');
                    $("#chatForm").trigger("reset");
                }
            }
        });
    });

    var refreshMessage, updateStatusInterval;
    var fromUser = $("#fromUser").val();
    var sendToUser = $("#sendToUser").val();
    var messageInputArea = $("#message");
    var submitBtn = $("#submitBtn");
    var remoteUserStatus = $("#remoteUserStatus");
    var remoteUserStatusColor = $("#remoteUserStatusColor");
    // var 


    fetchMessages();
    startUpdateStatus("Online");

    // disable btn if input box empty 
    function isEmptyInputArea() {
        console.log(messageInputArea.val().trim());
        console.log(messageInputArea.val().trim().length);
        if (messageInputArea.val().trim().length === 0) {
            submitBtn.prop('disabled', true);
        } else {
            submitBtn.prop('disabled', false);
        }
    }

    // if chat is opened 
    function fetchMessages() {
        if (sendToUser) {
            // refreshMessage = setInterval(() => {
                getMessage();
                getRemoteActivities();
                if ($("#chatMessages")[0])
                    $("#chatMessages")[0].scrollIntoView(false); // show the recent messages 
            // }, 500);
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
                            htmlStr += `
                            <li class="right">
                                <div class="conversation-list">
                                    <div class="user-chat-content">
                                        <div class="ctext-wrap">
                                            <div class="ctext-wrap-content p-2">
                                                <p class="mb-0">
                                                   ${message.message}
                                                </p>
                                                <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <small class="align-middle">${message.created_on}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>`;
                        } else {
                            htmlStr += `
                        <li>
                            <div class="conversation-list mb-2">
                                <div class="user-chat-content">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content p-2">
                                            <p class="mb-0">
                                                ${message.message}
                                            </p>
                                            <p class="chat-time mb-0"><i class="ri-time-line align-middle"></i> <small class="align-middle">${message.created_on}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>`;
                        }

                    });
                }

                $("#chatMessages").html(htmlStr);
            }
        });
    }

    // get activity from db 
    function getRemoteActivities() {
        $.ajax({
            url: "send-receive.php",
            type: "GET",
            cache: false,
            data: { sendTo: sendToUser, getActivity: true },
            success: function (res) {
                if (res !== "false") {
                    let = activities = JSON.parse(res);
                    if (activities.status) {
                        remoteUserStatus.text(activities.status);
                        remoteUserStatusColor.css("color", "#06d6a0");
                    }
                } else {
                    remoteUserStatusColor.css("color", "gray");
                    remoteUserStatus.text("Offline");
                }
            }
        });
    }

    // set lastseen  
    function updateLastSeen() {
        let currentTimestamp = (new Date((new Date((new Date(new Date())).toISOString())).getTime() - ((new Date()).getTimezoneOffset() * 60000))).toISOString().slice(0, 19).replace('T', ' ');
        $.ajax({
            url: "send-receive.php",
            type: "GET",
            cache: false,
            data: { fromUser: fromUser, timeStamp: currentTimestamp },
            success: function (res) {
                // console.log(res);

            }
        });
    }

    // check Realtime Update 
    function updateStatus(status) {
        $.ajax({
            url: "send-receive.php",
            type: "GET",
            cache: false,
            data: { fromUser: fromUser, status: status },
            success: function (res) {
                // console.log(res);
                // fetch remote user status 
            }
        });
    }

    function startUpdateStatus(status) {
        updateStatusInterval = setInterval(() => {
            updateStatus(status);
        }, 1000);
    }

    var LastSeenInterval = setInterval(() => {
        updateLastSeen();
    }, 10 * 1000);

    // textarea event 
    messageInputArea.keyup((e) => {

        if ((e.ctrlKey || e.metaKey) && (e.keyCode == 13 || e.keyCode == 10)) {
            $("#chatForm").submit();
            messageInputArea.focusout();
        }
        isEmptyInputArea();
    });


    // when textarea is active 
    messageInputArea.focusin(() => {
        clearInterval(refreshMessage);
        clearInterval(updateStatusInterval);
        startUpdateStatus("Typing...")
    })

    messageInputArea.focusout(() => {
        fetchMessages();
        clearInterval(updateStatusInterval);
        startUpdateStatus("Online");
    })

});