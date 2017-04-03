exports.config = {
    // See http://brunch.io/#documentation for docs.
    files: {
        templates: {
            joinTo: "js/app.js"
        },
        javascripts: {
            joinTo: "js/app.js"
        },
        stylesheets: {
            joinTo: {
                "css/sunta.css": /^(web\/static\/css\/sunta)/,
                "css/app.css": /^(web\/static\/css\/app)/
            }
        }
    },

    conventions: {
        assets: /^(web\/static\/assets)/
    },

    paths: {
        watched: [
            "web/static",
            "test/static"
        ],

        public: "priv/static"
    },

    plugins: {
        babel: {
            ignore: [/web\/static\/vendor/]
        }
    },

    modules: {
        autoRequire: {
            "js/app.js": ["web/static/js/app"]
        }
    },

    npm: {
        enabled: true,
        styles: {phoenix: ['web/static/css/phoenix.css']},
        globals: {Phoenix: 'phoenix'}
    }
};
