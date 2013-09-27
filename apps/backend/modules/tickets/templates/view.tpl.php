<div data-role="page" id="tkr-view-ticket" class="container">
    <div>
        <ol class="breadcrumb hidden-xs">
            <li><a href="<?php echo CITRUS_PROJECT_URL . $cos->app->name ?>/">Accueil</a></li>
            <li><a href="<?php 
                echo CITRUS_PROJECT_URL . $cos->app->name . '/projects'
            ?>/">Projets</a></li>
            <li><a href="<?php 
                echo CITRUS_PROJECT_URL . $cos->app->name . '/projects/' . $res->project->id . '/view'
            ?>"><?php echo $res->project->name ?></a></li>
            <li>
                <?php echo $res->title ?>
            </li>
        </ol>
        <div class="back-btn visible-xs">
            <a class="btn btn-default btn-xs" href="<?php 
                echo CITRUS_PROJECT_URL . $cos->app->name . '/projects/' . $res->project->id . '/view'
            ?>">
                <i class="icon-caret-left"></i> <?php echo $res->project->name ?>
            </a>
        </div>
        <div id="projet-panel">
            <h1>
                <?php echo $res->title ?>
            </h1>
             <?php include_slice( 'ticket_status', array( 
                'res' => $res,
                'devs' => $devs,
                'schema' => $schema
            ) ) ?>
        </div>
    </div>
    <div class="merci-ie"></div>
</div>
