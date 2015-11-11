function toggleNav() {
    var element = document.getElementById('navigation');
    if (element.className.indexOf("open") > -1) {
        element.className = element.className.replace(/\bopen\b/, '');
    } else {
        element.className = element.className + " open";
    }
}