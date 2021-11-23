$(document).ready(function() {
    if ($("body").height() < $(window).height()) {
        $("footer").css({ "position": "fixed", "bottom": "0" });
    }
});