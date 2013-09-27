<?php if ( count( $tickets ) == 0 ) { ?>
    <p class="alert">
        Aucun<?php 
            echo ( $schema_tkt->gender != 'm' ? 'e' : '' ) . ' ' . $schema_tkt->description 
        ?>.
    </p>
<?php } else {
        $resHead = array();
        foreach ($schema_tkt->adminColumns as $chmp) {
            if ( isset( $schema_tkt->properties[$chmp] ) ) {
                $libelle = isset( $schema_tkt->properties[$chmp]['formLabel'] ) ? $schema_tkt->properties[$chmp]['formLabel'] : '?';
                $resHead[] = '<th class="sortable" rel="' .$chmp. '">' . $libelle . '</th>';
            }
            else if (isset( $schema_tkt->manyProperties[$chmp])) {
                $libelle = isset( $schema_tkt->manyProperties[$chmp]['formLabel'] ) ? $schema_tkt->manyProperties[$chmp]['formLabel'] : '?';
                $resHead[] = '<th>' . $libelle . '</th>';
            }
        } 


        $resBody = array();
foreach ( $tickets as $object ) {
    $resTr = '';
    foreach ( $schema_tkt->adminColumns as $chmp ) {
        $sch_props = $schema_tkt->properties;
        if ( isset( $sch_props[$chmp] ) ) {
            $prop = $sch_props[$chmp];
            $is_lnk = in_array( $chmp, $schema_tkt->linkColumns );

            if ( isset( $prop['modelType'] ) ) {
               $chmp= substr( $chmp, 0, -3 );
            }
            if ( isset( $prop ) && $prop['type'] == 'datetime' && !is_null( $object->$chmp ) ) {
                $str = $object->$chmp->format( 'd/m/Y' );
            } else if ( isset( $prop ) && $prop['type'] == 'boolean' ) {
                $str = $object->$chmp ? 'Oui':'Non';
            } else if ( isset( $prop['options']) && $object->$chmp ) {
                $str = $prop['options'][ $object->$chmp ];                
            } else $str = $object->$chmp;
            
            if ( isset( $sch_props[$chmp . '_id']['modelType'] ) && is_null( $str->id ) ) {
                $str = ""; 
            }
            if ( $is_lnk ) {
                $cutopen = $chmp == 'title' ? '<span class="cut-txt">' : '';
                $cutclose = $chmp == 'title' ? '</span>' : '';
                $str = $cutopen . '<a href="' . 
                        CITRUS_PROJECT_URL . $cos->app->name . 
                        '/tickets/' . $object->id . '/view">' . 
                        $str . '</a>' . $cutclose;
            }
            if ( $object->isNew() && $chmp == 'datecreated' ) {
                $str .= ' <span class="label label-info label-xs">new</span>';
            }
            if ( $chmp == "priority" ) {
                switch ( $object->priority ) {
                    case \core\tkr\Ticket::PRIORITY_NORMAL:
                        $label_class = ' label-default';
                        break;
                    case \core\tkr\Ticket::PRIORITY_URGENT:
                        $label_class = ' label-warning';
                        break;
                    case \core\tkr\Ticket::PRIORITY_BLOCKING:
                        $label_class = ' label-danger';
                        break;
                    default:
                        $label_class = '';
                        break;
                }
                $str = '<span class="label' . $label_class . '">' . $str . '</span>';
            }
            if ( $chmp == "status" ) {
                switch ( $object->status ) {
                    case \core\tkr\Ticket::STATUS_WAITING:
                        $label_class = ' label-default';
                        break;
                    case \core\tkr\Ticket::STATUS_ASSIGNED:
                        $label_class = ' label-info';
                        break;
                    case \core\tkr\Ticket::STATUS_CLIENT_WAITING:
                        $label_class = ' label-warning';
                        break;
                    case \core\tkr\Ticket::STATUS_FIXED:
                        $label_class = ' label-success';
                        break;
                    case \core\tkr\Ticket::STATUS_ABORTED:
                        $label_class = ' label-info';
                        break;
                    default:
                        $label_class = '';
                        break;
                }
                $tick = \core\tkr\Ticket::STATUS_FIXED == $object->status ? '<i class="icon-ok"></i> ' : '';
                $str = '<span class="label' . $label_class . '">' . $tick . $str . '</span>';
            }
            $resTr[] = '<td>' . $str . '</td>';

        } else if ( isset( $schema_tkt->manyProperties[$chmp] ) ) {
            $str = count( $object->$chmp );
            if ( in_array( $chmp, $schema_tkt->linkColumns ) ) {
                $str = '<a href="' . 
                        CITRUS_PROJECT_URL . $cos->app->name . 
                        '/tickets/' . $object->id . '/view">' . $str . '</a>';
            }
            $resTr[] = '<td>' . $str . '</td>';
        }
    }
    $resBody[] = '<tr id="enreg_' . $object->id . '">' . implode('', $resTr ) . '</tr>';
} 
?>
    
    <h2>Derniers tickets</h2>
    <div class="table-responsive">
        <table class="listing table table-striped table-hover">
            <thead>
                <tr><?php echo implode( '', $resHead ) ?></tr>
            </thead>
            <tbody<?php if ( $schema_tkt->orderColumnDefined ) echo 'class="sortable"' ?>>
                <?php echo implode( chr( 10 ), $resBody ) ?>
            </tbody>
            <tfoot>
                <tr class="action">
                    <td colspan="<?php echo count( $schema_tkt->adminColumns ) ?>">
                       <?php echo $pager->displayPager() ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
<?php } ?>