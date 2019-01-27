import { handleSidebarToggle } from "../util/handleSidebarToggle";
import { handleSubMenus } from "../util/handleSubMenus";
import { handleMenuToggle } from "../util/handleMenuToggle";

export default {
  init() {
    handleSubMenus();
    handleMenuToggle();
    handleSidebarToggle();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  }
};
