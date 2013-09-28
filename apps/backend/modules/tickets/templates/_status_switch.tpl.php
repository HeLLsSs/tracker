<?php
    switch ($res->status) {
        case \core\tkr\Ticket::STATUS_WAITING:
            $btn_class = 'btn-danger';
            break;
        case \core\tkr\Ticket::STATUS_ASSIGNED:
            $btn_class = 'btn-info';
            break;
        case \core\tkr\Ticket::STATUS_CLIENT_WAITING:
            $btn_class = 'btn-warning';
            break;
        case \core\tkr\Ticket::STATUS_FIXED:
            $btn_class = 'btn-success';
            break;
        case \core\tkr\Ticket::STATUS_ABORTED:
            $btn_class = 'btn-danger';
            break;
        default:
            $btn_class = '';
            break;
    }
 ?><button id="status-btn" class="btn btn-sm <?php echo $btn_class ?> dropdown-toggle" data-toggle="dropdown">
    <span>Statut : <?php echo $res->getStatus() ?></span> 
    <span class="caret"></span>
</button>
<ul class="dropdown-menu status-changer" role="menu">
    <?php foreach ( \core\tkr\Ticket::statuses() as $k => $v ) { ?>
        <li>
            <a href="<?php 
                echo CITRUS_PROJECT_URL . 
                     $cos->app->name . 
                     '/tickets/' . 
                     $res->id . 
                     '/status/' . $k 
                ?>"<?php if ( $k == $res->status ) echo ' class="active"' ?>>
                <?php echo $v ?>
            </a>
        </li>
    <?php } ?>
</ul>