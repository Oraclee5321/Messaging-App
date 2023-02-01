<?php
session_start();
include "php-functions/db-connection.php";
include "classes/user-class.php";
$conn = connect();
$user = new User($_SESSION['UID'],$_SESSION['username'],$_SESSION['email'],$_SESSION['role'],connect());
?>
<html>
<head>
    <?php include "modules/links.php" ?>
</head>
<body>
    <?php include "modules/navbar.php" ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['newMessageInput'])){
            $message = $_POST['newMessageInput'];
            $message = str_replace("\r\n","<br>",$message);
            $message = mysqli_real_escape_string($conn,$message);
            $user->sendMessage($message, $conn);
            header("Location: main_page.php");
        }
        if (isset($_POST['editMessageInput'])){
            $id = $_POST['messageIDValue'];
            $text = $_POST['editMessageInput'];
            $text = str_replace("\r\n","<br>",$text);
            $text = mysqli_real_escape_string($conn,$text);
            $user->editMessage($id,$text,$conn);
            header("Location: main_page.php");
        }
        if (isset($_POST['deletePostCheck'])){;
            $id = $_POST['messageID'];
            $user->deletePost($id,$conn);
            header("Location: main_page.php");
        }
        if (isset($_POST['replyMessageID'])){
            $id = $_POST['replyMessageID'];
            $text = $_POST['replyMessageInput'];
            $text = str_replace("\r\n","<br>",$text);
            $text = mysqli_real_escape_string($conn,$text);
            $user->replyMessage($id,$text,$conn);
            header("Location: main_page.php");
        }

    }
    if (isset($_SESSION['Error'])){
            echo "<div class='alert alert-danger' role='alert'>".$_SESSION['Error']."</div>";
            unset($_SESSION['Error']);
    }
    ?>
    <br>
    <div class="modal fade" id="newMessageModal" tabindex="-1" aria-labelledby="newMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="newMessageModalLabel">New Message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="main_page.php" method="POST">
                    <div class="modal-body">
                        <div class="input-group mb-3">
                                <textarea class="form-control" maxlength="256" minlength="1" id="messageInput" value="" name="newMessageInput"></textarea>
                                <span class="input-group-text" id="charCounter"> / 256</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Send" name="sendMessageButton" data-bs-dismiss="modal">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editMessageModal" tabindex="-1" aria-labelledby="editMessageModalLabel" aria-hidden="false"> // Edit Message Modal
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editMessageModalLabel">New Message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="main_page.php" method="POST">
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <textarea class="form-control" maxlength="256" minlength="1" id="editMessageInput" name="editMessageInput"></textarea>
                            <span class="input-group-text" id="editMessageCharCounter"> / 256</span>
                            <input type="hidden" name="messageIDValue" id="messageIDValue" value="">
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Edit" name="editMessageButton" data-bs-dismiss="modal">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="replyMessageModal" tabindex="-1" aria-labelledby="replyMessageModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="replyMessageModalLabel">Reply</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="main_page.php" method="POST">
                    <input type="hidden" name="replyMessageID" id="replyMessageID" value="">
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <textarea class="form-control" maxlength="256" minlength="1" id="replyMessageInput" value="" name="replyMessageInput"></textarea>
                            <span class="input-group-text" id="replyCharCounter"> / 256</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Send" name="replyMessageButton" data-bs-dismiss="modal">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container" id="messages">
        <div class="row">
            <div class="col-6 col-md-4">
            </div>
            <div class="col-6 col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-title">
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: block;margin:auto" fill="#000000" class="w-75 h-50" viewBox="0 0 56 56"><path d="M 6.6505 42.2994 L 10.5900 42.2994 L 10.5900 45.9424 C 10.5900 50.3055 12.7927 52.5082 17.2405 52.5082 L 49.3495 52.5082 C 53.7548 52.5082 56 50.3055 56 45.9424 L 56 23.4281 C 56 19.0861 53.7548 16.8834 49.3495 16.8834 L 45.4100 16.8834 L 45.4100 13.4523 C 45.4100 9.0892 43.1861 6.8865 38.7803 6.8865 L 6.6505 6.8865 C 2.2239 6.8865 0 9.0892 0 13.4523 L 0 35.7548 C 0 40.1179 2.2239 42.2994 6.6505 42.2994 Z M 6.7141 38.8894 C 4.5961 38.8894 3.4100 37.7669 3.4100 35.5642 L 3.4100 13.6429 C 3.4100 11.4402 4.5961 10.2964 6.7141 10.2964 L 38.7170 10.2964 C 40.8138 10.2964 41.9998 11.4402 41.9998 13.6429 L 41.9998 16.8834 L 17.2405 16.8834 C 12.7927 16.8834 10.5900 19.0650 10.5900 23.4281 L 10.5900 38.8894 Z M 17.2829 49.0982 C 15.1649 49.0982 14.0000 47.9545 14.0000 45.7518 L 14.0000 23.6187 C 14.0000 21.4160 15.1649 20.2934 17.2829 20.2934 L 49.2857 20.2934 C 51.3826 20.2934 52.5897 21.4160 52.5897 23.6187 L 52.5897 45.7518 C 52.5897 47.9545 51.3826 49.0982 49.2857 49.0982 Z M 33.2949 44.8410 C 34.4175 44.8410 35.0952 44.0785 35.0952 42.8501 L 35.0952 36.6656 L 41.5552 36.6656 C 42.7411 36.6656 43.5674 36.0513 43.5674 34.9288 C 43.5674 33.7851 42.7836 33.1285 41.5552 33.1285 L 35.0952 33.1285 L 35.0952 26.5627 C 35.0952 25.3131 34.4175 24.5506 33.2949 24.5506 C 32.1512 24.5506 31.5370 25.3554 31.5370 26.5627 L 31.5370 33.1285 L 25.0983 33.1285 C 23.8486 33.1285 23.0650 33.7851 23.0650 34.9288 C 23.0650 36.0513 23.9122 36.6656 25.0983 36.6656 L 31.5370 36.6656 L 31.5370 42.8501 C 31.5370 44.0362 32.1512 44.8410 33.2949 44.8410 Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
            </div>
        </div>
        <br>
        <?php
            $sql = "SELECT * FROM messages ORDER BY message_id DESC";
            $sqlquery = $conn->query($sql);
            while($row = $sqlquery->fetch_assoc()) {
                $namesql = "SELECT username, pfp_image_link FROM users WHERE id = '$row[user_id]'";
                $namesqlquery = $conn->query($namesql);
                $username = $namesqlquery->fetch_assoc();
                $checkifreplysql = "SELECT * FROM replies WHERE new_message_id = '$row[message_id]'";
                $checkifreplysqlquery = $conn->query($checkifreplysql);
                $result = $checkifreplysqlquery->fetch_assoc();
                if (isset($result)){
                    continue;
                }
                echo
                    '<div class="row">
                        <div class="col-6 col-md-4">
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="card" style="width: 18rem;background-color:'.($username['username'] == $_SESSION['username'] ? "aqua" : "white").'">
                                <div class="card-title">
                                    <img src="pfp-pictures/'.$username['pfp_image_link'].'" width="100px" height="100px" class="rounded">
                                    '.$username['username'].'
                                </div>
                                <div class="card-body" id="message_'.$row['message_id'].'">
                                    '.$row['message_content'].'
                                </div>
                                <div class="card-footer"">
                                <form action="" method="">
                                    <input type="hidden" name="messageID" value="'.$row['message_id'].'">
                                    <input type="button" class="btn btn-success" style="display:'.($_SESSION['role'] < 2 ? ($_SESSION['username'] == $username['username'] ? : "none") : "").'" value="Edit Message" onclick="currentMessage('.$row['message_id'].')" />
                                    <button type="button" style="display:none" data-bs-toggle="modal" data-bs-target="#editMessageModal" id="editMessageButton"></button>
                                </form>
                                <form action="main_page.php" method="POST">
                                    <input type="hidden" name="messageID" value="'.$row['message_id'].'">
                                    <input type="hidden" name="deletePostCheck" value="1">
                                    <input type="submit" style="display:'.($_SESSION['role'] <=1 ? "none":"").'" class="btn btn-danger" value="Delete Message" name="deleteMessageButton"/>
                                </form>
                                <form action="main_page.php" method="POST">
                                    <input type="hidden" name="messageID" value="'.$row['message_id'].'">
                                    <input type="hidden" name="replyPostCheck" value="1">
                                    <input type="button" class="btn btn-primary" value="Reply" onclick="replyMessageID('.$row['message_id'].')" />
                                    <input type="button" style="display:none" value="Reply" id="replyMessageButton" data-bs-toggle="modal" data-bs-target="#replyMessageModal" id="editMessageButton"/>
                                </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                        </div>
                     </div>
                    ';
                if ($row['has_reply'] == 1){
                    $repliessql = "select * from replies where message_id = '$row[message_id]'";
                    $repliessqlquery = $conn->query($repliessql);
                    while($repliesrow = $repliessqlquery->fetch_assoc()){
                        $messagessql = "SELECT * FROM messages WHERE message_id = '$repliesrow[new_message_id]' ORDER BY message_id DESC";
                        $messagessqlquery = $conn->query($messagessql);
                        $messagesrow = $messagessqlquery->fetch_assoc();
                        $newmessagenamesql = "SELECT username, pfp_image_link FROM users WHERE id = '$messagesrow[user_id]'";
                        $newmessagenamesqlquery = $conn->query($newmessagenamesql);
                        $newmessageusername = $newmessagenamesqlquery->fetch_assoc();

                        echo
                        '   
                        <div class="row">
                            <div class="col-6 col-md-4">
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="accordion" style="width: 18rem" id="reply">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading'.$messagesrow['message_id'].'">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$messagesrow['message_id'].'" aria-expanded="false" aria-controls="collapse'.$messagesrow['message_id'].'">
                                                <img src="pfp-pictures/'.$newmessageusername['pfp_image_link'].'" width="50px" height="50px" class="rounded">
                                                '.$newmessageusername['username'].'
                                            </button>
                                        </h2>
                                        <div id="collapse'.$messagesrow['message_id'].'" class="accordion-collapse collapse show" aria-labelledby="heading'.$messagesrow['message_id'].'" data-bs-parent="#reply">
                                            <div class="accordion-body">
                                                <div class="card" style="width: 15rem;background-color:'.($newmessageusername['username'] == $_SESSION['username'] ? "aqua" : "white").'">
                                                    <div class="card-title">
                                                    </div>
                                                    <div class="card-body" id="message_'.$messagesrow['message_id'].'">
                                                        '.$messagesrow['message_content'].'
                                                    </div>
                                                    <div class="card-footer"">
                                                    <form action="" method="">
                                                        <input type="hidden" name="messageID" value="'.$messagesrow['message_id'].'">
                                                        <input type="button" class="btn btn-success" style="display:'.($_SESSION['role'] < 2 ? ($_SESSION['username'] == $newmessageusername['username'] ? : "none") : "").'" value="Edit Message" onclick="currentMessage('.$messagesrow['message_id'].')" />
                                                        <button type="button" style="display:none" data-bs-toggle="modal" data-bs-target="#editMessageModal" id="editMessageButton"></button>
                                                    </form>
                                                    <form action="main_page.php" method="POST">
                                                        <input type="hidden" name="messageID" value="'.$messagesrow['message_id'].'">
                                                        <input type="hidden" name="deletePostCheck" value="1">
                                                        <input type="submit" style="display:'.($_SESSION['role'] <=1 ? "none":"").'" class="btn btn-danger" value="Delete Message" name="deleteMessageButton"/>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                            </div>
                        </div>
                        ';
                    }
                    echo '<br>';

                }else{
                    echo '<br>';
                }

            }
            $sql = "SELECT message_id,message_content FROM messages ORDER BY message_id DESC LIMIT 1";
            $sqlquery = $conn->query($sql);
            $row = $sqlquery->fetch_assoc();
            $idresult = $row['message_id'];
            $messagecontent = $row['message_content'];
            $countsql = "SELECT COUNT(*) FROM messages";
            $countsqlquery = $conn->query($countsql);
            $count = $countsqlquery->fetch_assoc();
        ?>
    </div>
    <script type="text/javascript">
        var lastMessageId = <?php echo $idresult ?>;
        var lastMessageContent = "<?php echo $messagecontent ?>";
        var rowCount = <?php echo $count['COUNT(*)'] ?>;
        setInterval(function () {
            $.ajax({
                type: "POST",
                url: "php-functions/check-update.php",
                dataType: "json",
                success: function (response) {
                    var data = response;
                    if (rowCount+lastMessageId+lastMessageContent != data) {
                        $("#main-message").load(location.href + " #messages");
                    }
                }
            });
        }, 1000);
    </script>
    <script src="modules/char-counter.js"></script>
    <script type="text/javascript">
        function currentMessage(messageID) {
            var modal = document.getElementById("editMessageModal");
            modal.addEventListener('show.bs.modal',function(event){
                var previousMessage = document.getElementById("message_" + messageID).innerText;
                document.getElementById("editMessageInput").value = previousMessage;
                $('#editMessageCharCounter').text(previousMessage.length + " / 256");
                document.getElementById("messageIDValue").value = messageID;
            });
            document.getElementById("editMessageButton").click();
        }
        function replyMessageID(id) {
            var id = id;
            console.log(id);
            var modal=document.getElementById("replyMessageModal");
            modal.addEventListener('show.bs.modal',function(event){
                document.getElementById("replyMessageID").value = id;

            });
            document.getElementById("replyMessageButton").click();
        }
    </script>

</body>
</html>
<?php
$conn->close()
?>