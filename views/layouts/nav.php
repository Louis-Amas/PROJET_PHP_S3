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
                class="btn btn-primary btn-lg " role="button" aria-pressed="true">
                <?php echo $lang['LOGIN'] ?>
                </a>
                <a href="/?controller=user&action=create"
                class="btn btn-primary btn-lg" role="button" aria-pressed="true">
                <?php echo $lang['SIGNIN'] ?>
                </a>

            <?php } else { ?>


                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" ">
                        <?php echo $username ?>
                    </button>
                    <div class="dropdown-menu">
                        <a href="/?controller=user&action=show&id=<?php echo $id ?>"
                        class="dropdown-item text-dark" role="button" aria-pressed="true">
                            <?php echo 'My Profile' ?>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-dark" href="/?controller=user&action=unlogin">
                        <?php echo 'Log-Out' ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
            </span>
        </div>
    </nav>
