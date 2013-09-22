<td class="listAction">
    <?php echo link_to(
        'index.php?cos_app=backend&cos_module=' . $cos->app->module->name . '&cos_action=edit&id=' . $item->id,
        'Editer',
        array( 'class' => 'linkEdit' )
    )?>
    <?php echo link_to(
        'index.php?cos_app=backend&cos_module=' . $cos->app->module->name . '&cos_action=delete&id=' . $item->id,
        'Effacer',
        array( 'class' => 'linkDelete' )
    )?>
</td>