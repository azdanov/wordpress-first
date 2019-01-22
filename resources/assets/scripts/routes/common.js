/* eslint-disable import/extensions */
import $ from "jquery/dist/jquery.slim";
import quicklink from "quicklink/dist/quicklink.mjs";

function initQuicklink() {
  quicklink({
    ignores: [
      /\/wp\/?/,
      uri => uri.includes("#"),
      (uri, element) => element.hasAttribute("noprefetch")
    ]
  });
}

function handleSubMenus() {
  const subMenus = $(".nav .sub-menu").addClass("hidden");
  const toggleButton = $("<button />", {
    text: "▾",
    class: "text-grey-dark hover:text-grey-darker -ml-2 w-8 md:w-5"
  }).insertBefore(subMenus);

  // noinspection JSDeprecatedSymbols
  $(toggleButton).on("click", event => {
    $(event.currentTarget)
      .next(".sub-menu")
      .toggleClass("hidden");
    event.currentTarget.blur();
  });
}

function handleMenuToggle() {
  const toggleButton = $("#menu-toggle");

  // noinspection JSDeprecatedSymbols
  $(toggleButton).on("click", event => {
    $(event.currentTarget)
      .next("nav")
      .toggleClass("hidden");
  });
}

export default {
  init() {
    if (process.env.NODE_ENV === "production") {
      initQuicklink();
    }

    handleSubMenus();

    handleMenuToggle();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  }
};
