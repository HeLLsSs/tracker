<div class="panel panel-default" id="ticket-status">
    <!-- <div class="panel-heading"></div> -->
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
                <p>
                    <strong>Créé le <?php echo $res->datecreated->format( 'd/m/Y à H:i' ) ?></strong>
                    <br>
                    <?php if ( $cos->user->id == $res->author->id ) { ?>
                        <a class="btn btn-primary btn-xs" href="<?php
                            echo $cos->app->getControllerUrl() . $res->id . '/edit';
                         ?>">Modifier</a>
                    <?php } ?>
                </p>
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
                <form action="" method="post">
                    <?php if ( $cos->user->isadmin ) { ?>
                        <div class="form-group">
                            <label for="developer_id" 
                                class="control-label">
                                Assigné à : 
                                <div class="btn-group">
                                    <button id="dev-btn" 
                                        class="btn btn-xs btn-default dropdown-toggle" 
                                        data-toggle="dropdown">
                                        <span><?php 
                                            echo $res->developer->id ? 
                                                $res->developer->id == $cos->user->id ?
                                                    'Moi' : 
                                                    $res->developer 
                                                : 'Non assigné'; ?></span> 
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dev-changer" role="menu">
                                        <?php foreach ( $devs as $k => $v ) { ?>
                                            <li>
                                                <a href="<?php 
                                                    echo CITRUS_PROJECT_URL . 
                                                         $cos->app->name . 
                                                         '/tickets/' . 
                                                         $res->id . 
                                                         '/dev/' . $v->id
                                                    ?>"<?php if ( $v->id == $res->developer->id ) echo ' class="active"' ?>>
                                                    <?php echo $v->id == $cos->user->id ? 'Moi' : $v ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </label>
                            
                        </div>
                    <?php } else { ?>
                        <p><strong>Assigné à :</strong> <?php echo $res->developer ?></p>
                    <?php } ?>
                </form>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9">
                <p><strong>Description :</strong></p>
                <div id="ticket-description">
                    <div class="well well-sm">
                        <?php echo $res->description != '' ? $res->description : 'Pas de description.' ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="panel-footer">
        
        <div class="btn-group" id="status-switch">
            <?php if ( !$res->developer_id ) { ?>
                <p>Statut : <?php echo $res->getStatus() ?></p> 
            <?php } else include_slice( 'status_switch', Array(
                'res' => $res,
            ) ) ?>
        </div>
        
    </div>
</div>