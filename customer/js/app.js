function Logout() {
    if (confirm('Log-Out?')) {
        window.location.href = './process/logout.php?'
    }
}

function OnImageSelection(elem) {
    let img = $(elem).data('image');
    var fileReader = new FileReader();
    fileReader.onload = function(event) {
        $(img).attr('src', event.target.result);
    };
    fileReader.readAsDataURL($(elem)[0].files[0]);
   
}