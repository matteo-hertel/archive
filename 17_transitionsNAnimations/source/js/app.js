Vue.transition("fade", {
    enterClass: "fadeInUp",
    leaveClass: "fadeOutLeft",
});
Vue.transition("flip", {
    enterClass: "flipInX",
    leaveClass: "fadeOut",
});

new Vue({

    el: '#demo',
    data: {
        heading: "Hello",
        show: true
    }
});
