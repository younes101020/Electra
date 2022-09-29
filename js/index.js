gsap.set(".litem", {x:900});
        gsap.set(".logo", {autoAlpha: 0});

        let landingtl = gsap.timeline({});
        
        

        landingtl.to(".spidermanbox", {x: -900});
        landingtl.to(".womenbox", {x: -900});
        landingtl.to(".communitybox", {x: -900});
        
        landingtl.to(".logo", {autoAlpha: 1});