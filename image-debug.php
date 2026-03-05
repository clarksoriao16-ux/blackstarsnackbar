<?php
// Image Debug Utility for Render Deployment
// Access: yoursite.com/image-debug.php

include('config/constants.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Debug - <?php echo SITEURL; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .debug-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        .image-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px; }
        .image-item { border: 1px solid #ccc; padding: 10px; text-align: center; }
        .image-item img { max-width: 100%; height: 150px; object-fit: cover; }
        .status-ok { color: green; }
        .status-error { color: red; }
        .info { background: #f0f0f0; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Image Debug Utility</h1>
    <div class="info">
        <strong>Site URL:</strong> <?php echo SITEURL; ?><br>
        <strong>Server:</strong> <?php echo $_SERVER['SERVER_NAME']; ?><br>
        <strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?>
    </div>

    <div class="debug-section">
        <h2>Food Images Check</h2>
        <div class="image-grid">
            <?php
            $food_images = [
                'Food-Name-1073.jpg',
                'Food-Name-2043.jpg',
                'Food-Name-2696.jpg',
                'Food-Name-3779.jpg',
                'Food-Name-5018.jpg'
            ];

            foreach ($food_images as $img) {
                $url = SITEURL . "images/food/" . $img;
                echo "<div class='image-item'>";
                echo "<strong>$img</strong><br>";
                echo "<img src='$url' alt='$img' onerror=\"this.style.display='none'; this.nextElementSibling.style.display='block';\">";
                echo "<div class='status-error' style='display:none;'>❌ Not found</div>";
                echo "<div class='status-ok'>✅ URL: $url</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <div class="debug-section">
        <h2>Category Images Check</h2>
        <div class="image-grid">
            <?php
            $category_images = [
                'Food_Category_196.jpg',
                'Food_Category_291.jpg',
                'Food_Category_303.jpg',
                'Food_Category_41.jpg',
                'Food_Category_459.jpg'
            ];

            foreach ($category_images as $img) {
                $url = SITEURL . "images/category/" . $img;
                echo "<div class='image-item'>";
                echo "<strong>$img</strong><br>";
                echo "<img src='$url' alt='$img' onerror=\"this.style.display='none'; this.nextElementSibling.style.display='block';\">";
                echo "<div class='status-error' style='display:none;'>❌ Not found</div>";
                echo "<div class='status-ok'>✅ URL: $url</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <div class="debug-section">
        <h2>Database Image Names</h2>
        <?php
        // Check database for actual image names
        $sql_food = "SELECT title, image_name FROM tbl_food WHERE image_name IS NOT NULL AND image_name != '' LIMIT 10";
        $res_food = mysqli_query($conn, $sql_food);

        if ($res_food && mysqli_num_rows($res_food) > 0) {
            echo "<h3>Food Images in Database:</h3><ul>";
            while ($row = mysqli_fetch_assoc($res_food)) {
                $url = SITEURL . "images/food/" . $row['image_name'];
                echo "<li><strong>{$row['title']}</strong>: {$row['image_name']} <a href='$url' target='_blank'>[Test Link]</a></li>";
            }
            echo "</ul>";
        }

        $sql_cat = "SELECT title, image_name FROM tbl_category WHERE image_name IS NOT NULL AND image_name != '' LIMIT 10";
        $res_cat = mysqli_query($conn, $sql_cat);

        if ($res_cat && mysqli_num_rows($res_cat) > 0) {
            echo "<h3>Category Images in Database:</h3><ul>";
            while ($row = mysqli_fetch_assoc($res_cat)) {
                $url = SITEURL . "images/category/" . $row['image_name'];
                echo "<li><strong>{$row['title']}</strong>: {$row['image_name']} <a href='$url' target='_blank'>[Test Link]</a></li>";
            }
            echo "</ul>";
        }
        ?>
    </div>

    <div class="debug-section">
        <h2>Directory Check</h2>
        <p><strong>Images directory exists:</strong>
        <?php
        $images_dir = __DIR__ . '/images';
        echo file_exists($images_dir) ? '<span class="status-ok">✅ Yes</span>' : '<span class="status-error">❌ No</span>';
        ?>
        </p>

        <p><strong>Food subdirectory exists:</strong>
        <?php
        $food_dir = __DIR__ . '/images/food';
        echo file_exists($food_dir) ? '<span class="status-ok">✅ Yes</span>' : '<span class="status-error">❌ No</span>';
        ?>
        </p>

        <p><strong>Category subdirectory exists:</strong>
        <?php
        $cat_dir = __DIR__ . '/images/category';
        echo file_exists($cat_dir) ? '<span class="status-ok">✅ Yes</span>' : '<span class="status-error">❌ No</span>';
        ?>
        </p>
    </div>

    <div class="debug-section">
        <h2>Fix Instructions</h2>
        <ol>
            <li>Check that all image files are uploaded to the <code>images/</code> directory on your server</li>
            <li>Ensure filenames in database match actual files exactly (case-sensitive)</li>
            <li>Verify file permissions are set to 644 (readable by web server)</li>
            <li>Check that SITEURL constant is correct for your domain</li>
            <li>If images still don't load, try accessing them directly via URL</li>
        </ol>
    </div>
</body>
</html>