new Vue({

    el: '#demo',
    data: {
        /**
         * Got a list of random names from http://listofrandomnames.com/index.cfm
         */
        names: [
            "Merri",
            "Carroll ",
            "Antonietta",
            "Kendra",
            "Shala",
            "Carter",
            "Pierre",
            "Theresa",
            "Genia",
            "Detra",
            "Romona",
            "Drew",
            "Marilyn",
            "Hyun",
            "Dalene",
            "Bertha",
            "Joy",
            "Hoyt",
            "Arden",
            "Nilda"
        ]
    },
    methods: {
        addName: function() {
            if (!this.newName) {
                return;
            }
            this.names.push(this.newName);
            this.newName = "";
        }
    }
});
