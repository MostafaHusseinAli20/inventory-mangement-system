let notifCenterDiv = $('#notifCenterDiv');

let toggleNotifCenter = () => {
    $('#notifCenterDiv').toggle();
};

$(document).on('mouseup', (e) => {
    if (!$('#notifCenterDiv').is(e.target) && $('#notifCenterDiv').has(e.target).length === 0) {
        $('#notifCenterDiv').hide();
    }
});