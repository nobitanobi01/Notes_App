function hideSidebar() {
    document.getElementById("sidebar").style.display = "none";
    document.getElementById("main-container").style.width = "100%";
    document.getElementById("new-note").style.display = "block";
    document.getElementById("showSidebar").style.display = "block";
}

function showSidebar() {
    document.getElementById("sidebar").style.display = "block";
    document.getElementById("main-container").style.width = "81%";
    document.getElementById("showSidebar").style.display = "none";
    document.getElementById("new-note").style.display = "none";
}

function viewNote(element) {
    // Remove active class from all notes
    document.querySelectorAll('.note-item').forEach(el => el.classList.remove('active'));
    element.classList.add('active');

    const id = element.getAttribute('data-id');
    const title = element.getAttribute('data-title');
    const subtitle = element.getAttribute('data-subtitle');
    const desc = element.getAttribute('data-desc');
    const fontsize = element.getAttribute('data-fontsize');
    const image = element.getAttribute('data-image');
    const lastUpdated = element.getAttribute('data-last-updated');

    // Display note details
    document.getElementById("title").innerText = title;
    document.getElementById("subtitle").innerText = subtitle;
    document.getElementById("note_desc").innerText = desc;
    document.getElementById("note_desc").style.fontSize = fontsize + "px";

    const img = document.getElementById("viewImage");
    if (image && image !== "") {
        img.src = "uploads/" + image;
        img.style.display = "block";
    } else {
        img.style.display = "none";
    }

    if (lastUpdated) {
        let formattedDate = new Date(lastUpdated).toLocaleString();
        document.getElementById("lastUpdated").innerText = 'Last updated: ' + formattedDate;
    }

    // Set hidden inputs for update/delete
    document.getElementById("findNote").value = id;
    document.getElementById("del_id").value = id;

    // Show view content
    document.getElementById("view").style.display = "block";
    document.getElementById("create").style.display = "none";
    document.getElementById("update").style.display = "none";

    // ✅ Responsive behavior: hide sidebar if on mobile
    if (window.innerWidth <= 768) {
        document.getElementById("sidebar").style.display = "none";
        document.getElementById("main-container").style.width = "100%";
    }
}

function createNote() {
    document.getElementById("view").style.display = "none";
    document.getElementById("create").style.display = "block";
    document.getElementById("update").style.display = "none";

    // ✅ Responsive behavior: hide sidebar on mobile
    if (window.innerWidth <= 768) {
        document.getElementById("sidebar").style.display = "none";
        document.getElementById("main-container").style.width = "100%";
    }
}
