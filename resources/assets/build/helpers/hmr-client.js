// eslint-disable-next-line import/no-unresolved
const hotMiddlewareScript = require("webpack-hot-middleware/client?noInfo=true&timeout=20000&reload=true");

hotMiddlewareScript.subscribe(event => {
  if (event.action === "reload") {
    window.location.reload();
  }
});
