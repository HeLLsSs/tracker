<div class="panel panel-default search-filters">
    <div class="visible-sm visible-xs panel-heading">
    <button type="button" class="btn btn-default btn-wide" data-toggle="collapse" data-target=".filters-check">
        <i class="icon-filter"></i>
        Filtres
    </button>
    </div>
    <form class=" panel-body form-inline filters-check visible-lg visible-md" method="post" action="<?php 
        echo CITRUS_PROJECT_URL . $cos->app->name ?>/projects/<?php echo $res->id ?>/view">
        <div class="row">
            <fieldset class="col-lg-12 col-sm-12">
                <div class="form-group">
                    <input type="text" 
                        name="search" 
                        id="search" 
                        value="" 
                        class="form-control" 
                        placeholder="Rechercher" 
                        autocomplete="off" />
                </div>

            
            </fieldset>
        </div>
        <div class="row">
            <fieldset class="col-lg-12 col-sm-4 col-md-12">
                <legend>Statut</legend>
                <div class="form-group">
                    <label for="status_<?php echo \core\tkr\Ticket::STATUS_WAITING ?>">
                        <input type="checkbox" 
                            name="status[]" 
                            value="<?php echo \core\tkr\Ticket::STATUS_WAITING ?>"
                            id="status_<?php echo \core\tkr\Ticket::STATUS_WAITING ?>"
                            <?php if ( in_array( \core\tkr\Ticket::STATUS_WAITING, $statuses ) )
                                echo 'checked="checked"';
                            ?>>
                        En attente
                    </label>
                </div>
                <div class="form-group">
                    <label for="status_<?php echo \core\tkr\Ticket::STATUS_ASSIGNED ?>">
                        <input type="checkbox" 
                            name="status[]" 
                            value="<?php echo \core\tkr\Ticket::STATUS_ASSIGNED ?>"
                            id="status_<?php echo \core\tkr\Ticket::STATUS_ASSIGNED ?>"
                            <?php if ( in_array( \core\tkr\Ticket::STATUS_ASSIGNED, $statuses ) )
                                echo 'checked="checked"';
                            ?>>
                        En cours
                    </label>
                </div>
                <div class="form-group">
                    <label for="status_<?php echo \core\tkr\Ticket::STATUS_CLIENT_WAITING ?>">
                        <input type="checkbox" 
                            name="status[]" 
                            value="<?php echo \core\tkr\Ticket::STATUS_CLIENT_WAITING ?>"
                            id="status_<?php echo \core\tkr\Ticket::STATUS_CLIENT_WAITING ?>"
                            <?php if ( in_array( \core\tkr\Ticket::STATUS_CLIENT_WAITING, $statuses ) )
                                echo 'checked="checked"';
                            ?>>
                        En attente de retour client
                    </label>
                </div>
                <div class="form-group">
                    <label for="status_<?php echo \core\tkr\Ticket::STATUS_FIXED ?>">
                        <input type="checkbox" 
                            name="status[]" 
                            value="<?php echo \core\tkr\Ticket::STATUS_FIXED ?>"
                            id="status_<?php echo \core\tkr\Ticket::STATUS_FIXED ?>"
                            <?php if ( in_array( \core\tkr\Ticket::STATUS_FIXED, $statuses ) )
                                echo 'checked="checked"';
                            ?>>
                        Résolu
                    </label>
                </div>
                <div class="form-group">
                    <label for="status_<?php echo \core\tkr\Ticket::STATUS_ABORTED ?>">
                        <input type="checkbox" 
                            name="status[]" 
                            value="<?php echo \core\tkr\Ticket::STATUS_ABORTED ?>"
                            id="status_<?php echo \core\tkr\Ticket::STATUS_ABORTED ?>"
                            <?php if ( in_array( \core\tkr\Ticket::STATUS_ABORTED, $statuses ) )
                                echo 'checked="checked"';
                            ?>>
                        Abandonné
                    </label>
                </div>
            </fieldset>
            <fieldset class="col-lg-12 col-sm-4 col-md-12">
                <legend>Type</legend>
                <div class="form-group">
                    <label for="type_<?php echo \core\tkr\Ticket::TYPE_BUG ?>">
                        <input type="checkbox" 
                            name="type[]" 
                            value="<?php echo \core\tkr\Ticket::TYPE_BUG ?>"
                            id="type_<?php echo \core\tkr\Ticket::TYPE_BUG ?>"
                            <?php if ( in_array( \core\tkr\Ticket::TYPE_BUG, $types ) )
                                echo 'checked="checked"';
                            ?>>
                        Anomalie
                    </label>
                </div>
                <div class="form-group">
                    <label for="type_<?php echo \core\tkr\Ticket::TYPE_TASK ?>">
                        <input type="checkbox" 
                            name="type[]" 
                            value="<?php echo \core\tkr\Ticket::TYPE_TASK ?>"
                            id="type_<?php echo \core\tkr\Ticket::TYPE_TASK ?>"
                            <?php if ( in_array( \core\tkr\Ticket::TYPE_TASK, $types ) )
                                echo 'checked="checked"';
                            ?>>
                        Tâche
                    </label>
                </div>
                <div class="form-group">
                    <label for="type_<?php echo \core\tkr\Ticket::TYPE_IMPROVM ?>">
                        <input type="checkbox" 
                            name="type[]" 
                            value="<?php echo \core\tkr\Ticket::TYPE_IMPROVM ?>"
                            id="type_<?php echo \core\tkr\Ticket::TYPE_IMPROVM ?>"
                            <?php if ( in_array( \core\tkr\Ticket::TYPE_IMPROVM, $types ) )
                                echo 'checked="checked"';
                            ?>>
                        Amélioration
                    </label>
                </div>
                <div class="form-group">
                    <label for="type_<?php echo \core\tkr\Ticket::TYPE_REQUEST ?>">
                        <input type="checkbox" 
                            name="type[]" 
                            value="<?php echo \core\tkr\Ticket::TYPE_REQUEST ?>"
                            id="type_<?php echo \core\tkr\Ticket::TYPE_REQUEST ?>"
                            <?php if ( in_array( \core\tkr\Ticket::TYPE_REQUEST, $types ) )
                                echo 'checked="checked"';
                            ?>>
                        Requête
                    </label>
                </div>
            </fieldset>

            <fieldset class="col-lg-12 col-sm-4 col-md-12">
                <legend>Priorité</legend>
                <div class="form-group">
                    <label for="priority_<?php echo \core\tkr\Ticket::PRIORITY_NORMAL ?>">
                        <input type="checkbox" 
                            name="priority[]" 
                            value="<?php echo \core\tkr\Ticket::PRIORITY_NORMAL ?>"
                            id="priority_<?php echo \core\tkr\Ticket::PRIORITY_NORMAL ?>"
                            <?php if ( in_array( \core\tkr\Ticket::PRIORITY_NORMAL, $priorities ) )
                                echo 'checked="checked"';
                            ?>>
                        Normal
                    </label>
                </div>
                <div class="form-group">
                    <label for="priority_<?php echo \core\tkr\Ticket::PRIORITY_URGENT ?>">
                        <input type="checkbox" 
                            name="priority[]" 
                            value="<?php echo \core\tkr\Ticket::PRIORITY_URGENT ?>"
                            id="priority_<?php echo \core\tkr\Ticket::PRIORITY_URGENT ?>"
                            <?php if ( in_array( \core\tkr\Ticket::PRIORITY_URGENT, $priorities ) )
                                echo 'checked="checked"';
                            ?>>
                        Urgent
                    </label>
                </div>
                <div class="form-group">
                    <label for="priority_<?php echo \core\tkr\Ticket::PRIORITY_BLOCKING ?>">
                        <input type="checkbox" 
                            name="priority[]" 
                            value="<?php echo \core\tkr\Ticket::PRIORITY_BLOCKING ?>"
                            id="priority_<?php echo \core\tkr\Ticket::PRIORITY_BLOCKING ?>"
                            <?php if ( in_array( \core\tkr\Ticket::PRIORITY_BLOCKING, $priorities ) )
                                echo 'checked="checked"';
                            ?>>
                        Bloquant
                    </label>
                </div>
            </fieldset>
        </div>
    </form>
</div> 