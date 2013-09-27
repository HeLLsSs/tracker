<div data-role="page" id="cos-object-list" class="container cos-list">
    <ol class="breadcrumb hidden-xs">
        <li><a href="<?php echo CITRUS_PROJECT_URL . $cos->app->name ?>/">Accueil</a></li>
        <li><?php 
                echo ucfirst( $schema->pluralDescription ); 
        ?></li>
    </ol>
    <h1>
        Liste des <?php echo $schema->pluralDescription ?>
        <?php $nbItems = count( $list ); ?>
        <small><?php 
            echo $nbItems . ' élément' . 
                ( $nbItems > 0 ? $nbItems > 1 ? 's' : '' : '' ) 
        ?></small>

        <a href="<?php echo $cos->app->getControllerUrl() ?>edit" class="btn-add btn pull-right btn-success btn-sm">
            <span class="visible-xs">
                <i class="icon-plus-sign"></i>
            </span>
            <span class="hidden-xs">
                <i class="icon-plus-sign"></i> 
                Créer un<?php echo $schema->gender != 'm' ? 'e':''?>
                <?php echo $schema->description ?>
            </span>
        </a>
        <span class="clearfix"></span>
    </h1>
    <div class="row">

        <div class="col-lg-3">
            <div class="panel panel-default">
                <?php if ( $cos->user->isadmin == '1' ) { ?>
                    <div class="panel-body">
                        <p>
                            <input type="text" name="search" id="search" value="<?php echo $search ?>" class="form-control" placeholder="Rechercher" autocomplete="off" />
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-9">
            <?php if ( count( $list ) == 0 ) { ?>
                <?php if ( $cos->user->isadmin == '1' ) { ?>
                <table class="table">
                    <thead>
                        <tr class="action">
                            <td>
                                <a href="<?php echo $cos->app->getControllerUrl() ?>edit" 
                                    class="btn-add btn btn-primary">
                                    Ajouter un<?php 
                                        echo ( $schema->gender != 'm' ? 'e':'' ) . 
                                        ' ' . $schema->description 
                                    ?>
                                </a>
                            </td>
                        </tr>
                    </thead>
                </table>
                <?php } ?>
                <p class="alert">
                    Aucun<?php 
                        echo ( $schema->gender != 'm' ? 'e' : '' ) . ' ' . $schema->description 
                    ?> disponible
                </p>
            <?php } else { ?>
            <?php if ( $cos->user->isadmin == '1' )
                    // $resHead = array('<th class="sel"><input type="checkbox" /></th>');
                    $resHead = array();
                else $resHead = array();
                foreach ($schema->adminColumns as $chmp) {
                    if ( isset( $schema->properties[$chmp] ) ) {
                        $libelle = isset( $schema->properties[$chmp]['formLabel'] ) ? $schema->properties[$chmp]['formLabel'] : '?';
                        $resHead[] = '<th class="sortable" rel="' .$chmp. '">' . $libelle . '</th>';
                    }
                    else if (isset( $schema->manyProperties[$chmp])) {
                        $libelle = isset( $schema->manyProperties[$chmp]['formLabel'] ) ? $schema->manyProperties[$chmp]['formLabel'] : '?';
                        $resHead[] = '<th>' . $libelle . '</th>';
                    }
                } ?>
                <div class="table-responsive">
                    <table class="listing table table-striped table-hover">
                        <thead>
                            <tr><?php echo implode( '', $resHead ) ?></tr>
                        </thead><?php
                            include_slice( 'index-list', array(
                                'schema'    => $schema,
                                'list'      => $list,
                                'pager'     => $pager,
                                'search'    => $search,
                                'order'     => $order,
                                'orderType' => $orderType,
                            ) );
                        ?>
                    </table>
                </div>
                <?php if ( $schema->orderColumnDefined ) { ?>
                    <p class="alert alert-info">Vous pouvez ordonner les éléments du tableau en utilisant le glisser-déposer</p>
                <?php } ?>
            <?php } ?>
        </div>
        <div class="merci-ie"></div>
    </div>
</div>