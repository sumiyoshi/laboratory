import Vue from 'vue'
import View from 'view_models/content_view_model';
import "style.scss";

//Vue.config.delimiters = ['<%', '%>'];
new Vue(View);


class Test {
    a = 1;
}

var test = new Test();
console.log(test.a);