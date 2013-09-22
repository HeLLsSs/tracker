<div data-role="page" id="tkr-view-ticket" class="container">
    <div class="row">
        <div class="container">
            <?php if ( isset( $sidebar ) ) include_slice_global( $sidebar ); ?>

            <div<?php if ( isset( $sidebar ) ) echo ' class="col-lg-10"' ?>>
                <ol class="breadcrumb">
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
                <div id="projet-panel" class="row">
                    <div class="col-lg-3 col-md-3">
                        <?php include_slice( 'ticket_status', array( 
                            'res' => $res,
                            'devs' => $devs,
                            'schema' => $schema
                        ) ) ?>
                    </div>
                    <div class="col-lg-9 col-md-9">
                        <h3>
                            <?php echo $res->title ?>
                        </h3>
                        <div id="ticket-description">
                            <div class="well">
                                <?php echo $res->description ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="merci-ie"></div>
        </div>
    </div>
</div>