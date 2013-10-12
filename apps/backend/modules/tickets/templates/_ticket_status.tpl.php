<div id="ticket-status">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3">
            <div class="btn-group form-group" id="status-switch">
                <?php if ( !$res->developer_id ) { ?>
                    <p>Statut : <?php echo $res->getStatus() ?></p> 
                <?php } else include_slice( 'status_switch', Array(
                    'res' => $res,
                ) ) ?>
            </div>
            <?php include_slice( 'ticket_assign', Array( 
                'res' => $res,
                'devs' => $devs,
            ) ) ?>

            <p>
                <strong>Auteur :</strong> <?php echo $res->author ?>
            </p>
            <p>
                <strong>Type :</strong>
                <?php echo $res->getType() ?>
            </p>
            <p>
                <strong>Priorité :</strong>
                <?php 
                    switch ( (int) $res->priority ) {
                        case \core\tkr\Ticket::PRIORITY_NORMAL:
                            $label_class = ' label-default';
                            break;
                        case \core\tkr\Ticket::PRIORITY_URGENT:
                            $label_class = ' label-warning';
                            break;
                        case \core\tkr\Ticket::PRIORITY_BLOCKING:
                            $label_class = ' label-danger';
                            break;
                        default:
                            $label_class = ' label-default';
                            break;
                    }
                    echo '<span class="label' . $label_class . '">' . $res->getPriority() . '</span>';
                ?>
            </p>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9">
            <div id="ticket-description">
                <p><strong>Description :</strong></p>
                <div class="well well-sm">
                    <?php echo $res->description != '' ? $res->description : 'Pas de description.' ?>
                </div>
                <?php if ( $cos->user->id == $res->author->id ) { ?>
                    <div class="form-group pull-right">
                        <a class="btn btn-xs btn-primary btn-wide" href="<?php
                            echo $cos->app->getControllerUrl() . $res->id . '/edit';
                         ?>">Modifier</a>
                    </div>
                    <div class="clearfix"></div>
                <?php } ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 pull-right">
            <div id="comments-list">
                <?php include_slice( 'comments', Array( 'comments' => $res->comments ) ) ?>
            </div>
            <form method="post" id="add-comment" action="<?php echo CITRUS_PROJECT_URL . $cos->app->name ?>/comments/save">
                <label for="comment-content">Ajouter un commentaire</label>
                <div class="form-group">
                    <textarea name="content" id="comment-content" class="no-resize"></textarea>
                    <input type="hidden" name="author_id" value="<?php echo $cos->user->id ?>">
                    <input type="hidden" name="ticket_id" value="<?php echo $res->id ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm pull-right btn-default">Ajouter</button>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>