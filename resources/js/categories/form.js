$(document).ready(function () {
  $('body').on('submit', '#formSubmit',function (e) {
    e.preventDefault()
    let form = $(this);
    let url = form.attr('action');
    let formData = new FormData(form[0]);
    $.ajax({
      type: form.attr('method'),
      url: url,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.success) {
          toastr.success(response.message)
          setTimeout(() => {
            window.location.href = ROUTE_IDX
          }, 2000)
        } else {
          toastr.error(response.message)
        }
      },
      error: function (_xhr) {
        if (_xhr.status === 422) {
          let errors = _xhr.responseJSON.errors;
          for (let [key, value] of Object.entries(errors)) {
            showError(key, value[0]);
          }
        }
        if (_xhr.status === 500) {
          toastr.error(_xhr.responseJSON.message);
        }
      }
    })
  })
});
