$("#times").on("change", function(event) {
  var val = parseInt($(this).val(), 10);
  $("#plural").text((val !== -1 && val !== 1) ? "s" : "");
});

$("#rnjsus").on("submit", function(event) {
  event.preventDefault();

  var lower = $("#lower").val(),
      upper = $("#upper").val(),
      times = $("#times").val();

  $.ajax({
    url: "/api/" + lower + ".." + upper + "@" + times,
    success: function(response) {
      if (response.status) {
        $("#results div").text(response.data.join(", "));
        $("#rnjsus").addClass("animated fadeOutLeft");
        $("#results").removeClass("hidden").addClass("animated fadeInRight");
      }
    },
    error: function(error) {
      console.error(error.message);
    }
  });
});

$("#again").on("click", function(event) {
  $("#results div").empty();
  $("#rnjsus").removeClass("fadeOutLeft").addClass("fadeInLeft");
  $("#results").addClass("hidden").removeClass("fadeInRight");
});
