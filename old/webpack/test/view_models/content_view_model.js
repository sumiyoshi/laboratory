var assert = require('assert');

import View from 'view_models/content_view_model';

describe('CONTENT_VIEW_MODEL', function () {
  describe('initial value', function () {
    it('name', function () {
      assert(View.name === 'ContentViewModel');
    });
    it('el', function () {
      assert(View.el === '#point');
    });
    it('data list', function () {
      assert(View.data.list.length === 0);
    });
    it('data num', function () {
      assert(View.data.num === null);
    });
  });

});
