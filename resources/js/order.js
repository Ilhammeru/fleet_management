function initSelect2() {
    $('#vehicle').select2({
        placeholder: i18n.global.selectVehicle
    });
    $('#driver').select2({
        placeholder: i18n.global.selectDriver
    });
}

window.initSelect2 = initSelect2;
