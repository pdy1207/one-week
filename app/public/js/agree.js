$(document).ready(function () {
    const $all = $('#checkAll');
    const $items = $('.agree-item');

    // 전체 동의 클릭
    $all.on('change', function () {
        $items.prop('checked', $(this).is(':checked'));
    });

    // 개별 체크 → 전체동의 자동 체크/해제
    $items.on('change', function () {
        const total = $items.length;
        const checked = $items.filter(':checked').length;

        $all.prop('checked', total === checked);
    });
    // 취소 버튼
    $('#btn_cancel').on('click', function () {
        window.location.href = './';
    });
    // 가입 버튼
    $('#btn_member').on('click', function () {
        // 필수 체크
        if (!$('#check1').is(':checked') || !$('#check2').is(':checked')) {
            alert('필수 약관에 동의해주세요.');
            return false;
        }

        // 값 세팅
        $('#agree_rally').val($('#check1').is(':checked') ? 1 : 0);
        $('#agree_info').val($('#check2').is(':checked') ? 1 : 0);
        $('#agree_market').val($('#check3').is(':checked') ? 1 : 0);

        // 전송
        $("form[name='agree_form']").submit();
    });
});
