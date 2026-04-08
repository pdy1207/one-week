$(document).ready(function () {
  $("#phone").on("input", function () {
    let value = $(this)
      .val()
      .replace(/[^0-9]/g, "");

    if (value.length < 4) {
      $(this).val(value);
    } else if (value.length < 8) {
      $(this).val(value.slice(0, 3) + "-" + value.slice(3));
    } else {
      $(this).val(
        value.slice(0, 3) + "-" + value.slice(3, 7) + "-" + value.slice(7, 11),
      );
    }
  });

  $("#name, #phone").on("keydown", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      $("#btn_search").click();
    }
  });

  $("#btn_search").on("click", function () {
    const name = $("#name").val();
    const phone = $("#phone").val().replace(/-/g, "");

    // 이름 검증
    const nameError = (function (val) {
      const korean = /^[가-힣]{2,10}$/;
      const english = /^[a-zA-Z]{2,20}$/;
      if (!val) return "이름을 입력해주세요.";
      if (korean.test(val) || english.test(val)) return "";
      return "한글 2~10자 또는 영문 2~20자로 입력해주세요 (공백/숫자 불가).";
    })(name);

    if (nameError) {
      alert(nameError);
      $("#name").focus();
      return;
    }

    const phoneWithHyphen = $("#phone").val();

    // 전화번호 검증
    const phoneError = (function (val) {
      const reg = /^010-\d{4}-\d{4}$/;
      if (!val) return "전화번호를 입력해주세요.";
      if (!reg.test(val)) return "연락처 형식은 010-0000-0000 입니다.";
      return "";
    })(phoneWithHyphen);

    if (phoneError) {
      alert(phoneError);
      $("#phone").focus();
      return;
    }

    // 기존 결과 숨기고 스켈레톤 표시
    $("#result").html("");
    $("#skeleton").removeClass("d-none");
    // $("#loading").removeClass("d-none"); // 기존 로딩 ui

    const delay = Math.floor(Math.random() * 1000) + 2000;

    setTimeout(function () {
      $.ajax({
        url: "/api/get_registration.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({ name: name, phone: phone }),
        success: function (res) {
          $("#skeleton").addClass("d-none");
          // $("#loading").addClass("d-none"); // 기존 로딩 ui

          if (!res.data) {
            $("#result").html(`
              <div class="alert alert-danger text-center">
                조회 결과가 없습니다.
              </div>
            `);
            return;
          }

          function format_phone_js(phone) {
            if (!phone) return "";
            const clean = phone.replace(/[^0-9]/g, "");
            if (clean.length === 11) {
              return clean.replace(/(\d{3})(\d{4})(\d{4})/, "$1-$2-$3");
            } else if (clean.length === 10) {
              return clean.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3");
            }
            return phone;
          }

          const d = res.data;

          $("#result").html(`
              <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                  <div class="bg-primary text-white p-3">
                      <h4 class="mb-0 fw-bold">참가 정보</h4>
                  </div>
                  <div class="card-body">
                      <div class="d-flex justify-content-between mb-2">
                          <span class="text-muted">참가번호</span>
                          <strong class="text-primary">${d.participant_code}</strong>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                          <span class="text-muted">이름</span>
                          <strong>${d.name}</strong>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                          <span class="text-muted">전화번호</span>
                          <strong>${format_phone_js(d.phone)}</strong>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                          <span class="text-muted">코스</span>
                          <div>${getCourseBadge(d.course_id)}</div>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                          <span class="text-muted">기념품 사이즈</span>
                          <strong>${d.size}</strong>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                          <span class="text-muted">결제 상태</span>
                          <span class="badge ${d.pay_complete == 1 ? "bg-success" : "bg-danger"}">
                              ${d.pay_complete == 1 ? "완료" : "미완료"}
                          </span>
                      </div>
                      <hr>
                      <div class="small text-muted d-flex justify-content-between">
                          <div>주소</div>
                          <div class="text-end">
                              <span class="d-block">[${d.zipcode}]</span>
                              ${d.addr1} ${d.addr2}
                          </div>
                      </div>
                      <div class="small text-muted mt-2 d-flex justify-content-between">
                          등록일
                          <div>${d.created_at}</div>
                      </div>
                      <hr>
                      <div class="d-flex justify-content-between mb-2">
                          <span class="small text-muted">개인정보 수집 동의</span>${getAgreeBadge(d.agree_info)}
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                          <span class="small text-muted">러닝 대회 참가 동의</span>${getAgreeBadge(d.agree_rally)}
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                          <span class="small text-muted">이벤트/마케팅 동의</span>${getAgreeBadge(d.agree_market)}
                      </div>
                  </div>
              </div>
          `);
        },
        error: function () {
          $("#skeleton").addClass("d-none");
          $("#result").html(`
            <div class="alert alert-danger text-center">
              서버 오류 발생
            </div>
          `);
        },
      });
    }, delay);
  });
});
function getCourseBadge(course_id) {
  switch (parseInt(course_id)) {
    case 1:
      return `<span class="badge bg-info px-3 py-2">5km</span>
              <span class="badge bg-light text-dark border ms-2">가족 러닝</span>`;
    case 2:
      return `<span class="badge bg-primary px-3 py-2">10km</span>
              <span class="badge bg-light text-dark border ms-2">일반 코스</span>`;
    case 4:
      return `<span class="badge bg-warning text-dark px-3 py-2">21km</span>
              <span class="badge bg-light text-dark border ms-2">Half</span>`;
    case 5:
      return `<span class="badge bg-danger px-3 py-2">42km</span>
              <span class="badge bg-light text-dark border ms-2">Full 코스</span>`;
    default:
      return `<span class="badge bg-secondary">알 수 없음</span>`;
  }
}

function formatDate(dateString) {
  const date = new Date(dateString);

  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");
  const hour = String(date.getHours()).padStart(2, "0");
  const min = String(date.getMinutes()).padStart(2, "0");

  return `${year}-${month}-${day} ${hour}:${min}`;
}
function getAgreeBadge(val) {
  if (val == 1) {
    return `<span class="badge bg-success px-3 py-2">동의</span>`;
  } else {
    return `<span class="badge bg-secondary px-3 py-2">미동의</span>`;
  }
}
