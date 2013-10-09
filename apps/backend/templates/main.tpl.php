<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>
        <?php echo $cos->siteName ?>
    </title>
    <?php echo $this->displayStylesheets() ?>
</head>
<body class="backend"><?php 
        $module = $cos->app->controller;
        if ( $module->name != 'Main'  || $cos->app->ctrl->action != 'login' )
            include dirname( __FILE__ ) . '/_menutop.tpl.php'; 

    ?>
    <div id="page" class="container">
        <?php echo $this->getSubview(); ?>
        <div class="merci-ie"></div>
    </div>
    <div id="citrus-signature">
        <a href="http://www.citrus-project.net" target="_blank" title="Propulsé par Citrus PHP Framework">
            <img src="<?php echo CITRUS_PROJECT_URL; ?>images/citrus.png" alt="Citrus project">
        </a>
    </div> 
    <?php if ( $cos->debug ) { echo $cos->debug->debugBar(); } ?>
    <script type="text/javascript">
        var rootUrl = '<?php echo CITRUS_PROJECT_URL ?>';
        var less = {env: 'development'};
    </script>
    <?php echo $this->displayJavascriptFiles() ?>
</body>
</html>