<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="http://matteohertel.com/wp-content/uploads/favicon.png">

        <title>Login</title>

        <!-- Bootstrap core CSS -->
        <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">



        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            html {
                /* This prevents the page from shifting when a modal is opened e.g. search */
                overflow-y: auto;
            }
            .modal,.modal.in,.modal-backdrop.in {
                /* These are to prevent the blank space for the scroll bar being displayed unless the modal is > page height */
                overflow-y: auto;
            }
        </style>
    </head>

    <body>

        <div class="container">
            <?php
            if (array_key_exists("previuos_attempt", $_SESSION) && $_SESSION["previuos_attempt"] > 0):
                ?>
                <div class="alert alert-danger" role="alert">Invalid Login! you tried <?= $_SESSION["previuos_attempt"] ?> time(s) to log in this page</div>
                <?php
            endif;
            ?>
            <form class="form-signin" role="form" action="index.php" method="POST">
                <h2 class="form-signin-heading">Please sign in</h2>
                <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>

        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
    </body>