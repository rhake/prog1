document.documentElement.classList.add('js');

if (window.lucide) {
    lucide.createIcons();
}

document.querySelectorAll('[data-toggle-password]').forEach((button) => {
    button.addEventListener('click', () => {
        const input = button.parentElement.querySelector('input');
        if (!input) return;
        input.type = input.type === 'password' ? 'text' : 'password';
    });
});

document.querySelectorAll('[data-wizard]').forEach((form) => {
    const steps = [...form.querySelectorAll('[data-step]')];
    const dots = [...form.querySelectorAll('[data-step-dot]')];
    let current = 0;

    const show = (index) => {
        current = index;
        steps.forEach((step, i) => {
            step.hidden = i !== index;
        });
        dots.forEach((dot, i) => dot.classList.toggle('on', i <= index));
    };

    form.addEventListener('click', (event) => {
        if (event.target.closest('[data-next]')) {
            event.preventDefault();
            const radios = steps[current].querySelectorAll('input[type="radio"]');
            if (radios.length && ![...radios].some((radio) => radio.checked)) {
                radios[0].reportValidity();
                return;
            }
            show(Math.min(current + 1, steps.length - 1));
        }
        if (event.target.closest('[data-prev]')) {
            event.preventDefault();
            show(Math.max(current - 1, 0));
        }
    });

    show(0);
});

document.querySelectorAll('#map').forEach((element) => {
    if (!window.L) return;
    let points = [];
    try {
        points = JSON.parse(element.dataset.points || '[]').filter((point) => point.lat && point.lng);
    } catch (error) {
        points = [];
    }
    const map = L.map(element).setView(points[0] ? [points[0].lat, points[0].lng] : [-23.55, -46.63], points.length ? 12 : 11);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 19,
    }).addTo(map);
    const icon = L.divIcon({ className: 'pin', html: '<span></span>', iconSize: [16, 16], iconAnchor: [8, 8] });
    const markers = points.map((point) => L.marker([point.lat, point.lng], { icon }).addTo(map).bindPopup(`<strong>${point.name || ''}</strong><br>${point.address || ''}`));
    const frame = () => {
        map.invalidateSize();
        if (markers.length > 1) {
            map.fitBounds(L.featureGroup(markers).getBounds().pad(0.35));
        }
    };
    setTimeout(frame, 150);
});
