<?php
if (!file_exists('config.php')) {
    header("Location: install/install.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

require('includes/lang_strings.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <!-- Confessions CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/pace.css">
    <title><?php echo $messages['confessiontitle'] ?></title>
  </head>
  <body>
  <div class="pace  pace-inactive">
      <div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
          <div class="pace-progress-inner"></div>
      </div>
      <div class="pace-activity"></div>
  </div>
<?php require('includes/html/navigation.php'); ?>
<!-- FB Share -->
<div id="fb-root"></div>
<script src="assets/js/share.js"></script>
<!-- FB Share -->

<input type="hidden" name="conf_id" id="conf_id" value="<?php echo (empty($_GET['id']) ? '' : str_replace(array('+','-'), '', filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_FLOAT))); ?>">
  <div class="container">
    <div class="row align-items-center">
    <div class="col-md-3">
      
    </div>
    <div class="col-md-6">
      <h2 id="good-looking"><?php echo $messages['confession']; ?></h2>
      <div class="confessions" id="confessions">

      </div>
      <div class="comments" id="comments"></div>

      <div id="comm-success" class="alert"><?php echo $messages['commentsent']; ?></div>
      <div id="conf-short" class="alert"><?php echo $messages['commshort']; ?></div>
      <form name="comment" id="comment" action="#" method="POST" accept-charset="UTF-8">
      <div class="comment2 isp" style="box-shadow:none;">
      
      <textarea id="comment-textbox" name="comment-textbox" onkeyup="" rows="5" maxlength="1000" placeholder="<?php echo $messages['commtextholder']; ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = '<?php echo $messages['commtextholder']; ?>'" spellcheck="false"></textarea>
      <div id="charNum"><?php echo $messages['charleft']; ?></div>
      <br>
      <input type="button" name="" id="comment" value="Comment" class="btn btn-secondary comment-btn" style="color:white;">
      <br><br>
     
        
      </div>
  
      </form>

    </div>
    <div class="col-md-3">
      
    </div>
  </div>
  </div>

    <!-- jQuery first, then Tether, then Bootstrap JS, then Lang JS and Main js. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
    <script src="assets/js/lang_strings.js"></script>
    <script src="assets/js/pace.min.js"></script>
    <script src="assets/js/single_load.js"></script>
  </body>
</html>