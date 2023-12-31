import './bootstrap';

import { Notify, Loading } from 'notiflix';

var baseUrl = process.env.MIX_APP_URL;

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.sidebar-toggle').click(() => {
        if ($('body').hasClass('desktop-enable')) {
            $('body').addClass('mobile-enable');
            $('body').removeClass('desktop-enable');

            setTimeout(() => {
                $('body .app-wrapper').append(`
                <div class="vertical-overlay" onclick="hideSidebar()"></div>
                `);
            }, 400);
        } else {
            $('body').removeClass('mobile-enable');
            $('body').addClass('desktop-enable');
            $('body .vertical-overlay').remove();
        }
    });
});

function sidebarNavigation(event) {
    window.location.href = event;
}

function hideSidebar() {
    $('.sidebar-toggle').click();
}

function showNotification(payload) {
    if (payload.success) {
        Notify.success(payload.message);
    } else {
        Notify.failure(payload.message);
    }
}

function showLoading(message = i18n.global.processing) {
    Loading.dots(message);
}

function hideLoading() {
    Loading.remove();
}

function handleError(errors, formId) {
    if (errors.status == 422) {
        showFormErrorValidation(errors.responseJSON.errors, formId);
    } else {
        showNotification({
            success: false,
            message: errors.responseJSON.message,
        });
    }
}

function showFormErrorValidation(errors, formId) {
    var formElem = $(`#${formId}`);
    for (var a in errors) {
        if (document.querySelector(`#${formId} div[data-error="${a}"]`)) {
            document.querySelector(`#${formId} div[data-error="${a}"]`).innerHTML = errors[a][0];
            document.querySelector(`#${formId} div[data-error="${a}"]`).style.display = 'block';
        }

        if (document.querySelector(`#${formId} div[id="conjunction-${a}"]`)) {
            document.querySelector(`#${formId} div[id="conjunction-${a}"]`).style.display = 'block';
        }

        if (document.querySelector(`#${formId} select[id="${a}"]`)) {
            document.querySelector(`#${formId} select[id="${a}"]`).classList.add('is-invalid');
        }

        if (document.querySelector(`#${formId} input[id="${a}"]`)) {
            document.querySelector(`#${formId} input[id="${a}"]`).classList.add('is-invalid');
        }
    }
}

function defaultFormValidation(formId) {
    $('#' + formId).find('input').each((i, elem) => {
        $(elem).removeClass('is-invalid');
    });
    $('#' + formId).find('select').each((i, elem) => {
        $(elem).removeClass('is-invalid');
    });
    $('#' + formId).find('.invalid-feedback').each((i, elem) => {
        $(elem).html('');
        $(elem).css({
            display: 'none',
        });
    });
    $('#' + formId).find('.conjunction').each((i, elem) => {
        $(elem).css({
            display: 'none',
        });
    });
}

window.baseUrl = baseUrl;
window.sidebarNavigation = sidebarNavigation;
window.hideSidebar = hideSidebar;
window.showNotification = showNotification;
window.showLoading = showLoading;
window.hideLoading = hideLoading;
window.handleError = handleError;
window.defaultFormValidation = defaultFormValidation;
