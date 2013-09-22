<?php
$resBody = array();
foreach ( $list as $object ) {
    if ( $cos->user->isadmin == '1' ) {
        $resTr = array('<td><input type="checkbox" name="delete[]" value="' . $object->id . '" /></td>');
    } else $resTr = '';
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
                $str = '<a href="' . $cos->app->getControllerUrl() . $object->id . '/view">' . $str . '</a>';
                if ( date( 'U' ) - $object->datecreated->format( 'U' ) < ( 60 * 60 * 24 * 2 ) ) {
                    $str .= ' <span class="label label-warning">new</span>';
                }
            }
        
            $resTr[] = '<td>' . $str . '</td>';

        } else if ( isset( $schema->manyProperties[$chmp] ) ) {
            $str = count( $object->$chmp );
            if ( in_array( $chmp, $schema->linkColumns ) ) {
                $str = '<a href="' . $cos->app->getControllerUrl() . $object->id . '/view">' . $str . '</a>';
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