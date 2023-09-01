function dismissAlert(element) {
    // Remove the parent element
    element.parentNode.parentNode.remove();
}

$('#edit_modal').on('hide.bs.modal', function (e) {
    $('.jsmodalerror').html('');
});

function showAlert(type, message, errClass = "jserror") {
    let icon, shout = '';
    switch (type) {
        case 'success':
            icon = 'ep:success-filled';
            shout = 'Success!';
            break;
        case 'info':
            icon = 'ri:information-fill';
            shout = 'Info!';
            break;
        case 'warning':
            icon = 'ic:round-warning';
            shout = 'Warning!';
            break;
        case 'danger':
            icon = 'carbon:error-filled';
            shout = 'Error!';
            break;
    }

    const error = `<div class="py-[18px] mb-3 px-6 font-normal text-sm rounded-md bg-${type}-500 bg-opacity-[14%] text-white">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                        <iconify-icon class="text-2xl flex-0 text-${type}-500" icon="carbon:error-filled"></iconify-icon>
                        <p class="flex-1 text-${type}-500 font-Inter">
                            <strong>${shout}</strong> ${message}
                        </p>
                        <div class="flex-0 text-xl cursor-pointer text-${type}-500" onclick="dismissAlert(this)">
                            <iconify-icon icon="line-md:close"></iconify-icon>
                        </div>
                    </div>
                </div>`;
    $(`.${errClass}`).html(error);
}
