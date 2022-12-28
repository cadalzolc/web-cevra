function Logout() {
    if (confirm('Log-Out?')) {
        window.location.href = './process/logout.php?'
    }
}

function PostReservation(frm) {
    let btnConfirm = $(frm).data("confirm");
    let btnCancel = $(frm).data("cancel");
    $.ajax({
        type: "POST",
        url: $(frm).attr("action"),
        data: $(frm).serialize(),
        beforeSend: function () {
            if (btnConfirm) {
                $(btnConfirm).attr("disabled", true);
            }
            if (btnCancel) {
                $(btnCancel).attr("disabled", true);
            }
        },
        success: function (res) {
            console.log($(frm).data("redirect") + "ref=" + res.data);
            if (res.success == true){
                toastr.success(res.message)
                setTimeout(function () {
                    window.location.href = $(frm).data("redirect") + "ref=" + res.data
                 }, 1000);
            }else{
                toastr.error(res.message);
                if (btnConfirm) {
                    $(btnConfirm).attr("disabled", false);
                }
                if (btnCancel) {
                    $(btnCancel).attr("disabled", false);
                }
            }
        },
        error: function (err) {
            toastr.error(err);
            if (btnConfirm) {
                $(btnConfirm).attr("disabled", false);
            }
            if (btnCancel) {
                $(btnCancel).attr("disabled", false);
            }
        },
        complete: function() {
        }
    });
    return false;
}

function ReservationDateChecked(e) {
    $.get($(e).data("url"), { "date": e.value }, function(res) {
        $("#btnContinue").attr("disabled", !res.success);
        if (res.success == true){
            $("#dtS1").show();
            $("#dtS2").hide();
        }else{
            $("#dtS1").hide();
            $("#dtS2").show();
        }
    });
}