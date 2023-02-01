<?php
if (isset($_POST['editAvatarInput'])) {
    $newAvatar = $_FILES['editAvatarInput'];
    echo $newAvatar;
}