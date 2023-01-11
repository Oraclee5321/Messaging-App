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
        $messageContent = mysqli_real_escape_string($conn,$_POST['newMessageInput']);
        $uid = $_SESSION['UID'];
        $sql = "INSERT INTO messages (message_content,user_id) values ('$messageContent','$uid')";
        $sqlquery = $conn->query($sql);
        header("Location: main_page.php");
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

                                <textarea class="form-control" maxlength="256" minlength="1" id="newMessageInput" name="newMessageInput"></textarea>
                                <span class="input-group-text" id="charCounter"> / 256</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Send" name="sendMessageButton">
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
                            <svg
                                    xmlns="http://www.w3.org/2000/svg" style="display: block;margin:auto" fill="#000000" class="w-75 h-50" viewBox="0 0 56 56"><path d="M 6.6505 42.2994 L 10.5900 42.2994 L 10.5900 45.9424 C 10.5900 50.3055 12.7927 52.5082 17.2405 52.5082 L 49.3495 52.5082 C 53.7548 52.5082 56 50.3055 56 45.9424 L 56 23.4281 C 56 19.0861 53.7548 16.8834 49.3495 16.8834 L 45.4100 16.8834 L 45.4100 13.4523 C 45.4100 9.0892 43.1861 6.8865 38.7803 6.8865 L 6.6505 6.8865 C 2.2239 6.8865 0 9.0892 0 13.4523 L 0 35.7548 C 0 40.1179 2.2239 42.2994 6.6505 42.2994 Z M 6.7141 38.8894 C 4.5961 38.8894 3.4100 37.7669 3.4100 35.5642 L 3.4100 13.6429 C 3.4100 11.4402 4.5961 10.2964 6.7141 10.2964 L 38.7170 10.2964 C 40.8138 10.2964 41.9998 11.4402 41.9998 13.6429 L 41.9998 16.8834 L 17.2405 16.8834 C 12.7927 16.8834 10.5900 19.0650 10.5900 23.4281 L 10.5900 38.8894 Z M 17.2829 49.0982 C 15.1649 49.0982 14.0000 47.9545 14.0000 45.7518 L 14.0000 23.6187 C 14.0000 21.4160 15.1649 20.2934 17.2829 20.2934 L 49.2857 20.2934 C 51.3826 20.2934 52.5897 21.4160 52.5897 23.6187 L 52.5897 45.7518 C 52.5897 47.9545 51.3826 49.0982 49.2857 49.0982 Z M 33.2949 44.8410 C 34.4175 44.8410 35.0952 44.0785 35.0952 42.8501 L 35.0952 36.6656 L 41.5552 36.6656 C 42.7411 36.6656 43.5674 36.0513 43.5674 34.9288 C 43.5674 33.7851 42.7836 33.1285 41.5552 33.1285 L 35.0952 33.1285 L 35.0952 26.5627 C 35.0952 25.3131 34.4175 24.5506 33.2949 24.5506 C 32.1512 24.5506 31.5370 25.3554 31.5370 26.5627 L 31.5370 33.1285 L 25.0983 33.1285 C 23.8486 33.1285 23.0650 33.7851 23.0650 34.9288 C 23.0650 36.0513 23.9122 36.6656 25.0983 36.6656 L 31.5370 36.6656 L 31.5370 42.8501 C 31.5370 44.0362 32.1512 44.8410 33.2949 44.8410 Z"/>
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
                $namesql = "SELECT username FROM users WHERE id = '$row[user_id]'";
                $namesqlquery = $conn->query($namesql);
                $username = $namesqlquery->fetch_assoc();
                echo
                    '<div class="row">
                        <div class="col-6 col-md-4">
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="card" style="width: 18rem;background-color:'.($username['username'] == $_SESSION['username'] ? "aqua" : "white").'">
                                <div class="card-title">
                                    User: '.$username['username'].'
                                </div>
                                <div class="card-body">
                                    '.$row['message_content'].'
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                        </div>
                     </div>
                     <br>
                    ';

            }
            $sql = "SELECT message_id FROM messages ORDER BY message_id DESC LIMIT 1";
            $sqlquery = $conn->query($sql);
            $row = $sqlquery->fetch_assoc();
            $result = $row['message_id'];
        ?>
    </div>
    <script type="text/javascript">
        var lastMessage = <?php echo $result ?>;
        setInterval(function () {
            $.ajax({
                type: "POST",
                url: "php-functions/check-update.php",
                dataType: "json",
                success: function (response) {
                    var data = response;
                    if (parseInt(lastMessage) < parseInt(data)) {
                        $("#messages").load(location.href + " #messages");
                    }
                }
            });
        }, 1000);
    </script>
    <script>
        $(document).ready(function(){
            $("#newMessageInput").bind("keyup", function(){
                var counter = $('#newMessageInput').val().length;
                var completeCounter =(counter + " / 256");
                $('#charCounter').text(completeCounter);
            })
        })
    </script>
</body>
</html>

<?php
    $conn->close();
?>
