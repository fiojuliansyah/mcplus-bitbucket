document.addEventListener('DOMContentLoaded', function () {
    bindCreateDropdowns();
    bindEditDropdowns();
});

function bindCreateDropdowns() {
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
            .then(subjects => {
                subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
                subjects.forEach(subject => {
                    subjectDropdown.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                });

                // Clear dependent fields
                topicDropdown.innerHTML = '<option value="">Select Topic</option>';
                tutorDropdown.innerHTML = '<option value="">Select Tutor</option>';
            });
    });

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
}

function bindEditDropdowns() {
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
