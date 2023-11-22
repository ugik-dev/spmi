$(function () {
  const $facultiesTable = $("#faculties-datatable").DataTable({
    order: [0, "asc"],
  });

  // Function to add new vision input field with a remove button
  function addVisionInput(containerId, value = "") {
    const container = $(`#${containerId}`);
    const index = container.children().length + 1; // To keep track of the vision items
    container.append(`
    <div class="input-group mb-2 vision-input">
      <input type="text" name="vision[]" class="form-control" value="${value}" placeholder="Visi ${index}">
      <div class="input-group-append">
        <button type="button" class="btn btn-outline-danger remove-vision" onclick="removeVision(this)">
          <i class="fa fa-minus"></i>
        </button>
      </div>
    </div>
  `);
  }

  // Function to remove vision input field
  window.removeVision = function (button) {
    $(button).closest(".vision-input").remove();
  };

  // Add vision input field in create modal
  $("#add-create-vision").on("click", () =>
    addVisionInput("create-vision-container")
  );

  // Add vision input field in edit modal
  $("#add-edit-vision").on("click", () =>
    addVisionInput("edit-vision-container")
  );

  const $editModal = $("#editFacultyModal");
  const $formEdit = $("#edit-faculty-form");
  const $facultyNameInput = $("#edit-faculty-name");
  const $facultyAbbrInput = $("#edit-faculty-abbr");
  const $facultyMissionInput = $("#edit-faculty-mission");
  const $facultyDescriptionInput = $("#edit-faculty-description");

  $editModal.on("show.bs.modal", (event) => {
    const $buttonEdit = $(event.relatedTarget);
    const facultyData = $buttonEdit.data("faculty");
    const actionUrl = `/fakultas/edit/${facultyData.id}`;

    $formEdit.attr("action", actionUrl);
    $facultyNameInput.val(facultyData.name);
    $facultyAbbrInput.val(facultyData.abbr);

    // Populate vision fields in edit modal with remove buttons
    const visionArray = facultyData.vision
      ? JSON.parse(facultyData.vision)
      : [];
    const $visionContainer = $("#edit-vision-container");
    $visionContainer.empty(); // Clear existing inputs
    visionArray.forEach((visionItem, index) => {
      addVisionInput("edit-vision-container", visionItem); // Use the function to add inputs with values
    });

    $facultyMissionInput.val(facultyData.mission);
    $facultyDescriptionInput.val(facultyData.description);
  });

  $facultiesTable.on("click", ".delete-button", (event) => {
    const $buttonDelete = $(event.currentTarget);
    const facultyId = $buttonDelete.data("id");
    const facultyName = $buttonDelete.data("faculty-name");

    Swal.fire({
      title: "Apakah anda yakin?",
      text: `Data fakultas (${facultyName}) akan dihapus!`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Batal",
      showLoaderOnConfirm: true,
      preConfirm: () => deleteFacultyData(facultyId),
      allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
      if (result.isConfirmed) {
        setTimeout(() => window.location.reload(), 550);
      }
    });
  });

  function deleteFacultyData(facultyId) {
    return axios
      .delete(`/fakultas/hapus/${facultyId}`)
      .then((response) => {
        if (response.status === 200 || response.status === 204) {
          Swal.fire("Dihapus!", "Fakultas telah dihapus.", "success");
        } else {
          Swal.fire(
            "Gagal!",
            "Terjadi kesalahan saat menghapus fakultas.",
            "error"
          );
        }
      })
      .catch((error) => {
        Swal.showValidationMessage(`Request failed: ${error}`);
      });
  }
});
