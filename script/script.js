(function () {
  "use strict";

  var forms = document.querySelectorAll(".needs-validation");

  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();

$(document).ready(function () {
  $("#add-button").click(function () {
    var clone = $("#formulario-produto tr:first").clone();
    clone.find("input").val("");
    $("#formulario-produto").append(clone);
  });
});

/* $("#formulario-produto").on("click", ".remove-button", function () {
  var $row = $(this).closest("tr");
  var id_venda = $row.data("id-venda");
  var id = $row.data("id");
  $row.remove();
  if (id_venda && id) {
    deleteProduct(id_venda, id);
  }
});

function deleteProduct(id_venda, id) {
  $.ajax({
    type: "POST",
    url: "../public/products/deleteProduct.php",
    data: {
      id_venda: id_venda,
      id: id
    },
    success: function (data) {
      console.log("Product deleted successfully");
    },
    error: function (xhr, status, error) {
      console.error("Error deleting product:", error);
    }
  });
}


 */
