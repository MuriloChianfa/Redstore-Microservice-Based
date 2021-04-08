function customAlert(message, type = "success") {
    var customAlertType = "Sucesso";
    var customAlertColor = "#28a745";
    var customAlertIcon = "fa fa-check";

    if (type == "error") {
        customAlertType = "Erro";
        customAlertColor = "#ff0000";
        customAlertIcon = "fa fa-exclamation";
    }
    else if (type == "warning") {
        customAlertType = "Atenção";
        customAlertColor = "#ff9900";
        customAlertIcon = "fa fa-warning";
    }

    iziToast.warning({
        icon: customAlertIcon,
        position: 'topRight',
        title: customAlertType,
        color: customAlertColor,
        theme: 'dark',
        messageColor: '#ffffff',
        message: message
    });
}
