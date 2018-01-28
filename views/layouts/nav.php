    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Traducteur</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="/">
                <?php echo $lang['HOME']?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/?controller=translator">
                <?php echo $lang['MENU_TRANSLATE']?>
              </a>
            </li>
            <?php if (Util::can_acces('ADM')) { ?>
              <li class="nav-item">
                <a class="nav-link" href="/?controller=user">
                  <?php echo $lang['MENU_ADMINPANEL'];?>
                </a>
              </li>
            <?php } ?>
            <?php if (Util::can_acces('ADM')) { ?>
              <li class="nav-item">
                <a class="nav-link" href="/?controller=sentence">
                  <?php echo $lang['MENU_TRANSLATORPANEL'];?>
                </a>
              </li>
            <?php } ?>
            <?php if (Util::can_acces('PRE')) {  ?>
              <li class="nav-item">
                <a class="nav-link" href="/?controller=translator&action=showUserTranslation">
                  <?php echo $lang['MENU_USERASK'];?>
                </a>
              </li>
            <?php } ?>

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
                            <?php echo $lang['MY_PROFILE'] ?>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-dark" href="/?controller=user&action=unlogin">
                        <?php echo $lang['LOGOUT'] ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
            </span>
        </div>
    </nav>
