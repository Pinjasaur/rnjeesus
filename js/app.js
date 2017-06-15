(function($, window, document, undefined) {

  "use strict";

  $(function() {

    $("#rnjeesus").on("submit", function(event) {
      event.preventDefault();

      var lower = $("#lower-bound").val(),
          upper = $("#upper-bound").val(),
          quantity = $("#quantity").val();

      $.ajax({
        url: "/api/" + lower + ".." + upper + "@" + quantity,
        success: function(response) {
          $("body").css("transform", "translateX(-80%)");
          if (response.status) {
            $("#results .content").empty();
            $("#results .content").text(response.data.values.join(", "));
          } else {
            console.log(response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error("The RNG genie is not with you today. :(");
        }
      });

      return false;
    });

    $(".increment, .decrement").on("click", function(event) {

      var value = parseInt($("#" + $(this).data("for")).val(), 10);

      value = ($(this).val() === "+") ? ++value : --value;

      $("#" + $(this).data("for")).val(value);

    });

    $(".btn[data-target]").on("click", function(event) {

      var target = $(this).data("target");

      $("body").css("transform", "translateX(" + ((target - 1) * -20) + "%)");

    });

  });

})(jQuery, window, document);
