/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/auth.js ***!
  \******************************/
function doLogin() {
  var data = $('#form-login').serialize();
  $.ajax({
    type: 'POST',
    url: baseUrl + '/login',
    data: data,
    beforeSend: function beforeSend() {
      showLoading();
      defaultFormValidation('form-login');
    },
    success: function success(res) {
      console.log('res', res);
      hideLoading();
      showNotification({
        success: true,
        message: res.message
      });
      setTimeout(function () {
        window.location.href = res.data.url;
      }, 800);
    },
    error: function error(err) {
      console.log('err', err);
      hideLoading();
      handleError(err, 'form-login');
    }
  });
}
$('#btn-login').click(function () {
  doLogin();
});
$(document).ready(function () {});
/******/ })()
;