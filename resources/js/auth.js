function doLogin() {
    var data = $('#form-login').serialize();

    $.ajax({
        type: 'POST',
        url: baseUrl + '/login',
        data: data,
        beforeSend: function () {
            showLoading();
            defaultFormValidation('form-login');
        },
        success: function (res) {
            console.log('res',res);
            hideLoading();
            showNotification({
                success: true,
                message: res.message,
            });

            setTimeout(() => {
                window.location.href = res.data.url;
            }, 800);
        },
        error: function (err) {
            console.log('err',err);
            hideLoading();
            handleError(err, 'form-login');
        }
    })
}


$('#btn-login').click(() => {

    doLogin();
});
$(document).ready(function () {
});
