var store = {
    username: "MHDev"
};

new Vue({
    data: store,
    el: '#demo',
    components: {
        notification: {
            template: "<h2>{{username}} : <slot></slot></h2>",
            data: function() {
                return store;
            }
        }
    }
});
