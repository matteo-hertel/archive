<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="http://matteohertel.com/wp-content/uploads/favicon.png">

        <title>RSS Feed</title>

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

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">

            </div>
        </div>

        <!-- Main jumbotron for a primary marketing message or call to action -->
        <div class="jumbotron">
            <div class="container">
                <p>Please note: If the images are not showing is because the host is preventing hotlinking</p>

            </div>
        </div>


        <div class="container">
            <!-- Example row of columns -->
            <div class="row" id="container">

            </div>


            <footer>
                <p>&copy; Matteo Hertel 2014</p>
            </footer>
        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="bower_components/jquery/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="bower_components/ui/ui.min.js"></script>
        <script type="text/javascript">
            /**
             * 
             * This object will display the feed from the backend
             * 
             * @author Matteo Hertel
             * @email info@matteohertel.com
             * @version 0.1
             * @license MIT@
             * @copyright Copyright (C) 2014 Matteo Hertel
             */
            (function($) {
                var RSS = {
                    fire: function(config) {    //bootstrap method
                        this.config = config;   //make the config available to all the components
                        this.init();            // init method to set some usefull variables
                        this.fetch(0);          // fetch the content
                    },
                    init: function() {
                        var self = RSS;
                        // keep track of the time of the last article
                        self.config.last = 0;
                        // this var is set to false so display the content in order in the first run
                        // after that the new content will be inserted on the top of the container
                        self.config.prepend = false;
                        //add a loader to give a visual feedback that something is happening
                        self.config.container.append(UI.progressbar({percentage: 100, class: "dynamic-ui", striped: true, active: true}))

                    },
                    // fetch the content!
                    fetch: function(time) {
                        var self = RSS;
                        //ajax call
                        $.ajax({
                            url: "feed.php",
                            type: "GET",
                            data: {time: time},
                            dataType: "json"
                        }).done(self.process).fail(self.fetchFail);

                    },
                    // display a toast if something is wrong
                    fetchFail: function() {
                        $("body").append(UI.toast({level: "danger", html: "An error occurred", time: 5000, position: "top-right"}))
                    },
                    process: function(r) {
                        var self = RSS;
                        //remove the UI element that I don't want to see
                        $(".dynamic-ui").remove();
                        // add a toast to inform the user that new content was fetched
                        $("body").append(UI.toast({level: "success", html: "New content fetched!", time: 1000, position: "top-right"}))
                        if (r.children.length) {
                            for (elem in r.children) {
                                //for every children create a new row
                                self.parseChildren(r.children[elem]);
                            }
                        } else {
                            //a toast to infom that no new article are availabe
                            $("body").append(UI.toast({level: "warning", html: "There are no new articles", time: 5000, position: "top-right"}))
                        }
                        //init the timeout to have a fresh feed based on the give time
                        self.initTimeout();
                    },
                    //parse the children one by one
                    parseChildren: function(obj) {
                        var self = RSS;
                        for (el in obj) {
                            //create and inject the layout
                            self.injectLayout(self.createLayout(obj[el]));
                        }
                    },
                    //keep track of the time and create the HTML
                    createLayout: function(obj) {
                        var self = RSS;
                        if (obj.timestamp > self.config.last) {
                            self.config.last = obj.timestamp;
                        }
                        return $("<div>", {class: "col-md-12"}).append(
                                $("<img>", {src: obj.image, width: "auto", height: "auto"})
                                ).append(
                                $("<h2>", {text: obj.title, class: "pull-left"})
                                ).append(
                                $("<div>", {class: "clearfix"})
                                ).append(
                                $("<p>", {text: obj.description})
                                ).append(
                                $("<p>").append(
                                $("<a>", {
                                    href: obj.link,
                                    text: obj.link
                                })
                                )
                                );
                    },
                    //Inject the HTML prepending or appending base on the status of
                    // the application
                    injectLayout: function(obj) {
                        var self = RSS;
                        if (self.config.prepend === true) {
                            self.config.container.prepend(obj);
                        } else {
                            self.config.container.append(obj);
                        }
                    },
                    //timeout to fire agai the fetch function
                    initTimeout: function() {
                        var self = RSS;
                        self.config.prepend = true;

                        setTimeout(function() {
                            self.fetch(self.config.last);
                        }, self.config.timeout)
                    }
                };

                RSS.fire({
                    container: $('#container'),
                    timeout: 10000
                });

            }(jQuery));
        </script>
    </body>
</html>
