Vue.component("alert", {
    template: "#alertTemplate",
    props: ["type"],
    methods: {
        removeAlert: function() {
            this.$el.remove();
        }
    }
});

new Vue({

    el: '#demo',
    data: {},
});
