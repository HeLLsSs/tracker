<div data-role="page" id="cos-object-form">
    <div>
        <ol class="breadcrumb hidden-xs">
            <li><a href="<?php echo CITRUS_PROJECT_URL . $cos->app->name ?>/">Accueil</a></li>
            <li><a href="<?php 
                echo CITRUS_PROJECT_URL . $cos->app->name . '/projects'
            ?>/">Projets</a></li>
            <li><a href="<?php 
                echo CITRUS_PROJECT_URL . $cos->app->name . '/projects/' . $res->project->id . '/view'
            ?>"><?php echo $res->project->name ?></a></li>
            <li><?php 
                echo ( $res->id ? 'Modifier' : 'Créer' ) ?>
                un ticket
            </li>
        </ol>
        <div class="back-btn visible-xs">
            <a class="btn btn-default btn-xs" href="<?php 
                echo CITRUS_PROJECT_URL . $cos->app->name . '/projects/' . $res->project->id . '/view'
            ?>">
                <i class="icon-caret-left"></i> <?php echo $res->project->name ?>
            </a>
        </div>
        <h1>
            <?php echo $res->id ? 'Modifier' : 'Créer' ?> 
            un<?php echo ( $schema->gender != 'm' ? 'e ' : ' ' ) . $schema->description ?>
        </h1>
        <form class="form-object" action="<?php echo CITRUS_PROJECT_URL . $cos->app->name ?>/tickets/save" method="post" class="form-horizontal">
            <input type="hidden" name="formtype" value="project">
            <input type="hidden" name="status" value="<?php echo \core\tkr\Ticket::STATUS_WAITING ?>">
            <?php echo $form->render() ?>
            <p class="formActions">
                <a class="btn-cancel btn btn-danger" href="/<?php 
                    echo $cos->app->name . '/' . $cos->app->controller->name . '/' . $res->project->id . '/view'
                ?>">Annuler</a>
                <button type="submit" class="btn btn-primary"><?php 
                    echo $res->id ? 'Modifier' : 'Créer'?>
                </button>
            </p>
        </form>
    </div>
    <div class="clearfix"></div>
</div>