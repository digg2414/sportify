var currentPlaylist = [];
var shufflePlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;

$(document).on("change", "select.playlist", function() {
    var select = $(this);
    var playlistId = select.val();
    var songId = select.prev(".songId").val();

    $.post("includes/handlers/ajax/add-playlist.php", {playlistId: playlistId, songId: songId})
        .done(function(error) {
            if(error != "") {
                alert(error);
                return;
            }

            hideOptionsMenu();
            select.val("");
        })
})

$(document).click(function(click) {
    var target = $(click.target);

    if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
        hideOptionsMenu();
    }
})

$(window).scroll(function() {
    hideOptionsMenu();
});

function updateEmail(emailClass) {
    var emailValue = $("." + emailClass).val();

    $.post('includes/handlers/ajax/update-email.php', {email: emailValue, username: userLoggedIn})
        .done(function (response) {
            $("." + emailClass).nextAll(".message").text(response);
        });
}

function updatePassword(oldPasswordClass, newPassword1Class, newPassword2Class) {
    var oldPassword = $("." + oldPasswordClass).val();
    var newPassword1 = $("." + newPassword1Class).val();
    var newPassword2 = $("." + newPassword2Class).val();


    $.post('includes/handlers/ajax/update-password.php',
    {oldPassword: oldPassword,
        newPassword1: newPassword1,
        newPassword2: newPassword2,
        username: userLoggedIn})
    .done(function (response) {
        $("." + oldPasswordClass).nextAll(".message").text(response);
    });
}

function openPage(url) {
    if(timer != null) {
        clearTimeout(timer);
    }

    if(url.indexOf("?") == -1) {
        url = url + "?";
    }

    var encodedUrl = encodeURI(url + '&userLoggedIn=' + userLoggedIn);
    $("#mainContent").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null, null, url);
}

function logout() {
    $.post('includes/handlers/ajax/logout.php', function() {
        location.reload()
    })
}

function hideOptionsMenu() {
    var menu = $(".optionsMenu");
    if(menu.css("display") != "none") {
        menu.css("display", "none");
    }
}

function removeFromPlaylist(button, playlistId) {
    var songId = $(button).prevAll(".songId").val();

    $.post("includes/handlers/ajax/remove-from-playlist.php", {playlistId: playlistId, songId: songId})
        .done(function(error) {
            if(error != "") {
                alert(error);
                return;
            }

            openPage("playlist.php?id=" + playlistId);
        })
}

function showOptionsMenu(button) {
    var songId = $(button).prevAll(".songId").val();
    var menu = $(".optionsMenu");
    var menuWidth = menu.width();
    menu.find(".songId").val(songId);

    var scrollTop = $(window).scrollTop(); //Distance from top of window to top of document
    var elementOffset = $(button).offset().top; //Distance from top of document

    var top = elementOffset - scrollTop;
    var left = $(button).position().left;

    menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline" });

}

function createPlaylist(username) {
    console.log(userLoggedIn);
    var popup = prompt("Please enter the name of your playlist");
    if(popup != "") {
        $.post("includes/handlers/ajax/create-playlist.php", {name: popup, username: userLoggedIn}).done(function(error) {
            if(error != "") {
                alert(error);
                return;
            };

            openPage('your-music.php');
        });
    }
}

function deletePlaylist(playlistId) {
    var prompt = confirm("Are you sure you want to delete this playlist?");

    if(prompt === true) {
        $.post("includes/handlers/ajax/delete-playlist.php", {playlistId: playlistId}).done(function(error) {
            if(error != "") {
                alert(error);
                return;
            };

            openPage('your-music.php');
        });
    }
}

function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60); //Rounds down
    var seconds = time - (minutes * 60);

    var extraZero = (seconds < 10) ? "0" : "";

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remainingTime").text(formatTime(audio.duration - audio.currentTime));

    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("canplay", function() {
        //'this' refers to the object that the event was called on
        var duration = formatTime(this.duration);
        $(".progressTime.remainingTime").text(duration);
    });

    this.audio.addEventListener("timeupdate", function(){
        if(this.duration) {
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function() {
        updateVolumeProgressBar(this);
    });

    this.setTrack = function(track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }

    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }

}
