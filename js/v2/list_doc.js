// var myselect = document.getElementById("select-status");
// myselect.addEventListener("change", function() {
//     console.log(myselect);
//   var selectedOption = this.options[this.selectedIndex];
//   var color = selectedOption.value;
//   if (color==1) {
//     this.style.backgroundColor = "rgba(138,255,185,0.25)";
//     this.style.color = "#037847";
//   } else if(color==2){
//     this.style.backgroundColor = "rgba(242, 145, 0, 0.25)";
//     this.style.color = "rgba(82, 49, 0, 1)";
//   }
//   else {
//     this.style.backgroundColor = "rgba(214, 214, 214, 1)";
//   }
// });

$(document).ready(function(){
    $(".btn-close-form").click(function(){
        $(".search-filter-form").hide();
        $(".toggle-body").hide();
    });
    $("#btn-filter-form").click(function(){
        $(".search-filter-form").show();
        $(".toggle-body").show();
    });
    $(".btn-close").click(function(){
      $(".search-filter-form").hide();
      $(".toggle-body").hide();
    });
    $(".toggle-body").click(function(){
        $(".search-filter-form").hide();
        $(".toggle-body").hide();
    });
});
