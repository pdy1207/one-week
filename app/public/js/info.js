$(document).ready(function () {
  // =========================
  // sessionStorage 불러오기
  // =========================
  const saved = sessionStorage.getItem("applyForm");

  if (saved) {
    const data = JSON.parse(saved);

    $("#name").val(data.name || "");
    $("#birth").val(data.birth || "");
    $("#phone").val(data.phone || "");
    $("#email").val(data.email || "");
    $("#zipcode").val(data.zipcode || "");
    $("#f_adress").val(data.address || "");
    $("#f_adress2").val(data.address2 || "");

    if (data.gender) {
      $(`input[name="gender"][value="${data.gender}"]`).prop("checked", true);
    }

    if (data.tshirt_size) {
      $('select[name="tshirt_size"]').val(data.tshirt_size);
    }
  }

  /* =========================
     코스 정보 불러오기
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
          const name = $("#course_name").val(res.data.name);
          $("#course_des").val(res.data.description);
          const $courseBox = $("#course_des_box");
          const $courseSel = name;
          const desc = res.data.description;

          if (desc.includes("가족 러닝")) {
            $courseBox.addClass("border-success");
            $courseSel.addClass("text-success");
          } else if (desc.includes("일반 코스")) {
            $courseBox.addClass("border-primary");
            $courseSel.addClass("text-primary");
          } else if (desc.includes("Full 코스")) {
            $courseBox.addClass("border-danger");
            $courseSel.addClass("text-danger");
          } else if (desc.includes("Half 코스")) {
            $courseBox.addClass("border-warning");
            $courseSel.addClass("text-warning");
          }
        } else {
          alert("잘못된 접근입니다.");
          sessionStorage.removeItem("applyForm");
          window.location.href = "./";
        }
      },
    });
  }

  /* =========================
     이름 검증
  ========================= */
  const $name = $('input[name="name"]');
  const $nameError = $("#name_error");

  function validateName(value) {
    const invalid = /[^a-zA-Z가-힣]/;
    const korean = /^[가-힣]{2,10}$/;
    const english = /^[a-zA-Z]{2,20}$/;

    if (invalid.test(value))
      return "숫자, 특수문자, 공백은 입력할 수 없습니다.";
    if (korean.test(value) || english.test(value)) return "";
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
     생년월일 자동 포맷 + 실시간 검증
  ========================= */
  const $birth = $("#birth");
  const $birthError = $("#birth_error");

  $birth.on("input", function () {
    let v = $(this)
      .val()
      .replace(/[^0-9]/g, "");
    if (v.length > 8) v = v.substring(0, 8);

    let formatted = "";
    if (v.length >= 5)
      formatted =
        v.substring(0, 4) + "-" + v.substring(4, 6) + "-" + v.substring(6, 8);
    else if (v.length >= 3)
      formatted = v.substring(0, 4) + "-" + v.substring(4);
    else formatted = v;

    $(this).val(formatted);

    const msg = checkAge(formatted);
    if (msg) {
      $birthError.text(msg).removeClass("d-none");
      $(this).addClass("is-invalid");
    } else {
      $birthError.text("").addClass("d-none");
      $(this).removeClass("is-invalid");
    }
  });

  function checkAge(birth) {
    const today = new Date("2026-04-02");
    const b = new Date(birth);

    if (!/^\d{4}-\d{2}-\d{2}$/.test(birth))
      return "생년월일 형식이 올바르지 않습니다.";
    if (isNaN(b.getTime())) return "유효하지 않은 날짜입니다.";

    let age = today.getFullYear() - b.getFullYear();
    const m = today.getMonth() - b.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < b.getDate())) age--;

    const course = Number($('input[name="course"]').val());
    if (course === 5 && age < 18)
      return "Full 코스는 만 18세 이상만 참가 가능합니다.";

    return "";
  }

  /* =========================
     연락처 자동 포맷 + 중복 체크
  ========================= */
  const $phone = $("#phone");
  const $phoneError = $("#phone_error");

  $phone.on("input", function () {
    let v = $(this)
      .val()
      .replace(/[^0-9]/g, "");
    if (v.length > 11) v = v.substring(0, 11);

    let formatted = "";
    if (v.length < 4) formatted = v;
    else if (v.length < 8) formatted = v.substring(0, 3) + "-" + v.substring(3);
    else
      formatted =
        v.substring(0, 3) + "-" + v.substring(3, 7) + "-" + v.substring(7, 11);

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
    if (!reg.test(phone)) return "연락처 형식은 010-0000-0000 입니다.";
    return "";
  }

  /* =========================
     이메일 검사
  ========================= */
  const $email = $("#email");
  const $emailError = $("#email_error");

  function validateEmail(email) {
    const reg = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!reg.test(email)) return "이메일 형식이 올바르지 않습니다.";
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
     티셔츠 사이즈 필수 선택
  ========================= */
  function validateSize() {
    const size = $('select[name="tshirt_size"]').val();
    if (!size) return "기념품 티셔츠 사이즈를 선택해주세요.";
    return "";
  }

  /* =========================
     우편번호 & 주소
  ========================= */
  const $zipcode = $("#zipcode");
  const $address = $("#f_adress");
  const $address2 = $("#f_adress2");

  const $addrError = $(
    '<div class="text-danger small mt-1 d-none" id="addr_error">주소를 모두 입력해주세요.</div>',
  );
  $address.after($addrError);

  $("#btn_zipcode").on("click", function () {
    new daum.Postcode({
      oncomplete: function (data) {
        $zipcode.val(data.zonecode);
        $address.val(data.address);
        $address2.val("");
        $addrError.addClass("d-none");
      },
    }).open();
  });

  /* =========================
     sessionStorage 저장
  ========================= */
  function saveFormSession() {
    const data = {
      name: $("#name").val(),
      birth: $("#birth").val(),
      gender: $('input[name="gender"]:checked').val(),
      phone: $("#phone").val(),
      email: $("#email").val(),
      tshirt_size: $('select[name="tshirt_size"]').val(),
      zipcode: $("#zipcode").val(),
      address: $("#f_adress").val(),
      address2: $("#f_adress2").val(),
    };
    sessionStorage.setItem("applyForm", JSON.stringify(data));
  }

  $("input, select").on("input change", saveFormSession);

  /* =========================
     신청 완료 버튼 (최종 제출 + phone 중복 체크)
  ========================= */
  $('button:contains("정보 입력 완료")').on("click", function (e) {
    e.preventDefault();

    const name = $("#name").val().trim();
    const birth = $("#birth").val().trim();
    const phone = $("#phone").val().trim();
    const email = $("#email").val().trim();
    const gender = $('input[name="gender"]:checked').val();
    const size = $('select[name="tshirt_size"]').val();
    const zipcode = $zipcode.val().trim();
    const addr = $address.val().trim();
    const addr2 = $address2.val().trim();

    // 입력 검증
    const nameMsg = validateName(name);
    if (nameMsg) {
      alert(nameMsg);
      $("#name").focus();
      return false;
    }
    const birthMsg = checkAge(birth);
    if (birthMsg) {
      alert(birthMsg);
      $("#birth").focus();
      return false;
    }
    if (!gender) {
      alert("성별을 선택해주세요.");
      return false;
    }
    const phoneMsg = validatePhone(phone);
    if (phoneMsg) {
      alert(phoneMsg);
      $("#phone").focus();
      return false;
    }
    const emailMsg = validateEmail(email);
    if (emailMsg) {
      alert(emailMsg);
      $("#email").focus();
      return false;
    }
    if (!size) {
      alert("기념품 티셔츠 사이즈를 선택해주세요.");
      $('select[name="tshirt_size"]').focus();
      return false;
    }
    if (!zipcode || !addr || !addr2) {
      alert("주소를 모두 입력해주세요.");
      return false;
    }

    const phone_check = $("#phone").val().trim().replace(/-/g, "");

    // phone 중복 체크
    $.ajax({
      url: "/controller/check_phone.php",
      type: "POST",
      data: { phone: phone_check },
      dataType: "json",
      success: function (res) {
        console.log(res);
        if (res.exists) {
          alert("이미 신청된 전화번호입니다.");
          $("#phone").addClass("is-invalid").focus();
          return false;
        } else {
          $("#phone").removeClass("is-invalid");
          sessionStorage.removeItem("applyForm");
          $("form").submit();
        }
      },
      error: function () {
        sessionStorage.removeItem("applyForm");
        console.error("중복 확인 실패");
      },
    });
  });

  $("#btn_cancel").on("click", function () {
    sessionStorage.removeItem("applyForm");
    window.location.href = "./";
  });
});
