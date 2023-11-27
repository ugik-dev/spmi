export function setupEditModal(
  editModalSelector,
  formSelector,
  actionUrlPattern,
  modelDataAttribute
) {
  const $editModal = $(editModalSelector);
  const $form = $(formSelector);

  $editModal.on("show.bs.modal", (event) => {
    const $button = $(event.relatedTarget);
    const modelData = $button.data(modelDataAttribute);
    console.log(modelData);
    const actionUrl = actionUrlPattern.replace(":id", modelData.id);

    $form.attr("action", actionUrl);

    Object.keys(modelData).forEach((key) => {
      let value;

      if (
        key === "roles" &&
        Array.isArray(modelData[key]) &&
        modelData[key].length > 0
      ) {
        // Special handling for 'roles'
        value = modelData[key][0].name; // Use the name of the first role
      } else if (modelData[key] && typeof modelData[key] === "object") {
        // For other objects, use .id
        value = modelData[key].id || modelData[key];
      } else {
        // Use the value directly for non-object types
        value = modelData[key];
      }

      const $formElement = $form.find(`[name="${key}"]`);
      // Set the value for the form element
      $formElement.val(value);

      // Trigger change if it's a select element (for Select2)
      if ($formElement.is("select")) {
        $formElement.trigger("change");
      }
    });
  });
}

export function setupDeleteFunctionality(
  tableSelector,
  deleteEndpointPattern,
  modelNameAttribute
) {
  const $table = $(tableSelector);

  $table.on("click", ".delete-button", (event) => {
    const $button = $(event.currentTarget);
    const modelId = $button.data("id");
    const modelName = $button.data(modelNameAttribute);
    const deleteUrl = deleteEndpointPattern.replace(":id", modelId);

    Swal.fire({
      title: "Apakah anda yakin?",
      text: `Anda akan menghapus ${modelName}. Tindakan ini tidak bisa dibatalkan.`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Tidak, batalkan!",
      showLoaderOnConfirm: true,
      preConfirm: () => {
        return deleteData(deleteUrl).catch((error) => {
          // Handle specific HTTP status codes or default error message
          let errorMessage = "Terjadi kesalahan saat penghapusan.";
          if (error.response) {
            if (error.response.status === 404) {
              errorMessage = "URL tidak ditemukan.";
            } else if (error.response.status === 500) {
              errorMessage = "Kesalahan server internal.";
            }
          }
          Swal.showValidationMessage(errorMessage);
        });
      },
      allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire("Dihapus!", `${modelName} sudah dihapus.`, "success");
        $table.DataTable().ajax.reload(null, false);
      }
    });
  });

  function deleteData(url) {
    return axios
      .delete(url)
      .then((response) => {
        return response.data;
      })
      .catch((error) => {
        throw error;
      });
  }
}

export function setupCriterionEditModal(
  editModalSelector,
  formSelector,
  actionUrlPattern,
  modelDataAttribute
) {
  const $editModal = $(editModalSelector);
  const $form = $(formSelector);

  $editModal.on("shown.bs.modal", (event) => {
    const $button = $(event.relatedTarget);
    const modelData = $button.data(modelDataAttribute);
    const actionUrl = actionUrlPattern.replace(":id", modelData.id);

    $form.attr("action", actionUrl);

    // Populate form fields
    $form.find('[name="name"]').val(modelData.name);
    $form.find('[name="code"]').val(modelData.code);
    $form.find('[name="level"]').val(modelData.level);

    // For parent_id, you need to handle it separately
    if (modelData.parent_id) {
      $(".parent-criterion-group").removeClass("d-none");
      // Set value and trigger change for Select2

      $form.find('[name="parent"]').val(modelData.parent_id).trigger("change");
    } else {
      $(".parent-criterion-group").addClass("d-none");
      $form.find('[name="parent"]').val("").trigger("change");
    }

    // Trigger change events for select elements (useful if using Select2)
    $form.find("select").trigger("change");
  });
}
