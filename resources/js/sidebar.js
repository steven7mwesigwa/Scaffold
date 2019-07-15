window.onload = () => {
    document.querySelector('.sidebar-toggle').onclick = () => {
        document.querySelector('.sidebar').classList.toggle("toggled");
    }

    window.addEventListener("resize", () => {
        document.querySelector('.sidebar').classList.remove('toggled');
    });
}
