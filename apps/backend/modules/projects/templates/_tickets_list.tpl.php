<?php
$resBody = array();
foreach ( $list as $object ) {
    $resTr = '';
    foreach ( $schema->adminColumns as $chmp ) {
        $sch_props = $schema->properties;
        if ( isset( $sch_props[$chmp] ) ) {
            $prop = $sch_props[$chmp];
            $is_lnk = in_array( $chmp, $schema->linkColumns );

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
                $str = '<a href="' . 
                        CITRUS_PROJECT_URL . $cos->app->name . 
                        '/tickets/' . $object->id . '/view">' . 
                        $str . '</a>';
            }
            if ( $object->isNew() && $chmp == 'datecreated' ) {
                $str .= ' <span class="label label-info label-xs">new</span>';
            }
            if ( $chmp == "priority" ) {
                switch ( $object->priority ) {
                    case \core\tkr\Ticket::PRIORITY_NORMAL:
                        $label_class = ' label-warning';
                        break;
                    case \core\tkr\Ticket::PRIORITY_URGENT:
                        $label_class = ' label-danger';
                        break;
                    default:
                        $label_class = '';
                        break;
                }
                $str = '<span class="label' . $label_class . '">' . $str . '</span>';
            }
            $resTr[] = '<td>' . $str . '</td>';

        } else if ( isset( $schema->manyProperties[$chmp] ) ) {
            $str = count( $object->$chmp );
            if ( in_array( $chmp, $schema->linkColumns ) ) {
                $str = '<a href="' . 
                        CITRUS_PROJECT_URL . $cos->app->name . 
                        '/tickets/' . $object->id . '/view">' . $str . '</a>';
            }
            $resTr[] = '<td>' . $str . '</td>';
        }
    }
    $resBody[] = '<tr id="enreg_' . $object->id . '">' . implode('', $resTr ) . '</tr>';
} 

?><tbody<?php if ( $schema->orderColumnDefined ) echo 'class="sortable"' ?>>
    <?php echo implode( chr( 10 ), $resBody ) ?>
</tbody>
<tfoot>
    <tr class="action">
        <td colspan="<?php echo count( $schema->adminColumns ) + 1 ?>">
           <?php echo $pager->displayPager() ?>
        </td>
    </tr>
</tfoot>