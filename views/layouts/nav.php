    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Traducteur</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <?php 
                    foreach ($lang['MENU'] as $value) {
                        foreach ($value as $key => $val) {
                        echo '<li class="nav-item">
                                <a class="nav-link" href="'. $val . '"> 
                                ' . $key. '
                                </a>
                             </li>';
                        }
                    }
                ?>
                
            </ul>

            <span class="navbar-text">
            <?php 
                $username = $_SESSION['USER']['username'];
                $id = $_SESSION['USER']['id'];
                if ($username == null) {
            ?>
                <a href="/?controller=user&action=loginPage" 
                class="btn btn-primary btn-lg " role="button" aria-pressed="true">Log in</a>
                <a href="/?controller=user&action=new" 
                class="btn btn-primary btn-lg" role="button" aria-pressed="true">Sign-in</a>

            <?php } else { ?>
                <a href="/?controller=user&action=show&id=<?php echo $id ?>" 
                class="btn btn-primary btn-lg " role="button" aria-pressed="true">
                    <?php echo $username ?>
                </a>
            </div>
            <?php } ?>
            </span>
        </div>
    </nav>