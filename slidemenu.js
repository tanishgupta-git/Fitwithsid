var openbutton = document.querySelector(".click-show");
var closebutton = document.querySelector(".click-hide")
var navparent  =  document.querySelector(".nav-parent");
var body  = document.querySelector("body");
navparent.addEventListener("click" , function(event){
     event.stopPropagation();
 },false);
openbutton.addEventListener("click" , function(event){
    event.stopPropagation();
    navparent.classList.add("move");
    body.click(function(event){
        if(event.target!=navparent)
        navparent.classList.remove("move");
    })
},false)
closebutton.addEventListener("click" , function(){
    navparent.classList.remove("move");
})