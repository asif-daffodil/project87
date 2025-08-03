<?php
require_once('./header.php');
?>
<div class="container-fluid">
    <div class="row vh-100 overflow-hidden position-relative flex p-0">
        <?php
            require_once('./navbar.php'); 
        ?>
        <div class="col-12 d-flex p-0 gap-4">
            <div class="bg-dark text-white px-3 overflow-y-scroll flex-shrink-0 py-5" style="width: 260px;">
                <?php require_once('./sidebar.php'); ?>
            </div>
            <div class="flex-grow-1 overflow-y-scroll">
                
            </div>
            <?php
            require_once('./footer.php');
            ?>
        </div>
    </div>
</div>