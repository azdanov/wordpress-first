// eslint-disable-next-line import/extensions
import quicklink from "quicklink/dist/quicklink.mjs";

export default {
  init() {
    if (process.env.NODE_ENV === "production") {
      quicklink({
        // Ignore all requests to:
        //  - all "/wp/*" pathnames
        //  - all "#" fragments (e.g. index.html#top)
        //  - all <a> tags with "noprefetch" attribute
        ignores: [
          /\/wp\/?/,
          uri => uri.includes("#"),
          (uri, elem) => elem.hasAttribute("noprefetch")
        ]
      });
    }
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  }
};
