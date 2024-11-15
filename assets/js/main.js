const STATE = {
    dtDefaultOpts: {
        scrollX: true
    },
    regEx: {
        doubleOrInt: /^\d*\.?\d{1,2}$/,
        decimal: /^\d*\.?\d+$/,
        email: /[a-zA-Z0-9.!#$%&'*+-/=?^_`{|}~]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/,
    }
}

$(document).ready(function () {
    $("#ham-btn").on('click', function () {
        $("#ham-menu").toggleClass('viewing'); s
    });

    $(".password-eye-container").on("click", function () {
        const passwordInput = $(this).closest('.password-container').children('input');
        const viewingPassWord = passwordInput.prop("type") === "text";
        const newInputType = viewingPassWord ? "password" : "text";
        passwordInput.prop("type", newInputType);
    });

    $(".modal-close").on("click", function () {
        $(this).closest(".modal").removeClass("showing");
    });

    $(document).off('click').on("click", function (e) {
        const target = $(e.target);
        const modal = $(".modal");

        if (
            modal.hasClass("showing") // Modal is showing
            && !target.is(".modal-dialog") // Target is not modal dialog
            && !target.is(".open-modal-btn") // Target is not open modal button
            && !$(".swal2-container").length // No sweetalert modal showing
            && !target.closest("table").length // Target is not inside a table
            && !target.closest(".modal-dialog").length // Click is not inside modal dialog
            && !target.closest(".open-modal-btn").length // CLick is not inside open modal button
        ) {
            modal.removeClass("showing");
        }
    });
});