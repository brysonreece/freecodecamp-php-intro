<!doctype html>

<?php
    $uploadedImages = [];
    $imageDir = 'images';

    foreach (scandir($imageDir) as $filename) {
        $targetFile = $imageDir . DIRECTORY_SEPARATOR . $filename;

        if (! is_dir($targetFile)) {
            array_push($uploadedImages, $targetFile);
        }
    }
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.5/dist/alpine.js" defer></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <!-- Card -->
    <body class="h-screen overflow-hidden flex items-center justify-center" style="background: #edf2f7;">
        <div class="flex flex-col w-full h-screen items-center justify-center bg-grey-lighter">
            <?php
                if (isset($_GET['success'])) {
                    echo "<p id='success' class='text-green-500 text-xs text-center font-semibold italic mb-8'>" . html_entity_decode($_GET['success']) . "</p>";
                }
            ?>

            <!-- Photo Gallery -->
            <?php if (! empty($uploadedImages)): ?>
                <div class="grid grid-cols-3 gap-6 mb-8">
                    <?php foreach ($uploadedImages as $image): ?>
                        <div class="bg-white rounded-lg shadow-lg p-8 w-64 flex items-center justify-center">
                            <a href="<?php echo $image; ?>">
                                <img src="<?php echo $image; ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Upload Form -->
            <form class="w-64" action="upload.php" method="post" enctype="multipart/form-data">
                <!-- File picker -->
                <label class="flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue-400 hover:text-white">
                    <!-- Icon -->
                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                    </svg>

                    <!-- Preview -->
                    <span id="previewText" class="mt-2 text-base leading-normal">Select a file</span>

                    <!-- Hidden Upload -->
                    <input type='file' id="fileUpload" name="photo" class="hidden" />
                </label>

                <!-- Upload button -->
                <button id="uploadButton" type="submit" style="display: none;" class="mt-4 w-full text-center text-base inline-flex items-center justify-center px-6 py-4 border border-gray-300 text-xs leading-4 font-medium rounded text-gray-700 bg-white hover:bg-blue-400 hover:text-white focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-200 active:bg-blue-500 transition ease-in-out duration-150">
                    Upload
                </button>

                <?php
                    if (isset($_GET['error'])) {
                        echo "<p id='error' class='text-red-500 text-xs text-center font-semibold italic mt-5'>" . html_entity_decode($_GET['error']) . "</p>";
                    }
                ?>
            </form>
        </div>
    </body>

    <script type="text/javascript">
        var uploadElement = document.getElementById("fileUpload");
        var textElement = document.getElementById("previewText");
        var buttonElement = document.getElementById("uploadButton");
        var errorElement = document.getElementById("error");
        var successElement = document.getElementById("success");

        uploadElement.addEventListener('change', () => {
            // Count how many files the user selected
            var fileCount = uploadElement.files.length;

            // Update the preview text
            if (fileCount > 0) {
                // File count string, adds 's' to end if fileCount > 1
                var previewText = fileCount + ' file';

                if (fileCount > 1) {
                    $text += 's';
                }

                textElement.innerText = previewText;
                buttonElement.style.display = 'block';
            }
            else {
                textElement.innerText = 'Select a file';
                buttonElement.style.display = 'none';
            }

            errorElement.style.display = 'none';
            successElement.style.display = 'none';
        });
    </script>
</body>
