import "./bootstrap";
import {
  setupEditModal,
  setupDeleteFunctionality,
  setupCriterionEditModal,
} from "./ud-operations";
$(function () {
  $("select").select2({
    theme: "bootstrap4",
  });
});

// Expose the functions globally if they are not already
window.setupEditModal = setupEditModal;
window.setupDeleteFunctionality = setupDeleteFunctionality;
window.setupCriterionEditModal = setupCriterionEditModal;
