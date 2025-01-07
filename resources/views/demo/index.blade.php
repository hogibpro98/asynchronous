<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lazy Loading với Spinner</title>
    <!-- Khai báo Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Spinner CSS */
        #spinner {
            width: 30px;
            height: 30px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 2s linear infinite;
            margin: 0 auto;
        }

        /* Định nghĩa hiệu ứng spin */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Hiệu ứng fade-in cho phần tử */
        .fade-in {
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* Spinner được căn giữa màn hình */
        /* #spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        } */
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Danh sách 1</h1>
    <ul id="list1" class="list-group mb-5">
        <!-- Danh sách 1 sẽ hiển thị từ 1 đến 5 -->
        <li class="list-group-item">1</li>
        <li class="list-group-item">2</li>
        <li class="list-group-item">3</li>
        <li class="list-group-item">4</li>
        <li class="list-group-item">5</li>
    </ul>

    <h1 class="text-center">Danh sách 2 (Lazy Loading)</h1>
    <ul id="list2" class="list-group">
        <!-- Danh sách 2 sẽ thực hiện lazy loading -->
    </ul>

    <!-- Spinner sẽ được hiển thị trong khi đang tải -->
    <div id="spinner"></div>
</div>

<!-- Khai báo jQuery và Bootstrap 5 Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Mảng dữ liệu cho danh sách 2
    const list2Data = [
        'Mục 1',
        'Mục 2',
        'Mục 3',
        'Mục 4',
        'Mục 5',
        'Mục 6',
        'Mục 7',
        'Mục 8',
        'Mục 9',
        'Mục 10'
    ];

    let list2Index = 0;

    // Hàm để hiển thị một mục từ danh sách 2 sau mỗi 2 giây với hiệu ứng fade
    function loadLazyData() {
        // Ẩn spinner trong khi đang tải
        $('#spinner').hide();

        if (list2Index < list2Data.length) {
            setTimeout(function () {
                const listItem = $('<li>')
                    .addClass('list-group-item fade-in')
                    .text(list2Data[list2Index]);

                // Thêm vào danh sách 2
                $('#list2').append(listItem);

                list2Index++;

                // Ẩn spinner khi hoàn thành việc tải phần tử mới
                $('#spinner').show();
            }, 2000);  // Giới hạn thời gian tải mỗi phần tử (2 giây)
        } else {
            $('#spinner').hide();
            clearInterval(lazyLoadingInterval); // Dừng lại khi hết dữ liệu
        }
    }

    // Tạo interval để load lazy loading sau mỗi 2 giây
    const lazyLoadingInterval = setInterval(loadLazyData, 2000);
</script>

</body>
</html>
