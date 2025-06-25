document.addEventListener('DOMContentLoaded', function () {
    const gradeDropdown = document.getElementById('gradeDropdown');
    const subjectDropdown = document.getElementById('subjectDropdown');
    const topicDropdown = document.getElementById('topicDropdown');
    const tutorDropdown = document.getElementById('tutorDropdown');

    if (!gradeDropdown || !subjectDropdown) return;

    gradeDropdown.addEventListener('change', function () {
        const gradeId = this.value;
        subjectDropdown.innerHTML = '<option value="">Loading...</option>';
        fetch(`/admin/subjects/by-grade/${gradeId}`)
            .then(res => res.json())
            .then(data => {
                subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
                data.forEach(subject => {
                    subjectDropdown.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                });
                topicDropdown.innerHTML = '<option value="">Select Topic</option>';
                tutorDropdown.innerHTML = '<option value="">Select Tutor</option>';
            });
    });

    subjectDropdown.addEventListener('change', function () {
        const gradeId = gradeDropdown.value;
        const subjectId = this.value;

        topicDropdown.innerHTML = '<option value="">Loading...</option>';
        fetch(`/admin/topics/by-subject/${gradeId}/${subjectId}`)
            .then(res => res.json())
            .then(data => {
                topicDropdown.innerHTML = '<option value="">Select Topic</option>';
                data.forEach(topic => {
                    topicDropdown.innerHTML += `<option value="${topic.id}">${topic.name}</option>`;
                });
            });

        tutorDropdown.innerHTML = '<option value="">Loading...</option>';
        fetch(`/admin/tutors/by-subject/${subjectId}`)
            .then(res => res.json())
            .then(data => {
                tutorDropdown.innerHTML = '<option value="">Select Tutor</option>';
                data.forEach(tutor => {
                    tutorDropdown.innerHTML += `<option value="${tutor.id}">${tutor.name}</option>`;
                });
            });
    });
});
