function swalLoading() {
    Swal.fire({
        title: "Loading!..",
        // allowOutsideClick: false,
    });
    Swal.showLoading();
}

function swal(text, message, icon) {
    Swal.fire({
        title: text,
        text: message,
        type: icon,
    });
}
