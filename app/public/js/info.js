$(document).ready(function () {
  /* =========================
     1. 코스 정보 불러오기
  ========================= */
  const course = $('input[name="course"]').val();

  if (course) {
    $.ajax({
      url: "/api/name.php",
      type: "GET",
      data: { course: course },
      dataType: "json",
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

  /* =========================
     2. 이름 검증
  ========================= */
  const $name = $('input[name="name"]');
  const $nameError = $("#name_error");

  function validateName(value) {
    const invalid = /[^a-zA-Z가-힣]/;
    const korean = /^[가-힣]{2,10}$/;
    const english = /^[a-zA-Z]{2,20}$/;

    if (invalid.test(value)) {
      return "숫자, 특수문자, 공백은 입력할 수 없습니다.";
    }

    if (korean.test(value) || english.test(value)) {
      return "";
    }

    return "한글 2~10자 / 영문 2~20자로 입력해주세요.";
  }

  $name.on("input", function () {
    const value = $(this).val().trim();
    const msg = validateName(value);

    if (msg) {
      $nameError.text(msg).removeClass("d-none");
      $(this).addClass("is-invalid");
    } else {
      $nameError.text("").addClass("d-none");
      $(this).removeClass("is-invalid");
    }
  });

  /* =========================
     3. 생년월일 자동 포맷 + 실시간 검증
  ========================= */
  const $birth = $("#birth");
  const $birthError = $("#birth_error");

  $birth.on("input", function () {
    let v = $(this)
      .val()
      .replace(/[^0-9]/g, "");

    if (v.length > 8) v = v.substring(0, 8);

    let formatted = "";

    if (v.length >= 5) {
      formatted =
        v.substring(0, 4) + "-" + v.substring(4, 6) + "-" + v.substring(6, 8);
    } else if (v.length >= 3) {
      formatted = v.substring(0, 4) + "-" + v.substring(4);
    } else {
      formatted = v;
    }

    $(this).val(formatted);

    // 👉 실시간 나이 체크
    const msg = checkAge(formatted);

    if (msg) {
      $birthError.text(msg).removeClass("d-none");
      $(this).addClass("is-invalid");
    } else {
      $birthError.text("").addClass("d-none");
      $(this).removeClass("is-invalid");
    }
  });

  /* =========================
     4. 나이 검증 (만 18세)
  ========================= */
  function checkAge(birth) {
    const today = new Date("2026-04-02");
    const b = new Date(birth);

    if (!/^\d{4}-\d{2}-\d{2}$/.test(birth)) {
      return "생년월일 형식이 올바르지 않습니다.";
    }

    if (isNaN(b.getTime())) {
      return "유효하지 않은 날짜입니다.";
    }

    let age = today.getFullYear() - b.getFullYear();

    const m = today.getMonth() - b.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < b.getDate())) {
      age--;
    }
    const course = Number($('input[name="course"]').val());
    // 👉 Full 코스일 때만 제한
    if (course === 5 && age < 18) {
      return "Full 코스는 만 18세 이상만 참가 가능합니다.";
    }

    return "";
  }

  /* =========================
     성별 검사 (라디오 필수)
  ========================= */
  function validateGender() {
    const gender = $('input[name="gender"]:checked').val();
    if (!gender) {
      return "성별을 선택해주세요.";
    }
    return "";
  }

  /* =========================
     연락처 자동 포맷 (010-0000-0000)
  ========================= */
  const $phone = $("#phone");
  const $phoneError = $("#phone_error");

  $phone.on("input", function () {
    let v = $(this)
      .val()
      .replace(/[^0-9]/g, "");

    if (v.length > 11) v = v.substring(0, 11);

    let formatted = "";

    if (v.length < 4) {
      formatted = v;
    } else if (v.length < 8) {
      formatted = v.substring(0, 3) + "-" + v.substring(3);
    } else {
      formatted =
        v.substring(0, 3) + "-" + v.substring(3, 7) + "-" + v.substring(7, 11);
    }

    $(this).val(formatted);

    const msg = validatePhone(formatted);

    if (msg) {
      $phoneError.text(msg).removeClass("d-none");
      $(this).addClass("is-invalid");
    } else {
      $phoneError.text("").addClass("d-none");
      $(this).removeClass("is-invalid");
    }
  });

  function validatePhone(phone) {
    const reg = /^010-\d{4}-\d{4}$/;
    if (!reg.test(phone)) {
      return "연락처 형식은 010-0000-0000 입니다.";
    }
    return "";
  }

  /* =========================
     이메일 검사
  ========================= */
  const $email = $("#email");
  const $emailError = $("#email_error");

  function validateEmail(email) {
    const reg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!reg.test(email)) {
      return "이메일 형식이 올바르지 않습니다.";
    }
    return "";
  }

  $email.on("input", function () {
    const msg = validateEmail($(this).val().trim());

    if (msg) {
      $emailError.text(msg).removeClass("d-none");
      $(this).addClass("is-invalid");
    } else {
      $emailError.text("").addClass("d-none");
      $(this).removeClass("is-invalid");
    }
  });

  /* =========================
     기념품 사이즈 필수 선택
  ========================= */
  function validateSize() {
    const size = $('select[name="tshirt_size"]').val();

    if (!size) {
      return "기념품 티셔츠 사이즈를 선택해주세요.";
    }

    return "";
  }

  /* =========================
     최종 제출 검증 (추가됨)
  ========================= */
  $('button:contains("신청 완료")').on("click", function () {
    const name = $name.val().trim();
    const birth = $birth.val().trim();
    const phone = $phone.val().trim();
    const email = $email.val().trim();

    // 이름
    const nameMsg = validateName(name);
    if (nameMsg) {
      alert(nameMsg);
      $name.focus();
      return false;
    }

    // 성별
    const genderMsg = validateGender();
    if (genderMsg) {
      alert(genderMsg);
      return false;
    }

    // 생년월일 + 나이
    const birthMsg = checkAge(birth);
    if (birthMsg) {
      alert(birthMsg);
      $birth.addClass("is-invalid").focus();
      return false;
    }

    // 연락처
    const phoneMsg = validatePhone(phone);
    if (phoneMsg) {
      alert(phoneMsg);
      $phone.addClass("is-invalid").focus();
      return false;
    }

    // 이메일
    const emailMsg = validateEmail(email);
    if (emailMsg) {
      alert(emailMsg);
      $email.addClass("is-invalid").focus();
      return false;
    }

    // 사이즈
    const sizeMsg = validateSize();
    if (sizeMsg) {
      alert(sizeMsg);
      $('select[name="tshirt_size"]').focus();
      return false;
    }

    alert("검증 완료 → 다음 단계 진행");

    // $('form').submit();
  });
});
