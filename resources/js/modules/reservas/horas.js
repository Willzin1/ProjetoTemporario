export default function() {
    const horaInput = document.getElementById('hora');

    for (let h = 9; h <= 20; h++) { // Hora de 9h até 20h30
        for (let m = 0; m <= 30; m += 30) {
            const timeOption = `${h}:${m.toString().padStart(2, '0')}`;
            const option = document.createElement('option');
            option.value = timeOption;
            option.textContent = timeOption;
            horaInput.appendChild(option);
        }
    }
}
