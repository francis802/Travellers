
function toggleSearchButton(buttonId, sectionId) {
    const buttons = document.querySelectorAll('#buttons button');
    buttons.forEach(button => {
        button.classList.remove('underline');
    });
    const selectedButton = document.getElementById(buttonId);
    selectedButton.classList.add('underline');

    document.getElementById('user-bar').style.display = 'none';
    document.getElementById('groups').style.display = 'none';
    document.getElementById('posts').style.display = 'none';
    document.getElementById('select-date-range').style.display = 'none';
    document.getElementById('date-range').style.display = 'none';

    document.getElementById(sectionId).style.display = 'flex';

    if (sectionId == 'posts') {
        document.getElementById('select-date-range').style.display = 'flex';
    }
}

function toggleDateRange() {
    const dateRangeSection = document.getElementById('date-range');
    const currentDisplay = dateRangeSection.style.display;

    // Toggle visibility
    dateRangeSection.style.display = currentDisplay === 'none' ? 'block' : 'none';
}

function applyDateRange() {
    const startDate = document.getElementById('start-date').value;
    const endDate = document.getElementById('end-date').value;

    const input = document.querySelector("#date-range input[type='hidden']").value;

    const url = `/search?query=` + input + `&startDate=`+ startDate + `&endDate=`+ endDate;

    window.location.href = url;
}


document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('date-range').style.display = 'none';
    document.getElementById('groups').style.display = 'none';
    document.getElementById('posts').style.display = 'none';
    document.getElementById('select-date-range').style.display = 'none';
    document.getElementById('apply-date-range').addEventListener('click', applyDateRange);

    
});
