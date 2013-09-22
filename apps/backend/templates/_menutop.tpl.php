<?php 
    $module = $cos->app->controller;
    if ( $cos->user->isLogged() ) {
?>
<div class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".cos-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo CITRUS_PROJECT_URL . 'backend/projects/'; ?>">Tracker</a>
        </div>
        <div class="cos-navbar navbar-collapse collapse">
            <ul id="main-nav" class="nav navbar-nav">
                <li<?php if ( $module->name == "projects" ) echo ' class="active"' ?><?php /* class="dropdown"*/ ?>>
                    <a href="<?php echo CITRUS_PROJECT_URL . 'backend/projects/'; ?>"<?php /*class="dropdown-toggle" data-toggle="dropdown"*/?>>
                        Projets <!-- <b class="caret"></b> -->
                    </a>
                    <!-- <ul class="dropdown-menu">
                        <li<?php if ( $module->name == 'Tree' ) echo ' class="active"'; ?>>
                            <a href="<?php echo CITRUS_PROJECT_URL . 'backend/'; ?>">
                                lien
                            </a>
                        </li>
                    </ul> -->
                </li>

                <li<?php if ( $module->name == "tickets" ) echo ' class="active"' ?>>
                    <a href="<?php echo CITRUS_PROJECT_URL . 'backend/tickets/'; ?>">
                        Tickets
                    </a>
                </li>

                <li<?php if ( $module->name == "users" ) echo ' class="active"' ?>>
                    <a href="<?php echo CITRUS_PROJECT_URL . 'backend/users/'; ?>">
                        Utilisateurs
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-right">
                <li class="logout"><?php echo link_to( 
                    '/backend/logout',
                    'Déconnexion'
                ) ?></li>
            </ul>
        </div>
    </div>
</div><?php } ?> 