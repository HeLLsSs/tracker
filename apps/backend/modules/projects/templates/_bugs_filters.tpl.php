<div class="panel panel-default search-filters">
    <form class="panel-body form-inline" method="post" action="<?php 
        echo CITRUS_PROJECT_URL . $cos->app->name ?>/projects/<?php echo $res->id ?>/view">
        <fieldset>
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
        <fieldset>
            <legend>Statut</legend>
            <div class="form-group">
                <label for="status_<?php echo \core\tkr\Ticket::STATUS_WAITING ?>">
                    <input type="checkbox" 
                        name="status[]" 
                        value="<?php echo \core\tkr\Ticket::STATUS_WAITING ?>"
                        id="status_<?php echo \core\tkr\Ticket::STATUS_WAITING ?>">
                    En attente
                </label>
            </div>
            <div class="form-group">
                <label for="status_<?php echo \core\tkr\Ticket::STATUS_ASSIGNED ?>">
                    <input type="checkbox" 
                        name="status[]" 
                        value="<?php echo \core\tkr\Ticket::STATUS_ASSIGNED ?>"
                        id="status_<?php echo \core\tkr\Ticket::STATUS_ASSIGNED ?>">
                    En cours
                </label>
            </div>
            <div class="form-group">
                <label for="status_<?php echo \core\tkr\Ticket::STATUS_CLIENT_WAITING ?>">
                    <input type="checkbox" 
                        name="status[]" 
                        value="<?php echo \core\tkr\Ticket::STATUS_CLIENT_WAITING ?>"
                        id="status_<?php echo \core\tkr\Ticket::STATUS_CLIENT_WAITING ?>">
                    En attente de retour client
                </label>
            </div>
            <div class="form-group">
                <label for="status_<?php echo \core\tkr\Ticket::STATUS_FIXED ?>">
                    <input type="checkbox" 
                        name="status[]" 
                        value="<?php echo \core\tkr\Ticket::STATUS_FIXED ?>"
                        id="status_<?php echo \core\tkr\Ticket::STATUS_FIXED ?>">
                    Résolu
                </label>
            </div>
            <div class="form-group">
                <label for="status_<?php echo \core\tkr\Ticket::STATUS_ABORTED ?>">
                    <input type="checkbox" 
                        name="status[]" 
                        value="<?php echo \core\tkr\Ticket::STATUS_ABORTED ?>"
                        id="status_<?php echo \core\tkr\Ticket::STATUS_ABORTED ?>">
                    Abandonné
                </label>
            </div>
        </fieldset>
        <fieldset>
            <legend>Type</legend>
            <div class="form-group">
                <label for="type_<?php echo \core\tkr\Ticket::TYPE_BUG ?>">
                    <input type="checkbox" 
                        name="type[]" 
                        value="<?php echo \core\tkr\Ticket::TYPE_BUG ?>"
                        id="type_<?php echo \core\tkr\Ticket::TYPE_BUG ?>">
                    Anomalie
                </label>
            </div>
            <div class="form-group">
                <label for="type_<?php echo \core\tkr\Ticket::TYPE_TASK ?>">
                    <input type="checkbox" 
                        name="type[]" 
                        value="<?php echo \core\tkr\Ticket::TYPE_TASK ?>"
                        id="type_<?php echo \core\tkr\Ticket::TYPE_TASK ?>">
                    Tâche
                </label>
            </div>
            <div class="form-group">
                <label for="type_<?php echo \core\tkr\Ticket::TYPE_IMPROVM ?>">
                    <input type="checkbox" 
                        name="type[]" 
                        value="<?php echo \core\tkr\Ticket::TYPE_IMPROVM ?>"
                        id="type_<?php echo \core\tkr\Ticket::TYPE_IMPROVM ?>">
                    Amélioration
                </label>
            </div>
            <div class="form-group">
                <label for="type_<?php echo \core\tkr\Ticket::TYPE_REQUEST ?>">
                    <input type="checkbox" 
                        name="type[]" 
                        value="<?php echo \core\tkr\Ticket::TYPE_REQUEST ?>"
                        id="type_<?php echo \core\tkr\Ticket::TYPE_REQUEST ?>">
                    Requête
                </label>
            </div>
        </fieldset>

        <fieldset>
            <legend>Priorité</legend>
            <div class="form-group">
                <label for="priority_<?php echo \core\tkr\Ticket::PRIORITY_NORMAL ?>">
                    <input type="checkbox" 
                        name="priority[]" 
                        value="<?php echo \core\tkr\Ticket::PRIORITY_NORMAL ?>"
                        id="priority_<?php echo \core\tkr\Ticket::PRIORITY_NORMAL ?>">
                    Normal
                </label>
            </div>
            <div class="form-group">
                <label for="priority_<?php echo \core\tkr\Ticket::PRIORITY_URGENT ?>">
                    <input type="checkbox" 
                        name="priority[]" 
                        value="<?php echo \core\tkr\Ticket::PRIORITY_URGENT ?>"
                        id="priority_<?php echo \core\tkr\Ticket::PRIORITY_URGENT ?>">
                    Urgent
                </label>
            </div>
            <div class="form-group">
                <label for="priority_<?php echo \core\tkr\Ticket::PRIORITY_BLOCKING ?>">
                    <input type="checkbox" 
                        name="priority[]" 
                        value="<?php echo \core\tkr\Ticket::PRIORITY_BLOCKING ?>"
                        id="priority_<?php echo \core\tkr\Ticket::PRIORITY_BLOCKING ?>">
                    Bloquant
                </label>
            </div>
        </fieldset>
    </form>
</div> 