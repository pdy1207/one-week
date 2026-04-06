$(document).ready(function () {
  const course = $('input[name="course"]').val();

  $.ajax({
    url: "/api/name.php",
    type: "GET",
    data: { course: course },
    success: function (res) {
      $('input[name="course_name"]').val(res.data.name);
    },
  });
});
