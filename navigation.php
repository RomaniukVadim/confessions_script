<nav class="navbar sticky-top navbar-toggleable-md navbar-inverse bg-honest">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="index.php"><span class='site-title'><?php echo $messages['title']; ?></span><img src="assets/img/logo_conf.png" class="mobile-logo" /></a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><?php echo $messages['home']; ?> <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="confess.php"><?php echo $messages['confess']; ?></a>
      </li>
    </ul>
    <a href="index.php"><img src="assets/img/logo_conf.png" class="main-logo" /></a>
    <span class="navbar-text">
      <a href="confess.php" class="btn-confess"><?php echo $messages['confess-btn']; ?></a>
    </span>
  </div>
</nav>