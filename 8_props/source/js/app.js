Vue.component("coupon", {
    template: document.getElementById("coupon-template"),
    props: ["applied"],
    data: function() {
        return {
            coupon: "",
            invalid: false,
            submitted: false,
            glyphicon: "",
            glyphiconError: "glyphicon-remove",
            glyphiconSuccess: "glyphicon-ok",
            feedback: "",
            feedbackError: "has-error",
            feedbackSuccess: "has-success",
        };
    },
    methods: {
        validateCoupon: function() {
            this.reset();
            if (this.coupon === "Papoi") {
                this.applied(this.coupon);
                return this.validCoupon();
            }
            this.invalidCoupon();
        },
        validCoupon: function() {
            this.submitted = true;
            this.glyphicon = this.glyphiconSuccess;
            this.feedback = this.feedbackSuccess;
        },
        invalidCoupon: function() {
            this.submitted = true;
            this.glyphicon = this.glyphiconError;
            this.feedback = this.feedbackError;
        },
        reset: function() {
            this.glyphicon = "";
            this.feedback = "";
        }
    }
});

new Vue({

    el: '#demo',
    data: {
        coupon: "",
    },
    methods: {
        setCoupon: function(coupon) {
            this.coupon = coupon;
        }
    }
});
