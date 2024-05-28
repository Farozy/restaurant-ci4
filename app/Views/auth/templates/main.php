<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran</title>
    <link rel="shortcut icon" href="https://www.seekpng.com/png/full/474-4741429_food-up-arrow-flat-icon.png" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Toast -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" />
    <link rel="stylesheet" href="<?= base_url('library/css/auth.css') ?>">
</head>

<body>
    <div class="login-dark">
        <?= $this->renderSection('content'); ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <!-- Toast -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(function() {
            <?php if (session()->getFlashdata('success')) : ?>
                $.toast({
                    heading: 'Sukses',
                    text: "<?= session()->getFlashdata('success'); ?>",
                    position: 'top-right',
                    showHideTransition: 'slide',
                    icon: 'success',
                    bgColor: 'green',
                    textColor: '#eee',
                    allowToastClose: false,
                    hideAfter: 3000,
                    stack: 3,
                    textAlign: 'left',
                })
            <?php elseif (session()->getFlashdata('error')) : ?>
                $.toast({
                    heading: 'Error',
                    text: "<?= session()->getFlashdata('error'); ?>",
                    position: 'top-right',
                    showHideTransition: 'slide',
                    icon: 'error',
                    bgColor: 'red',
                    textColor: '#eee',
                    allowToastClose: false,
                    hideAfter: 3000,
                    stack: 3,
                    textAlign: 'left',
                })
            <?php endif; ?>
        })
    </script>
</body>

</html>