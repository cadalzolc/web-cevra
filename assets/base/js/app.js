$(function () {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    $(document).on('click','[data-dialog]', OpenDialog);
    $(document).on('click','[data-dialog-close]', CloseDialog);
});


function OnVerticalNavClick() {
    $('#vnav').toggleClass("vertical_nav__minify");
}

function PostRequestRedirect(frm) {
    let resRedirect= $(frm).data("redirect");
    let btnConfirm = $(frm).data("confirm");
    let btnCancel= $(frm).data("cancel");
    $.ajax({
        type: "POST",
        url: $(frm).attr("action"),
        data: $(frm).serialize(),
        beforeSend: function () {
            if (btnConfirm) {
                $(btnConfirm).attr("disabled", true);
            }
        },
        success: function (res) {
            if (res.success == true){
                toastr.success(res.message)
                if (resRedirect) {
                    setTimeout(function () {
                        window.location.href = resRedirect;
                    }, 2000);
                }
            }else{
                toastr.error(res.message);
                if (btnConfirm) {
                    $(btnConfirm).attr("disabled", false);
                }
            }
        },
        error: function (err) {
            toastr.error(err);
            if (btnConfirm) {
                $(btnConfirm).attr("disabled", false);
            }
        }
    });
    return false;
}

function PostRequestReload(frm) {
    let btnConfirm = $(frm).data("confirm");
    let btnCancel = $(frm).data("cancel");
    let divContainer = $(frm).data("div");
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
            //console.log(res);
            if (res.success == true){
                toastr.success(res.message)
                setTimeout(function () {
                   window.location.reload(true);
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

function generateQuickGuid() {
    return Math.random().toString(36).substring(2, 15) +
        Math.random().toString(36).substring(2, 15);
}

function OpenDialog() {
    var urlForm =  $(this).data('dialog');
    var divID = generateQuickGuid();
    $.get(urlForm, { 'id': $(this).data('id'), 'div': divID }, function(res) {
        $('<div/>')
        .attr("id", divID)
        .attr("class", "dialog-container")
        .append(res)
        .prependTo('body');
    });
}

function CloseDialog() {
    var ova =  $(this).data("dialog-close");
    $(ova).remove();
}

function SendVerification(e) {
    $.post($(e).data("url"), function(res) {
        if (res.success == true){
            toastr.success(res.message)
        }else{
            toastr.error(res.message);
        }
    });
}