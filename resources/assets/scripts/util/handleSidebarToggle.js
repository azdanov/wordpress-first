import $ from "jquery";

export function handleSidebarToggle() {
  const $sidebar = $(".sidebar").hide();

  if ($sidebar) {
    $($sidebar).hide();
    const $button = $(
      "<button class='toggle-sidebar left' title='Toggle Sidebar'>▾</button>"
    ).insertBefore($sidebar);

    const $attachment = $(".featured-image")
      .not(".index")
      .addClass("full-bleed");

    $button.on("click", event => {
      event.currentTarget.blur();
      $button.toggleClass("right left sidebar-visible");
      $attachment.toggleClass("full-bleed");

      $($sidebar).toggle();
    });
  }
}
