function submitNewFaq() {
    // Get the values from the form
    var newQuestion = document.getElementById('newQuestion').value;
    var newAnswer = document.getElementById('newAnswer').value;

    // Validate the values (you can add more validation logic)
    if (!newQuestion || !newAnswer) {
        alert('Please fill in both question and answer.');
        return;
    }

    // Set the values in a hidden form (assuming you have a form with an ID 'newFaqForm')
    document.getElementById('newFaqQuestion').value = newQuestion;
    document.getElementById('newFaqAnswer').value = newAnswer;

    // Submit the form
    document.getElementById('newFaqForm').submit();
}