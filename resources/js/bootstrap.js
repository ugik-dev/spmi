// Import libraries and modules
import _ from "lodash";
import $ from "jquery";
import axios from "axios";
import Swal from "sweetalert2";
import "bootstrap";
import DataTable from "datatables.net-bs4";
import jszip from "jszip";
import pdfmake from "pdfmake";
import "datatables.net-autofill-bs4";
import "datatables.net-buttons-bs4";
import "datatables.net-buttons/js/buttons.colVis.mjs";
import "datatables.net-buttons/js/buttons.html5.mjs";
import "datatables.net-buttons/js/buttons.print.mjs";
import "datatables.net-colreorder-bs4";
import "datatables.net-datetime";
import "datatables.net-responsive-bs4";
import "datatables.net-rowgroup-bs4";
import "datatables.net-searchpanes-bs4";
import "datatables.net-select-bs4";
import "select2";

// Custom imports
import easing from "./vendor/jquery.easing.min.js";
import "./vendor/sb-admin-2.min.js";
import "../../public/vendor/datatables/buttons.server-side.js";

// Make jQuery and lodash available globally
window.$ = window.jQuery = $;
window._ = _;

// Axios default configuration
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.Swal = Swal;

// Import custom easing functions
$.extend(true, $.easing, easing);
