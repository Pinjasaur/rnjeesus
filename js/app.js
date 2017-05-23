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
      console.log(response);
    },
    error: function(error) {
      console.error(error.message);
    }
  });
});
