
function showSelectedCheck(name, menuNameId, status) {
    if (status == 1) {
        $('#' + name + menuNameId).iCheck('check');
    } else {
        $('#' + name + menuNameId).iCheck('uncheck');
    }
} 