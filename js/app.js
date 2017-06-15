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

    $("#rnjeesus").on("submit", function(event) {
      event.preventDefault();

      var lower = $("#lower-bound").val(),
          upper = $("#upper-bound").val(),
          quantity = $("#quantity").val();

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
    });

    $(".increment, .decrement").on("click", function(event) {

      var $input = $("#" + $(this).data("for")),
          value = parseInt($input.val(), 10),
          min = $input.attr("min"),
          max = $input.attr("max");

      value = ($(this).val() === "+") ? ++value : --value;

      value = Math.min(Math.max(value, min), max);

      $("#" + $(this).data("for")).val(value);

    });

    $(".btn[data-target]").on("click", function(event) {

      var target = $(this).data("target");

      $("body").css("transform", "translateX(" + ((target - 1) * -20) + "%)");

    });

  });

})(jQuery, window, document);
