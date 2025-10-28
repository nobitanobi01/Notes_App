<?php
include "db.php";

$stmt = $conn->prepare("SELECT * FROM notes");
$stmt->execute();
$result = $stmt->get_result();
$allNotes = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $allNotes[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes-App</title>
    <script src="https://kit.fontawesome.com/35821647e0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="stylesheet1.css">
</head>

<body>
    <section class="container">
        <div class="sidebar" id="sidebar">
            <div class="sidebar-nav">
                <h2>Saved Notes</h2>
                <i class="fa-solid fa-pen-to-square" onclick="createNote()"></i>
            </div>

            <div class="sidebar-list">
                <?php
                if (count($allNotes) != 0) {
                    $index = 1;
                    foreach ($allNotes as $single) {
                        $note_id = $single["note_unique_id"];
                        $title = $single["note_title"];
                        $subtitle = $single["note_subtitle"];
                        $desc = $single["note_desc"];
                        $fontsize = $single["note_desc_fontsize"];
                        $image = $single["note_image"];
                        $last_updated = $single["last_updated"];

                        ?>

                        <div class="note-item" data-id="<?php echo $note_id ?>"
                            data-title="<?php echo htmlspecialchars($title, ENT_QUOTES) ?>"
                            data-subtitle="<?php echo htmlspecialchars($subtitle, ENT_QUOTES) ?>"
                            data-desc="<?php echo htmlspecialchars($desc, ENT_QUOTES) ?>"
                            data-fontsize="<?php echo $fontsize ?>" data-image="<?php echo $image ?>"
                            data-last-updated="<?php echo $last_updated ?>">
                            <?php echo $index++ . '. ' . $title ?>
                        </div>

                        <?php
                    }
                } else {

                    echo " No Notes Yet!!!!";

                }
                ?>
            </div>
        </div>

        <div class="main-container" id="main-container">
            <div class="main-container-nav">
                <h2>Notes</h2>
                <i class="fa-solid fa-bars" id="toggleSidebarBtn" style="cursor: pointer; "></i>
            </div>
            <div class="main-container-content" id="create">
                <div class="view-note">
                    <div class="content">
                        <form action="insertRecord.php" method="post" enctype="multipart/form-data">
                            <input type="text" name="title" placeholder="Enter Title" required
                                style="font-family: 'Comic Relief', system-ui; "><br>
                            <input type="text" name="subtitle" placeholder="Enter Subtitle" style="  
                                  font-family: 'Comic Relief', system-ui;"><br>

                            <div class="values">
                                <textarea name="desc" id="desc" rows="10" placeholder="Write Your note here" required
                                    style="font-family: 'Comic Relief', system-ui; "></textarea>
                                <select name="fontsize" id="font" onchange="changeSize()"
                                    style="font-family: 'Comic Relief', system-ui; ">
                                    <option value="18">Select Font Size</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                </select>
                            </div>
                            <input type="file" name="image" id="image" style="font-family: 'Comic Relief', system-ui; ">
                            <br>
                            <button type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="main-container-content view" id="view">
                <div class="view-note">
                    <div class="icons">
                        <form>
                            <i class="fa-solid fa-pen edit" onclick="updateNote()" style="color:green"></i>
                        </form>
                        <form action="deleteRecord.php" method="post">
                            <input type="text" id="del_id" name="note_id" hidden>
                            <button id="del-btn"><i class="fa-solid fa-trash" style="color:red"></i></button>
                        </form>
                    </div>
                    <div class="content">
                        <h1 id="title"></h1>
                        <h3 id="subtitle"></h3>
                        <p id="note_desc"></p>
                        <input type="text" id="findNote" hidden><br>
                        <img src="" alt="" id="viewImage">

                        <!-- Add Date and Time of Last Update -->
                        <p id="lastUpdated" style="font-style: italic; color: gray;"></p>
                    </div>
                </div>
            </div>

            <div class="main-container-content update" id="update">
                <div class="view-note">
                    <div class="content">
                        <form action="updateRecord.php" method="post">
                            <input type="text" id="n_id" name="n_id" hidden
                                style="font-family: 'Comic Relief', system-ui; ">
                            <input type="text" name="title" id="update_title" placeholder="Enter Title" required
                                style="font-family: 'Comic Relief', system-ui; "><br>
                            <input type="text" name="subtitle" id="update_subtitle" placeholder="Enter Subtitle"
                                style="font-family: 'Comic Relief', system-ui; "><br>

                            <div class="values">
                                <textarea name="desc" id="update_desc" rows="10" placeholder="Write Your note here"
                                    required style="font-family: 'Comic Relief', system-ui; "></textarea>
                                <select name="fontsize" id="update_font" required onchange="changeSizeU()" style="font-family: 'Comic Relief', system-ui; ">
                                    <option value="18">Select Font Size</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                </select>
                            </div>

                            <button type="submit" style="font-family: 'Comic Relief', system-ui; ">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
<script src="script.js"></script>
<script>

    function updateNote() {
        let allNotesRecords = <?php echo json_encode($allNotes) ?>;

        document.getElementById("view").style.display = "none";
        document.getElementById("create").style.display = "none";
        document.getElementById("update").style.display = "block";

        let a = document.getElementById("findNote").value;

        allNotesRecords.forEach(element => {
            if (element["note_unique_id"] == a) {

                document.getElementById("n_id").value = element["note_unique_id"];
                document.getElementById("update_title").value = element["note_title"];
                document.getElementById("update_subtitle").value = element["note_subtitle"];

                let note = document.getElementById("update_desc");
                note.style.fontSize = element["note_desc_fontsize"] + "px";
                note.innerHTML = element["note_desc"];
            }
        });
    }

    // Display last updated date and time in the view mode
    document.querySelectorAll('.note-item').forEach(item => {
        item.addEventListener('click', () => {
            const lastUpdated = item.getAttribute('data-last-updated');
            const formattedDate = new Date(lastUpdated).toLocaleString(); // Format it to a readable format

            document.getElementById('lastUpdated').innerText = 'Last updated: ' + formattedDate;
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("toggleSidebarBtn");
        const sidebar = document.getElementById("sidebar");
        const mainContainer = document.getElementById("main-container");

        let sidebarVisible = true;

        toggleBtn.addEventListener("click", function () {
            sidebarVisible = !sidebarVisible;

            if (sidebarVisible) {
                sidebar.style.display = "block";
                mainContainer.style.width = "81%"; // or whatever you use
            } else {
                sidebar.style.display = "none";
                mainContainer.style.width = "100%";
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("toggleSidebarBtn");
        const sidebar = document.getElementById("sidebar");
        const mainContainer = document.getElementById("main-container");

        // Handle menu toggle (≡)
        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("hide");
        });

        // When a note is clicked, show its content and hide sidebar on mobile
        document.querySelectorAll(".note-item").forEach(item => {
            item.addEventListener("click", () => {
                // ✅ Hide sidebar on mobile
                if (window.innerWidth <= 768) {
                    sidebar.classList.add("hide");
                }

                // ✅ Show the note content
                const title = item.getAttribute("data-title");
                const subtitle = item.getAttribute("data-subtitle");
                const desc = item.getAttribute("data-desc");
                const fontSize = item.getAttribute("data-fontsize");
                const image = item.getAttribute("data-image");
                const lastUpdated = new Date(item.getAttribute("data-last-updated")).toLocaleString();
                const noteId = item.getAttribute("data-id");

                document.getElementById("view").style.display = "block";
                document.getElementById("create").style.display = "none";
                document.getElementById("update").style.display = "none";

                document.getElementById("title").innerText = title;
                document.getElementById("subtitle").innerText = subtitle;
                document.getElementById("note_desc").innerText = desc;
                document.getElementById("note_desc").style.fontSize = fontSize + "px";
                document.getElementById("lastUpdated").innerText = "Last updated: " + lastUpdated;
                document.getElementById("findNote").value = noteId;

                const viewImage = document.getElementById("viewImage");
                if (image) {
                    viewImage.src = image;
                    viewImage.style.display = "block";
                } else {
                    viewImage.style.display = "none";
                }
            });
        });
    });


</script>

</html>