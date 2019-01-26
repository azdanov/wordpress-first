/* eslint-disable import/extensions */
import $ from "jquery";

function handleSubMenus() {
  const $subMenus = $(".nav .sub-menu").addClass("hidden");
  const $toggleButton = $("<button />", {
    title: "Toggle Sub-Menu",
    text: "▾",
    class: "text-grey-dark text-lg hover:text-grey-darker -ml-2 w-8 md:w-5"
  }).insertBefore($subMenus);

  // noinspection JSDeprecatedSymbols
  $toggleButton.on("click", event => {
    $(event.currentTarget)
      .next(".sub-menu")
      .toggleClass("hidden");
    event.currentTarget.blur();
  });
}

function handleMenuToggle() {
  const $toggleButton = $("#menu-toggle");

  // noinspection JSDeprecatedSymbols
  $toggleButton.on("click", event => {
    $(event.currentTarget)
      .next("nav")
      .toggleClass("hidden");
  });
}

function handleSidebarToggle() {
  const $sidebar = $(".sidebar").hide();

  if ($sidebar) {
    $($sidebar).hide();
    const $button = $(
      "<button class='toggle-sidebar left' title='Toggle Sidebar'>▾</button>"
    ).insertBefore($sidebar);

    const $attachment = $(".featured-image").addClass("full-bleed");

    $button.on("click", event => {
      event.currentTarget.blur();
      $button.toggleClass("right left sidebar-visible");
      $attachment.toggleClass("full-bleed");

      $($sidebar).toggle();
    });
  }
}

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
