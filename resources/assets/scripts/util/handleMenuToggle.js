import $ from "jquery";

export function handleMenuToggle() {
  const $toggleButton = $("#menu-toggle");

  // noinspection JSDeprecatedSymbols
  $toggleButton.on("click", event => {
    $(event.currentTarget)
      .next("nav")
      .toggleClass("hidden");
  });
}
