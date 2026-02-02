<?php
$uploadDir = 'assets/';

// Ensure assets directory exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$message = "";
$status = "";

// Mapping label to filename
$products = [
    'kopi_susu_jiva' => 'kopi_susu_jiva.png',
    'americano' => 'americano.jpg',
    'coffee_latte' => 'coffee_latte.jpg',
    'vanilla_latte' => 'vanilla_latte.jpg', // although HTML uses Unsplash for now, we'll prep it
    'red_velvet' => 'red_velvet.png',
    'matcha_latte' => 'matcha_latte.jpg',
    'croissant' => 'croissant.jpg',
    'nasi_goreng' => 'nasi_goreng.jpg'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['product_image'])) {
    $productKey = $_POST['product_name'];
    
    if (isset($products[$productKey])) {
        $targetFile = $uploadDir . $products[$productKey];
        $imageFileType = strtolower(pathinfo($_FILES["product_image"]["name"], PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
                $status = "success";
                $message = "Berhasil! Foto untuk " . str_replace('_', ' ', $productKey) . " telah diperbarui. ✨";
            } else {
                $status = "error";
                $message = "Maaf, terjadi kesalahan saat mengupload file.";
            }
        } else {
            $status = "error";
            $message = "File yang diupload bukan gambar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JIVA - Upload Foto Produk 🌸</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #fff0f5; }
        .card { background: white; border-radius: 24px; box-shadow: 0 10px 25px rgba(244, 114, 182, 0.2); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="card w-full max-w-md p-8">
        <div class="text-center mb-8">
            <div class="inline-block p-4 rounded-full bg-pink-100 mb-4">
                <i class="fas fa-camera-retro text-pink-500 text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Upload Foto Produk</h1>
            <p class="text-gray-500 text-sm">Pilih produk dan upload fotonya 💕</p>
        </div>

        <?php if ($message): ?>
            <div class="mb-6 p-4 rounded-xl <?php echo $status === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> text-center font-medium">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Produk</label>
                <select name="product_name" required class="w-full px-4 py-3 rounded-xl border border-pink-200 focus:ring-2 focus:ring-pink-400 outline-none transition-all">
                    <option value="kopi_susu_jiva">Kopi Susu Jiva</option>
                    <option value="americano">Americano</option>
                    <option value="coffee_latte">Coffee Latte</option>
                    <option value="vanilla_latte">Vanilla Latte</option>
                    <option value="red_velvet">Red Velvet</option>
                    <option value="matcha_latte">Matcha Latte</option>
                    <option value="croissant">Croissant</option>
                    <option value="nasi_goreng">Nasi Goreng Jiva</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih File Foto</label>
                <div class="relative group">
                    <input type="file" name="product_image" required accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="border-2 border-dashed border-pink-200 rounded-xl p-8 text-center group-hover:border-pink-400 transition-all bg-pink-50/30">
                        <i class="fas fa-cloud-upload-alt text-pink-400 text-2xl mb-2"></i>
                        <p class="text-xs text-gray-400 mt-1">Klik atau seret foto ke sini</p>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-pink-200 transition-all transform hover:-translate-y-1">
                Upload Sekarang 🚀
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="index jihan.html" class="text-pink-400 hover:text-pink-600 text-sm flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Website
            </a>
        </div>
    </div>

</body>
</html>
