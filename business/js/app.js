$(function (){
    $('[data-thumb]').on("change", UploadVenueImage);
});

function Logout() {
    if (confirm('Log-Out?')) {
        window.location.href = './process/logout.php?'
    }
}

function UploadVenueImage() {
    let img = $(this).data('image');
    var fileReader = new FileReader();
    fileReader.onload = function(event) {
        $(img).attr('src', event.target.result);
    };
    fileReader.readAsDataURL($(this)[0].files[0]);
    var payload = new FormData();
    payload.append("venue", $(this).data('venue'));
    payload.append("order", $(this).data('order'));
    payload.append("photo", $(this)[0].files[0]);
    $.ajax({
        url : $(this).data('action'),
        type : 'POST',
        data : payload,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data.success === true) {
                toastr.success(data.message);
                window.location.reload(true);
            } else {
                toastr.error(data.message);
            }
        },
    });
}

function OnImageSelection(elem) {
    let img = $(elem).data('image');
    let inp = $(elem).data('input');
    var fileReader = new FileReader();
    fileReader.onload = function(event) {
        $(img).attr('src', event.target.result);
    };
    fileReader.readAsDataURL($(elem)[0].files[0]);
    $(inp).val(1);
}