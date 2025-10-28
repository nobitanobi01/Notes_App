<?php
include "db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    <link rel="icon" type="image/x-icon" href="favicon.png">
</head>

<body>
    <section class="container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-nav">
                <h2>Saved Notes</h2>
                <!-- Create Note Icon -->
                <i class="fa-solid fa-pen-to-square" onclick="createNote()" style="cursor:pointer;"></i>
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

                        <div class="note-item"
                            data-id="<?php echo $note_id ?>"
                            data-title="<?php echo htmlspecialchars($title, ENT_QUOTES) ?>"
                            data-subtitle="<?php echo htmlspecialchars($subtitle, ENT_QUOTES) ?>"
                            data-desc="<?php echo htmlspecialchars($desc, ENT_QUOTES) ?>"
                            data-fontsize="<?php echo $fontsize ?>"
                            data-image="<?php echo $image ?>"
                            data-last-updated="<?php echo $last_updated ?>">
                            <?php echo $index++ . '. ' . $title ?>
                        </div>

                        <?php
                    }
                } else {
                    echo "No Notes Yet!!!!";
                }
                ?>
            </div>
        </div>

        <!-- Main Container -->
        <div class="main-container" id="main-container">
            <div class="main-container-nav">
                <h2>Notes</h2>
                <i class="fa-solid fa-bars" id="toggleSidebarBtn" style="cursor: pointer;"></i>
            </div>

            <!-- Create Note Section -->
            <div class="main-container-content" id="create" style="display:none;">
                <div class="view-note">
                    <div class="content">
                        <form action="insertRecord.php" method="post" enctype="multipart/form-data">
                            <input type="text" name="title" placeholder="Enter Title" required><br>
                            <input type="text" name="subtitle" placeholder="Enter Subtitle"><br>

                            <div class="values">
                                <textarea name="desc" id="desc" rows="10" placeholder="Write Your note here" required></textarea>
                                <select name="fontsize" id="font" onchange="changeSize()">
                                    <option value="18">Select Font Size</option>
                                    <?php for ($i = 8; $i <= 18; $i++) echo "<option value='$i'>$i</option>"; ?>
                                </select>
                            </div>
                            <input type="file" name="image" id="image">
                            <br>
                            <button type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- View Note Section -->
            <div class="main-container-content view" id="view" style="display:none;">
                <div class="view-note">
                    <div class="icons">
                        <i class="fa-solid fa-pen edit" onclick="updateNote()" style="color:green; cursor:pointer;"></i>
                        <form action="deleteRecord.php" method="post" style="display:inline;">
                            <input type="text" id="del_id" name="note_id" hidden>
                            <button id="del-btn" style="border:none; background:none; cursor:pointer;">
                                <i class="fa-solid fa-trash" style="color:red;"></i>
                            </button>
                        </form>
                    </div>
                    <div class="content">
                        <h1 id="title"></h1>
                        <h3 id="subtitle"></h3>
                        <p id="note_desc"></p>
                        <input type="text" id="findNote" hidden><br>
                        <img src="" alt="" id="viewImage" style="display:none;">
                        <p id="lastUpdated" style="font-style: italic; color: gray;"></p>
                    </div>
                </div>
            </div>

            <!-- Update Note Section -->
            <div class="main-container-content update" id="update" style="display:none;">
                <div class="view-note">
                    <div class="content">
                        <form action="updateRecord.php" method="post">
                            <input type="text" id="n_id" name="n_id" hidden>
                            <input type="text" name="title" id="update_title" placeholder="Enter Title" required><br>
                            <input type="text" name="subtitle" id="update_subtitle" placeholder="Enter Subtitle"><br>

                            <div class="values">
                                <textarea name="desc" id="update_desc" rows="10" placeholder="Write Your note here" required></textarea>
                                <select name="fontsize" id="update_font" required onchange="changeSizeU()">
                                    <option value="18">Select Font Size</option>
                                    <?php for ($i = 8; $i <= 18; $i++) echo "<option value='$i'>$i</option>"; ?>
                                </select>
                            </div>

                            <button type="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script>
    // ✅ Function to open the create note section
    function createNote() {
        document.getElementById("view").style.display = "none";
        document.getElementById("update").style.display = "none";
        document.getElementById("create").style.display = "block";
    }

    // ✅ Function to open update form with existing note data
    function updateNote() {
        let allNotesRecords = <?php echo json_encode($allNotes) ?>;
        document.getElementById("view").style.display = "none";
        document.getElementById("create").style.display = "none";
        document.getElementById("update").style.display = "block";
        let noteId = document.getElementById("findNote").value;

        allNotesRecords.forEach(element => {
            if (element["note_unique_id"] == noteId) {
                document.getElementById("n_id").value = element["note_unique_id"];
                document.getElementById("update_title").value = element["note_title"];
                document.getElementById("update_subtitle").value = element["note_subtitle"];
                let note = document.getElementById("update_desc");
                note.style.fontSize = element["note_desc_fontsize"] + "px";
                note.innerHTML = element["note_desc"];
            }
        });
    }

    // ✅ Sidebar and note selection behavior
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("toggleSidebarBtn");
        const sidebar = document.getElementById("sidebar");

        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("hide");
        });

        // Show "Create Note" by default on page load
        createNote();

        // Handle click on existing notes
        document.querySelectorAll(".note-item").forEach(item => {
            item.addEventListener("click", () => {
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
                document.getElementById("del_id").value = noteId;

                const viewImage = document.getElementById("viewImage");
                if (image) {
                    viewImage.src = image;
                    viewImage.style.display = "block";
                } else {
                    viewImage.style.display = "none";
                }

                if (window.innerWidth <= 768) {
                    sidebar.classList.add("hide");
                }
            });
        });
    });
</script>

</body>
</html>
