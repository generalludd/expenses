<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// modal.php Chris Dart Mar 24, 2015 3:01:49 PM chrisdart@cerebratorium.com

?>
<!-- page/modal /-->

<div class="modal fade" id="my_dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php echo $title; ?></h4>
            </div>
            <div class="modal-body">
                <!--page/modal -->
                <?php $this->load->view($target);?>
            </div>
            <div class="modal-footer"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->