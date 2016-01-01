new Vue({

    el: '#demo',
    data: {},
    methods: {
        onKeyUp: function() {
            console.log("KeyUp");
        },
        onBlur: function() {
            console.log("Blur");
        }
    }
});
