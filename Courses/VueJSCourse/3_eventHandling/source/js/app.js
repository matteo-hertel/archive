new Vue({

    el: '#demo',
    data: {
        count: 0
    },
    methods: {
        handleSubmit: function(e) {
            e.preventDefault();
            console.log("handeled");
        }
    }
});
