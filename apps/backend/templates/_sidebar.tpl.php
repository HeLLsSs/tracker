<?php
if ( isset( $schema ) ) {
    $module = $cos->app->module;
?><div id="sidebar">
    <h4><?php echo ucfirst( $schema->pluralDescription ) ?></h4>
    <ul>
        <li><?php echo link_to(
            '/backend/' . $module->name . '/index',
            'Liste des ' . $schema->pluralDescription,
            array( 'class' => ( $module->ctrl->action == 'index' ) ? 'active' : '' )
        ) ?></li>
        <li><?php echo link_to(
            '/backend/' . $module->name . '/edit',
            'Ajouter un ' . $schema->description,
            array( 'class' => ( $module->ctrl->action == 'edit' ) ? 'active' : '' )
        ) ?></li>
    </ul>
</div>
<?php } ?>