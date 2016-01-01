new Vue({

    el: '#demo',
    data: {
        name: "Hello, World!"
    },
    ready: function() {
        setInterval(function() {
            this.name = new Date().toString();
        }.bind(this), 1000);
    }
});
