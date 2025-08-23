// resources/js/gerencia-reservas.js

document.addEventListener('keydown', function(e) {
    const dateInput = document.getElementById('date');
    const current = new Date(dateInput.value || new Date().toISOString().slice(0,10));

    const f = d => {
        const m = String(d.getMonth()+1).padStart(2,'0');
        const day = String(d.getDate()).padStart(2,'0');
        return `${d.getFullYear()}-${m}-${day}`;
    };

    let shift = window.shiftKeyBlade; // lo explico abajo 👇

    if (e.key === 'ArrowRight') {
        current.setDate(current.getDate() + 1);
        window.location = `${window.routeReservas}?date=${f(current)}&shift=${shift}`;
    }
    if (e.key === 'ArrowLeft') {
        current.setDate(current.getDate() - 1);
        window.location = `${window.routeReservas}?date=${f(current)}&shift=${shift}`;
    }
    if (e.key.toLowerCase() === 'm') {
        shift = 'mediodia';
        window.location = `${window.routeReservas}?date=${dateInput.value}&shift=${shift}`;
    }
    if (e.key.toLowerCase() === 'n') {
        shift = 'noche';
        window.location = `${window.routeReservas}?date=${dateInput.value}&shift=${shift}`;
    }
});
