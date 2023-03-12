(() => {
    const header = document.querySelector("header");
    const nav = document.querySelector("nav");

    document.addEventListener("scroll", function (e) {
        if (window.innerWidth >= 768) {
            if (window.scrollY > 300) {
                header.style.transform = "translateY(-8rem)";
            } else {
                header.style.transform = "translateY(0)";
            }
        }
    });
})();
