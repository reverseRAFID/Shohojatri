const $cursor = document.querySelector('#cursor');

// Listeners
document.body.addEventListener('mousemove', onMouseMove);

// Move cursor
function onMouseMove(e) {

    // set cursor position
    $cursor.style.left = `${e.pageX}px`;
    $cursor.style.top = `${e.pageY}px`;

    // set cursor trail
    const trail = document.createElement('div');
    trail.className = 'trail';
    trail.style.left = `${e.pageX}px`;
    trail.style.top = `${e.pageY}px`;
    document.body.appendChild(trail);

    // remove trail
    setTimeout(() => {
        trail.remove();
    }, 2000);

}
