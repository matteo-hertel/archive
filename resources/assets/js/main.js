/**
 * Input validator for number type, whit customizable rules
 */
function ValidateIntegerInput($el) {
        this.$el = $el;
        /**
         * basically on the element itself is possible to set data- attributes to change the behavior of the validator:
         *
         * min will change the min value of the validator default 1 as per spec
         * max will change the max value of the validator default 100 as per spec
         * minmessage will change the min validator message in the help span tag
         * maxmessage will change the max validator message in the help span tag
         */
        this.min = $el.data("min") || 1;
        this.max = $el.data("max") || 100;
        this.minErrorMessage = $el.data("minmessage") || "The number must be at least " + this.min + ".";
        this.maxErrorMessage = $el.data("maxmessage") || "The number may not be greater than " + this.max + ".";

        //on each key press fire the validator
        this.bindEvents = function() {
            this.$el.on("keyup", this.validate.bind(this));
        };

        /**
         * validator logic
         * clean everything up
         * validate the input based on rules
         * if the validation fails create the appropriate errors
         *
         * I can potentially stop the form from being submitted, is not difficult at all to implement
         */
        this.validate = function() {
            this.cleanUp();
            var val = parseInt(this.$el.val());
            if (val < this.min) {
                return this.makeMinError.bind(this)();
            }

            if (val > this.max) {
                this.makeMaxError.bind(this)();
            }

        };
        /**
         * using jquery fluent syntax create the error message and add it to the parent of the element
         */
        this.makeMinError = function() {
            var help = $("<span/>", {
                class: "help-block validationError",
                html: $("<strong/>", {
                    text: this.minErrorMessage
                })
            });
            this.toggleBlockError();
            this.$el.parent().append(help);
        };
        /**
         * using jquery fluent syntax create the error message and add it to the parent of the element
         */
        this.makeMaxError = function() {
            var help = $("<span/>", {
                class: "help-block validationError",
                html: $("<strong/>", {
                    text: this.maxErrorMessage
                })
            });
            this.toggleBlockError();
            this.$el.parent().append(help);
        };
        /**
         * some housekeeping is always required to clean up previous validations
         */
        this.cleanUp = function() {
            this.toggleBlockError(true);
            this.$el.parent().find(".validationError").remove();
            this.$el.parent().remove(".validationError");
        };
        // toggle the has-class error based on a particular flag
        this.toggleBlockError = function(flag) {
            if (flag) {
                return this.$el.parent().parent().removeClass("has-error");
            }
            this.$el.parent().parent().addClass("has-error");

        };

        this.bindEvents();
    }
    // find the number input field 
var number = $("#number");
//if is not empty, fire in the hole!!
if (number.length) {
    new ValidateIntegerInput(number);
}
