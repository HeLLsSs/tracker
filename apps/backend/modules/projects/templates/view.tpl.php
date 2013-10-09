<div data-role="page" id="tkr-view-project">
    <div>
        <ol class="breadcrumb hidden-xs">
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
        <div class="navbar">
            <h1 class="pull-left">
                <?php echo $res->name ?>
                <small class="xs"><?php echo $res->getStatus() ?></small>
            </h1>
            <div class="pull-right">
                <a class="btn btn-success btn-sm" href="<?php 
                    echo CITRUS_PROJECT_URL . $cos->app->name 
                ?>/projects/<?php echo $res->id ?>/new-ticket">
                    <span class="visible-xs">
                        <i class="icon-plus-sign"></i>
                    </span>
                    <span class="hidden-xs">
                        <i class="icon-plus-sign"></i> Créer un ticket
                    </span>
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php if ( $res->description && $has_any_url ) { ?>
            <div class="row">
                <div class="<?php echo $has_any_url ? 'col-lg-9' : 'col-lg-12' ?>">
                    <strong>Description</strong>
                    <div class="well">
                        <?php echo $res->description != '' ? $res->description : "Pas de description."  ?>
                    </div>
                </div>
                <div class="col-lg-3">
                    <?php if ( $res->url_dev != '' ) { ?>
                        <a class="btn btn-link" href="<?php echo $res->url_dev ?>">
                            <i class="icon-external-link"></i>
                            Site de développement
                        </a>
                    <?php } ?>
                    <?php if ( $res->url_preprod != '' ) { ?>
                        <a class="btn btn-link" href="<?php echo $res->url_preprod ?>">
                            <i class="icon-external-link"></i>
                            Site de pré-production
                        </a>
                    <?php } ?>
                    <?php if ( $res->url_prod != '' ) { ?>
                        <a class="btn btn-link" href="<?php echo $res->url_prod ?>">
                            <i class="icon-external-link"></i>
                            Site de production
                        </a>
                    <?php } ?>
                </div>
            </div>
            <hr>
        <?php } ?>
        <div id="projet-panel" class="row">
            <div class="col-lg-3 col-md-3 col-xs-12">
                <?php include_slice( 'tickets_filters', array( 
                    'res'        => $res,
                    'statuses'   => $statuses,
                    'types'      => $types,
                    'priorities' => $priorities,
                ) )  ?>
            </div>
            <div class="col-lg-9 col-md-9 col-xs-12">
                <div id="bugs-list">
                    <?php
                        include_slice( 'tickets_list', array(
                            'schema_tkt' => $schema_tkt,
                            'tickets'    => $tickets,
                            'pager'      => $pager,
                            'search'     => $search,
                            'order'      => $order,
                            'orderType'  => $orderType,
                        ) );
                    ?>
                </div>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>
</div>