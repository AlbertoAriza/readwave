document.addEventListener('DOMContentLoaded', () => {
    const audio = document.getElementById('audio');
    const subtitles = document.querySelectorAll('.subtitle');

    audio.addEventListener('timeupdate', () => {
        const currentTime = audio.currentTime;
        subtitles.forEach(subtitle => {
            const start = parseFloat(subtitle.dataset.start);
            const end = parseFloat(subtitle.dataset.end);

            if (currentTime >= start && currentTime <= end) {
                subtitle.classList.add('highlight');
            } else {
                subtitle.classList.remove('highlight');
            }
        });
    });

    subtitles.forEach(subtitle => {
        subtitle.addEventListener('click', () => {
            const start = parseFloat(subtitle.dataset.start);
            audio.currentTime = start;
            audio.play();
        });
    });
});