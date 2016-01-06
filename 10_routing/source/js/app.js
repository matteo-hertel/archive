var router = new VueRouter();

router.map({
    "/about": {
        component: {
            template: "<p>this is the about page</h1>"
        }
    },
    "/contact": {
        component: {
            template: "<p>this is the contact page</h1>"
        }
    }
});

var App = Vue.extend({});

router.start(App, "#demo");
