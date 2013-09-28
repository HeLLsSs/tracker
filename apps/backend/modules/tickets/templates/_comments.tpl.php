<h3>Commentaires</h3>
<?php if ( count( $comments ) ) { ?> 
    <?php $i = 0; foreach ( $comments as $c ) { 
        $w1 = $i % 2 == 0 ? 'pull-left' : 'pull-right';
        // $w2 = $i % 2 == 0 ? 'pull-right' : 'pull-left';
    ?>
        <div class="ticket-comment">
            <div class="comment-author <?php echo $w1 ?>">
                <span data-toggle="tooltip" title="<?php echo $c->datecreated->format( 'd/m/Y H:i:s' ) ?>">
                    <i class="icon-user"></i>
                    <?php echo $c->author ?>
                </span>
            </div>
            <div class="comment-content <?php echo $w1 ?>">
                <p><?php echo $c->content ?></p>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php $i++; } ?>
<?php } else { ?> 
    <p class="empty-list">Aucun commentaire</p>
<?php } ?> 