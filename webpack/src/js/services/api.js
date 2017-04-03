const request = require('superagent');

export default class Api {

  get(url, params, cb) {
    return request
      .get(url)
      .query(params)
      .end(function (err, res) {
        if (err !== null) {
          console.log(err);
          return;
        }
        cb(res.body);
      });
  }

  post(url, params, cb) {
    return request
      .post(url)
      .send(params)
      .end(function (err, res) {
        if (err !== null) {
          console.log(err);
          return;
        }
        cb(res.body);
      });
  }
}

