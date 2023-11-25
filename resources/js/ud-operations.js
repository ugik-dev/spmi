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
      preConfirm: () => deleteData(deleteUrl),
      allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire("Dihapus!", `${modelName} sudah dihapus.`, "success");
        $table.DataTable().ajax.reload(null, false);
      }
    });
  });

  function deleteData(url) {
    return axios.delete(url).catch((error) => {
      Swal.fire("Kesalahan!", "Terjadi kesalahan saat penghapusan.", "error");
    });
  }
}
