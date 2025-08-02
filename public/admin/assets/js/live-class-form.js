document.addEventListener('DOMContentLoaded', function () {
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> dc16350 (Add Update and Delete Live Class)
    bindCreateDropdowns();
    bindEditDropdowns(); // Initial bind (e.g. on page load)
});

function bindCreateDropdowns() {
<<<<<<< HEAD
=======
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
=======
>>>>>>> dc16350 (Add Update and Delete Live Class)
    const gradeDropdown = document.getElementById('gradeDropdown');
    const subjectDropdown = document.getElementById('subjectDropdown');
    const topicDropdown = document.getElementById('topicDropdown');
    const tutorDropdown = document.getElementById('tutorDropdown');

    if (!gradeDropdown || !subjectDropdown) return;

    gradeDropdown.addEventListener('change', function () {
        const gradeId = this.value;
        subjectDropdown.innerHTML = '<option value="">Loading...</option>';
<<<<<<< HEAD
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
=======

>>>>>>> dc16350 (Add Update and Delete Live Class)
        fetch(`/admin/subjects/by-grade/${gradeId}`)
            .then(res => res.json())
            .then(subjects => {
                subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
                subjects.forEach(subject => {
                    subjectDropdown.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                });
<<<<<<< HEAD
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
=======

                // Clear dependent fields
>>>>>>> dc16350 (Add Update and Delete Live Class)
                topicDropdown.innerHTML = '<option value="">Select Topic</option>';
                tutorDropdown.innerHTML = '<option value="">Select Tutor</option>';
            });
    });

    subjectDropdown.addEventListener('change', function () {
        const gradeId = gradeDropdown.value;
        const subjectId = this.value;

        topicDropdown.innerHTML = '<option value="">Loading...</option>';
<<<<<<< HEAD
<<<<<<< HEAD
        tutorDropdown.innerHTML = '<option value="">Loading...</option>';

        fetch(`/admin/topics/by-subject/${gradeId}/${subjectId}`)
            .then(res => res.json())
            .then(topics => {
                topicDropdown.innerHTML = '<option value="">Select Topic</option>';
                topics.forEach(topic => {
=======
=======
        tutorDropdown.innerHTML = '<option value="">Loading...</option>';

>>>>>>> dc16350 (Add Update and Delete Live Class)
        fetch(`/admin/topics/by-subject/${gradeId}/${subjectId}`)
            .then(res => res.json())
            .then(topics => {
                topicDropdown.innerHTML = '<option value="">Select Topic</option>';
<<<<<<< HEAD
                data.forEach(topic => {
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
=======
                topics.forEach(topic => {
>>>>>>> dc16350 (Add Update and Delete Live Class)
                    topicDropdown.innerHTML += `<option value="${topic.id}">${topic.name}</option>`;
                });
            });

<<<<<<< HEAD
<<<<<<< HEAD
        fetch(`/admin/tutors/by-subject/${subjectId}`)
            .then(res => res.json())
            .then(tutors => {
                tutorDropdown.innerHTML = '<option value="">Select Tutor</option>';
                tutors.forEach(tutor => {
=======
        tutorDropdown.innerHTML = '<option value="">Loading...</option>';
=======
>>>>>>> dc16350 (Add Update and Delete Live Class)
        fetch(`/admin/tutors/by-subject/${subjectId}`)
            .then(res => res.json())
            .then(tutors => {
                tutorDropdown.innerHTML = '<option value="">Select Tutor</option>';
<<<<<<< HEAD
                data.forEach(tutor => {
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
=======
                tutors.forEach(tutor => {
>>>>>>> dc16350 (Add Update and Delete Live Class)
                    tutorDropdown.innerHTML += `<option value="${tutor.id}">${tutor.name}</option>`;
                });
            });
    });
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> dc16350 (Add Update and Delete Live Class)
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
<<<<<<< HEAD
=======
});
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
=======
>>>>>>> dc16350 (Add Update and Delete Live Class)
