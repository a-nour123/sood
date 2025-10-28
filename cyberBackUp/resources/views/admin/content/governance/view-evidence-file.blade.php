<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Evidence</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
        }

        .file-viewer {
            max-width: 90%;
            max-height: 90%;
            overflow: hidden;
            position: relative;
            background-color: #fff;
            padding: 10px;
            border: 1px solid #ddd;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
            pointer-events: none; /* Prevent interaction with the iframe content */
        }

        img {
            max-width: 100%;
            max-height: 100%;
            pointer-events: none; /* Prevent right-click and dragging */
        }

        .no-print {
            display: none;
        }

        @media print {
            .no-print {
                display: block;
            }

            body * {
                visibility: hidden;
            }

            .no-print {
                visibility: visible;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="file-viewer">
            @if (str_starts_with($file_mime_type, 'image/'))
                {{-- Handle image files --}}
                @php
                    $fileContent = file_get_contents($file_path);
                    $fileBase64 = base64_encode($fileContent);
                    $fileDataUrl = 'data:' . $file_mime_type . ';base64,' . $fileBase64;
                @endphp

                <img src="{{ $fileDataUrl }}" alt="Evidence Image">
            @elseif (str_starts_with($file_mime_type, 'application/pdf'))
                {{-- Handle PDF files --}}
                <iframe src="{{ asset('storage/' . basename($file_path)) }}"></iframe>
            @elseif (str_starts_with($file_mime_type, 'application/vnd.ms-excel') ||
                    str_starts_with($file_mime_type, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'))
                {{-- Handle Excel files --}}
                <p>Excel files are not directly viewable in the browser. <a href="{{ asset('storage/' . basename($file_path)) }}" target="_blank">Download the file</a>.</p>
            @else
                <p>Unsupported file type: {{ $file_mime_type }}</p>
            @endif
        </div>
    </div>

    <script>
        // Disable right-click context menu
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        // Disable Ctrl+P (print) and other print-related shortcuts
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey && e.key.toLowerCase() === 'p') || e.key === 'PrintScreen') {
                e.preventDefault();
            }
        });

        // Prevent Print Dialog using onbeforeprint (for some browsers)
        window.onbeforeprint = function () {
            return false;
        };

        // Prevent dragging of images
        const images = document.querySelectorAll('img');
        images.forEach(function (img) {
            img.addEventListener('dragstart', function (e) {
                e.preventDefault();
            });
        });
    </script>
</body>

</html>
