import $ from "jquery";

export function handleSubMenus() {
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
