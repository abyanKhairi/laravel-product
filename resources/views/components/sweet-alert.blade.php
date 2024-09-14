<div x-data="{ open: false }" x-show="open"
    @sweet.window="
  Swal.fire({
  title: event.detail.title,
  text: event.detail.text ,
  icon: event.detail.icon }) ">

</div>
