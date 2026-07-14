<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title><?= $this->h($this->title ?? 'Home'); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= URL; ?>assets/img/favicon/favicon.ico" type="image/x-icon" sizes="any">
    <link rel="apple-touch-icon" href="<?= URL; ?>assets/img/favicon/apple-touch-icon.png" sizes="180x180">

    <!-- キャッシュとクローラー拒否（HTMLのみ。静的CSS/JSはブラウザキャッシュ可） -->
    <meta name="robots" content="noindex" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="stylesheet" href="<?= URL; ?>css/style.css">

    <?php if (isset($this->css)) : ?>
        <?php foreach ($this->css as $css) : ?>
            <link rel="stylesheet" href="<?= URL; ?>css/<?= $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>