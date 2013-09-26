<div id="cos-object-list" class="cos-list">
    <?php if ( count( $tickets ) == 0 ) { ?>
        <p class="alert">
            Aucun<?php 
                echo ( $schema->gender != 'm' ? 'e' : '' ) . ' ' . $schema->description 
            ?>.
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
    ?>
    <div class="table-responsive">
        <table class="listing table table-striped table-hover" cellspacing="0" cellpadding="0">
            <thead>
                <tr><?php echo implode( '', $resHead ) ?></tr>
            </thead><?php
                include_slice( 'tickets_list', array(
                    'schema'    => $schema,
                    'list'      => $tickets,
                    'pager'     => $pager,
                    'search'    => $search,
                    'order'     => $order,
                    'orderType' => $orderType,
                ) );
            ?>
        </table>
    </div>
    <?php } ?>
</div>