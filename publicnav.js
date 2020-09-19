// for loading the pages
 window.onload = function() 
  { setTimeout(function(){
  	document.getElementById("hideAll").style.display = "none";},3000) }
 // common code for all pages 
 var x= new Date();
  const date = document.querySelector("#date");
   var openbutton = document.querySelector(".click-show");
     var closebutton = document.querySelector(".side-nav-bar>.hide")
       var sidenavbar  =  document.querySelector(".side-nav-bar");
         var body  = document.querySelector("body");
        date.textContent = x.getFullYear();
        sidenavbar.addEventListener("click" , function(event){
          event.stopPropagation();
           },false);
       openbutton.addEventListener("click" , function(event){
          event.stopPropagation();
           sidenavbar.classList.add("move");
        body.addEventListener("click",function(){
          if(event.target!=sidenavbar)
           sidenavbar.classList.remove("move");
           })
            },false)
   closebutton.addEventListener("click" , function(){
      sidenavbar.classList.remove("move");
      })
// end of common code
// code for animation on scroll on public pages
// scroll jumpers code
const jumpOptions = {
	threshold:0,
	rootMargin:"0px 0px 0px 0px"
    }
const jumpboxes = document.querySelectorAll(".jumpers");
const jumpOnScroll = new IntersectionObserver(
   function(entries,jumpOnScroll){
   	entries.forEach(entry=>{
   		if(!entry.isIntersecting){
   			return; }
   		else{
   			entry.target.classList.add("jump");
   			jumpOnScroll.unobserve(entry.target);
   		}
   	});
   }
	,jumpOptions);
jumpboxes.forEach(jumpbox=>{
	jumpOnScroll.observe(jumpbox);
})
// end of scroll jumpers code
// code for bottom to up 
const mythOptions = {
	threshold:0,
	rootMargin:"0px 0px 0px 0px"
}
const mythboxes = document.querySelectorAll(".mythers");
const mythOnScroll = new IntersectionObserver(
	function(entries,mythOnScroll){
		entries.forEach(entry=>{
			if(!entry.isIntersecting){
				return;
			}
			else{
				entry.target.classList.add("myth");
				mythOnScroll.unobserve(entry.target);
			}
		});
	},mythOptions);
 mythboxes.forEach(mythbox=>{
 	mythOnScroll.observe(mythbox);
 })
// end of code for bottom to up
// scroll faders code
	const appearOptions = {
	threshold:0,
	rootMargin:"0px 0px -40px 0px"
}
const appearboxes = document.querySelectorAll(".faders");
const appearOnScroll = new IntersectionObserver(
	function(entries,appearOnScroll){
		entries.forEach(entry=>{
			if(!entry.isIntersecting){
				return;
			}
			else{
				entry.target.classList.add("appear");
				appearOnScroll.unobserve(entry.target);
			}
		});
	},
	appearOptions);
  appearboxes.forEach(appearbox=>{
  	appearOnScroll.observe(appearbox);
  });
// end of scroll faders code
// scroll sliders code
  const slideOptions = {
  	threshold:0,
  	rootMargin:"0px 0px -65px 0px"
  };
  const teamsliders = document.querySelectorAll(".sliders")
  const slideOnScroll = new IntersectionObserver(
    function(entries,slideOnScroll){
    	entries.forEach(entry => {
    	   if(!entry.isIntersecting){
    	   	return;
    	   }
    	   else{
    	   	entry.target.classList.add("slide");
    	   	slideOnScroll.unobserve(entry.target);
    	   }	
    	});
    },slideOptions);
  
  teamsliders.forEach(teamslider => {
  	slideOnScroll.observe(teamslider);
  });

// end of scroll sliders code
// end of code fpor animation on scroll
// code for animation in input text
 var input = document.querySelectorAll(".animated-input");
   var text = document.querySelectorAll(".text");
    var line = document.querySelectorAll(".animated-line");
	for(let i=0;i<2;i++)
	{
       input[i].addEventListener("focus",function(){
	   line[i].classList.add("move");
	   text[i].classList.add("move-change");
	});
     input[i].addEventListener("blur", function(){
		if(input[i].value==="")
		{
       line[i].classList.remove("move");
       text[i].classList.remove("move-change");
		}
	});
	}