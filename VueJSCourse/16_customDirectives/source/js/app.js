// Vue.directive("ajax", {
//     bind: function() {
//         //set up here
//     },
//     update: function() {
//         // main function
//     },
//     unbind: function() {
//         //free resources
//     }
// });
Vue.directive("ajax", {
    params: ["complete"],
    bind: function() {
        this.el.addEventListener("submit", this.onSubmit.bind(this));
    },
    onSubmit: function(e) {
        e.preventDefault();
        this.vm.$http[this.getRequestType()](this.el.action)
            .then(this.onComplete.bind(this))
            .catch(this.onError.bind(this));
    },
    onComplete: function(data) {
        if (this.params.complete) {
            console.log(this.params.complete);
            return;
        }
        console.log("Standard complete message");
    },
    onError: function(data) {
        if (this.params.error) {
            console.log(this.params.error);
            return;
        }
        console.log("Standard error message");
    },
    getRequestType: function() {
        var method = this.el.querySelector("input[name='_method']");
        return (method ? method.value : this.el.method).toLowerCase();
    }
});

new Vue({

    el: '#demo',
    data: {
        heading: "Hello"
    }
});
