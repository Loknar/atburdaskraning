<?php
if (!isset($to_be_or_not_to_be)) {
  // not to be
  exit();
}

if (!isset($index_active)) {
  $index_active = "";
}

if (!isset($news_active)) {
  $news_active = "";
}

if (!isset($events_active)) {
  $events_active = "";
}

if (!isset($users_active)) {
  $users_active = "";
}


echo <<<_END

        <div class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php">$website_name</a>
            </div>
            <div class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li$index_active><a href="index.php">Forsíða</a></li>
                <li$news_active><a href="#">Fréttir</a></li>
                <li$events_active><a href="#">Atburðir</a></li>
                <li$users_active><a href="#">Félagar</a></li>
              </ul>
_END;

if (USER_LOGGEDIN) {
  echo <<<_END

              <div class="navbar-form navbar-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-user"></span> $user_name <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Síðan mín</a></li>
                    <li><a href="event.add.php">Skrá nýjan atburð</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php">Útskrá</a></li>
                  </ul>
                </div>
              </div>
_END;
}
else {
  echo <<<_END

              <div class="navbar-form navbar-right">
                <a class="btn btn-default" href="login.php">
                <span class="glyphicon glyphicon-user"></span> Innskráning
                </a>
              </div>
_END;
}


echo <<<_END

            </div><!--/.nav-collapse -->
          </div>
        </div>
_END;


?>