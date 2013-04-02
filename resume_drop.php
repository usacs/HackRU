<?php 
  $errors = array();
  if($_REQUEST['submit']) {
    $email = $_REQUEST['email'];
    $project = $_REQUEST['project'];
    $description = $_REQUEST['project_description'];


    //email is valid
    if(!$email || !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
      $errors[] = "Your email is invalid.";
    }

    if(!$project) {
      $errors[] = "Give me the title of your HackRU project.";
    }

    if(!$description) {
      $errors[] = "Give me a short description of your HackRU project.";
    }


    if(!$_FILES || !$_FILES['resume']) {
      $errors[] = "You need to upload a resume";
    }

    if(!$errors) {
      $file_contents = "";
      $file_contents .= "Email: $email\n";
      $file_contents .= "Project Title: $project\n";
      $file_contents .= "Project Description: $description\n";

      $filename = basename($email);
      $upload_dir = "uploads";

      $file_path = $upload_dir.'/'.$filename.'.txt';

      $ext = substr($_FILES['resume']['name'], strrpos($_FILES['resume']['name'], '.') + 1);
      $resume_path = $upload_dir.'/'.$filename.'.'.$ext;

      file_put_contents($file_path, $file_contents);

      if(move_uploaded_file($FILES['resume']['tmp_name'], $resume_path)) {

      }
      else {
        $errors[] = "Uploading the file failed.";
      }
    }
  }
  else {
    $email = "";
    $project = "";
    $description = "";
  }
?>
<!doctype html>
<!--
__  __  ______  ______  __  __    ______  __  __    
/\ \_\ \/\  __ \/\  ___\/\ \/ /   /\  == \/\ \/\ \   
\ \  __ \ \  __ \ \ \___\ \  _"-. \ \  __<\ \ \_\ \  
\ \_\ \_\ \_\ \_\ \_____\ \_\ \ \ \ \_\ \_\ \_____\ 
\/_/\/_/\/_/\/_/\/_____/\/_/\/_/  \/_/ /_/\/_____/
-->
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />

    <title>hackru - an incredible opportunity for learning and creation</title>

    <link rel="stylesheet" href="stylesheets/foundation.min.css">
    <link rel="stylesheet" href="stylesheets/style.css">
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <script src="javascripts/modernizr.foundation.js"></script>
    <!--[if lt ie 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="row">
      <h2 id="logo">
        <a href="/"><img src="./images/hackru_logo.png" alt="HackRU" /></a>
      </h2>
      <h3 class="subheader hosted">Hosted by <a href="http://usacs.rutgers.edu">The Undergraduate Student Alliance of Computer Scientists</a></h3>
    </div>
    <div class="row shadow">
      <div class="row panel opaque">
        <div class="row">
          <div class="twelve columns centered hosted">
            <ul class="nav-bar">
              <li><a href="index.html">Home</a></li>
              <li><a href="directions.html">Directions</a></li>
              <li><a href="sponsors.html">Sponsors</a></li>
              <li><a href="photos.html">Photos</a></li>
              <li><a href="workshops.html">Workshops</a></li>
              <li><a href="prizes.html">Prizes</a></li>
            </ul>
          </div>
        </div>
    
        <div class="row panel opaque">
          <h1> Resume Drop </h1>
<?php if($errors || !$_REQUEST['submit']): ?>
          <p> Filling this form will send your resume to our sponsors. </p>
          <ul>
            <?php foreach($errors as $error): ?>
              <li> <?= $error; ?>
            <?php endforeach; ?>
          </ul>
          <form action="resume_drop.php" enctype="multipart/form-data" method="POST">
            <label for="email"> Email </label>
            <input type="text"  name="email" id="email" value="<?= htmlspecialchars($email) ?>" />

            <label for="project"> HackRU Project Title </label>
            <input type="text" name="project" id="project" value="<?= htmlspecialchars($project) ?>" />

            <label for="project_description"> HackRU Project Description </label>
            <input type="text" name="project_description" id="project_description" value="<?= htmlspecialchars($project_description) ?>" />

            <label for="resume"> Resume </label>
            <input type="file" name="resume" id="resume" />

            <input type="submit" class="button" value="Submit" name="submit" />

          </form>
<?php else: ?>
          <div class="alert-box success">
            Successfully added your resume. Thanks!
          </div>
<?php endif; ?>
        </div>
      </div>
    </div>
  </body>
</html>
