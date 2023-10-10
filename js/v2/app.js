
function showNotificationWidthScreen(x) {
    if (x.matches) { // If media query matches
        $('.noti-icon').removeAttr('data-bs-toggle');
        $('.noti-check').removeAttr('disabled');
        
    } else {
        $('.noti-icon').attr('data-bs-toggle', 'dropdown');
        $('.noti-check').attr('disabled');
    }
}
var x = window.matchMedia("(max-width: 827px)")
$(window).on('load', function () {
    showNotificationWidthScreen(x);
});
x.addEventListener('change', function (e) {
    showNotificationWidthScreen(e.target);
});

function handleOverflow(checkboxId) {
    const isChecked = $(`#${checkboxId}`).is(":checked");
    $('body').css('overflow', isChecked ? 'hidden' : 'auto');
}

$('#calender-check, #nav-check, #noti-mobi-check').on('change', function () {
    handleOverflow(this.id);
});
