document.addEventListener("DOMContentLoaded", () => {
    const eventDate = new Date("2025-01-18T12:00:00"); 
    const timer = document.getElementById("countdown-timer");

    function updateCountdown() {
        const now = new Date();
        const timeLeft = eventDate - now;

        if (timeLeft <= 0) {
            timer.innerHTML = "<p>The event has started!</p>";
            clearInterval(interval);
            return;
        }

        // Calculate days, hours, minutes, and seconds
        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        // Update the DOM
        timer.innerHTML = `
            <div>${days} <span>Days</span></div>
            <div>${hours} <span>Hours</span></div>
            <div>${minutes} <span>Minutes</span></div>
            <div>${seconds} <span>Seconds</span></div>
        `;
    }

    // Run the timer and update every second
    const interval = setInterval(updateCountdown, 1000);
    updateCountdown(); 
});
