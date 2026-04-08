$(document).ready(function () {
  $.ajax({
    url: "/api/courses.php",
    type: "GET",
    dataType: "json",
    success: function (res) {
      let courses = res.data;
      let html = "";

      // 1. 마감된 코스 뒤로 보내기
      courses.sort((a, b) => {
        const remainingA = a.max_participants - a.registered;
        const remainingB = b.max_participants - b.registered;
        const isFullA = remainingA <= 0;
        const isFullB = remainingB <= 0;

        return isFullA - isFullB;
      });

      courses.forEach((c) => {
        const percent = (c.registered / c.max_participants) * 100;
        const remaining = c.max_participants - c.registered;
        const isFull = remaining <= 0;

        let badgeColor = "success";
        let courseIcon = "👨‍👩‍👧‍👦";
        if (c.description.includes("Full")) {
          badgeColor = "danger";
          courseIcon = "🏆";
        } else if (c.description.includes("Half")) {
          badgeColor = "warning";
          courseIcon = "🏃";
        } else if (c.description.includes("일반")) {
          badgeColor = "primary";
          courseIcon = "👟";
        }

        const progressColor = isFull ? "secondary" : badgeColor;

        // 2. 버튼 클릭 시 이동 경로 추가 및 onclick 이벤트
        html += `
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden course-card ${isFull ? "opacity-75 bg-light" : ""}" 
                  style="transition: all 0.3s ease-in-out;">
                
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <span class="fs-3 me-2">${courseIcon}</span>
                    <h5 class="card-title mb-0 fw-bold text-dark">${c.name}</h5>
                  </div>
                  ${
                    isFull
                      ? `<span class="badge bg-secondary rounded-pill px-3 py-2">모집 마감</span>`
                      : `<span class="badge bg-${badgeColor}-subtle text-${badgeColor} rounded-pill px-3 py-2">${c.description}</span>`
                  }
                </div>

                <div class="card-body d-flex flex-column justify-content-between">
                  <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-end mb-2">
                      <h4 class="fw-extrabold text-primary mb-0">
                        ${Number(c.price).toLocaleString()}<span class="fs-6 text-muted fw-normal">원</span>
                      </h4>
                      <span class="small text-muted">총 ${Number(c.max_participants).toLocaleString()}티켓</span>
                    </div>
                    
                    <p class="card-text text-secondary small mb-0">
                      코스 상세: ${c.description} 마라톤 대회 참가를 위한 접수 티켓입니다.
                    </p>
                  </div>

                  <div>
                    <div class="d-flex justify-content-between align-items-center mb-2 small">
                      <span class="fw-bold ${isFull ? "text-secondary" : "text-dark"}">
                        ${isFull ? "🚫 접수 마감" : `🔥 현재 ${Number(c.registered).toLocaleString()}명 신청 중`}
                      </span>
                      <span class="text-muted">
                        ${isFull ? "0" : Number(remaining).toLocaleString()}석 남음
                      </span>
                    </div>
                    
                    <div class="progress rounded-pill" style="height: 12px; background-color: #e9ecef;">
                      <div class="progress-bar bg-${progressColor} rounded-pill ${!isFull ? "progress-bar-striped progress-bar-animated" : ""}" 
                          role="progressbar" 
                          style="width: ${percent}%">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-footer bg-white border-0 pb-4 pt-0">
                  <button class="btn ${isFull ? "btn-secondary" : "btn-" + badgeColor} w-100 rounded-pill fw-bold" 
                          ${isFull ? "disabled" : `onclick="location.href='./agree.php?id=${c.id}'"`}>
                    ${isFull ? "다음에 만나요 :(" : "지금 바로 신청하기 " + courseIcon}
                  </button>
                </div>
              </div>
            </div>
          `;
      });

      $("#course_list").html(html);
    },
  });
});
