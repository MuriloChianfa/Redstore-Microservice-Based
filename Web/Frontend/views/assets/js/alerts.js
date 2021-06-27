
const customAlert = (message, type = 'error') => {
    switch(type) {
        case 'success':
           iziToast.success({
    			title: 'OK',
                position: 'topRight',
                pauseOnHover: false,
                closeOnClick: true,
                progressBar: false,
    			message: message,
			}); 
            break;
		case 'warning':
			iziToast.warning({
    			title: 'Caution',
                position: 'topRight',
                pauseOnHover: false,
                closeOnClick: true,
                progressBar: false,
    			message: message,
			});
			break;
		case 'info':
			iziToast.info({
                position: 'topRight',
                pauseOnHover: false,
                closeOnClick: true,
                progressBar: false,
    			message: message,
			})
			break;
		default:
			iziToast.error({
    			title: 'Error',
                position: 'topRight',
                pauseOnHover: false,
                closeOnClick: true,
                progressBar: false,
    			message: message,
			});
			break;
    }
}

