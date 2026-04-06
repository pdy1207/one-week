$(document).ready(function () {
  // 1. 페이지 로드 시 코스 정보 가져오기
  const course = $('input[name="course"]').val();

  if (course) {
    $.ajax({
      url: "/api/name.php",
      type: "GET",
      data: { course: course },
      dataType: "json", // 응답 데이터 형식 지정
      success: function (res) {
        if (res.data) {
          $("#course_name").val(res.data.name);
          $("#course_des").val(res.data.description);
        }
      },
      error: function () {
        console.error("코스 정보를 불러오는 데 실패했습니다.");
      },
    });
  }

  const $name = $('input[name="name"]');
  const $error = $("#name_error");

  function validateName(value) {
    // 공백, 특수문자, 숫자 포함 체크
    const invalid = /[^a-zA-Z가-힣]/;

    // 한글 2~10자
    const korean = /^[가-힣]{2,10}$/;

    // 영문 2~20자
    const english = /^[a-zA-Z]{2,20}$/;

    if (invalid.test(value)) {
      return "숫자, 특수문자, 공백은 입력할 수 없습니다.";
    }

    if (korean.test(value) || english.test(value)) {
      return "";
    }

    return "한글은 2~10자, 영문은 2~20자로 입력해주세요.";
  }

  // 입력할 때마다 검사
  $name.on("input", function () {
    const value = $(this).val().trim();
    const msg = validateName(value);

    if (msg) {
      $error.text(msg).removeClass("d-none");
      $(this).addClass("is-invalid");
    } else {
      $error.text("").addClass("d-none");
      $(this).removeClass("is-invalid");
    }
  });

  // 제출 막기 (버튼 클릭 기준)
  $('button:contains("신청 완료")').on("click", function () {
    const value = $name.val().trim();
    const msg = validateName(value);

    if (msg) {
      alert(msg);
      $name.focus();
      return false;
    }

    // 여기서 폼 submit or 다음 단계 진행
    alert("검증 통과");
  });
});
