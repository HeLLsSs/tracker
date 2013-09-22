<div class="panel panel-default">
    <!-- <div class="panel-heading"></div> -->
    <div class="panel-body">
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
                switch ( $res->priority ) {
                    case \core\tkr\Ticket::PRIORITY_NORMAL:
                        $label_class = ' label-warning';
                        break;
                    case \core\tkr\Ticket::PRIORITY_URGENT:
                        $label_class = ' label-danger';
                        break;
                    default:
                        $label_class = '';
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
                        <?php if ( $res->developer->id ) { ?>
                        Assigné à : <?php echo $res->developer ?>
                        <?php } else { ?>
                            Non assigné
                        <?php } ?>
                    </label>
                    
                </div>
                <!-- <div class="form-group">
                    <label for="developer_id" 
                        class="control-label">
                        Statut :
                    </label>
                    <select name="developer_id" id="developer_id">
                        <?php foreach ( $schema->properties['status']['options'] as $k => $v ) { ?>
                            <?php 
                                $selected = $k == $res->status ? 
                                ' selected="selected"' : 
                                '' 
                            ?><option value="<?php echo $k ?>"<?php echo $selected ?>>
                                <?php echo $v ?>
                            </option>
                        <?php } ?>
                    </select>
                </div> -->
            <?php } ?>
        </form>
    </div>
    <div class="panel-footer">
        <div class="btn-group">
            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                Statut : <?php echo $res->getStatus() ?> 
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu status-changer" role="menu">
                <?php foreach ( \core\tkr\Ticket::statuses() as $k => $v ) { ?>
                    <li>
                        <a href="#"<?php if ( $k == $res->status ) echo ' class="active"' ?>>
                            <?php echo $v ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <select name="developer_id" id="developer_id">
                        <option value="">Non assigné</option>
                        <?php 
                            $selected = $cos->user->id == $res->developer->id ? 
                            ' selected="selected"' : 
                            ''
                        ?><option value="<?php echo $cos->user->id ?>"<?php echo $selected ?>>
                            <?php echo $cos->user ?>
                        </option>
                        <?php foreach ( $devs as $d ) { ?>
                            <?php 
                                $selected = $d->id == $res->developer->id ? 
                                ' selected="selected"' : 
                                ''
                            ?><option value="<?php echo $d->id ?>"<?php echo $selected ?>>
                                <?php echo $d; ?>
                            </option>
                        <?php } ?>
                    </select>
        </div>
    </div>
</div>