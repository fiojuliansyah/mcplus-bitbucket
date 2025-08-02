document.addEventListener('DOMContentLoaded', function () {
<<<<<<< HEAD
    bindCreateDropdowns();
    bindEditDropdowns(); // Initial bind (e.g. on page load)
});

function bindCreateDropdowns() {
=======
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
    const gradeDropdown = document.getElementById('gradeDropdown');
    const subjectDropdown = document.getElementById('subjectDropdown');
    const topicDropdown = document.getElementById('topicDropdown');
    const tutorDropdown = document.getElementById('tutorDropdown');

    if (!gradeDropdown || !subjectDropdown) return;

    gradeDropdown.addEventListener('change', function () {
        const gradeId = this.value;
        subjectDropdown.innerHTML = '<option value="">Loading...</option>';
<<<<<<< HEAD

        fetch(`/admin/subjects/by-grade/${gradeId}`)
            .then(res => res.json())
            .then(subjects => {
                subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
                subjects.forEach(subject => {
                    subjectDropdown.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                });

                // Clear dependent fields
=======
        fetch(`/admin/subjects/by-grade/${gradeId}`)
            .then(res => res.json())
            .then(data => {
                subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
                data.forEach(subject => {
                    subjectDropdown.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                });
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
                topicDropdown.innerHTML = '<option value="">Select Topic</option>';
                tutorDropdown.innerHTML = '<option value="">Select Tutor</option>';
            });
    });

    subjectDropdown.addEventListener('change', function () {
        const gradeId = gradeDropdown.value;
        const subjectId = this.value;

        topicDropdown.innerHTML = '<option value="">Loading...</option>';
<<<<<<< HEAD
        tutorDropdown.innerHTML = '<option value="">Loading...</option>';

        fetch(`/admin/topics/by-subject/${gradeId}/${subjectId}`)
            .then(res => res.json())
            .then(topics => {
                topicDropdown.innerHTML = '<option value="">Select Topic</option>';
                topics.forEach(topic => {
=======
        fetch(`/admin/topics/by-subject/${gradeId}/${subjectId}`)
            .then(res => res.json())
            .then(data => {
                topicDropdown.innerHTML = '<option value="">Select Topic</option>';
                data.forEach(topic => {
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
                    topicDropdown.innerHTML += `<option value="${topic.id}">${topic.name}</option>`;
                });
            });

<<<<<<< HEAD
        fetch(`/admin/tutors/by-subject/${subjectId}`)
            .then(res => res.json())
            .then(tutors => {
                tutorDropdown.innerHTML = '<option value="">Select Tutor</option>';
                tutors.forEach(tutor => {
=======
        tutorDropdown.innerHTML = '<option value="">Loading...</option>';
        fetch(`/admin/tutors/by-subject/${subjectId}`)
            .then(res => res.json())
            .then(data => {
                tutorDropdown.innerHTML = '<option value="">Select Tutor</option>';
                data.forEach(tutor => {
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
                    tutorDropdown.innerHTML += `<option value="${tutor.id}">${tutor.name}</option>`;
                });
            });
    });
<<<<<<< HEAD
}

function bindEditDropdowns() {
    // Loop through all grade dropdowns with edit prefix
    document.querySelectorAll('[id^="editGradeDropdown-"]').forEach(gradeDropdown => {
        const id = gradeDropdown.id.replace('editGradeDropdown-', '');
        const subjectDropdown = document.getElementById(`editSubjectDropdown-${id}`);
        const topicDropdown = document.getElementById(`editTopicDropdown-${id}`);
        const tutorDropdown = document.getElementById(`editTutorDropdown-${id}`);

        if (!subjectDropdown || !topicDropdown || !tutorDropdown) return;

        // Grade Change
        gradeDropdown.addEventListener('change', function () {
            const gradeId = this.value;

            subjectDropdown.innerHTML = '<option value="">Loading...</option>';

            fetch(`/admin/subjects/by-grade/${gradeId}`)
                .then(res => res.json())
                .then(subjects => {
                    subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
                    subjects.forEach(subject => {
                        subjectDropdown.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                    });

                    topicDropdown.innerHTML = '<option value="">Select Topic</option>';
                    tutorDropdown.innerHTML = '<option value="">Select Tutor</option>';
                });
        });

        // Subject Change
        subjectDropdown.addEventListener('change', function () {
            const gradeId = gradeDropdown.value;
            const subjectId = this.value;

            topicDropdown.innerHTML = '<option value="">Loading...</option>';
            tutorDropdown.innerHTML = '<option value="">Loading...</option>';

            fetch(`/admin/topics/by-subject/${gradeId}/${subjectId}`)
                .then(res => res.json())
                .then(topics => {
                    topicDropdown.innerHTML = '<option value="">Select Topic</option>';
                    topics.forEach(topic => {
                        topicDropdown.innerHTML += `<option value="${topic.id}">${topic.name}</option>`;
                    });
                });

            fetch(`/admin/tutors/by-subject/${subjectId}`)
                .then(res => res.json())
                .then(tutors => {
                    tutorDropdown.innerHTML = '<option value="">Select Tutor</option>';
                    tutors.forEach(tutor => {
                        tutorDropdown.innerHTML += `<option value="${tutor.id}">${tutor.name}</option>`;
                    });
                });
        });
    });
}
=======
});
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
