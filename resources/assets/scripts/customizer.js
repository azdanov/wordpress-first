import $ from "jquery";

wp.customize("rock", value => {
  value.bind(to => $(".brand").text(to));
});
