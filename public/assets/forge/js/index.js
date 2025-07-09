function setElementPositionAndHeight({ selectorOrElement, height, top }) {
    let elements;
    if (typeof selectorOrElement === 'string') {
        elements = document.querySelectorAll(selectorOrElement);
    } else if (selectorOrElement instanceof HTMLElement) {
        elements = [selectorOrElement];
    } else {
        throw new Error('Property "selectorOrElement" harus berupa string atau elemen HTML.');
    }

    elements.forEach(element => {
        element.style.setProperty('--element-height', `${height}px`);
        element.style.setProperty('--element-top', `${top}px`);
    });
}

function initToggleClassHandlers() {
    document.querySelectorAll('[data-toggle][data-target]').forEach(trigger => {
        const className = trigger.getAttribute('data-toggle');
        const targetSelector = trigger.getAttribute('data-target');
        const target = document.querySelector(targetSelector);

        if (target && className) {
            trigger.addEventListener('click', () => {
                target.classList.toggle(className);
            });
        }
    });
}

initToggleClassHandlers();

const header = document.querySelector('header');
const viewportHeight = window.innerHeight;
const headerHeight = header.offsetHeight;

setElementPositionAndHeight({
    selectorOrElement: '.sidebar',
    height: window.innerHeight - header.offsetHeight,
    top: header.offsetHeight
});

window.addEventListener("resize", () => {
    setElementPositionAndHeight({
        selectorOrElement: '.sidebar',
        height: window.innerHeight - header.offsetHeight,
        top: header.offsetHeight
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".accordion-button[data-title]");

    buttons.forEach(button => {
        const accordionTitle = button.dataset.title;

        button.addEventListener("click", function () {
            setTimeout(() => {
                fetch(`/accordion-state/save/${encodeURIComponent(accordionTitle)}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    console.log("Toggled accordion:", data);
                });
            }, 150);
        });
    });
});
