<div data-role="page" id="tkr-view-project" class="container">
    <div class="row">
        <!-- <div class="container"> -->
            <?php if ( isset( $sidebar ) ) include_slice_global( $sidebar ); ?>

            <div<?php if ( isset( $sidebar ) ) echo ' class="col-lg-10"' ?>>
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
                <h1>
                    <?php echo $res->name ?>
                    <small class="xs"><?php echo $res->getStatus() ?></small>
                    <a class="btn btn-danger btn-xs" href="<?php 
                        echo CITRUS_PROJECT_URL . $cos->app->name 
                    ?>/projects/<?php echo $res->id ?>/new-ticket">
                        <i class="icon-plus-sign"></i> Créer un ticket
                    </a>
                </h1>
                <div id="projet-panel" class="row">
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
                    <div class="col-lg-3 col-md-3 col-xs-12">
                        <?php include_slice( 'bugs_filters', array( 'res' => $res ) )  ?>
                    </div>
                </div>

            </div>
            <div class="merci-ie"></div>
        <!-- </div> -->
    </div>
</div>