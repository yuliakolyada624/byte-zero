<?=$this->extend('template/layout') ?>
<?=$this->section('content') ?>

	<?=$this->section('extra-css') ?>
	<?=$this->endSection() ?>

  <?php 
  $lang = get_language();
  $title = ($lang=='en' ? 'title' : 'title_'.$lang );
  $content = ($lang=='en' ? 'content' : 'content_'.$lang );
  ?>

	<div class="container">
		<h1><?=$blog->$title?></h1>

    <?=(strlen($blog->$content)>0 ? $blog->$content : 'Content is not available in this language')?>

        <p>Last edit: <?=$blog->updated_at?></p>
	</div>
	

    <?=$this->section('extra-js') ?>
    <script>

    </script>
    <?=$this->endSection() ?>
<?= $this->endSection() ?>



