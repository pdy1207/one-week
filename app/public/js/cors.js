$(document).ready(function () {
  const $list = $("#course_list");
  const $total = $("#total_price");

  // 코스 불러오기
  function loadCourses() {
    $.ajax({
      url: "/api/courses.php",
      type: "GET",
      dataType: "json",
      success: function (res) {
        let html = "";

        res.data.forEach((c) => {
          const remaining = c.max_participants - c.registered;
          const isFull = remaining <= 0;

          html += `
            <div class="col-6">
              <input type="radio"
                     class="btn-check course-radio"
                     name="course"
                     id="course${c.id}"
                     value="${c.id}"
                     data-price="${c.price}"
                     ${isFull ? "disabled" : ""}>

              <label class="btn w-100 p-3 ${isFull ? "btn-secondary" : "btn-outline-primary"}"
                     for="course${c.id}">
                     
                <div class="fw-bold">${c.name}</div>

                <small>${remaining} / ${c.max_participants} 남음</small><br>

                <small>${Number(c.price).toLocaleString()}원</small>

                ${isFull ? `<div class="badge bg-danger mt-2">접수 마감</div>` : ""}
              </label>
            </div>
          `;
        });

        $list.html(html);
      },
    });
  }

  // 가격 업데이트
  function updatePrice() {
    let price = 0;

    const selected = $(".course-radio:checked");

    if (selected.length > 0) {
      price = parseInt(selected.data("price"));
    }

    $total.text(price.toLocaleString() + "원");
  }

  // 이벤트 (동적 생성이니까 이렇게)
  $(document).on("change", ".course-radio", function () {
    updatePrice();
  });

  // 버튼
  $("#btn_next").on("click", function () {
    const selected = $(".course-radio:checked");

    if (selected.length === 0) {
      alert("코스를 선택해주세요.");
      return;
    }

    $("#f_course").submit();
  });

  // 실행
  loadCourses();
});
