document.addEventListener('DOMContentLoaded', () => {
    initializeDateSelector();
    initializeFilters();
    initializeReservationActions();
    initializeCalendar();
    initializeTimeSlots();
    updateStatistics();
});


// 예약 필터 초기화
function initializeFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // 활성화된 필터 표시
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // 예약 목록 필터링
            const status = button.textContent;
            filterReservations(status);
        });
    });
}