let $ = require("jquery");

class JqueryVersion {
    constructor(jquery) {
        this.jquery = jquery;
    }

    get () {
        return this.jquery.fn.jquery
    }
}
export default JqueryVersion;

var version = new JqueryVersion($);
console.log(version.get());