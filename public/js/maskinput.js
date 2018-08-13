$(document).ready(function () {
    $('.datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy', "clearIncomplete": true });
    $('.monthmask').inputmask('mm/yyyy', { 'placeholder': 'mm/yyyy', "clearIncomplete": true });
    $('.yearmask').inputmask('9999', { "placeholder": "" });
    $('#phonemask').inputmask({ "mask": "0 9999999999999 ", "placeholder": "" });
    $('#cmnnmask').inputmask({ "mask": "999999999999", "placeholder": "" });
    $('.maskmoney').maskMoney({ "precision": 0 });
});