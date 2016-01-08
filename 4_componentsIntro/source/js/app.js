Vue.component("counter", {

    template: "#counter-template",
    props: ["heading"],
    data: function() {
        return {
            counter: 0
        };
    }
});

new Vue({

    el: '#demo',
    data: {
        heading: "Hello"
    }
});
