<form action="" method="post">
    <?php if ( $cos->user->isadmin ) { ?>
        <div class="form-group">
            <div class="btn-group">
                <button id="dev-btn" 
                    class="btn btn-sm btn-wide btn-default dropdown-toggle" 
                    data-toggle="dropdown">
                    <span><?php 
                        echo $res->developer->id ? 
                            $res->developer->id == $cos->user->id ?
                                'Attribué à : moi' : 
                                'Attribué à : ' . $res->developer 
                            : 'Attribuer'; ?></span> 
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dev-changer" role="menu">
                    <?php foreach ( $devs as $k => $v ) { ?>
                        <li>
                            <a href="<?php 
                                echo CITRUS_PROJECT_URL . 
                                     $cos->app->name . 
                                     '/tickets/' . 
                                     $res->id . 
                                     '/dev/' . $v->id
                                ?>"<?php if ( $v->id == $res->developer->id ) echo ' class="active"' ?>>
                                <?php echo $v->id == $cos->user->id ? 'Moi' : $v ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php } else { ?>
        <p><strong>Assigné à :</strong> <?php echo $res->developer ?></p>
    <?php } ?>
</form>