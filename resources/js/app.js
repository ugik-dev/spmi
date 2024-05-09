import.meta.glob(["../images/**"]);
import "./import.plugins";

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: "pusher",
    key: "0692e41e02b68080e3e6",
    cluster: "mt1",
    forceTLS: true,
});

// var channel = Echo.channel("private-user.1");
// channel.listen(".new-request", function (data) {
//     alert(JSON.stringify(data));
// });

function formatAsIDRCurrency(value) {
    if (!isNaN(value)) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(value);
    }
    return "";
}

function enforceNumericInput(event) {
    const charCode = event.which ? event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        event.preventDefault();
    }
}
function confirmDelete(id) {
    Swal.fire({
        title: "Anda yakin ingin hapus?",
        text: "Data tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batalkan",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delete-form-" + id).submit();
        }
    });
}
function allowOnlyNumericInput(e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if (
        $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        // Allow: Ctrl+A,Ctrl+C,Ctrl+V, Command+A
        ((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) &&
            (e.ctrlKey === true || e.metaKey === true)) ||
        // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)
    ) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if (
        (e.shiftKey || e.keyCode < 48 || e.keyCode > 57) &&
        (e.keyCode < 96 || e.keyCode > 105)
    ) {
        e.preventDefault();
    }
}
// Handle paste event separately
function handlePaste(e) {
    // Get pasted data via clipboard API
    let pastedData = (e.originalEvent || e).clipboardData.getData("text/plain");

    // Ensure that pasted data is numeric only
    if (!/^\d+$/.test(pastedData)) {
        // If not numeric, prevent the paste
        e.preventDefault();
    }
}
// Populate Select Options
function populateSelectWithOptions(
    selectElement,
    options,
    defaultOptionTextContent = "Pilih opsi..."
) {
    // Clear existing options
    selectElement.textContent = "";

    // Create a default option
    const defaultOption = document.createElement("option");
    defaultOption.textContent = defaultOptionTextContent;
    defaultOption.disabled = true;
    defaultOption.selected = true;
    selectElement.appendChild(defaultOption);

    // Loop through the options array and create options
    if (Array.isArray(options)) {
        options.forEach((option) => {
            const optionElement = document.createElement("option");
            optionElement.value = option.value;
            optionElement.textContent = option.text;
            selectElement.appendChild(optionElement);
        });
    } else {
        console.error("Options must be an array.");
    }
}

window.formatAsIDRCurrency = formatAsIDRCurrency;
window.enforceNumericInput = enforceNumericInput;
window.confirmDelete = confirmDelete;
window.allowOnlyNumericInput = allowOnlyNumericInput;
window.handlePaste = handlePaste;
window.populateSelectWithOptions = populateSelectWithOptions;
