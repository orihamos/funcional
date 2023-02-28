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
$("#outro_tipo_pagamento").css("display", "none");
$(document).ready(function () {
  $("#add-button").click(function () {
    var clone = $("#formulario-produto tr:first").clone();
    clone.find("input").val("");
    $("#formulario-produto").append(clone);
  });
  
  $("#tipo_pagamento").change(function() {
    if ($(this).val() === "Outro") {
        $("#outro_tipo_pagamento").show();
    } else {
        $("#outro_tipo_pagamento").hide();
    }
}).trigger('change');
  

});



