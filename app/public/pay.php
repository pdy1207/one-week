<!-- 결제 및 완료 페이지  -->
<?php

    $js_array = ['./js/pay.js'];

    $g_title = '결제 페이지';
    $menu_code = 'agree';
    $course = $_GET['course'] ?? '';

    require './layout/header.php';    
?>



<?php 
    require './layout/footer.php';
?>