// Vue.directive("confirm", function(message) {
//     this.el.addEventListener("click", function(e) {
//         if (!confirm(message)) {
//             e.preventDefault();
//         }
//     }, false);
//
// });

Vue.directive("confirm", {
    isLiteral: true,
    bind: function() {
            this.el.addEventListener("click", function(e) {
                if (!confirm(this.expression)) {
                    e.preventDefault();
                }
            }.bind(this), false);
        }
        //bind
        //update
        //unbind
});
Vue.directive("age", {
    acceptStatement: true,
    update: function(fnc) {
        //console.log(fnc);
        fnc();
    }
});
new Vue({

    el: '#demo',
    data: {
        age: 0
    },
    methods: {
        check: function(e) {
            e.preventDefault();
            console.log("Submitted");
        }
    }
});
