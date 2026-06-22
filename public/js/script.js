AOS.init({
    duration:1200,
    once:true
});

// NAVBAR EFFECT
window.addEventListener("scroll",()=>{

    let navbar=document.querySelector(".custom-navbar");

    navbar.classList.toggle(
        "scrolled",
        window.scrollY > 50
    );

});

// ACTIVE MENU
const sections=document.querySelectorAll("section");

const navLinks=document.querySelectorAll(".nav-link");

window.addEventListener("scroll",()=>{

    let current="";

    sections.forEach(section=>{

        const top=section.offsetTop - 200;

        if(pageYOffset >= top){
            current=section.getAttribute("id");
        }

    });

    navLinks.forEach(link=>{

        link.classList.remove("active");

        if(link.getAttribute("href").includes(current)){
            link.classList.add("active");
        }

    });

});

// PARTICLE EFFECT
const particles=document.getElementById("particles");

for(let i=0;i<40;i++){

    let particle=document.createElement("div");

    particle.style.position="absolute";
    particle.style.width=Math.random()*4+"px";
    particle.style.height=particle.style.width;
    particle.style.background="white";
    particle.style.opacity="0.1";
    particle.style.borderRadius="50%";
    particle.style.left=Math.random()*100+"%";
    particle.style.top=Math.random()*100+"%";

    particles.appendChild(particle);

}