const io = new IntersectionObserver(
  (entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) {
        e.target.classList.add("visible");
        io.unobserve(e.target);
      }
    });
  },
  { threshold: 0.1 },
);
document.querySelectorAll(".reveal").forEach((el) => io.observe(el));

const barIO = new IntersectionObserver(
  (entries) => {
    entries.forEach((e) => {
      if (e.isIntersecting) {
        e.target.querySelectorAll(".mp-fill").forEach((bar, i) => {
          setTimeout(() => {
            bar.style.transition = "width 1.3s cubic-bezier(.4,0,.2,1)";
            bar.style.width = bar.dataset.w;
          }, i * 120);
        });
        barIO.unobserve(e.target);
      }
      z;
    });
  },
  { threshold: 0.3 },
);
const kep = document.querySelector("#kependudukan");
if (kep) barIO.observe(kep);
