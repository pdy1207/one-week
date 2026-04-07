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
                                data-desc="${c.description}"
                                ${isFull ? "disabled" : ""}>

                        <label class="btn w-100 p-3 ${isFull ? "btn-secondary" : "btn-outline-primary"}"
                                for="course${c.id}">
                                
                            <div class="fw-bold d-flex align-items-center gap-2">
                            ${c.name}
                            ${
                              c.description
                                ? `
                                <span class="badge ${
                                  c.description === "가족 러닝"
                                    ? "bg-success"
                                    : c.description === "일반 코스"
                                      ? "bg-primary"
                                      : c.description === "Half 코스"
                                        ? "bg-warning"
                                        : c.description === "Full 코스"
                                          ? "bg-danger"
                                          : "bg-secondary"
                                }">
                                ${c.description}
                                </span>
                            `
                                : ""
                            }
                            </div>

                            <small>잔여 수량 : ${remaining} / ${c.max_participants}</small><br>

                            <small>참가 비 : ${Number(c.price).toLocaleString()}원</small>

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

  // 취소 버튼
  $("#btn_cancel").on("click", function () {
    window.location.href = "./";
  });

  // 실행
  loadCourses();
});
