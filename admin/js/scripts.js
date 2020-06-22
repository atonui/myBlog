$(document).ready(function() {

    // EDITOR CKEDITOR, WYSWYG editor
    ClassicEditor
        .create(document.querySelector('#body'))
        .catch(error => {
            console.error(error);
        });

    // check all boxes in view all posts

    $('#selectAllBoxes').click(function (event) {

        if (this.checked) {
            $('.checkBoxes').each(function () {

                this.checked = true;
            });

        } else {
            $('.checkBoxes').each(function () {

                this.checked = false;
            });
        }

    });

    //pretty loader delay in admin panel

    var div_box = "<div id='load-screen'><div id='loading'></div></div>";

    $("body").prepend(div_box);

    $('#load-screen').delay(700).fadeOut(600, function () {
        $(this.remove());
    })

});
// get number of users online
function loadUsersOnline() {
    $.get("functions.php?onlineusers=result", function (data) {
        $(".usersonline").text(data);

    });

}
setInterval(function () {
    loadUsersOnline();

}, 500);