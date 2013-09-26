<div data-role="page" id="cos-object-list" class="container cos-list">
    <div class="row">
        <?php if ( isset( $sidebar ) ) include_slice_global( $sidebar ); ?>
        <div<?php if ( isset( $sidebar ) ) echo ' class="col-lg-10"' ?>>
            <ol class="breadcrumb hidden-xs">
                <li><a href="<?php echo CITRUS_PROJECT_URL . $cos->app->name ?>/">Accueil</a></li>
                <li><?php 
                        echo ucfirst( $schema->pluralDescription ); 
                ?></li>
            </ol>
            <h1>
                Liste des <?php echo $schema->pluralDescription ?>
                <?php $nbItems = count( $list ); ?>
                <small><?php echo $nbItems . ' élément' . ( $nbItems > 0 ? $nbItems > 1 ? 's' : '' : '' ) ?></small>
            </h1>
            
            <?php if (count( $list ) == 0 ) { ?>
                <p class="alert">
                    Aucun<?php 
                        echo ( $schema->gender != 'm' ? 'e' : '' ) . ' ' . $schema->description 
                    ?> disponible
                </p>
                <?php } else {
                    $resHead = array();
                    foreach ($schema->adminColumns as $chmp) {
                        if ( isset( $schema->properties[$chmp] ) ) {
                            $libelle = isset( $schema->properties[$chmp]['formLabel'] ) ? $schema->properties[$chmp]['formLabel'] : '?';
                            $resHead[] = '<th class="sortable" rel="' .$chmp. '">' . $libelle . '</th>';
                        }
                        else if (isset( $schema->manyProperties[$chmp])) {
                            $libelle = isset( $schema->manyProperties[$chmp]['formLabel'] ) ? $schema->manyProperties[$chmp]['formLabel'] : '?';
                            $resHead[] = '<th>' . $libelle . '</th>';
                        }
                    } 
                ?><form action="<?php echo $cos->app->getControllerUrl() ?>deleteSeveral" method="post" class="delete-form">
                    <div class="navbar">
                        <div class="navbar-form pull-left">
                            <div class="btn-group">
                                <?php /*<button type="submit" class="deleteSeveral btn btn-danger">
                                    Supprimer les <?php echo $schema->pluralDescription ?>
                                    sélectionné<?php echo $schema->gender != 'm' ? 'e':''?>s
                                </button> */ ?>
                            </div>
                        </div>
                        <div class="navbar-form pull-right">
                            <input type="text" name="search" id="search" value="<?php echo $search ?>" class="form-control" placeholder="Rechercher" autocomplete="off" />
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="listing table table-striped table-hover" cellspacing="0" cellpadding="0">
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
                </form>
            <?php } ?>
        </div>
        <div class="merci-ie"></div>
    </div>
</div>