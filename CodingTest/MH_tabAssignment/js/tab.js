/**
 * Tab object
 *
 * This object will create a tab-like system for the given assignment.
 * 
 * Total time:
 *  ~ 35 to :
 *      - write the code
 *      - write the documentation
 *      - test it on multiple browser
 *          tested on:
 *              - Chrome: 35.0.1916.153 m Windows 8
 *              - Firefox: 30 Windows 8
 *              - Internet Explore: 11 Windows 8
 *
 * @author Matteo Hertel
 * @email info@matteohertel.com
 * @version 0.1
 * @license MIT@
 */
//the js will load in the header so the object will fire only once the document is loaded
$(document).ready(function () {
    (function ($) {
        var Tab = {
            fire: function (config) {
                //add config to the object
                this.config = config;
                //run the bootstrap
                this.init();
            },
            init: function () {
                var self = Tab;
                //hide all the content and h2
                self.config.subheading.hide();
                self.config.content.hide();

                //create a new ul
                self.config.list = $("<ul/>");
                //empty tracker
                self.config.tracker = [];

                //fire the core function
                self.createAndInjectList();
            },
            createAndInjectList: function () {
                var self = Tab,
                    temp, li;

                //for every h2 create an li with the same text, bind the click evente and 

                self.config.subheading.each(function (k, e) {
                    // add the content to the tracket
                    self.config.tracker.push($(e).next());

                    li = $("<li/>", {
                        text: $(e).text(),
                        "data-key": k,
                        "class": self.config.clickLink,
                    }).on("click", self.eventFunction).appendTo(self.config.list);
                    //start the tab system to the given index
                    if (k === self.config.firstElement) {
                        li.trigger("click");
                    }
                });
                //inject the list
                temp = self.config.subheading[0];
                $(temp).before(self.config.list);

            },

            eventFunction: function () {
                var self = Tab;
                //hide all the conntent
                $(".content").hide();
                // show the right content
                $(self.config.tracker[$(this).data("key")]).show();

            }
        };
        // fire the object!
        Tab.fire({
            subheading: $('.subheading'),
            content: $(".content"),
            clickLink: "list-change",
            firstElement: 0
        });

    }(jQuery));

});