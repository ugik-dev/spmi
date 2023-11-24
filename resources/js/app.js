import "./bootstrap";
import { setupEditModal, setupDeleteFunctionality } from "./ud-operations";
$(function () {
  $(document).ready(function () {
    $("select").select2({
      theme: "bootstrap4",
    });
  });
});

// Expose the functions globally if they are not already
window.setupEditModal = setupEditModal;
window.setupDeleteFunctionality = setupDeleteFunctionality;
