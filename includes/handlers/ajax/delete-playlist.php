<?php
include('../../../core/init≤.php');

if(isset($_POST['playlistId'])) {
    $playlistId = $_POST['playlistId'];

    $playlistQuery = mysqli_query($conn, "DELETE FROM playlists WHERE id = '$playlistId'");
    $songQuery = mysqli_query($conn, "DELETE FROM playlistSongs WHERE playlistId = '$playlistId'");
} else {
    echo "Playlist was not deleted from the playlist database";
}
?>
