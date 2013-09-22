<div data-role="page" id="tkr-view-project" class="container">
    <div class="row">
        <div class="container">
            <?php if ( isset( $sidebar ) ) include_slice_global( $sidebar ); ?>

            <div<?php if ( isset( $sidebar ) ) echo ' class="col-lg-10"' ?>>
                <ol class="breadcrumb">
                    <li><a href="<?php echo CITRUS_PROJECT_URL . $cos->app->name ?>/">Accueil</a></li>
                    <li>
                        <a href="<?php echo CITRUS_PROJECT_URL . $cos->app->name . '/' . $cos->app->controller->name ?>/"><?php 
                            echo ucfirst( $res->schema->pluralDescription ); 
                        ?></a>
                    </li>
                    <li>
                        <?php echo $res->name ?>
                    </li>
                </ol>
                <h1>
                    <?php echo $res->name ?>
                    <small class="xs"><?php echo $res->getStatus() ?></small>
                    <a class="btn btn-danger btn-xs" href="<?php 
                        echo CITRUS_PROJECT_URL . $cos->app->name 
                    ?>/tickets/create/project/<?php echo $res->id ?>">
                        Créer un ticket
                    </a>
                </h1>
                <div id="projet-panel" class="row">
                    <div class="col-lg-3 col-md-3">
                        <?php include_slice( 'bugs_filters', array( 'res' => $res ) )  ?>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <div id="bugs-list"></div>
                    </div>
                </div>

            </div>
            <div class="merci-ie"></div>
        </div>
    </div>
</div>