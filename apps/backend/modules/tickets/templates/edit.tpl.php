<div data-role="page" id="cos-object-form" class="container">
    <div class="row">
        <div class="container">
            <?php if ( isset( $sidebar ) ) include_slice_global( $sidebar ); ?>
            <div<?php if ( isset( $sidebar ) ) echo ' class="col-lg-10"' ?>>
                <ol class="breadcrumb hidden-xs">
                    <li><a href="<?php echo CITRUS_PROJECT_URL . $cos->app->name ?>/">Accueil</a></li>
                    <li><a href="<?php 
                    	echo CITRUS_PROJECT_URL . $cos->app->name . '/projects'
                    ?>/">Projets</a></li>
                    <li><a href="<?php 
                    	echo CITRUS_PROJECT_URL . $cos->app->name . '/projects/' . $res->project->id . '/view'
                    ?>"><?php echo $res->project->name ?></a></li>
                    <li><?php 
                    	echo ( $res->id ? 'Modifier' : 'Créer' ) ?>
                        un ticket
                    </li>
                </ol>
                <h1>
                    <?php echo $res->id ? 'Modifier' : 'Créer' ?> 
                    un<?php echo ( $schema->gender != 'm' ? 'e ' : ' ' ) . $schema->description ?>
                </h1>
                <form class="form-object" action="save" method="post" class="form-horizontal">
                    <?php echo $form->render() ?>
                    <p class="formActions">
                        <a class="btn-cancel btn btn-danger" href="/<?php 
                            echo $cos->app->name . '/tickets/' . $res->id . '/view' 
                        ?>">Annuler</a>
                        <button type="submit" class="btn btn-primary"><?php 
                            echo $res->id ? 'Modifier' : 'Créer'?>
                        </button>
                    </p>
                </form>
            </div>
            <div class="merci-ie"></div>
        </div>
    </div>
</div>