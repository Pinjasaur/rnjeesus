(function($, window, document, undefined) {

  "use strict";

  $(function() {

    var width = $(window).width(),
        height = $(window).height();

    $.firefly({
      color: "#fff",
      minPixel: 1,
      maxPixel: 2,
      total : ((width * height) / 8192),
      on: "#backplate"
    });

    $("#rnjeesus").on("submit", generateRNG);

    $(".increment, .decrement").on("click", changeValue);

    $(".btn[data-target]").on("click", goToSection);

  });

  // Submit the form and make an AJAX request to the API
  function generateRNG(event) {

    event.preventDefault();

    var lower = $("#lower-bound").val().trim(),
        upper = $("#upper-bound").val().trim(),
        quantity = $("#quantity").val().trim();

    $.ajax({
      url: "/api/" + lower + ".." + upper + "@" + quantity,
      success: function(response) {
        if (response.status) {
          $("#results .content").empty();
          $("#results .content").text(response.data.values.join(", "));
        } else {
          $("#results .content").text(response.message);
        }
        $("body").css("transform", "translateX(-80%)");
      },
      error: function(xhr, status, error) {
        $("#results .content").html("The RNG genie is not with you today. :(<br>If the issue persists, <a href='https://github.com/Pinjasaur/rnjeesus/issues'>let me know</a>.");
      }
    });

    return false;

  }

  // Change the value to an number <input>
  function changeValue(event) {

    var $input = $("#" + $(this).data("for")),
        value = parseInt($input.val(), 10),
        min = $input.attr("min"),
        max = $input.attr("max");

    value = ($(this).val() === "+") ? ++value : --value;

    value = Math.min(Math.max(value, min), max);

    $("#" + $(this).data("for")).val(value);

  }

  // Animate to a section
  function goToSection(event) {

    var target = $(this).data("target");

    $("body").css("transform", "translateX(" + ((target - 1) * -20) + "%)");

  }

})(jQuery, window, document);
